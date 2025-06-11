<?php
/**
 * Remove comments from the site
 *
 * @package _mrw-mu-plugins
 */

namespace MRW\Site;

// Close comments on the front-end
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );

// hide comments feed on front end
add_filter( 'feed_links_show_comments_feed', '__return_false' );

// Hide existing comments
add_filter( 'comments_array', '__return_empty_array', 10, 2 );
add_filter( 'post_comments_feed_link_html', '__return_empty_string' );

// Remove comments page in menu
add_action( 'admin_menu', function () {
    remove_menu_page( 'edit-comments.php' );
} );

add_action( 'admin_init', __NAMESPACE__ . '\remove_comments_admin' );
function remove_comments_admin() {
    // Redirect any user trying to access comments page
    global $pagenow;

    if ( $pagenow === 'edit-comments.php' ) {
        wp_safe_redirect( home_url() );
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

    // Remove support for comments and trackbacks in post types
    foreach ( get_post_types() as $post_type ) {
        if ( post_type_supports( $post_type, 'comments' ) ) {
            remove_post_type_support( $post_type, 'comments' );
            remove_post_type_support( $post_type, 'trackbacks' );
        }
    }
}