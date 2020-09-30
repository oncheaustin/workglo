<div class="dropdown user-menu">
<a href="#" id="usermenu" class="user dropdown-toggle menuItem" style="margin-top: 17px;" class="dropdown-toggle" data-toggle="dropdown">
  <?php if(!empty($seller_image)){ ?>
  <img src="<?php echo $site_url; ?>/user_images/<?php echo $seller_image; ?>" width="27" height="27" class="rounded-circle">
  <?php }else{ ?>
  <img src="<?php echo $site_url; ?>/user_images/empty-image.png" width="27" height="27" class="rounded-circle">
  <?php } ?>
  <span class="name"><?php echo $_SESSION['seller_user_name']; ?></span>
</a>
<div class="dropdown-menu <?=($lang_dir=="right"?'text-right':'')?>" style="min-width:200px; width:auto!important;z-index:2000;">
   <a class="dropdown-item" href="<?php echo $site_url; ?>/dashboard">
   <?php echo $lang['dashboard']['title']; ?>
   </a>
   <a class="dropdown-item dropdown-toggle" href="#" data-toggle="collapse" data-target="#selling">
   <?php echo $lang['selling']; ?>
   </a>
   <div id="selling" class="dropdown-submenu collapse">
      <?php if($count_active_proposals > 0){ ?>
      <a class="dropdown-item" href="<?php echo $site_url; ?>/selling_orders">
      <?php echo $lang['orders']; ?>
      </a>
      <?php } ?>
      <a class="dropdown-item" href="<?php echo $site_url; ?>/proposals/view_proposals">
      <?php echo $lang['my_proposals']; ?>
      </a>
      <?php if($count_active_proposals > 0){ ?>
      <a class="dropdown-item" href="<?php echo $site_url; ?>/proposals/create_coupon">
      <?php echo $lang['create_coupon']; ?>
      </a>
      <?php } ?>
      <?php if($count_active_proposals > 0){ ?>
      <a class="dropdown-item" href="<?php echo $site_url; ?>/requests/buyer_requests">
      <?php echo $lang['buyer_requests']; ?>
      </a>
      <a class="dropdown-item" href="<?php echo $site_url; ?>/revenue">
      <?php echo $lang['revenues']; ?>
      </a>
      <a class="dropdown-item" href="<?php echo $site_url; ?>/withdrawal_requests">
      <?php echo $lang['withdrawal_requests']; ?>
      </a>
      <?php } ?>
   </div>
   <a class="dropdown-item dropdown-toggle" href="#" data-toggle="collapse" data-target="#buying">
   <?php echo $lang['buying']; ?>
   </a>
   <div id="buying" class="dropdown-submenu collapse">
      <a class="dropdown-item" href="<?php echo $site_url; ?>/buying_orders">
      <?php echo $lang['orders']; ?>
      </a>
      <a class="dropdown-item" href="<?php echo $site_url; ?>/purchases">
      <?php echo $lang['purchases']; ?>
      </a>
      <a class="dropdown-item" href="<?php echo $site_url; ?>/favorites">
      <?php echo $lang['favorites']; ?>
      </a>
   </div>
   <a class="dropdown-item dropdown-toggle" href="#" data-toggle="collapse" data-target="#requests">
   <?php echo $lang['requests']; ?>
   </a>
   <div id="requests" class="dropdown-submenu collapse">
      <a class="dropdown-item" href="<?php echo $site_url; ?>/requests/post_request">
      <?php echo $lang['post_request']; ?>
      </a>
      <a class="dropdown-item" href="<?php echo $site_url; ?>/requests/manage_requests">
      <?php echo $lang['manage_requests']; ?>
      </a>
   </div>
   <a class="dropdown-item dropdown-toggle" href="#" data-toggle="collapse" data-target="#contacts">
   <?php echo $lang['contacts']; ?>
   </a>
   <div id="contacts" class="dropdown-submenu collapse">
      <a class="dropdown-item" href="<?php echo $site_url; ?>/manage_contacts?my_buyers">
      <?php echo $lang['my_buyers']; ?>
      </a>
      <a class="dropdown-item" href="<?php echo $site_url; ?>/manage_contacts?my_sellers">
      <?php echo $lang['my_sellers']; ?>
      </a>
   </div>
   <?php if($enable_referrals == "yes"){ ?>
   <a class="dropdown-item dropdown-toggle" href="#" data-toggle="collapse" data-target="#referrals">
   <?php echo $lang['my_referrals']['title']; ?>
   </a>
   <div id="referrals" class="dropdown-submenu collapse">
      <a class="dropdown-item" href="<?php echo $site_url; ?>/my_referrals" data-target="#referrals">
      <?php echo $lang['user_referrals']; ?>
      </a>
      <a class="dropdown-item" href="<?php echo $site_url; ?>/proposal_referrals" data-target="#referrals">
      <?php echo $lang['proposal_referrals']; ?>
      </a>
   </div>
   <?php } ?>
   <a class="dropdown-item" href="<?php echo $site_url; ?>/conversations/inbox">
   <?php echo $lang['inbox_messages']; ?>
   </a>
   <a class="dropdown-item" href="<?php echo $site_url; ?>/<?php echo $_SESSION['seller_user_name']; ?>">
   <?php echo $lang['my_profile']; ?>
   </a>
   <a class="dropdown-item dropdown-toggle" href="#" data-toggle="collapse" data-target="#settings">
   <?php echo $lang['settings']; ?>
   </a>
   <div id="settings" class="dropdown-submenu collapse">
      <a class="dropdown-item" href="<?php echo $site_url; ?>/settings?profile_settings">
      <?php echo $lang['profile_settings']; ?>
      </a>
      <a class="dropdown-item" href="<?php echo $site_url; ?>/settings?account_settings">
      <?php echo $lang['account_settings']; ?>
      </a>
   </div>
   <div class="dropdown-divider"></div>
   <a class="dropdown-item" href="<?php echo $site_url; ?>/logout">
   <?php echo $lang['logout']; ?>
   </a>
</div>
</div>