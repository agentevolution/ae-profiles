<?php
/**
 * Holds functions used by the Agent Evolution Profiles Plugin
 */

add_filter( 'template_include', 'aep_template_include' );

function aep_template_include( $template ) {

    $post_type = 'aeprofiles';

    if ( ae_is_taxonomy_of($post_type) ) {
        if ( file_exists(get_stylesheet_directory() . '/archive-' . $post_type . '.php' ) ) {
            return get_stylesheet_directory() . '/archive-' . $post_type . '.php';
        } else {
            return dirname( __FILE__ ) . '/views/archive-' . $post_type . '.php';
        }
    }

    if ( is_post_type_archive( $post_type ) ) {
        if ( file_exists(get_stylesheet_directory() . '/archive-' . $post_type . '.php') ) {
            return $template;
        } else {
            return dirname( __FILE__ ) . '/views/archive-' . $post_type . '.php';
        }
    }

    if ( $post_type == get_post_type() ) {
        if ( file_exists(get_stylesheet_directory() . '/single-' . $post_type . '.php') ) {
            return $template;
        } else {
            return dirname( __FILE__ ) . '/views/single-' . $post_type . '.php';
        }
    }

    return $template;
}

function aep_do_agent_details() {

    $output = '';

    if (genesis_get_custom_field('_agent_title') != '')
        $output .= sprintf('<p class="title">%s</p>', genesis_get_custom_field('_agent_title') );

    if (genesis_get_custom_field('_agent_phone') != '')
        $output .= sprintf('<p class="tel"><span class="type">Work</span>%s</p>', genesis_get_custom_field('_agent_phone') );

    if (genesis_get_custom_field('_agent_email') != '')
        $output .= sprintf('<p><a class="email" href="mailto:%s">%s</a></p>', genesis_get_custom_field('_agent_email'), genesis_get_custom_field('_agent_email') );

    if (genesis_get_custom_field('_agent_city') != '' || genesis_get_custom_field('_agent_address') != '' || genesis_get_custom_field('_agent_state') != '' ) {

        $address = '<p class="adr">';

        if (genesis_get_custom_field('_agent_address') != '') {
            $address .= '<span class="street-address">' . genesis_get_custom_field('_agent_address') . '</span>, ';
        }

        if (genesis_get_custom_field('_agent_city') != '') {
            $address .= '<span class="locality">' . genesis_get_custom_field('_agent_city') . '</span>, ';
        }

        if (genesis_get_custom_field('_agent_state') != '') {
            $address .= '<abbr class="region">' . genesis_get_custom_field('_agent_state') . '</abbr>';
        }

        $address .= '</p>';

        if (genesis_get_custom_field('_agent_address') != '' || genesis_get_custom_field('_agent_city') != '' || genesis_get_custom_field('_agent_state') != '' ) {
            $output .= $address;
        }
    }

    return $output;
}

function aep_do_agent_social() {

    if (genesis_get_custom_field('_agent_facebook') != '' || genesis_get_custom_field('_agent_twitter') != '' || genesis_get_custom_field('_agent_linkedin') != '') {

        $output = '<div class="agent-social-profiles">';

        if (genesis_get_custom_field('_agent_facebook') != '') {
            $output .= sprintf('<a class="agent-facebook" href="%s" title="Facebook Profile"></a>', genesis_get_custom_field('_agent_facebook'));
        }

        if (genesis_get_custom_field('_agent_twitter') != '') {
            $output .= sprintf('<a class="agent-twitter" href="%s" title="Twitter Profile"></a>', genesis_get_custom_field('_agent_twitter'));
        }

        if (genesis_get_custom_field('_agent_linkedin') != '') {
            $output .= sprintf('<a class="agent-linkedin" href="%s" title="LinkedIn Profile"></a>', genesis_get_custom_field('_agent_linkedin'));
        }

        $output .= '</div><!-- .agent-social-profiles -->';

        return $output;
    }
}