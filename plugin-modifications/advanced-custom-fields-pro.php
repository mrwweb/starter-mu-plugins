<?php
/**
 * Advanced Custom Field PRO Modifications
 * 
 * Notably: change sync folder to mu-plugins subfolder, security hardening
 */

namespace _MRW_\ACF;

add_action( 'acf/init', __NAMESPACE__ . '\remove_acf_shortcode' );
/**
 * Harden site security by preventing use of [acf] shortcode
 *
 * @see https://www.advancedcustomfields.com/blog/acf-6-0-3-release-security-changes-to-the-acf-shortcode-and-ui-improvements/#acf-shortcode
 */
function remove_acf_shortcode() {
	acf_update_setting( 'enable_shortcode', false );
}

// sync ACF JSON fields in new mu-plugins folder
add_filter('acf/settings/save_json', __NAMESPACE__ . '\acf_json_sync_location');
function acf_json_sync_location( $path ) {
	$path = WPMU_PLUGIN_DIR . '/acf-json';
	return $path;
}

add_filter('acf/settings/load_json', __NAMESPACE__ . '\acf_json_load_point');
function acf_json_load_point( $paths ) {
	// remove original path
	unset($paths[0]);
	// append path
	$paths[] = WPMU_PLUGIN_DIR . '/acf-json';
	return $paths;  
}

add_filter( 'rest_prepare_taxonomy', __NAMESPACE__ . '\acf_hide_taxonomy_fix', 10, 3 );
/**
 * Make the "No metabox" option in ACF for taxonomies work for the block editor
 *
 * @see https://support.advancedcustomfields.com/forums/topic/hiding-removing-acf-custom-taxonomy-meta-boxes-in-gutenberg-editor-sidebar-2/#post-161683
 */
function acf_hide_taxonomy_fix( $response, $taxonomy, $request ) {
    $context = ! empty( $request['context'] ) ? $request['context'] : 'view';
    // Context is edit in the editor
    if( $context === 'edit' && $taxonomy->meta_box_cb === false ){
        $data_response = $response->get_data();
        $data_response['visibility']['show_ui'] = false;
        $response->set_data( $data_response );
    }
    return $response;
}
