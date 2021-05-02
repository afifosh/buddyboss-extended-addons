<?php
 /**
 * Admin hooks responsible for single unsubscribe
 * 
 * @package    BuddyBossExtendedAddon
 * @subpackage classes
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

if(!class_exists('BBEA_Unsubscribe')):

class BBEA_Unsubscribe {

  protected static $instance;

  public function __construct() {
    if(get_option('bbea_option_unsubscribe') == 1):
      add_action('bbp_theme_after_forum_description', function() {
        require BBEA_PLUGIN_DIR . 'templates/forum/template-unsubscribe-single.php';
      });

      add_action('wp_ajax_bbea_unsubscribe', array($this, 'unsubscribe'));
      add_action('wp_ajax_nopriv_bbea_unsubscribe', array($this, 'unsubscribe_no_priv'));
    endif;
  }

  /**
    * Admin AJAX for unsubscribing to forum
    */
  public function unsubscribe() {
    if(!wp_verify_nonce($_REQUEST['nonce'], "bbea_unsubscribe")) {
      exit('Invalid nonce');
      die();
    } 

    if(!isset($_REQUEST['forum'])) {
      exit('Invalid forum request');
      die();
    }

    $user_id = get_current_user_id();
    if(!$user_id) {
      exit('Invalid user');
      die();
    }

    $forum_id = sanitize_text_field($_REQUEST['forum']);
    bbp_remove_user_forum_subscription($user_id, $forum_id);

    $topics = bbea_get_bp_row(
      'posts', 
      'GROUP_CONCAT(ID) as ids', 
      'WHERE `post_parent` = '.$forum_id.' GROUP BY "all"'
    );

    if(!empty($topics)):
      $topics_arr_ids = explode(',', $topics->ids);
      foreach ($topics_arr_ids as $topic_id):
        bbp_remove_user_topic_subscription($user_id, $topic_id);
      endforeach;
    endif;

    //wp_redirect(trailingslashit(bp_displayed_user_domain() . 'forums/subscriptions'));

    wp_redirect($_SERVER["HTTP_REFERER"]);
    die();
  }

  public function unsubscribe_no_priv() {
    wp_die('Permissin denied.');
    die();
  }

  public static function get_instance() {
    
    if(!isset(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

}

BBEA_Unsubscribe::get_instance();
  
endif;