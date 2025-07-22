<?php
/*
Plugin Name: Announcement Banner Feature
Description: Requires synced ACF field
Version: 1.0
Author: Mark Root-Wiley
Author URI: https://MRWweb.com
*/

namespace _MRW\Site;

add_action( 'acf/init', __NAMESPACE__ . '\options_page' );
function options_page() {

	acf_add_options_page( [
		'page_title' 	=> 'Banner Message',
		'menu_title'	=> 'Banner Message',
		'menu_slug'		=> 'banner-message',
		'capability'	=> 'manage_options',
		'position'		=> 207,
		'icon_url'		=> 'dashicons-megaphone',
		'autoload'		=> true,
	] );

}

// Required to use menu_order
add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', __NAMESPACE__ . '\menu_order', 10000 );
/**
 * Put announcement banner directly above Separator 1, even when Menu Humility plugin is active
 *
 * @param array $menu menu order
 * @return array updated $menu order
 */
function menu_order( $menu ) {
	$banner_key = array_search( 'banner-message', $menu );
	$separator1_key = array_search( 'separator1', $menu );
	array_splice( $menu, $separator1_key, 0, $menu[$banner_key] );
	unset( $menu[$banner_key + 1] );
	
	return $menu;
}

add_action( 'wp_body_open', __NAMESPACE__ . '\banner_markup', -999 );
function banner_markup() {
	$show_banner = get_option( 'options_banner_state' );
	$banner_content = get_option( 'options_banner_message' );
	$banner_use_expiration_date = get_option( 'options_set_banner_expiration_date' );
	$banner_expiration_date = get_option( 'options_banner_expiration_date' );

	$banner = sprintf(
		'<p class="announcement-banner">%1$s</p>',
		wp_kses_post( $banner_content )
	);

	if( '1' === $show_banner && ! empty( $banner_content ) ) {

		if( '1' === $banner_use_expiration_date ) {

			$now = wp_date( 'Ymd' );
			if ( $now < $banner_expiration_date ) {
				// output content because banner is visible and expiration is in future
				echo $banner;
			} else {
				// don't output content and turn off the banner options
				delete_option( 'options_banner_state' );
				delete_option( 'options_set_banner_expiration_date' );
				delete_option( 'options_banner_expiration_date' );
			}

		} else {
			// output content because banner is visible and not using expiration date
			echo $banner;
		}
	}

}

add_filter( 'acf/fields/wysiwyg/toolbars' , __NAMESPACE__ . '\add_very_simple_acf_toolbar'  );
function add_very_simple_acf_toolbar( $toolbars ) {
    // remove the 'Basic' toolbar completely
	$toolbars['Very Simple'] = array();
    $toolbars['Very Simple'][1] = array( 'bold', 'italic', 'link', 'undo', 'redo' );

    // return $toolbars - IMPORTANT!
    return $toolbars;
}

add_action( 'admin_head', __NAMESPACE__ . '\admin_styles' );
function admin_styles() {
   ?>
   <style>
    .acf-field-625071dfc506e .acf-editor-wrap iframe {
        min-height: auto;
        height: 3lh !important;
    }
    .announcement-banner-active #toplevel_page_banner-message .dashicons-megaphone::before {
        margin: 5px 0 0 2px;
        padding: 3px;
        border-radius: 50%;
        background-color: #52aa59;
        color: #fff !important;
		width: 18px;
		height: 18px;
		font-size: 18px;
    }
   </style>
   <?php
}

add_filter( 'admin_body_class', __NAMESPACE__ . '\admin_body_class' );
function admin_body_class( $classes ) {
    if ( get_option( 'options_banner_state' ) ) {
        $classes .= ' announcement-banner-active ';
    }
    return $classes;
}