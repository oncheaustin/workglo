
<h4 class="text-success mb-3">Order Details</h4>

<h5><i class="fa fa-clock-o"></i> &nbsp; <?php echo $delivery_proposal_title; ?> Delivery Time </h5>

<h5 class="mt-2 mb-3"><i class="fa fa-refresh"></i> &nbsp; <?php //echo $proposal_revisions; ?> Revisions </h5>

<?php if(!isset($_SESSION['seller_user_name'])){ ?>
<a href="#" data-toggle="modal" data-target="#login-modal" class="btn btn-order primary mb-3">
	<i class="fa fa-shopping-cart"></i> &nbsp; <strong>Add to Cart</strong>
</a>
<a href="#" data-toggle="modal" data-target="#login-modal" class="btn btn-order">
	<strong>Order Now (<?php echo $s_currency; ?><span class="total-price"><?php echo $proposal_price; ?></span>)</strong>
</a>
<?php if($count_extras > 0){ ?>
<div class="form-group mt-3 mb-3"><!--- form-group mt-2 Starts --->
	<ul class="buyables m-b-25">
		<?php
		$i = 0;
		$total = 0;
		while($row_extras = $get_extras->fetch()){
		$id = $row_extras->id;
		$name = $row_extras->name;
		$price = $row_extras->price;
		$total += $price;
		$i++;
		?>
		<li>
		<label class="fake-check-black check-text">
		<input type="checkbox" name="proposal_extras[<?php echo $i; ?>]" value="<?php echo $id; ?>">
		<span class="chk-img"></span>
		<span class="js-express-delivery-text">
		<?php echo $name; ?> (+<span class="price"><?php echo $s_currency; ?><?php echo $price; ?></span>)
		</span>
		</label>
		</li>
		<?php } ?>
	</ul>	
</div><!--- form-group mt-2 Ends --->
<?php } ?>
<hr>
<div class="form-group row mb-0"><!-- form-group row Starts -->
	<label class="col-6 control-label"> Proposal's Quantity </label>
	<div class="col-6">
		<select class="form-control" name="proposal_qty">
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
		</select>
	</div>
</div><!-- form-group row Ends -->
<?php }else{ ?>
<?php if($proposal_seller_user_name == @$_SESSION['seller_user_name']){  ?>
<a class="btn btn-order" href="../edit_proposal.php?proposal_id=<?php echo $proposal_id; ?>">
<i class="fa fa-edit"></i> Edit Proposal
</a>
<?php }else{ ?>
<form method="post" action="../../checkout"><!--- form Starts --->
	<input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">
  <?php if($countcart == 1){ ?>
	<button type="button" class="btn btn-order primary added mb-3">
	<i class="fa fa-shopping-cart"></i> &nbsp;<strong>Already Added</strong>
	</button>
  <?php }else{ ?>
	<button type="submit" name="add_cart" class="btn btn-order primary mb-3">
	<i class="fa fa-shopping-cart"></i> &nbsp;<strong>Add to Cart</strong>
	</button>
  <?php } ?>
	<button type="submit" name="add_order" class="btn btn-order">
	<strong>
	Order Now (<?php echo $s_currency; ?><span class="total-price"><?php echo $proposal_price; ?></span>)
	</strong>
	</button>
	<?php if($count_extras > 0){ ?>
	<div class="form-group mt-3 mb-3"><!--- form-group mt-2 Starts --->
	<ul class="buyables m-b-25">
	<?php
	$i = 0;
  $total = 0;
  while($row_extras = $get_extras->fetch()){
    $id = $row_extras->id;
    $name = $row_extras->name;
    $price = $row_extras->price;
    $total += $price;
    $i++;
	?>
	<li>
	  <label class="fake-check-black check-text">
		<input type="checkbox" name="proposal_extras[<?php echo $i; ?>]" value="<?php echo $id; ?>">
		<span class="chk-img"></span>
		<span class="js-express-delivery-text"><?php echo $name; ?> (+<span class="price"><?php echo $s_currency; ?><?php echo $price; ?></span>)</span>
		</label>
	</li>
  <?php } ?>
	</ul>	
	</div><!--- form-group mt-2 Ends --->
	<?php } ?>
	<hr>
	<div class="form-group row mb-0"><!--- form-group row mb-0 Starts --->
		<label class="col-6 control-label"> Proposal's Quantity </label>
		<div class="col-6">
			<select class="form-control" name="proposal_qty">
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
			</select>
		</div>
	</div><!--- form-group row mb-0 Ends --->
</form><!--- form Ends --->
<?php } ?>
<?php } ?>