<?php
remove_action( 'genesis_before_post_content', 'genesis_post_info' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 ); // HTML5
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' ); // HTML5
remove_action( 'genesis_after_post', 'genesis_do_author_box_single' );
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single' ); // HTML5
remove_action( 'genesis_post_content' , 'genesis_do_post_content' );
remove_action( 'genesis_entry_content' , 'genesis_do_post_content' ); // HTML5
remove_action( 'genesis_after_post_content', 'agentevo_post_meta' );
remove_action( 'genesis_entry_footer', 'agentevo_post_meta' ); // HTML5
remove_action( 'genesis_after_post', 'genesis_get_comments_template' );
remove_action( 'genesis_after_entry', 'genesis_get_comments_template' ); // HTML5
add_action( 'genesis_post_content' , 'agent_post_content' );
add_action( 'genesis_entry_content' , 'agent_post_content' ); // HTML5

function agent_post_content() { ?>

	<div class="agent-wrap">
		<?php echo agentevo_image($size='agent-profile-photo'); ?>
		<div class="agent-details vcard">
			<span class="fn" style="display:none;"><?php the_title(); ?></span>
			<?php echo do_agent_details(); ?>
			<?php echo do_agent_social(); ?>
		</div> <!-- .agent-details -->
	</div> <!-- .agent-wrap -->

	<div class="agent-bio">
		<?php the_content(); ?>
	</div><!-- .agent-bio -->

<?php }

genesis();