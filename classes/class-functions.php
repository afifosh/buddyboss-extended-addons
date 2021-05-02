<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Generic row query for bbea
 * @param string $table
 * @param string $selector
 * @param string $q
 */
function bbea_get_bp_row($table, $selector, $q) {
  global $wpdb;
  $table = $wpdb->prefix . $table;
  $bp_row = $wpdb->get_row( "SELECT $selector FROM $table $q" );
  return $bp_row;
}

/**
 * Get forum topics
 * @param int $forum_id
 */
function bbea_get_forum_topics($forum_id) {
  return bbea_get_bp_row(
    'posts', 
    'GROUP_CONCAT(ID) as ids', 
    'WHERE `post_parent` = '.$forum_id.' GROUP BY "all"'
  );
}