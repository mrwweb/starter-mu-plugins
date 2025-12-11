<?php
/**
 * Change location of WP-CFM config files
 *
 * @see: https://github.com/forumone/wp-cfm/wiki/Filters-Reference
 *
 * @package _mrw-mu-plugins
 */

namespace MRW\Yoast;

add_action( 'admin_menu', __NAMESPACE__ . '\remove_upsell', 999 );
/**
 * Remove the Yoast Redirects upsell
 */
function remove_upsell() {
	remove_submenu_page( 'tools.php', 'wpseo_redirects_tools' );
	remove_submenu_page( 'wpseo_dashboard', 'wpseo_redirects' );
	remove_submenu_page( 'wpseo_dashboard', 'wpseo_workouts' );
	remove_submenu_page( 'wpseo_dashboard', 'wpseo_upgrade_sidebar' );
	remove_submenu_page( 'wpseo_dashboard', 'wpseo_brand_insights' );
	remove_submenu_page( 'wpseo_dashboard', 'wpseo_licenses' );
	remove_submenu_page( 'wpseo_dashboard', 'wpseo_page_academy' );
}