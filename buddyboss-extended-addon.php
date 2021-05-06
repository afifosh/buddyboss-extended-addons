<?php
/**
 * BuddyBoss Extended Add-on
 *
 * @package BuddyBossExtendedAddon
 *
 * Plugin Name: BuddyBoss Extended Add-on
 * Plugin URI:  https://github.com/jcatama/buddyboss-extended-addon
 * Description: 🚀 All-in-one enhancement plugin that improves WordPress & BuddyBoss integration.
 * Author:      John Albert Catama
 * Author URI:  https://github.com/jcatama
 * Version:     1.0.1
 * Text Domain: buddyboss-extended-addon
 * License:     GPL2
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

if(!defined('BBEA_VERSION')) {
	define('BBEA_VERSION', 'v1.0.1');
}

if(!defined('BBEA_PLUGIN_DIR')) {
	define('BBEA_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

/**
 * Check for BuddyBoss dependency
 */
register_activation_hook(__FILE__, 'bbea_activate');
function bbea_activate() {
  $plugin = plugin_basename(__FILE__);
  if(!is_plugin_active('buddyboss-platform/bp-loader.php') and current_user_can('activate_plugins')):
    wp_die('Sorry, but this plugin requires the BuddyBoss Platform Plugin to be installed and active. <br>
    <a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    deactivate_plugins($plugin);
  endif;
}

/**
 * Add setting page link
 */
add_filter('plugin_action_links_' . plugin_basename( __FILE__ ), 'bbea_plugin_page_settings_link');
function bbea_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'options-general.php?page=bbea' ) .
		'">' . __('Settings') . '</a>';
	return $links;
}

/**
 * Enqueues scripts and styles
 */
add_action('wp_enqueue_scripts', 'bbea_scripts_styles', 9999);
function bbea_scripts_styles() {
  /**
   * Scripts and Styles loaded by the parent theme can be unloaded if needed
   * using wp_deregister_script or wp_deregister_style.
   *
   * See the WordPress Codex for more information about those functions:
   * http://codex.wordpress.org/Function_Reference/wp_deregister_script
   * http://codex.wordpress.org/Function_Reference/wp_deregister_style
   **/

  wp_enqueue_style('bbea-css', plugins_url('/main.css', __FILE__ ), array(), BBEA_VERSION);

  wp_localize_script('jquery', 'bbea', array('ajaxurl' => admin_url('admin-ajax.php')));
}

/**
 * Register BBPress overrides
 */
if(get_option('bbea_option_all_unsubscribe') == 1):
  add_action('bbp_register_theme_packages',  'bbea_register_plugin_template');
  function bbea_register_plugin_template() {
    bbp_register_template_stack('bbea_get_template_path', 12);
  }
  function bbea_get_template_path() {
    return BBEA_PLUGIN_DIR . 'templates/bbpress/';
  }
endif;

/**
 * Include classes
 */
require_once BBEA_PLUGIN_DIR . 'classes/class-index.php';