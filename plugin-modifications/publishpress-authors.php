<?php
/**
 * Modifications to the PublishPress Authors defaults
 *
 * @package via-nova-training-mu-plugins
 */

namespace ViaNova\Site;

add_action( 'init', __NAMESPACE__ . '\let_editors_add_authors', 11 );
/**
 * Let authors add new authors
 *
 * @return void
 */
function let_editors_add_authors() {
	// Gets the simple_role role object.
	$role = get_role( 'editor' );

	// Add a new capability.
	$role->add_cap( 'ppma_manage_authors', true );
}

add_filter( 'render_block_publishpress-authors/author-boxes-block', __NAMESPACE__ . '\author_block_link_fix', 10, 2 );
/**
 * Fix the author block link text to be clear about link purpose
 *
 * @param array $block_content The block content.
 * @param array $block The block data.
 * @return array The modified block content.
 */
function author_block_link_fix( $block_content, $block ) {
	// "Inline with Avatars" layout
	if ( $block['attrs']['selectedBoxId'] === 'ppma_boxes_1958' ) { // ⚠️ Make sure this ID is correct for your site
		ob_start();
		do_action( 'pp_multiple_authors_show_author_box', false, 'author-byline', false, true );
		$block_content = ob_get_clean();
	}
	return $block_content;
}
