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

require_once __DIR__ . '/functionality/admin-bar.php';
require_once __DIR__ . '/functionality/admin-menu.php';
require_once __DIR__ . '/functionality/style-login.php';