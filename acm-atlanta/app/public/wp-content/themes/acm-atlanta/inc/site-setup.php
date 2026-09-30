<?php
/**
 * One-time site setup
 *
 * Runs once when the theme is activated (or on the next admin page load if the
 * theme was already active) so a fresh WordPress install is ready to use:
 *   - creates the Home, About, Events, Officers, Membership and Contact pages
 *   - sets Home as the static front page
 *   - switches permalinks to "Post name" so page and event URLs work
 *   - builds the Primary Navigation menu
 *
 * Existing pages and settings are left alone. To run it again, delete the
 * `acm_atlanta_setup_done` option.
 */

function acm_atlanta_site_pages() {
    return [
        'home'       => 'Home',
        'about'      => 'About',
        'events'     => 'Events',
        'officers'   => 'Officers',
        'membership' => 'Membership',
        'contact'    => 'Contact',
    ];
}

function acm_atlanta_run_site_setup() {
    if ( get_option( 'acm_atlanta_setup_done' ) ) return;

    // Pages — reuse any page that already has the slug
    $page_ids = [];
    foreach ( acm_atlanta_site_pages() as $slug => $title ) {
        $existing = get_page_by_path( $slug );
        if ( $existing ) {
            $page_ids[ $slug ] = $existing->ID;
            continue;
        }
        $page_ids[ $slug ] = wp_insert_post( [
            'post_type'   => 'page',
            'post_status' => 'publish',
            'post_title'  => $title,
            'post_name'   => $slug,
        ] );
    }

    // Static front page, unless one is already chosen
    if ( get_option( 'show_on_front' ) !== 'page' && ! empty( $page_ids['home'] ) ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $page_ids['home'] );
    }

    // Pretty permalinks, unless already customised
    if ( ! get_option( 'permalink_structure' ) ) {
        update_option( 'permalink_structure', '/%postname%/' );
    }

    // Primary menu, unless one is already assigned
    $locations = get_theme_mod( 'nav_menu_locations', [] );
    if ( empty( $locations['primary'] ) ) {
        $menu    = wp_get_nav_menu_object( 'Primary Navigation' );
        $menu_id = $menu ? $menu->term_id : wp_create_nav_menu( 'Primary Navigation' );

        if ( ! is_wp_error( $menu_id ) ) {
            if ( ! $menu ) {
                foreach ( $page_ids as $page_id ) {
                    if ( ! $page_id || is_wp_error( $page_id ) ) continue;
                    wp_update_nav_menu_item( $menu_id, 0, [
                        'menu-item-object-id' => $page_id,
                        'menu-item-object'    => 'page',
                        'menu-item-type'      => 'post_type',
                        'menu-item-status'    => 'publish',
                    ] );
                }
            }
            $locations['primary'] = $menu_id;
            set_theme_mod( 'nav_menu_locations', $locations );
        }
    }

    // Register the Events/Officers post types before rebuilding URL rules
    acm_atlanta_register_events();
    acm_atlanta_register_officers();
    flush_rewrite_rules();

    update_option( 'acm_atlanta_setup_done', 1 );
}
add_action( 'after_switch_theme', 'acm_atlanta_run_site_setup' );

// Covers installs where the theme was activated before this file existed
add_action( 'admin_init', function () {
    if ( current_user_can( 'manage_options' ) ) {
        acm_atlanta_run_site_setup();
    }
} );
