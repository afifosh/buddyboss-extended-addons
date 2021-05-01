<?php if(bbp_is_user_subscribed_to_forum()): ?>
  <div id="unsubscribe-single">
    <?php
      $nonce = wp_create_nonce('bbea_unsubscribe');
      $link = admin_url('admin-ajax.php?action=bbea_unsubscribe&nonce='.$nonce.'&forum='.bbp_get_forum_id());
    ?>	 
    <a href="<?php echo $link; ?>" data-nonce="<?php echo $nonce; ?>" class="subscription-toggle" rel="nofollow">
      <?php _e( 'Unsubscribe', 'buddyboss' ); ?>
    </a>
  </div>
<?php endif; ?>