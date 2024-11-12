<?php
/*
Plugin Name: The Events Calendar Customizations
Description: An assortment of changes to how The Events Calendar behaves. You are encouraged to delete, add, and revise this file to meet your needs!
Version: 2.1.0
Author: Mark Root-Wiley, MRW Web Design
Author URI: https://MRWweb.com
Plugin URI: https://github.com/mrwweb/the-events-calendar-reset
*/

namespace _MRW_\TEC;

/**
 * Useful helper function to detect Tribe Events pages in your theme
 *
 * Modified slightly from the link
 *
 * Usage: \_MRW_\TEC\is_tribe_view()
 *
 * @link https://gist.github.com/samkent/b98bd3c9b28426b8461bc1417adf7b5d
 */
function is_tribe_view() {
	return
		(
			function_exists( 'tribe_is_event' ) &&
			tribe_is_event()
		) ||
		(
			function_exists( 'tribe_is_event_category' ) &&
			tribe_is_event_category()
		) ||
		(
			function_exists( 'tribe_is_in_main_loop' ) &&
			tribe_is_in_main_loop()
		) ||
		(
			function_exists( 'tec_is_view' ) &&
			tec_is_view()
		) ||
		'tribe_events' === get_post_type() ||
		is_singular( 'tribe_events' );
}

add_filter( 'tribe_events_views_v2_bootstrap_html', __NAMESPACE__ . '\replace_section_with_div' );
/**
 * Replace the wrapping <section> element surrounding all output with a <div>
 */
function replace_section_with_div( $html ) {
	return str_replace( '<section', '<div', str_replace( '</section>', '</div>', $html ) );
}

add_filter( 'tribe_get_organizer_website_link_label', __NAMESPACE__ . '\return_organizer_name', 99 );
/**
 * Use Organizer name for Event Organizer Website Link
 */
function return_organizer_name() {
	return tribe_get_organizer();
}

add_filter( 'tribe_get_venue_link', __NAMESPACE__ . '\venue_link', 10, 4 );
/**
 * Link Venue Name to Website instead of venue
 */
function venue_link( $link, $venue_id, $full_link, $url ) {
	if( $full_link ) {
		$venue_name = tribe_get_venue( $venue_id );
		$website = tribe_get_venue_website_url( $venue_id );
		if( $website ) {
			$link = str_replace( $url, $website, $link );
			$link = str_replace( 'title="' . $venue_name . '"', '', $link );
		}
	}
	return $link;
}

add_filter( 'register_tribe_events_post_type_args', __NAMESPACE__ . '\no_tags_on_events' );
/**
 * Remove post_tag from tribe_events post_type
 */
function no_tags_on_events( $args ) {
    $args['taxonomies'] = [];

    return $args;
}

add_action( 'pre_get_posts', __NAMESPACE__ . '\no_events_in_tag_archives' );
/**
 * Exclude tribe_events posts from tag archives
 */
function no_events_in_tag_archives( $query ) {
	if( ! is_admin() && ! $query->is_main_query() ) {
		return;
	}

	if( is_tag() ) {
		$query->set( 'post_type', [ 'post' ] );
	}
}

// hide "Recent Past Events" when there are no upcoming events
// add_filter( 'tribe_events_views_v2_show_latest_past_events_view', '__return_false' );

// List View
add_filter( 'tribe_events_views_v2_view_list_template_vars', __NAMESPACE__ . '\tribe_past_reverse_chronological_v2', 100, 2 );
/**
 * Changes Past Event to Reverse Chronological Order
 *
 * @param array $template_vars An array of variables used to display the current view.
 *
 * @return array Same as above. 
 */
function tribe_past_reverse_chronological_v2( $template_vars, $view ) {
	if ( ! empty( $template_vars['is_past'] ) ) {
		$template_vars['events'] = array_reverse( $template_vars['events'] );
	}

	return $template_vars;
}

add_filter( 'tribe_template_html', __NAMESPACE__ . '\prevent_ajax_page_loads', 10, 4 );
/**
 * Prevent AJAX page loads by removing the data-js attribute that triggers them
 * 
 * Due to the number of changes required via PHP templates and filters (Category filters, archive titles, etc.), the AJAX page loads cause more problems than they solve
 */
function prevent_ajax_page_loads( $html, $file, $name, $template ) {
	return str_replace( 'data-js="tribe-events-view-link"', '', $html );
}

add_filter( 'tribe_get_events_title', __NAMESPACE__ . '\archive_title', 11 );
add_filter( 'get_the_archive_title', __NAMESPACE__ . '\archive_title', 11 );
/**
 * Change "Events" to "Upcoming Events"/"Past Events" for List/Month/Day page
 *
 * Known issue: does not work with AJAX paging. Reverts to "Events"
 */
function archive_title( $title ) {
    if( 'tribe_events' === get_post_type() ) {

        if( tribe_is_past() || ( $_GET['eventDisplay'] ?? '' ) === 'past' ) {
            $title = 'Past Events';
        } elseif ( tribe_is_upcoming() ) {
			$title = 'Upcoming Events';
		} else {
			$title = "Events";
        }

    }

    return $title;
}

add_action( 'tribe_template_after_include:events/v2/components/before', __NAMESPACE__ . '\events_archive_header', 9 );
/**
 * Add Title to Event Archive Pages
 *
 * Use Post Type Archive Descriptions plugin to edit archive description
 * https://wordpress.org/plugins/post-type-archive-descriptions/
 */
function events_archive_header() {
	if( get_post_type() !== 'tribe_event_series' ) {
		echo '<header class="page-header is-layout-constrained alignfull">';
		the_archive_title( '<h1 class="archive-title page-title">', '</h1>' );
		the_archive_description( '<div class="archive-description">', '</div>' );
		echo '</header>';
	}
}

/**
 * Remove "Events" menu from WordPress admin bar
 *
 * @see https://theeventscalendar.com/knowledgebase/k/remove-events-from-the-wordpress-admin-bar/
 */
define( 'TRIBE_DISABLE_TOOLBAR_ITEMS', true );
