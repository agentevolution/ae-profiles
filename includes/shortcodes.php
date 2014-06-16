<?php 
/**
 * Adds shortcode to display agent profiles
 */

add_shortcode( 'agent_profiles', 'gap_profile_shortcode' );

function gap_profile_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'id'   => ''
    ), $atts ) );

    if ($id == '') {
        $query_args = array(
            'post_type'       => 'aeprofiles',
            'posts_per_page'  => -1,
            'orderby'   => 'menu_order',
            'order'     => 'ASC'

        );
    } else {
        $query_args = array(
            'post_type'       => 'aeprofiles',
            'post__in'        => explode(',', $id),
            'posts_per_page'  => -1,
            'orderby'         => 'menu_order',
            'order'           => 'ASC'

        );
    }

    global $post;

    $profiles_array = get_posts( $query_args );

    $output = '';

    foreach ( $profiles_array as $post ) : setup_postdata( $post );

        $output .= '<div class="shortcode-agent-wrap">';
        $output .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post->ID, 'agent-profile-photo' ) . '</a>';
        $output .= '<div class="shortcode-agent-details"><a class="fn" href="' . get_permalink() . '">' . get_the_title() . '</a>';
        $output .= do_agent_details();
        if (function_exists('_p2p_init') && function_exists('agentpress_listings_init') || function_exists('_p2p_init') && function_exists('wp_listings_init')) {
            $output .= '<a class="agent-listings-link" href="' . get_permalink() . '#agent-listings">View My Listings</a>';
        }
        
        $output .= '</div>';
        $output .= do_agent_social();

        $output .= '</div><!-- .shortcode-agent-wrap -->';

    endforeach;
    wp_reset_postdata();

    echo $output;
    
}
