<?php
/**
 * Change location of WP-CFM config files
 *
 * @see: https://github.com/forumone/wp-cfm/wiki/Filters-Reference
 *
 * @package _mrw-mu-plugins
 */

namespace MRW\WPCFM;

add_filter( 'wpcfm_config_url', __NAMESPACE__ . '\change_config_url' );
/**
 * Change URL of WP-CFM config files
 *
 * @param string $config_url - Default is "<domain>/wp-content/config"
 * @return string
 */
function change_config_url( $config_url ) {
	$config_url = WPMU_PLUGIN_URL . '/wp-cfm-json';

	return $config_url;
}

add_filter( 'wpcfm_config_dir', __NAMESPACE__ . '\change_config_dir' );
/**
 * Change path of WP-CFM config files
 *
 * @param string $config_dir - Default is "<root>/wp-content/config"
 * @return string
 */
function change_config_dir( $config_dir ) {
	$config_dir = WPMU_PLUGIN_DIR . '/wp-cfm-json';

	return $config_dir;
}
