<?php
/*
	Plugin Name: Agent Evolution Profiles
	Plugin URI: http://www.agentevolution.com
	Description: Adds an agent directory post type and custom templates
	Author: Justin Tallant
	Author URI: http://www.justintallant.com

	Version: 0.1.0

	License: GNU General Public License v2.0 (or later)
	License URI: http://www.opensource.org/licenses/gpl-license.php
*/

register_activation_hook( __FILE__, 'ae_profiles_activation' );
/**
 * This function runs on plugin activation. It checks to make sure the required
 * minimum Genesis version is installed. If not, it deactivates itself.
 *
 * @since 0.1.0
 */
function ae_profiles_activation() {

		$latest = '1.7.1';

		$theme_info = get_theme_data( get_template_directory() . '/style.css' );

		if ( 'genesis' != basename( get_template_directory() ) ) {
	        deactivate_plugins( plugin_basename( __FILE__ ) ); /** Deactivate ourself */
			wp_die( sprintf( __( 'Sorry, you can\'t activate unless you have installed <a href="%s">Genesis</a>', 'aep' ), 'http://www.studiopress.com/themes/genesis' ) );
		}

		if ( version_compare( $theme_info['Version'], $latest, '<' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) ); /** Deactivate ourself */
			wp_die( sprintf( __( 'Sorry, you cannot activate without <a href="%s">Genesis %s</a> or greater', 'aep' ), 'http://www.studiopress.com/support/showthread.php?t=19576', $latest ) );
		}

		/** Flush rewrite rules */
		if ( ! post_type_exists( 'aeprofiles' ) ) {
			agent_profiles_init();
			global $_agent_directory;
			$_agent_directory->create_post_type();
		}
		flush_rewrite_rules();

}

add_action( 'after_setup_theme', 'agent_profiles_init' );
/**
 * Initialize Agent Directory.
 *
 * Include the libraries, define global variables, instantiate the classes.
 *
 * @since 0.1.0
 */
function agent_profiles_init() {

	/** Do nothing if a Genesis child theme isn't active */
	if ( ! function_exists( 'genesis_get_option' ) )
		return;

	global $_agent_directory;

	define( 'AEP_URL', plugin_dir_url( __FILE__ ) );
	define( 'AEP_VERSION', '0.1.0' );

	/** Loads textdomain for translation */
	load_plugin_textdomain( 'aep', false, basename( dirname( __FILE__ ) ) . '/languages/' );

	/** Includes */
	require_once( dirname( __FILE__ ) . '/includes/class-aeprofiles.php' );
	require_once( dirname( __FILE__ ) . '/includes/functions.php' );
	require_once( dirname( __FILE__ ) . '/includes/class-agent-evolution-profiles-widget.php');

	/** Enqueus style file if it exists */
	add_action('wp_enqueue_scripts', 'add_aep_css');
	function add_aep_css() {
		$options = get_option('plugin_ae_profiles_settings');
		if ( !isset($options['stylesheet_load']) ) {
			$options['stylesheet_load'] = 0;
		}
		if ( '1' != $options['stylesheet_load'] ) {
	        $aep_css_path = AEP_URL . 'aep.css';
	        if ( file_exists(dirname( __FILE__ ) . '/aep.css') ) {
	            wp_register_style('aepCSS', $aep_css_path);
	            wp_enqueue_style('aepCSS');
	        }
		}
    }

    add_action( 'widgets_init', 'register_agent_directory_widget' );

    function register_agent_directory_widget() {
    	register_widget('AgentEvolution_Profiles_Widget');
    }

	/** Instantiate */
	$_agent_directory = new Agent_Directory;

	/**
	 * @todo add localization, create localization file.
	 */

}
