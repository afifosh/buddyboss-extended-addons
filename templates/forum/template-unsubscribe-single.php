<div id="unsubscribe-single">
<?php if(bbp_is_user_subscribed_to_forum()): ?>
  <?php
    $nonce = wp_create_nonce('bbea_unsubscribe');
    $link = admin_url('admin-ajax.php?action=bbea_unsubscribe&nonce='.$nonce.'&forum='.bbp_get_forum_id());
  ?>	 
  <a href="<?php echo $link; ?>" data-nonce="<?php echo $nonce; ?>" class="subscription-toggle" rel="nofollow">
    <i class="bb-icon-star-fill"></i>
  </a>
<?php else: ?>
  <?php
    $nonce = wp_create_nonce('bbea_subscribe');
    $link = admin_url('admin-ajax.php?action=bbea_subscribe&nonce='.$nonce.'&forum='.bbp_get_forum_id());
  ?>	 
  <a href="<?php echo $link; ?>" data-nonce="<?php echo $nonce; ?>" class="subscription-toggle" rel="nofollow">
    <i class="bb-icon-star"></i>
  </a>
<?php endif; ?>
</div>