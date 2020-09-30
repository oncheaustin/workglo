<form action="../../checkout" id="checkoutForm" method="post">
  <input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">
  <input type="hidden" name="proposal_qty" value="1">
  <div class="header">
    <span class="text <?=($lang_dir == "right" ? 'text-right':'')?>">
      <span class="dropdown" tabindex="0" data-toggle="popover" data-placement="bottom" data-html="true" data-content="<?php include('orderDetailsPopover.php'); ?>">Order Details</span>
      <a href="#" class="secure ml-2"><?php include("$dir/images/svg/secure.svg"); ?></a>
      <?php if(!isset($_SESSION['seller_user_name'])){ ?>
      <a href="#" data-toggle="modal" data-target="#login-modal" class="favorite ml-2"> 
      <i class="fa fa-heart dil1" data-toggle="tooltip" data-placement="top" title="Favorites"></i> 
      </a>
      <?php }else{ ?>
      <a href="#" id="<?php echo $show_favorite_id; ?>" class="favorite ml-2"> 
      <i class="fa fa-heart <?php echo $show_favorite_class; ?>" data-toggle="tooltip" data-placement="top" title="Favorites"></i> 
      </a>
      <?php } ?>
    </span>
    <div class="price <?=($lang_dir == "right" ? 'text-right':'')?>">
      <b class="currency"><?php echo $s_currency; ?><span class="total-price"><?php echo $proposal_price; ?></span></b>
    </div>
  </div>
  <hr class="mt-0">
  <div class="row">
    <div class="col-12 ml-2 p-2">
      <h6 class="mb-0 <?=($lang_dir == "right" ? 'text-right pr-4':'')?>"><i class="fa fa-clock-o"></i> <?php echo $delivery_proposal_title; ?> Delivery </h6>
    </div>
    <!-- <div class="col-6 text-center p-2">
     <h6 class="mb-0"><i class="fa fa-refresh"></i> &nbsp; <?php //echo $proposal_revisions; ?> Revisions </h6>
    </div> -->
  </div>
  <?php 
    include('extras.php');
    include('quantity.php');
    include('buttons.php');
  ?>
</form>