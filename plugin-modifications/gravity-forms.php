<?php
/**
 * Modifications to the Gravity Forms defaults
 *
 * @package _mrw-mu-plugins
 */

add_filter( 'gform_form_settings_initial_values', __NAMESPACE__ . '\default_form_settings' );
/**
 * Set my preferred default settings for new forms
 *
 * @param array $initial_values
 * @return array $values
 * 
 * @see https://docs.gravityforms.com/gform_form_settings_initial_values/
 */
function default_form_settings( $initial_values ) {
   
    $initial_values['enableHoneypot'] = true;
    $initial_values['descriptionPlacement'] = 'above';
    $initial_values['validationPlacement'] = 'above';
    $initial_values['subLabelPlacement'] = 'above';
    $initial_values['validationSummary'] = true;
  
    return $initial_values;
}