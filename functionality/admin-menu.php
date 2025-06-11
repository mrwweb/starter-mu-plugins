<?php
/**
 * Reorder the admin menu and add direct link to Template Parts
 *
 * @package _mrw-mu-plugins
 */

namespace _CLIENT\Site;

add_action( 'admin_menu', __NAMESPACE__ . '\reorder_admin_menu', 9999 );
/**
 * Remove and reorder admin menu items
 *
 * General grouping: Content, Media, editor-facing design/options/forms, everything else
 *
 * @return void
 */
function reorder_admin_menu() {
	// phpcs:disable WordPress.WP.GlobalVariablesOverride.Prohibited
	global $menu;

	$menu['31.56465'] = [ '', 'read', 'separator2', '', 'wp-menu-separator' ];
	$menu['53.98435'] = [ '', 'read', 'separator3', '', 'wp-menu-separator' ];

	/* Hide the PublishPress "Author Profile" page since you can edit it just as easily from the Authors page */
	unset( $menu['26.8'] );

	/* default_position => new_position */
	$menu_swap = [
		/*  Post Types */
		20      => '4.5', // pages
		5       => '4.659', // posts
		10      => '57.65498', // Media Library

		/* Plugins */
		6       => '9.59864', // The Events Calendar with other Post Types
		30      => '30.26456', // WP Jobs Manager with other Post Types
		26      => '57.98479', // Easy Digital Downloads close to Media Library
		'16.9'  => '58.56849', // Gravity Forms Close to Media Library
		'26.7'  => '68.686544', // PublishPress Authors close to Users
		'58.95' => '80.1264', // Searchwp close to settings
		3       => '1654987.9867498', // Jetpack
	];

	foreach ( $menu_swap as $orig => $new ) {
		if ( array_key_exists( $orig, $menu ) ) {
			$menu[ $new ] = $menu[ $orig ];
			unset( $menu[ $orig ] );
		}
	}
	// phpcs:enable
}

add_action( 'admin_menu', __NAMESPACE__ . '\add_template_parts_menu_item', 9999 );
/**
 * Add a "Template Parts" link to the Appearance submenu for faster access
 *
 * @return void
 */
function add_template_parts_menu_item() {
	add_submenu_page(
		'themes.php',
		'',
		'Template Parts',
		'manage_options',
		'site-editor.php?postType=wp_template_part',
		'',
		1
	);
}
