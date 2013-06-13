<?php
/**
 * This widget displays a featured agent.
 *
 * @author Justin Tallant
 * @package plugins
 * @subpackage agent_profiles
 */
class AgentEvolution_Profiles_Widget extends WP_Widget {

	function AgentEvolution_Profiles_Widget() {
		$widget_ops = array( 'classname' => 'featured-agent clearfix', 'description' => __( 'Display featured agent', 'aep' ) );
		$control_ops = array( 'width' => 300, 'height' => 350 );
		$this->WP_Widget( 'featured-agent', __( 'Agentevo - Featured Agent', 'aep' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		/** defaults */
		$instance = wp_parse_args( $instance, array(
			'post_id'	=> '',
			'show_all'	=> 0
		) );

		extract( $args );

		echo $before_widget;

			if ( $instance['show_all'] == 1 ) {
				echo $before_title . apply_filters( 'widget_title', 'Featured Agents' , $instance, $this->id_base ) . $after_title;
				$query_args = array(
					'post_type'			=> 'aeprofiles',
					'posts_per_page'	=> -1,
					'orderby'	=> 'menu_order',
					'order'		=> 'ASC'
				);
			} elseif ( !empty( $instance['post_id'] ) ) {
				$post_id = explode( ',', $instance['post_id']);
				echo $before_title . apply_filters( 'widget_title', $post_id[1], $instance, $this->id_base ) . $after_title;
				$query_args = array(
					'post_type'			=> 'aeprofiles',
					'p'					=> $post_id[0],
					'posts_per_page'	=> 1
				);
			}

			query_posts( $query_args );

			if ( have_posts() ) : while ( have_posts() ) : the_post();

				if ( $instance['show_all'] == 1 )
					echo '<div class="widget-agent-wrap">';

<<<<<<< HEAD
				echo '<a href="' . get_permalink() . '">' . agentevo_image($size='agent-profile-photo') . '</a>';
				echo '<div class="widget-agent-details">' . do_agent_details() . '</div>';
				echo do_agent_social();
=======
				echo '<a href="' . get_permalink() . '">' . agentevo_image() . '</a>';
				echo '<div class="widget-agent-details">' . aep_do_agent_details() . '</div>';
				echo aep_do_agent_social();
>>>>>>> f01b1dba34ffcb50f20cee859f3b73fa4fa4e71b

				if ( $instance['show_all'] == 1 )
					echo '</div><!-- .widget-agent-wrap -->';

			endwhile; endif;
			wp_reset_query();

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( $instance, array(
			'post_id'   =>	'',
			'show_all'	=>	0
		) );

		echo '<p>';
		echo '<label for="' . $this->get_field_id( 'post_id' ) . '">Select an Agent or check the box to show all:</label>';
		echo '<select id="' . $this->get_field_id( 'post_id' ) . '" name="' . $this->get_field_name( 'post_id' ) . '" class="widefat" style="width:100%;">';
			global $post;
			$args = array('post_type' => 'aeprofiles');
			$agents = get_posts($args);
			foreach( $agents as $post ) : setup_postdata($post);
				echo '<option style="margin-left: 8px; padding-right:10px;" value="' . $post->ID . ',' . $post->post_title . '" ' . selected( $post->ID . ',' . $post->post_title, $instance['post_id'], false ) . '>' . $post->post_title . '</option>';
			endforeach;
		echo '</select>';
		echo '</p>';

		?>
		<p>
			<input class="checkbox" type="checkbox" value="1" <?php checked( $instance['show_all'], 1 ); ?> id="<?php echo $this->get_field_id( 'show_all' ); ?>" name="<?php echo $this->get_field_name( 'show_all' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_all' ); ?>">Show all agents?</label>
		</p>
		<?php
	}
}
