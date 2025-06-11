<?php
/**
 * Plugin Name: MRW Functionality Plugin
 * Description: Standard Tweaks to WP functions for all sites by MRW Web Design
 * Version: 1.0
 * Author: Mark Root-Wiley, MRW Web Design
 * Author URI: https://MRWweb.com
 *
 * @package _mrw-mu-plugins
 */

namespace MRW\Site;

if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	add_action(
		'admin_init',
		function () {
			define( 'DISALLOW_FILE_EDIT', true ); //phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound
		}
	);
}

add_action( 'init', __NAMESPACE__ . '\feed_links' );
/**
 * Clean up the <head> to remove generator links and ensure RSS support
 *
 * @return void
 */
function feed_links() {
	add_theme_support( 'automatic-feed-links' );
}

add_action( 'init', __NAMESPACE__ . '\page_post_type_supports' );
/**
 * Add and remove post type supports for the Page post type
 *
 * @return void
 */
function page_post_type_supports() {
	add_post_type_support( 'page', 'excerpt' );
	add_post_type_support( 'page', 'post-thumbnail' );
}

add_shortcode( 'email', __NAMESPACE__ . '\hide_email' );
/**
 * Obfuscate email shortcode
 * 
 * Simple Usage: [email]hello@example.org[/email]
 * 
 * Advanced Usage: [email subject="Optional Subject" email="hello@example.com"]email us[/email]
 *
 * @param array $atts with one optional parameter: subject
 * @param string $content content of shortcode which should be an email
 * @return string obfuscated email link
 */
function hide_email($atts , $content = null ) {
	$atts = shortcode_atts(
		array(
			'subject' => '',
			'email'   => false,
		),
		$atts,
		'email'
	);

	if ( ! is_email($content) && ! is_email($atts['email']) ) {
		return;
	}

	$anchor = $content;
	$email = ! $atts['email'] ? $content : $atts['email'];

	return sprintf(
		'<a href="mailto:%1$s%2$s">%3$s</a>',
		antispambot($email),
		! empty( $atts['subject'] ) ? '?subject=' . rawurlencode(esc_attr($atts['subject'])) : '',
		is_email( $anchor ) ? antispambot($anchor) : $anchor
	);
}

add_filter( 'login_headerurl', __NAMESPACE__ . '\login_logo_url' );
/**
 * Change URL of logo on login screen to go to site homepage
 *
 * @return string URL
 */
function login_logo_url() {
	return esc_url( get_bloginfo( 'url' ) );
}

add_filter( 'login_headertext', __NAMESPACE__ . '\login_logo_url_title' );
/**
 * Change title/alt of logo to be the site name
 *
 * @return URL title
 */
function login_logo_url_title() {
	return esc_html( get_bloginfo( 'name' ) );
}

require_once __DIR__ . '/functionality/remove-comments.php';