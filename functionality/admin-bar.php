<?php
/**
 * Remove most items from the admin bar for a cleaner, focused experience
 *
 * @package _mrw-mu-plugins
 */

namespace _CLIENT\Site;

add_action( 'wp_before_admin_bar_render', __NAMESPACE__ . '\cleanup_admin_bar' );
/**
 * Remove a bunch of default stuff from the admin bar. Leaves behind a cleaner bar and frees up space for things like WP Environment Type and Query Monitor
 *
 * @return void
 */
function cleanup_admin_bar() {
	global $wp_admin_bar;

	/* Core */
	$wp_admin_bar->remove_menu( 'wp-logo' );
	$wp_admin_bar->remove_menu( 'comments' );
	$wp_admin_bar->remove_menu( 'customize' );
	$wp_admin_bar->remove_menu( 'search' );

	$account = $wp_admin_bar->get_node( 'my-account' );
	$wp_admin_bar->add_node(
		array(
			'id'    => 'my-account',
			'title' => str_replace( 'Howdy, ', '', $account->title ),
		)
	);

	/* Plugin-specific */
	$wp_admin_bar->remove_menu( 'edd-store-menu' ); // easy digital downloads
	$wp_admin_bar->remove_menu( 'content_audit' ); // content audit plugin
}
