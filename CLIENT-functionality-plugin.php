<?php
/**
 * Plugin Name: CLIENT Custom Functionality Plugin
 * Description:
 * Version: 1.0
 * Author: Mark Root-Wiley, MRW Web Design
 * Author URI: https://MRWweb.com
 *
 * @package _mrw-mu-plugins
 */

namespace _CLIENT\Site;

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\admin_styles' );
/**
 * Enqueue a custom stylesheet for the admin area
 *
 * @return void
 */
function admin_styles() {
	wp_enqueue_style(
		'custom-admin',
		plugins_url( '/custom-admin-styles.css', __FILE__ ),
		[],
		'1.0.0'
	);
}

add_filter( 'get_the_archive_title', __NAMESPACE__ . '\archive_titles', 10, 2 );
/**
 * Strip title prefix from Archive titles
 *
 * @param string $title full title with prefix
 * @param string $original_title title without prefix
 * @return void
 */
function archive_titles( $title, $original_title ) {
    $title = $original_title;

    return $title;
}

if( ! class_exists('ACF') ) {
	require_once __DIR__ . '/functionality/announcement-banner.php';
}
require_once __DIR__ . '/functionality/admin-bar.php';
require_once __DIR__ . '/functionality/admin-menu.php';
require_once __DIR__ . '/functionality/style-login.php';
require_once __DIR__ . '/functionality/remove-comments.php';
