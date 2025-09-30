<?php
/**
 * A shortcode to obfuscate email addresses and set subject for mailto links
 *
 * @package _mrw-mu-plugins
 */

namespace _CLIENT\Site;

add_shortcode( 'email', __NAMESPACE__ . '\hide_email' );
/**
 * Obfuscate email shortcode
 *
 * Simple Usage: [email]hello@example.org[/email]
 *
 * Advanced Usage: [email subject="Optional Subject" email="hello@example.com"]email us[/email]
 *
 * @param array  $atts with one optional parameter: subject
 * @param string $content content of shortcode which should be an email
 * @return string obfuscated email link
 */
function hide_email( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'subject' => '',
			'email'   => false,
		),
		$atts,
		'email'
	);

	if ( ! is_email( $content ) && ! is_email( $atts['email'] ) ) {
		return;
	}

	$anchor = $content;
	$email  = ! $atts['email'] ? $content : $atts['email'];

	return sprintf(
		'<a href="mailto:%1$s%2$s">%3$s</a>',
		antispambot( $email ),
		! empty( $atts['subject'] ) ? '?subject=' . rawurlencode( esc_attr( $atts['subject'] ) ) : '',
		is_email( $anchor ) ? antispambot( $anchor ) : $anchor
	);
}