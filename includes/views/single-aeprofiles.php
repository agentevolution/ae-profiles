<?php
remove_action( 'genesis_before_post_content', 'genesis_post_info' );
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
remove_action( 'genesis_after_post', 'genesis_do_author_box_single' );
remove_action( 'genesis_post_content' , 'genesis_do_post_content' );
remove_action( 'genesis_after_post_content', 'agentevo_post_meta' );
remove_action( 'genesis_after_post', 'genesis_get_comments_template' );
add_action( 'genesis_post_content' , 'agent_post_content' );

function agent_post_content() { ?>

	<div class="agent-wrap">
		<?php echo agentevo_image($size='agent-profile-photo'); ?>
		<div class="agent-details vcard">
			<span class="fn" style="display:none;"><?php the_title(); ?></span>
			<?php echo aep_do_agent_details(); ?>
			<?php echo aep_do_agent_social(); ?>
		</div> <!-- .agent-details -->
	</div> <!-- .agent-wrap -->

	<div class="agent-bio">
		<?php the_content(); ?>
	</div><!-- .agent-bio -->

<?php }

genesis();