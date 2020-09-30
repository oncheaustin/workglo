<li class="logged-in-link">
  <a class="menuItem" href="<?php echo $site_url; ?>/freelancers">
    <span class="gigtodo-icon nav-icon gigtodo-icon-relative">
      <img width="135" src="<?php echo $site_url; ?>/images/big-users.png" style="width: 35px;height: 35px;top: -10px;">
    </span>
  </a>
</li>
<li class="logged-in-link">
  <a class="bell menuItem" data-toggle="dropdown" title="Notifications">
  <span class="gigtodo-icon nav-icon gigtodo-icon-relative"><?php include("{$dir}images/svg/notification.svg"); ?></span>
  <span class="total-user-count count c-notifications-header"></span>
  </a>
  <div class="dropdown-menu notifications-dropdown">
  </div>
</li>
<li class="logged-in-link">
  <a class="message menuItem" data-toggle="dropdown" title="Inbox">
  <span class="gigtodo-icon nav-icon gigtodo-icon-relative"><?php include("{$dir}images/svg/email.svg"); ?></span>
  <span class="total-user-count count c-messages-header"></span>
  </a>
  <div class="dropdown-menu messages-dropdown">
  </div>
</li>
<li class="logged-in-link">
  <a href="<?php echo $site_url; ?>/favorites" class="heart menuItem">
  <span class="gigtodo-icon nav-icon gigtodo-icon-relative"><?php include("{$dir}images/svg/heart.svg"); ?> </span>
  <span>
  <span class="total-user-count count c-favorites"></span>
  </span>
  </a>
</li>
<li class="logged-in-link">
  <a class="menuItem" href="<?php echo $site_url; ?>/cart">
  <span class="gigtodo-icon nav-icon gigtodo-icon-relative"><?php include("{$dir}images/svg/basket.svg"); ?></span>
  <?php if($count_cart > 0){ ?>
  <span class="total-user-count count"><?php echo $count_cart; ?></span>
  <?php } ?>
  </a>
</li>
<li class="logged-in-link">
  <?php require_once("userMenuLinks.php"); ?>
</li>
<li class="logged-in-link mr-lg-0 mr-2">
  <a class="menuItem btn btn-success text-white"><?php echo $s_currency; ?><?php echo $current_balance; ?></a>
</li>