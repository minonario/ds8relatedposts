<?php
/**
 * @package DS8 RelatedPosts
 */
/*
Plugin Name: DS8 Related Posts
Plugin URI: https://deseisaocho.com/
Description: DS7 <strong>Related Posts with shortcode</strong>
Version: 1.0
Author: JLMA
Author URI: https://deseisaocho.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: ds8relatedposts
*/


if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'DS8RELATEDPOSTS_VERSION', '3.4' );
define( 'DS8RELATEDPOSTS_MINIMUM_WP_VERSION', '5.0' );
define( 'DS8_RELATEDPOSTS_ASSETS', plugins_url('/assets/', __FILE__));
define( 'DS8RELATEDPOSTS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

register_activation_hook( __FILE__, array( 'DS8RelatedPosts', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'DS8RelatedPosts', 'plugin_deactivation' ) );

//require_once DS8RELATEDPOSTS_PLUGIN_DIR . '/includes/helpers.php';
require_once( DS8RELATEDPOSTS_PLUGIN_DIR . 'class.ds8relatedposts.php' );

//add_action( 'init', array( 'DS8RelatedPosts', 'init' ) );

global $simple_ds8_relatedposts;
$simple_ds8_relatedposts = DS8RelatedPosts::get_instance();
