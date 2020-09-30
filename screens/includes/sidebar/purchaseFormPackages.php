<form method="post" action="../../checkout" id="checkoutForm<?php echo $i; ?>" class="<?=($lang_dir == "right" ? 'text-right':'')?>">
  <input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">
  <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
  <input type="hidden" name="proposal_qty" value="1">
  <h3><?php echo $package_name; ?> <span class="<?=($lang_dir == "left" ? 'float-right':'')?> font-weight-normal"> $<?php echo $price; ?></span></h3>
  <p><?php echo $row->description; ?></p>
  <h6 class="mb-3"><i class="fa fa-clock-o"></i> <?php echo $delivery_time; ?> Days Delivery  &nbsp; &nbsp; <i class="fa fa-refresh"></i> <?php echo $row->revisions; ?> Revisions </h6>
  <?php include('buttons.php'); ?>
</form>