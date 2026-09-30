<?php
/**
 * Event Registration System
 *
 * - Creates wp_acm_registrations table on theme activation
 * - Handles public form submissions via admin-post.php
 * - Adds an admin submenu under Events with per-event registration lists and CSV export
 */

// ── DB Table ──────────────────────────────────────────────────────────────────

function acm_registrations_create_table() {
    global $wpdb;
    $table   = $wpdb->prefix . 'acm_registrations';
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        event_id bigint(20) unsigned NOT NULL,
        first_name varchar(100) NOT NULL,
        last_name varchar(100) NOT NULL,
        email varchar(200) NOT NULL,
        phone varchar(30) NOT NULL DEFAULT '',
        registered_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY event_id (event_id)
    ) $charset;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}
add_action( 'after_switch_theme', 'acm_registrations_create_table' );

// Run once on admin_init using a version flag so the table is created
// even when the theme was already active when this code was first deployed.
function acm_registrations_maybe_create_table() {
    if ( get_option( 'acm_registrations_db_version' ) !== '1.0' ) {
        acm_registrations_create_table();
        update_option( 'acm_registrations_db_version', '1.0' );
    }
}
add_action( 'admin_init', 'acm_registrations_maybe_create_table' );


// ── Turnstile Verification ────────────────────────────────────────────────────

function acm_verify_turnstile( $token ) {
    if ( wp_get_environment_type() === 'local' ) return true;
    if ( empty( $token ) ) return false;
    $secret = get_option( 'acm_turnstile_secret_key', '' );
    if ( empty( $secret ) ) return false;
    $response = wp_remote_post( 'https://challenges.cloudflare.com/turnstile/v0/siteverify', [
        'body' => [
            'secret'   => $secret,
            'response' => $token,
        ],
    ] );
    if ( is_wp_error( $response ) ) return false;
    $data = json_decode( wp_remote_retrieve_body( $response ), true );
    return ! empty( $data['success'] );
}


// ── Form Submission Handler ───────────────────────────────────────────────────

function acm_handle_event_registration() {
    // Verify nonce
    if ( ! isset( $_POST['acm_reg_nonce'] ) || ! wp_verify_nonce( $_POST['acm_reg_nonce'], 'acm_event_register' ) ) {
        wp_die( 'Security check failed.', 'Error', [ 'back_link' => true ] );
    }

    $event_id   = absint( $_POST['acm_event_id'] ?? 0 );
    $first_name = sanitize_text_field( $_POST['first_name'] ?? '' );
    $last_name  = sanitize_text_field( $_POST['last_name']  ?? '' );
    $email      = sanitize_email( $_POST['email'] ?? '' );
    $phone      = sanitize_text_field( $_POST['phone'] ?? '' );

    $event_url = get_permalink( $event_id );

    // Verify Turnstile challenge
    if ( ! acm_verify_turnstile( $_POST['cf-turnstile-response'] ?? '' ) ) {
        wp_redirect( add_query_arg( 'reg', 'error', $event_url ) );
        exit;
    }

    // Basic validation
    if ( ! $event_id || ! $first_name || ! $last_name || ! is_email( $email ) ) {
        wp_redirect( add_query_arg( 'reg', 'error', $event_url ) );
        exit;
    }

    // Confirm event exists and is upcoming
    $event_date = get_post_meta( $event_id, '_event_date', true );
    if ( ! $event_date || strtotime( $event_date ) < strtotime( 'today' ) ) {
        wp_redirect( add_query_arg( 'reg', 'closed', $event_url ) );
        exit;
    }

    global $wpdb;
    $table = $wpdb->prefix . 'acm_registrations';

    $existing_id = $wpdb->get_var( $wpdb->prepare(
        "SELECT id FROM $table WHERE event_id = %d AND email = %s LIMIT 1",
        $event_id, $email
    ) );

    if ( $existing_id ) {
        $wpdb->update( $table, [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'phone'      => $phone,
        ], [ 'id' => $existing_id ], [ '%s', '%s', '%s' ], [ '%d' ] );
    } else {
        $wpdb->insert( $table, [
            'event_id'   => $event_id,
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email,
            'phone'      => $phone,
        ], [ '%d', '%s', '%s', '%s', '%s' ] );
    }

    wp_redirect( add_query_arg( 'reg', 'success', $event_url ) );
    exit;
}
add_action( 'admin_post_nopriv_acm_event_register', 'acm_handle_event_registration' );
add_action( 'admin_post_acm_event_register',        'acm_handle_event_registration' );


// ── Bulk Delete Handler ───────────────────────────────────────────────────────

function acm_handle_bulk_delete_registrations() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Insufficient permissions.' );
    }
    if ( ! isset( $_POST['acm_bulk_delete_nonce'] ) || ! wp_verify_nonce( $_POST['acm_bulk_delete_nonce'], 'acm_bulk_delete' ) ) {
        wp_die( 'Security check failed.' );
    }

    $ids = array_map( 'absint', (array) ( $_POST['reg_ids'] ?? [] ) );

    if ( $ids ) {
        global $wpdb;
        $table        = $wpdb->prefix . 'acm_registrations';
        $placeholders = implode( ',', array_fill( 0, count( $ids ), '%d' ) );
        $wpdb->query( $wpdb->prepare( "DELETE FROM $table WHERE id IN ($placeholders)", $ids ) );
    }

    $redirect = add_query_arg( [
        'post_type'  => 'acm_event',
        'page'       => 'acm-registrations',
        'event_id'   => absint( $_POST['acm_event_id'] ?? 0 ),
        'acm_deleted' => count( $ids ),
    ], admin_url( 'edit.php' ) );

    wp_redirect( $redirect );
    exit;
}
add_action( 'admin_post_acm_bulk_delete_registrations', 'acm_handle_bulk_delete_registrations' );


// ── Turnstile Settings Save ───────────────────────────────────────────────────

function acm_save_turnstile_settings() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Insufficient permissions.' );
    }
    if ( ! isset( $_POST['acm_settings_nonce'] ) || ! wp_verify_nonce( $_POST['acm_settings_nonce'], 'acm_save_settings' ) ) {
        wp_die( 'Security check failed.' );
    }
    $site_key = sanitize_text_field( $_POST['acm_turnstile_site_key']   ?? '' );
    $secret   = sanitize_text_field( $_POST['acm_turnstile_secret_key'] ?? '' );
    if ( $site_key ) update_option( 'acm_turnstile_site_key',   $site_key );
    if ( $secret )   update_option( 'acm_turnstile_secret_key', $secret );
    wp_redirect( add_query_arg( [
        'post_type'   => 'acm_event',
        'page'        => 'acm-registrations',
        'acm_saved'   => '1',
    ], admin_url( 'edit.php' ) ) );
    exit;
}
add_action( 'admin_post_acm_save_turnstile_settings', 'acm_save_turnstile_settings' );


// ── Admin Menu ────────────────────────────────────────────────────────────────

function acm_registrations_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=acm_event',
        'Registrations',
        'Registrations',
        'manage_options',
        'acm-registrations',
        'acm_registrations_admin_page'
    );
}
add_action( 'admin_menu', 'acm_registrations_admin_menu' );


// ── CSV Export ────────────────────────────────────────────────────────────────

function acm_registrations_maybe_export() {
    if (
        ! isset( $_GET['page'], $_GET['acm_export'] ) ||
        $_GET['page'] !== 'acm-registrations' ||
        ! current_user_can( 'manage_options' )
    ) {
        return;
    }

    if ( ! isset( $_GET['acm_export_nonce'] ) || ! wp_verify_nonce( $_GET['acm_export_nonce'], 'acm_export_registrations' ) ) {
        wp_die( 'Security check failed.' );
    }

    global $wpdb;
    $table    = $wpdb->prefix . 'acm_registrations';
    $event_id = absint( $_GET['acm_export'] );
    $rows     = $wpdb->get_results( $wpdb->prepare(
        "SELECT first_name, last_name, email, phone, registered_at FROM $table WHERE event_id = %d ORDER BY registered_at ASC",
        $event_id
    ), ARRAY_A );

    $event_title = get_the_title( $event_id ) ?: "event-$event_id";
    $filename    = 'registrations-' . sanitize_title( $event_title ) . '.csv';

    header( 'Content-Type: text/csv' );
    header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
    header( 'Pragma: no-cache' );

    $out = fopen( 'php://output', 'w' );
    fputcsv( $out, [ 'First Name', 'Last Name', 'Email', 'Phone', 'Registered At' ] );
    foreach ( $rows as $row ) {
        fputcsv( $out, $row );
    }
    fclose( $out );
    exit;
}
add_action( 'admin_init', 'acm_registrations_maybe_export' );


// ── Admin Page ────────────────────────────────────────────────────────────────

function acm_registrations_admin_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'acm_registrations';

    // Fetch all events that have at least one registration
    $event_ids_with_regs = $wpdb->get_col( "SELECT DISTINCT event_id FROM $table ORDER BY event_id DESC" );

    // Also fetch all published events for the filter dropdown
    $all_events = get_posts([
        'post_type'      => 'acm_event',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value',
        'meta_key'       => '_event_date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    ]);

    $selected_event = isset( $_GET['event_id'] ) ? absint( $_GET['event_id'] ) : ( $event_ids_with_regs[0] ?? 0 );

    $rows = $selected_event ? $wpdb->get_results( $wpdb->prepare(
        "SELECT * FROM $table WHERE event_id = %d ORDER BY registered_at ASC",
        $selected_event
    ) ) : [];

    $export_url = $selected_event ? wp_nonce_url(
        add_query_arg( [ 'page' => 'acm-registrations', 'acm_export' => $selected_event ], admin_url( 'edit.php?post_type=acm_event' ) ),
        'acm_export_registrations',
        'acm_export_nonce'
    ) : '';
    $deleted = isset( $_GET['acm_deleted'] ) ? absint( $_GET['acm_deleted'] ) : 0;
    $saved   = ! empty( $_GET['acm_saved'] );
    $has_secret = ! empty( get_option( 'acm_turnstile_secret_key', '' ) );
    ?>
    <div class="wrap">
        <h1>Event Registrations</h1>

        <?php if ( $deleted ) : ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo $deleted; ?> registration(s) deleted.</p>
            </div>
        <?php endif; ?>

        <?php if ( $saved ) : ?>
            <div class="notice notice-success is-dismissible">
                <p>Turnstile secret key saved.</p>
            </div>
        <?php endif; ?>

        <?php
        $has_site_key = ! empty( get_option( 'acm_turnstile_site_key', '' ) );
        if ( ( ! $has_secret || ! $has_site_key ) && wp_get_environment_type() !== 'local' ) : ?>
            <div class="notice notice-warning">
                <p><strong>Turnstile is not fully configured.</strong> Registrations are not protected. Add both keys below.</p>
            </div>
        <?php endif; ?>

        <details style="margin: 16px 0; background:#f6f7f7; border:1px solid #ddd; border-radius:4px; padding:12px 16px;">
            <summary style="font-weight:600; cursor:pointer;">Turnstile Settings</summary>
            <form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" style="margin-top:12px;">
                <input type="hidden" name="action" value="acm_save_turnstile_settings">
                <?php wp_nonce_field( 'acm_save_settings', 'acm_settings_nonce' ); ?>
                <table class="form-table" style="margin:0;">
                    <tr>
                        <th style="padding:8px 16px 8px 0; width:200px;">
                            <label for="acm_turnstile_site_key">Site Key</label>
                        </th>
                        <td style="padding:8px 0;">
                            <input type="text" id="acm_turnstile_site_key" name="acm_turnstile_site_key"
                                value="<?php echo esc_attr( get_option( 'acm_turnstile_site_key', '' ) ); ?>"
                                style="width:360px; font-family:monospace;">
                            <p class="description" style="margin-top:6px;">Public key — shown in the form HTML. Safe to share.</p>
                        </td>
                    </tr>
                    <tr>
                        <th style="padding:8px 16px 8px 0;">
                            <label for="acm_turnstile_secret_key">Secret Key</label>
                        </th>
                        <td style="padding:8px 0;">
                            <input type="password" id="acm_turnstile_secret_key" name="acm_turnstile_secret_key"
                                placeholder="<?php echo $has_secret ? '••••••••••••••••' : 'Paste your secret key'; ?>"
                                style="width:360px; font-family:monospace;">
                            <p class="description" style="margin-top:6px;">
                                Private key — never share this. Leave blank to keep the current value.
                            </p>
                        </td>
                    </tr>
                </table>
                <p class="description" style="margin-top:4px;">
                    Both keys are found at
                    <a href="https://dash.cloudflare.com/?to=/:account/turnstile" target="_blank" rel="noopener">
                        dash.cloudflare.com
                    </a>
                    → <strong>[Your Account] → Turnstile → [Widget name] → Settings</strong>.
                </p>
                <button type="submit" class="button button-primary" style="margin-top:8px;">Save Keys</button>
            </form>
        </details>

        <form method="get" action="<?php echo esc_url( admin_url('edit.php') ); ?>" style="margin: 16px 0; display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
            <input type="hidden" name="post_type" value="acm_event">
            <input type="hidden" name="page" value="acm-registrations">
            <label for="acm-event-filter" style="font-weight:600;">Filter by Event:</label>
            <select id="acm-event-filter" name="event_id" style="min-width:260px;">
                <option value="">— Select an event —</option>
                <?php foreach ( $all_events as $event ) : ?>
                    <?php
                    $edate = get_post_meta( $event->ID, '_event_date', true );
                    $label = esc_html( $event->post_title ) . ( $edate ? ' (' . date( 'M j, Y', strtotime( $edate ) ) . ')' : '' );
                    ?>
                    <option value="<?php echo $event->ID; ?>" <?php selected( $selected_event, $event->ID ); ?>>
                        <?php echo $label; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="button">View</button>
        </form>

        <?php if ( $selected_event ) : ?>
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:12px;">
                <p style="color:#555; margin:0;">
                    <?php echo count( $rows ); ?> registration(s) for <strong><?php echo esc_html( get_the_title( $selected_event ) ); ?></strong>
                </p>
                <a href="<?php echo esc_url( $export_url ); ?>" class="button button-primary">Export CSV</a>
            </div>
            <?php if ( $rows ) : ?>
                <form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
                    <input type="hidden" name="action"        value="acm_bulk_delete_registrations">
                    <input type="hidden" name="acm_event_id"  value="<?php echo $selected_event; ?>">
                    <?php wp_nonce_field( 'acm_bulk_delete', 'acm_bulk_delete_nonce' ); ?>

                    <table class="widefat fixed striped" style="margin-top:8px;">
                        <thead>
                            <tr>
                                <th style="width:32px;"><input type="checkbox" id="acm-check-all"></th>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Registered At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $rows as $i => $row ) : ?>
                            <tr>
                                <td><input type="checkbox" name="reg_ids[]" value="<?php echo absint( $row->id ); ?>" class="acm-reg-check"></td>
                                <td><?php echo $i + 1; ?></td>
                                <td><?php echo esc_html( $row->first_name ); ?></td>
                                <td><?php echo esc_html( $row->last_name ); ?></td>
                                <td><?php echo esc_html( $row->email ); ?></td>
                                <td><?php echo esc_html( $row->phone ); ?></td>
                                <td><?php echo esc_html( date( 'M j, Y g:i a', strtotime( $row->registered_at ) ) ); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div style="margin-top:10px;">
                        <button type="submit" class="button button-secondary"
                            onclick="return confirm('Delete selected registrations? This cannot be undone.')">
                            Delete Selected
                        </button>
                    </div>
                </form>
                <script>
                    document.getElementById('acm-check-all').addEventListener('change', function() {
                        document.querySelectorAll('.acm-reg-check').forEach(cb => cb.checked = this.checked);
                    });
                </script>
            <?php else : ?>
                <p style="color:#888;">No registrations yet for this event.</p>
            <?php endif; ?>
        <?php else : ?>
            <p style="color:#888;">Select an event above to view its registrations.</p>
        <?php endif; ?>
    </div>
    <?php
}
