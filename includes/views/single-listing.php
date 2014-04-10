<?php
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single' );
remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );

add_action( 'genesis_after_entry', 'aeprofiles_show_connected_agent' );

function aeprofiles_show_connected_agent() {
	if (function_exists('_p2p_init') && function_exists('agentpress_listings_init')) {
		echo'
		<div class="connected-agent-listings">';
		aeprofiles_connected_agents_markup();

	echo '</div>';
	}
}

genesis();