<?php
 /**
 * Admin hooks responsible for single unsubscribe
 * 
 * @package    BuddyBossExtendedAddon
 * @subpackage classes
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

if(!class_exists('BBEA_Un_Subscribe')):

class BBEA_Un_Subscribe {

  protected static $instance;

  public function __construct() {
    if(get_option('bbea_option_subscribe') == 1):
      add_action('bbp_theme_after_forum_description', function() {
        require BBEA_PLUGIN_DIR . 'templates/forum/template-unsubscribe-single.php';
      });

      add_action('wp_ajax_bbea_subscribe', array($this, 'un_subscribe'));
      add_action('wp_ajax_nopriv_bbea_subscribe', array($this, 'un_subscribe_no_priv'));
      add_action('wp_ajax_bbea_unsubscribe', array($this, 'un_subscribe'));
      add_action('wp_ajax_nopriv_bbea_unsubscribe', array($this, 'un_subscribe_no_priv'));
    endif;
  }

  /**
   * Admin AJAX for subscribing/unsubscribing to a forum
   */
  public function un_subscribe() {
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

    if(wp_verify_nonce($_REQUEST['nonce'], 'bbea_subscribe')) {
      $this->subscribe($user_id, $forum_id);
    } elseif (wp_verify_nonce($_REQUEST['nonce'], 'bbea_unsubscribe')) {
      $this->unsubscribe($user_id, $forum_id);
    } else {
      exit('Invalid request');
      die();
    }
  }

  /**
   * Subscribe users to forums and its discussions
   */
  private function subscribe($user_id, $forum_id) {
    bbp_add_user_forum_subscription($user_id, $forum_id);

    $topics = bbea_get_forum_topics($forum_id);

    if(!empty($topics)):
      $topics_arr_ids = explode(',', $topics->ids);
      foreach ($topics_arr_ids as $topic_id):
        bbp_add_user_topic_subscription($user_id, $topic_id);
      endforeach;
    endif;
    
    wp_redirect($_SERVER["HTTP_REFERER"]);
    die();
  }

  /**
   * Unsubscribe users to forums and its discussions
   */
  private function unsubscribe($user_id, $forum_id) {
    bbp_remove_user_forum_subscription($user_id, $forum_id);

    $topics = bbea_get_forum_topics($forum_id);

    if(!empty($topics)):
      $topics_arr_ids = explode(',', $topics->ids);
      foreach ($topics_arr_ids as $topic_id):
        bbp_remove_user_topic_subscription($user_id, $topic_id);
      endforeach;
    endif;

    wp_redirect($_SERVER["HTTP_REFERER"]);
    die();
  }

  public function un_subscribe_no_priv() {
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

BBEA_Un_Subscribe::get_instance();
  
endif;