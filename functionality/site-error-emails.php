<?php
/**
 * Route site error emails to my email address
 *
 * @package _mrw-mu-plugins
 */

namespace MRW\Site;

add_filter( 'recovery_mode_email', __NAMESPACE__ . '\recovery_mode_email' );
/**
 * Sets the recovery mode to email address instead of the default Admin Email setting
 *
 * @param string $email array of data about error email
 * @return array
 */
function recovery_mode_email( $email ) {
	$email['to'] = 'info@mrwweb.com';

	return $email;
}
