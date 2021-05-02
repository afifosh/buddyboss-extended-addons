<?php
 /**
 * Setting page for plugin dashboard
 * 
 * @package    BuddyBossExtendedAddon
 * @subpackage classes
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

if(!class_exists('BBEA_Setting')):

class BBEA_Setting {

  protected static $instance;

  public function __construct() {
    add_action('admin_init', array($this, 'register_settings'));
    add_action('admin_menu', array($this, 'register_options_page'));
    add_action('admin_head', array($this, 'settings_style'));
  }

  /**
   * Add option value
   */
  public function register_settings() {
    add_option('bbea_option_auto_subscribe', 1);
    add_option('bbea_option_discussion_types', 'publish,private,inherit,closed');
    add_option('bbea_option_unsubscribe', 1);
    add_option('bbea_option_all_unsubscribe', 1);
    register_setting('bbea_options_group', 'bbea_option_auto_subscribe');
    register_setting('bbea_options_group', 'bbea_option_discussion_types');
    register_setting('bbea_options_group', 'bbea_option_unsubscribe');
    register_setting('bbea_options_group', 'bbea_option_all_unsubscribe');
  }

  /**
   * Create admin menu page
   */
  public function register_options_page() {
    add_options_page(
      'Buddyboss Extended Add-on', 'Buddyboss Extended Add-on', 
      'manage_options', 'bbea', array($this, 'bbea_options_page')
    );
  }

  public function settings_style() {
    echo '<style>
      #bbea-settings input[type="text"] {
        width: 300px;
      }
    </style>';
  }

  public function bbea_options_page() { ?>
    <div id="bbea-settings">
      <h2>Buddyboss Extended Add-ons</h2>
      <form method="post" action="options.php">
        <?php settings_fields('bbea_options_group'); ?>
        <table style="text-align: left;">
          <tr valign="top">
            <th scope="row">
              <label for="bbea_option_auto_subscribe">Enable auto forum & discussion subscription on group?: </label>
            </th>
            <td>
              <select name="bbea_option_auto_subscribe" id="bbea_option_auto_subscribe">
                <option value="1" 
                  <?php echo get_option('bbea_option_auto_subscribe') == 1 ? 'selected' : ''; ?>>Yes
                </option>
                <option value="0" 
                  <?php echo get_option('bbea_option_auto_subscribe') == 0 ? 'selected' : ''; ?>>No
                </option>
              </select>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">
              <label for="bbea_option_discussion_types">User within group will be only subcribe to selected discussion type/s: </label>
            </th>
            <td>
              <input 
                style=""
                type="text" 
                id="bbea_option_discussion_types" 
                name="bbea_option_discussion_types" 
                value="<?php echo get_option('bbea_option_discussion_types'); ?>" 
                placeholder="Default: publish,private,inherit,closed"
              />
            </td>
          </tr>
        </table>
        <hr>
        <table style="text-align: left;">
          <tr valign="top">
            <th scope="row">
              <label for="bbea_option_unsubscribe">Enable unsubscribe button in forum cards? : </label>
            </th>
            <td>
              <select name="bbea_option_unsubscribe" id="bbea_option_unsubscribe">
                <option value="1" 
                  <?php echo get_option('bbea_option_unsubscribe') == 1 ? 'selected' : ''; ?>>Yes
                </option>
                <option value="0" 
                  <?php echo get_option('bbea_option_unsubscribe') == 0 ? 'selected' : ''; ?>>No
                </option>
              </select>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">
              <label for="bbea_option_all_unsubscribe">Enable unsubcribe button in /forums/subscriptions page? : </label>
            </th>
            <td>
              <select name="bbea_option_all_unsubscribe" id="bbea_option_all_unsubscribe">
                <option value="1" 
                  <?php echo get_option('bbea_option_all_unsubscribe') == 1 ? 'selected' : ''; ?>>Yes
                </option>
                <option value="0" 
                  <?php echo get_option('bbea_option_all_unsubscribe') == 0 ? 'selected' : ''; ?>>No
                </option>
              </select>
            </td>
          </tr>
        </table>
        <?php submit_button(); ?>
      </form>
    </div>
  <?php
  }

  public static function get_instance() {
    if(!isset(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

}

BBEA_Setting::get_instance();

endif;

?>