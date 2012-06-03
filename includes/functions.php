<?php
/**
 * Holds functions used by the Agent Evolution Profiles Plugin
 */

add_action('template_redirect', 'aep_template_redirect');

/**
 * Controls template redirects for agent directory templates
 *
 * By handling redirects in this manner and keeping the plugin templates
 * separate from your themes core templates you avoid serving the wrong
 * template for other taxonomies your theme is using or have been created
 * by other plugins. You can safely edit your taxonomy.php file and not
 * worry about the edits affecting the way agent directory templates
 * are displayed.
 *
 * The function will check to see if a template with the same name already
 * exists in the active theme files. If it does it will return that template
 * else it will return the templates stored in the plugin. This is to allow
 * editing of the plugin templates without those edits being overwritten in
 * an update to this plugin.
 */
function aep_template_redirect() {
	/**
	 * Finds the taxonomy queried. Used to determine which template is served.
	 */
	$taxonomy = get_query_var('taxonomy');

	/**
	 * Finds the post type queried.
	 */
	$post_type = get_query_var('post_type');

	/**
	 * Gets the path to the views directory of the aep plugin
	 */
	$views_dir = dirname( __FILE__ ) . '/views/';

	/**
	 * Gets the path to the active theme directory
	 */
	$active_theme_dir = get_stylesheet_directory();

	/** The aeprofiles single post redirect */
	if ( is_single() && $post_type == 'aeprofiles' ) {
		if (file_exists($active_theme_dir . '/single-aeprofiles.php')) {
			return;
		} else {
			require_once($views_dir . 'single-aeprofiles.php');
			exit;
		}
	/** The aeprofiles archive redirect */
	} elseif ( is_archive() && $post_type == 'aeprofiles' ) {
		if (file_exists($active_theme_dir . '/archive-aeprofiles.php')) {
			return;
		} else {
			require_once($views_dir . 'archive-aeprofiles.php');
			exit;
		}
	}
}

/**
 * Shows default image if genesis_image() returns false
 */
 function aep_image() {
	if ( genesis_get_image( array( 'size' => 'thumbnail' ) ) ) {
		return genesis_get_image( array( 'size' => 'thumbnail' ) );
	} else {
		return '<img src="' . AEP_URL . '/images/default-biz-thumb.png' . '" alt="no preview available" />';
	}
 }

 function do_agent_details() {

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

		$output .= $address;
	}

	return $output;
 }

 function do_agent_social() {
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