<?php
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
// remove_action( 'genesis_before_post_content', 'genesis_post_info' );
// remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
// remove_action( 'genesis_after_post', 'genesis_do_author_box_single' );
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');
remove_action( 'genesis_loop', 'genesis_do_loop');
add_action( 'genesis_loop' , 'agent_directory_archive_loop' );
add_filter( 'body_class', 'add_body_class' );
function add_body_class( $classes ) {
   $classes[] = 'archive-aeprofiles';
   return $classes;
}

function agent_directory_archive_loop() {

	$options = get_option('plugin_ae_profiles_settings');

	$title = preg_replace('/-/', ' ', $options['slug']);

	echo '<div class="responsive-wrap"><h1 class="entry-title">', $title, '</h1>';

	$class = '';

	if ( have_posts() ) : while ( have_posts() ) : the_post();

	// starting at 0
	$class = ( $class == 'first' ) ? '' : 'first';

	?>

	<div class="agent-wrap one-half <?php echo $class; ?>">
		<?php printf('<a href="%s" class="">%s</a>', get_permalink(), agentevo_image() ); ?>
		<div class="agent-details vcard">
		<?php

		printf('<p><a class="fn" href="%s">%s</a></p>', get_permalink(), get_the_title() );

		echo aep_do_agent_details();
		echo aep_do_agent_social();

		?>
		</div><!-- .agent-details -->
	</div> <!-- .agent-wrap -->

	<?php endwhile; genesis_posts_nav(); else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php endif;

	echo '</div><!-- .responsive-wrap -->';
}

genesis();