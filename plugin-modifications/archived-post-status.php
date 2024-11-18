<?php
/**
 * Modifications to the Archived Post Status plugin
 *
 * @package _mrw-mu-plugins
 */

// Don't show "Archived" status in the admin "All" post list.
add_filter( 'aps_status_arg_public', '__return_false' );
add_filter( 'aps_status_arg_private', '__return_false' );
add_filter( 'aps_status_arg_show_in_admin_all_list', '__return_false' );
