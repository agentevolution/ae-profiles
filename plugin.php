<?php
/*
	Plugin Name: Agent Profiles
	Plugin URI: http://www.agentevolution.com
<<<<<<< HEAD
	Description: Adds an agent directory post type and custom templates
	Author: Agent Evolution
	Author URI: http://www.agentevolution.com
=======
	Description: Adds an agent profiles post type and custom templates
	Author: jtallant
	Author URI: http://agentevolution.com
>>>>>>> f01b1dba34ffcb50f20cee859f3b73fa4fa4e71b

	Version: 0.9

	License: GNU General Public License v2.0 (or later)
	License URI: http://www.opensource.org/licenses/gpl-license.php
*/

/**
 * Registers the activation hook if the plugin
 * is not being used inside the agentevo framework
 */
if ( ! defined('AGENTEVO_LIB_URL') ) {
	register_activation_hook( __FILE__, 'agent_profiles_activation' );
}

/**
 * Initiliazes the post type
 *
 * @since 0.1.0
 */
function agent_profiles_activation() {

<<<<<<< HEAD
		if ( 'genesis' != basename( get_template_directory() ) ) {
	        deactivate_plugins( plugin_basename( __FILE__ ) ); /** Deactivate ourself */
			wp_die( sprintf( __( 'Sorry, you can\'t activate unless you have installed <a href="%s">Genesis</a>', 'aep' ), 'http://agentevo.com/genesis' ) );
		}
=======
	if ( agent_profiles_maybe_deactivate() ) {
		wp_die( sprintf( __( 'Sorry, you can\'t activate unless you have installed <a href="%s">Genesis</a>', 'aep' ), 'http://www.studiopress.com/themes/genesis' ) );
	}
>>>>>>> f01b1dba34ffcb50f20cee859f3b73fa4fa4e71b

	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

add_action('switch_theme', 'agent_profiles_maybe_deactivate');
/**
 * Deactivates the ae-profiles plugin if genesis is not installed
 *
 * @return bool true if deactivated
 */
function agent_profiles_maybe_deactivate() {

	if ( 'genesis' != basename( get_template_directory() ) && is_dir( plugin_dir_path( __FILE__ ) ) ) {

        deactivate_plugins( plugin_basename( __FILE__ ) );

        return true;
	}

	return false;
}

add_action( 'after_setup_theme', 'agent_profiles_init' );
/**
 * Initialize Agent Profiles.
 *
 * Include the libraries, define global variables, instantiate the classes.
 *
 * @since 0.1.0
 */
function agent_profiles_init() {

	/** Do nothing if a Genesis child theme isn't active */
	if ( ! function_exists( 'genesis_get_option' ) ) {
		return;
	}

	/** Require the agentevo helper functions if they aren't available */
	if ( ! function_exists( 'agentevo_image' ) ) {
		require_once dirname( __FILE__ ) . '/includes/helpers.php';
	}

	global $_agent_directory;

<<<<<<< HEAD
	define( 'AEP_URL', plugin_dir_url( __FILE__ ) );
	define( 'AEP_VERSION', '0.9' );
=======
	if ( ! defined('AGENTEVO_LIB_URL') ) {
		define( 'AEP_URL', plugin_dir_url( __FILE__ ) );	
	} else {
		define( 'AEP_URL', AGENTEVO_LIB_URL . '/plugins/ae-profiles/' );
	}
>>>>>>> f01b1dba34ffcb50f20cee859f3b73fa4fa4e71b

	/** Loads textdomain for translation */
	load_plugin_textdomain( 'aep', false, basename( dirname( __FILE__ ) ) . '/languages/' );

	/** Includes */
	require_once( dirname( __FILE__ ) . '/includes/class-aeprofiles.php' );
	require_once( dirname( __FILE__ ) . '/includes/functions.php' );
	require_once( dirname( __FILE__ ) . '/includes/class-agent-evolution-profiles-widget.php');

	/** Create new featured image size */
	add_image_size( 'agent-profile-photo', 150, 200, true );

	/** Enqueues style file if it exists */
	add_action('wp_enqueue_scripts', 'add_aep_css');
	function add_aep_css() {

		$options = get_option('plugin_ae_profiles_settings');

		if ( !isset($options['stylesheet_load']) ) {
			$options['stylesheet_load'] = 0;
		}

		if ( 1 == $options['stylesheet_load'] || 1 == get_option('use_agentevo_theme_css') ) {
			return;
		}

        $aep_css_path = AEP_URL . 'aep.css';

        wp_register_style('agent-profiles', $aep_css_path);
        wp_enqueue_style('agent-profiles');
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
<<<<<<< HEAD

}

/* hook updater to init */
add_action( 'init', 'ae_profiles_updater_init' );

/**
 * Load and Activate Plugin Updater Class.
 * @since 0.1.0
 */
function ae_profiles_updater_init() {

    /* Load Plugin Updater */
    require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/plugin-updater.php' );

    /* Updater Config */
    $config = array(
        'base'         => plugin_basename( __FILE__ ), //required
        'repo_uri'     => 'http://themes.agentevolution.com/',
        'repo_slug'    => 'ae-profiles',
    );

    /* Load Updater Class */
    new AE_Profiles_Plugin_Updater( $config );
=======
>>>>>>> f01b1dba34ffcb50f20cee859f3b73fa4fa4e71b
}