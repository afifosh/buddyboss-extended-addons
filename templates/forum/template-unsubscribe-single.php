<div id="un-subscribe-single">
<?php if(bbp_is_user_subscribed_to_forum()): ?>
  <?php
    $nonce = wp_create_nonce('bbea_unsubscribe');
    $link = admin_url('admin-ajax.php?action=bbea_unsubscribe&nonce='.$nonce.'&forum='.bbp_get_forum_id());
  ?>	 
  <a href="<?php echo $link; ?>" data-nonce="<?php echo $nonce; ?>" class="subscription-toggle" rel="nofollow">
    <i id="bbea_unsubscribe_icon" class="<?php echo get_option('bbea_unsubscribe_icon'); ?>"></i>
  </a>
<?php else: ?>
  <?php
    $nonce = wp_create_nonce('bbea_subscribe');
    $link = admin_url('admin-ajax.php?action=bbea_subscribe&nonce='.$nonce.'&forum='.bbp_get_forum_id());
  ?>	 
  <a href="<?php echo $link; ?>" data-nonce="<?php echo $nonce; ?>" class="subscription-toggle" rel="nofollow">
    <i id="bbea_subscribe_icon" class="<?php echo get_option('bbea_subscribe_icon'); ?>"></i>
  </a>
<?php endif; ?>
</div>