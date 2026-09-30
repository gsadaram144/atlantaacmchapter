<?php
/**
 * ACM Atlanta Theme Functions
 */

require_once get_template_directory() . '/inc/event-registrations.php';
require_once get_template_directory() . '/inc/site-setup.php';

// ── Asset Versioning ──────────────────────────────────────────────
// Uses the file's last-modified time as its version so browsers pick up
// CSS/JS changes right after a deploy instead of serving a cached copy.
function acm_atlanta_asset_version( $relative_path ) {
    $file = get_template_directory() . $relative_path;
    return file_exists( $file ) ? (string) filemtime( $file ) : '1.0.0';
}

// ── Enqueue Styles & Scripts ──────────────────────────────────────
function acm_atlanta_enqueue_assets() {

    // Google Fonts
    wp_enqueue_style(
        'acm-google-fonts',
        'https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;0,900;1,400&family=Source+Sans+3:wght@300;400;500;600;700&display=swap',
        [],
        null
    );

    // CSS Variables (load first — everything depends on these)
    wp_enqueue_style(
        'acm-variables',
        get_template_directory_uri() . '/css/variables.css',
        ['acm-google-fonts'],
        acm_atlanta_asset_version( '/css/variables.css' )
    );

    // Typography
    wp_enqueue_style(
        'acm-typography',
        get_template_directory_uri() . '/css/typography.css',
        ['acm-variables'],
        acm_atlanta_asset_version( '/css/typography.css' )
    );

    // Layout
    wp_enqueue_style(
        'acm-layout',
        get_template_directory_uri() . '/css/layout.css',
        ['acm-variables'],
        acm_atlanta_asset_version( '/css/layout.css' )
    );

    // Buttons
    wp_enqueue_style(
        'acm-buttons',
        get_template_directory_uri() . '/css/buttons.css',
        ['acm-variables'],
        acm_atlanta_asset_version( '/css/buttons.css' )
    );

    // Header
    wp_enqueue_style(
        'acm-header',
        get_template_directory_uri() . '/css/header.css',
        ['acm-variables'],
        acm_atlanta_asset_version( '/css/header.css' )
    );

    // Footer
    wp_enqueue_style(
        'acm-footer',
        get_template_directory_uri() . '/css/footer.css',
        ['acm-variables'],
        acm_atlanta_asset_version( '/css/footer.css' )
    );

    // Registrations form
    wp_enqueue_style(
        'acm-registrations',
        get_template_directory_uri() . '/css/registrations.css',
        ['acm-variables'],
        acm_atlanta_asset_version( '/css/registrations.css' )
    );

    // Responsive (load last)
    wp_enqueue_style(
        'acm-responsive',
        get_template_directory_uri() . '/css/responsive.css',
        ['acm-variables'],
        acm_atlanta_asset_version( '/css/responsive.css' )
    );

    // Main JS
    wp_enqueue_script(
        'acm-main',
        get_template_directory_uri() . '/js/main.js',
        [],
        acm_atlanta_asset_version( '/js/main.js' ),
        true // load in footer
    );
}
add_action( 'wp_enqueue_scripts', 'acm_atlanta_enqueue_assets' );


// ── Theme Supports ────────────────────────────────────────────────
function acm_atlanta_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ]);
    add_theme_support( 'custom-logo', [
        'height'      => 72,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    // Register navigation menus
    register_nav_menus([
        'primary' => __( 'Primary Navigation', 'acm-atlanta' ),
        'footer'  => __( 'Footer Navigation', 'acm-atlanta' ),
    ]);
}
add_action( 'after_setup_theme', 'acm_atlanta_setup' );


// ── Events Custom Post Type ───────────────────────────────────────
function acm_atlanta_register_events() {
    register_post_type( 'acm_event', [
        'labels' => [
            'name'               => 'Events',
            'singular_name'      => 'Event',
            'add_new'            => 'Add New Event',
            'add_new_item'       => 'Add New Event',
            'edit_item'          => 'Edit Event',
            'new_item'           => 'New Event',
            'view_item'          => 'View Event',
            'search_items'       => 'Search Events',
            'not_found'          => 'No events found',
            'not_found_in_trash' => 'No events found in Trash',
            'menu_name'          => 'Events',
        ],
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-calendar-alt',
        'menu_position' => 5,
        'supports'      => [ 'title', 'editor', 'thumbnail' ],
        'has_archive'   => false,
        'rewrite'       => [ 'slug' => 'events' ],
        'show_in_rest'  => true,
    ]);
}
add_action( 'init', 'acm_atlanta_register_events' );


// ── Event Custom Meta Fields ──────────────────────────────────────
function acm_atlanta_event_meta_box() {
    add_meta_box(
        'acm_event_details',
        'Event Details',
        'acm_atlanta_render_event_meta',
        'acm_event',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'acm_atlanta_event_meta_box' );

function acm_atlanta_render_event_meta( $post ) {
    wp_nonce_field( 'acm_event_meta', 'acm_event_nonce' );
    $date     = get_post_meta( $post->ID, '_event_date', true );
    $time     = get_post_meta( $post->ID, '_event_time', true );
    $location = get_post_meta( $post->ID, '_event_location', true );
    $rsvp_url = get_post_meta( $post->ID, '_event_rsvp_url', true );
    $ticket   = get_post_meta( $post->ID, '_event_ticket', true );
    ?>
    <style>
        .acm-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding: 8px 0; }
        .acm-meta-field { display: flex; flex-direction: column; gap: 6px; }
        .acm-meta-field label { font-weight: 600; font-size: 13px; }
        .acm-meta-field input { padding: 6px 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        .acm-meta-full { grid-column: 1 / -1; }
    </style>
    <div class="acm-meta-grid">
        <div class="acm-meta-field">
            <label for="event_date">📅 Event Date <span style="color:red">*</span></label>
            <input type="date" id="event_date" name="event_date" value="<?php echo esc_attr($date); ?>" required/>
        </div>
        <div class="acm-meta-field">
            <label for="event_time">🕕 Time (e.g. 6:00 – 8:30 PM)</label>
            <input type="text" id="event_time" name="event_time" value="<?php echo esc_attr($time); ?>" placeholder="6:00 – 8:30 PM"/>
        </div>
        <div class="acm-meta-field">
            <label for="event_location">📍 Location</label>
            <input type="text" id="event_location" name="event_location" value="<?php echo esc_attr($location); ?>" placeholder="Venue TBA – Atlanta, GA"/>
        </div>
        <div class="acm-meta-field">
            <label for="event_ticket">🎟 Ticket / Entry Info</label>
            <input type="text" id="event_ticket" name="event_ticket" value="<?php echo esc_attr($ticket); ?>" placeholder="Free for Members"/>
        </div>
        <div class="acm-meta-field acm-meta-full">
            <label for="event_rsvp_url">🔗 RSVP / Registration URL</label>
            <input type="url" id="event_rsvp_url" name="event_rsvp_url" value="<?php echo esc_attr($rsvp_url); ?>" placeholder="https://..."/>
        </div>
    </div>
    <?php
}

function acm_atlanta_save_event_meta( $post_id ) {
    if ( ! isset( $_POST['acm_event_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['acm_event_nonce'], 'acm_event_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = [
        '_event_date'     => 'event_date',
        '_event_time'     => 'event_time',
        '_event_location' => 'event_location',
        '_event_rsvp_url' => 'event_rsvp_url',
        '_event_ticket'   => 'event_ticket',
    ];

    foreach ( $fields as $meta_key => $field_name ) {
        if ( isset( $_POST[$field_name] ) ) {
            update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[$field_name] ) );
        }
    }
}
add_action( 'save_post_acm_event', 'acm_atlanta_save_event_meta' );


// ── Officers Custom Post Type ─────────────────────────────────────
function acm_atlanta_register_officers() {
    register_post_type( 'acm_officer', [
        'labels' => [
            'name'               => 'Officers',
            'singular_name'      => 'Officer',
            'add_new'            => 'Add New Officer',
            'add_new_item'       => 'Add New Officer',
            'edit_item'          => 'Edit Officer',
            'new_item'           => 'New Officer',
            'view_item'          => 'View Officer',
            'search_items'       => 'Search Officers',
            'not_found'          => 'No officers found',
            'not_found_in_trash' => 'No officers found in Trash',
            'menu_name'          => 'Officers',
        ],
        'public'        => false,   // no individual officer URL pages needed
        'show_ui'       => true,    // still shows in WP Admin
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-groups',
        'menu_position' => 6,
        'supports'      => [ 'title', 'editor', 'thumbnail' ],
        'show_in_rest'  => true,
    ]);
}
add_action( 'init', 'acm_atlanta_register_officers' );

/**
 * Standard ACM professional chapter officer positions, in display order.
 * Offered as suggestions in the Officer editor and used as placeholders
 * on the Officers page until real officer profiles are published.
 */
function acm_atlanta_officer_roles() {
    return [
        'Chair'            => 'Leads the chapter, chairs officer and member meetings, and represents ACM Atlanta to ACM and the regional computing community.',
        'Vice Chair'       => 'Supports the Chair, steps in when the Chair is unavailable, and coordinates chapter programs and speaker outreach.',
        'Secretary'        => 'Keeps meeting minutes and chapter records, manages member communications, and files the annual report with ACM.',
        'Treasurer'        => 'Manages chapter finances, membership dues, and budgets, and prepares the annual financial report for ACM.',
        'Membership Chair' => 'Recruits and welcomes new members, maintains the member roster, and runs member engagement initiatives.',
        'Program Chair'    => 'Plans the events calendar, secures venues and speakers, and coordinates event logistics.',
    ];
}

/**
 * Default roster shown on the Officers page when no officers exist in WP Admin.
 * Only the core elected positions are shown; positions without a name listed
 * in $appointed display as "To Be Announced".
 */
function acm_atlanta_default_officers() {
    $roles = acm_atlanta_officer_roles();

    $appointed = [
        'Chair' => [
            'name'     => 'Gangadhar Sadaram',
            'linkedin' => 'https://www.linkedin.com/in/gangadhar-sadaram-00b0b0159/',
            'photo'    => 'officer-chair-gangadhar-sadaram.jpg', // file in the theme's images/ folder
        ],
    ];

    $default = [];
    foreach ( [ 'Chair', 'Vice Chair', 'Secretary', 'Treasurer' ] as $role ) {
        $person = $appointed[ $role ] ?? [];
        $name   = $person['name'] ?? '';
        $default[] = [
            'id'          => 0,
            'slug'        => sanitize_title( $role ),
            'name'        => $name ?: 'To Be Announced',
            'title'       => $role,
            'duties'      => $roles[ $role ],
            'email'       => $person['email'] ?? '',
            'linkedin'    => $person['linkedin'] ?? '',
            'bio'         => '',
            'photo'       => ! empty( $person['photo'] ) ? get_template_directory_uri() . '/images/' . $person['photo'] : '',
            'initial'     => strtoupper( mb_substr( $name ?: $role, 0, 1 ) ),
            'placeholder' => $name === '',
        ];
    }
    return $default;
}


// ── Officer Meta Fields ───────────────────────────────────────────
function acm_atlanta_officer_meta_box() {
    add_meta_box(
        'acm_officer_details',
        'Officer Details',
        'acm_atlanta_render_officer_meta',
        'acm_officer',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'acm_atlanta_officer_meta_box' );

function acm_atlanta_render_officer_meta( $post ) {
    wp_nonce_field( 'acm_officer_meta', 'acm_officer_nonce' );
    $title    = get_post_meta( $post->ID, '_officer_title',    true );
    $duties   = get_post_meta( $post->ID, '_officer_duties',   true );
    $email    = get_post_meta( $post->ID, '_officer_email',    true );
    $linkedin = get_post_meta( $post->ID, '_officer_linkedin', true );
    $order    = get_post_meta( $post->ID, '_officer_order',    true );
    ?>
    <style>
        .acm-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding: 8px 0; }
        .acm-meta-field { display: flex; flex-direction: column; gap: 6px; }
        .acm-meta-field label { font-weight: 600; font-size: 13px; }
        .acm-meta-field input, .acm-meta-field textarea { padding: 6px 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        .acm-meta-full { grid-column: 1 / -1; }
    </style>
    <div class="acm-meta-grid">
        <div class="acm-meta-field">
            <label for="officer_title">🏷 Role / Title <span style="color:red">*</span></label>
            <input type="text" id="officer_title" name="officer_title" value="<?php echo esc_attr($title); ?>" placeholder="Chair" list="acm_officer_roles"/>
            <datalist id="acm_officer_roles">
                <?php foreach ( array_keys( acm_atlanta_officer_roles() ) as $role ) : ?>
                    <option value="<?php echo esc_attr( $role ); ?>"></option>
                <?php endforeach; ?>
            </datalist>
        </div>
        <div class="acm-meta-field">
            <label for="officer_order">↕ Display Order</label>
            <input type="number" id="officer_order" name="officer_order" value="<?php echo esc_attr($order); ?>" placeholder="1" min="1"/>
        </div>
        <div class="acm-meta-field acm-meta-full">
            <label for="officer_duties">📋 Duties &amp; Responsibilities</label>
            <textarea id="officer_duties" name="officer_duties" rows="3" placeholder="Leads the chapter, chairs officer meetings, represents ACM Atlanta at regional events..."><?php echo esc_textarea($duties); ?></textarea>
        </div>
        <div class="acm-meta-field">
            <label for="officer_email">✉️ Email Address</label>
            <input type="email" id="officer_email" name="officer_email" value="<?php echo esc_attr($email); ?>" placeholder="chair@atlanta.acm.org"/>
        </div>
        <div class="acm-meta-field">
            <label for="officer_linkedin">🔗 LinkedIn URL</label>
            <input type="url" id="officer_linkedin" name="officer_linkedin" value="<?php echo esc_attr($linkedin); ?>" placeholder="https://linkedin.com/in/..."/>
        </div>
    </div>
    <p style="margin-top:12px; color:#666; font-size:13px;">💡 Use the <strong>Featured Image</strong> panel on the right to set the officer's photo.</p>
    <p style="color:#666; font-size:13px;">✏️ Write the officer's bio in the block editor above.</p>
    <?php
}

function acm_atlanta_save_officer_meta( $post_id ) {
    if ( ! isset( $_POST['acm_officer_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['acm_officer_nonce'], 'acm_officer_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = [
        '_officer_title'    => 'officer_title',
        '_officer_duties'   => 'officer_duties',
        '_officer_email'    => 'officer_email',
        '_officer_linkedin' => 'officer_linkedin',
        '_officer_order'    => 'officer_order',
    ];

    foreach ( $fields as $meta_key => $field_name ) {
        if ( isset( $_POST[$field_name] ) ) {
            update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[$field_name] ) );
        }
    }
    // Sanitize duties as textarea
    if ( isset( $_POST['officer_duties'] ) ) {
        update_post_meta( $post_id, '_officer_duties', sanitize_textarea_field( $_POST['officer_duties'] ) );
    }
}
add_action( 'save_post_acm_officer', 'acm_atlanta_save_officer_meta' );