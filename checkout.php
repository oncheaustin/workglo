<?php
	session_start();
	require_once("includes/db.php");
	require_once("functions/processing_fee.php");

	if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('login','_self')</script>";
	}

	if(!isset($_POST['add_order']) and !isset($_POST['add_cart']) and !isset($_POST['coupon_submit']) and !isset($_SESSION['c_proposal_id'])){
		echo "<script>window.open('index','_self')</script>";
	}

	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$enable_paypal = $row_payment_settings->enable_paypal;
	$paypal_email = $row_payment_settings->paypal_email;
	$paypal_currency_code = $row_payment_settings->paypal_currency_code;
	$paypal_sandbox = $row_payment_settings->paypal_sandbox;
	$enable_dusupay = $row_payment_settings->enable_dusupay;

	if($paypal_sandbox == "on"){
	$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	}elseif($paypal_sandbox == "off"){
	$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
	}

	$enable_stripe = $row_payment_settings->enable_stripe;
	$enable_payza = $row_payment_settings->enable_payza;
	$payza_test = $row_payment_settings->payza_test;
	$payza_currency_code = $row_payment_settings->payza_currency_code;
	$payza_email = $row_payment_settings->payza_email;

	$enable_coinpayments = $row_payment_settings->enable_coinpayments;
	$coinpayments_merchant_id = $row_payment_settings->coinpayments_merchant_id;
	$coinpayments_currency_code = $row_payment_settings->coinpayments_currency_code;

	$enable_paystack = $row_payment_settings->enable_paystack;

	$login_seller_user_name = $_SESSION['seller_user_name'];
	$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	$row_login_seller = $select_login_seller->fetch();
	$login_seller_id = $row_login_seller->seller_id;
	$login_seller_email = $row_login_seller->seller_email;
	
if(isset($_POST['add_order']) or isset($_POST['coupon_submit'])){

	$_SESSION['c_proposal_id'] = $input->post('proposal_id');
	$_SESSION['c_proposal_qty'] = $input->post('proposal_qty');
	if(isset($_POST['package_id'])){
		$_SESSION['c_package_id'] = $input->post('package_id');
	}

	if(isset($_SESSION['c_proposal_id'])){

	$proposal_id = $_SESSION['c_proposal_id'];
	$proposal_qty = $_SESSION['c_proposal_qty'];

	$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));

	$row_proposals = $select_proposals->fetch();

	if(isset($_POST['package_id'])){
		$_SESSION['c_package_id'] = $input->post('package_id');
		$get_p = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_id"=>$input->post('package_id')));
		$row_p = $get_p->fetch();
		$proposal_price = $row_p->price;
		$single_price = $row_p->price;
	}else{
		unset($_SESSION['c_package_id']);
		$proposal_price = $row_proposals->proposal_price;
		$single_price = $row_proposals->proposal_price;
	}

	$proposal_title = $row_proposals->proposal_title;
	$proposal_seller_id = $row_proposals->proposal_seller_id;
	$proposal_url = $row_proposals->proposal_url;
	$proposal_img1 = $row_proposals->proposal_img1;

	$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));
	$row_seller = $select_seller->fetch();
	$proposal_seller_user_name = $row_seller->seller_user_name;

	if(isset($_POST['proposal_extras'])){
		$extra_price = 0;
		$_SESSION['c_proposal_extras'] = $input->post('proposal_extras');
		if (isset($_POST['add_order'])) {
			$proposal_extras = $_SESSION['c_proposal_extras'];
		}else{
			$proposal_extras = unserialize(base64_decode($input->post('proposal_extras')));
		}
		foreach($proposal_extras as $value){
			$get_extras = $db->select("proposals_extras",array("id"=>$value));
			$row_extras = $get_extras->fetch();
			$extra_price += $row_extras->price;
			$proposal_price += $row_extras->price;
		}
	}else{
	unset($_SESSION['c_proposal_extras']);
	}

	$_SESSION['c_proposal_price'] = $proposal_price;

	$sub_total = $proposal_price*$proposal_qty;

	$_SESSION["c_sub_total"] = $sub_total;

	$processing_fee = processing_fee($sub_total);
	$total = processing_fee($sub_total)+$sub_total;

	$select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
	$row_seller_accounts = $select_seller_accounts->fetch();
	$current_balance = $row_seller_accounts->current_balance;

	if($proposal_id == @$_SESSION['r_proposal_id']){
		$referrer_id = $_SESSION['r_referrer_id'];
		$sel_referrer = $db->select("sellers",array("seller_id" => $referrer_id));
		$referrer_user_name = $sel_referrer->fetch()->seller_user_name;
	}

?>
<!DOCTYPE html>

<html lang="en" class="ui-toolkit">

<head>
<title><?php echo $site_name; ?> - Checkout</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="<?php echo $site_author; ?>">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
<link href="styles/bootstrap.css" rel="stylesheet">
<link href="styles/styles.css" rel="stylesheet">
<link href="styles/categories_nav_styles.css" rel="stylesheet">
<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
<link href="styles/owl.carousel.css" rel="stylesheet">
<link href="styles/owl.theme.default.css" rel="stylesheet">
<link href="styles/sweat_alert.css" rel="stylesheet">
<script type="text/javascript" src="js/sweat_alert.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<?php if(!empty($site_favicon)){ ?>
<link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
<?php } ?>
</head>
<body class="is-responsive">
<?php
require_once("includes/header.php"); 
if($seller_verification != "ok"){
echo "
<div class='alert alert-danger rounded-0 mt-0 text-center'>
Please confirm your email to use this feature.
</div>";
}else{
?>
<?php
$site_logo_image = $row_general_settings->site_logo;
$coupon_usage = "no";
if(isset($_POST['code'])){
$coupon_code = $input->post('code');
$select_coupon = $db->select("coupons",array("proposal_id"=>$proposal_id,"coupon_code"=>$coupon_code));
$count_coupon = $select_coupon->rowCount();
if($count_coupon == 1){
$row_coupon = $select_coupon->fetch();
$coupon_limit = $row_coupon->coupon_limit;
$coupon_used = $row_coupon->coupon_used;
$coupon_type = $row_coupon->coupon_type;
$coupon_price = $row_coupon->coupon_price;
if($coupon_limit <= $coupon_used){
$proposal_price = $input->post('proposal_price');
$proposal_qty = $input->post('proposal_qty');
$sub_total = $proposal_price * $proposal_qty;
$processing_fee = processing_fee($sub_total);
$total = $processing_fee + $sub_total;
$coupon_usage = "expired";
echo "<script> $('.coupon-response').html('Your coupon code expired.').attr('class', 'coupon-response mt-2 p-2 bg-danger text-white'); </script>";
}else{
$proposal_price = $input->post('proposal_price');
$proposal_qty = $input->post('proposal_qty');
$sub_total = $proposal_price * $proposal_qty;
$processing_fee = processing_fee($sub_total);
$total = $processing_fee + $sub_total;
$select_used = $db->select("coupons_used",array("proposal_id"=>$proposal_id,"seller_id"=>$login_seller_id,"coupon_price"=>$sub_total));
$count_used = $select_used->rowCount();
if($count_used == 1){
$coupon_usage = "a_used";
}else{
$update_coupon = $db->query("update coupons set coupon_used=coupon_used+1 where proposal_id=:p_id and coupon_code=:c_code",array("p_id"=>$proposal_id,"c_code"=>$coupon_code));
if($coupon_type == "fixed_price"){
$proposal_price = $input->post('proposal_price');
$proposal_price = $coupon_price;
}else{
$proposal_price = $input->post('proposal_price');
$numberToAdd = ($proposal_price / 100) * $coupon_price;
$proposal_price = $proposal_price - $numberToAdd;
}
$proposal_qty = $input->post('proposal_qty');
$sub_total = $proposal_price * $proposal_qty;
$_SESSION['c_proposal_price'] = $proposal_price;
$_SESSION["c_sub_total"] = $sub_total;
$select_used = $db->select("coupons_used",array("proposal_id"=>$proposal_id,"seller_id"=>$login_seller_id,"coupon_price"=>$sub_total));
$count_used = $select_used->rowCount();
if($count_used == 0){
$insert_used = $db->insert("coupons_used",array("proposal_id"=>$proposal_id,"seller_id"=>$login_seller_id,"coupon_used"=>1,"coupon_price"=>$sub_total));
}
$processing_fee = processing_fee($sub_total);
$total = $processing_fee + $sub_total;
$coupon_usage = "used";
}
}
}else{
$proposal_price = $input->post('proposal_price');
$proposal_qty = $input->post('proposal_qty');
$sub_total = $proposal_price * $proposal_qty;
$processing_fee = processing_fee($sub_total);
$total = $processing_fee + $sub_total;
$coupon_usage = "not_valid";
}
}
?>
<div class="container mt-5 mb-5">
	<div class="row">
		<div class="col-md-7">
			<div class="row">
      	<?php if($current_balance >= $sub_total){ ?>
				<div class="col-md-12 mb-3">
					<div class="card payment-options">
						<div class="card-header">
							<h5><i class="fa fa-dollar"></i> Available Shopping Balance</h5>
						</div>
						<div class="card-body">
						<div class="row">
						<div class="col-1">
						<input id="shopping-balance" type="radio" name="method" class="form-control radio-input" checked>
						</div>
						<div class="col-11">
							<p class="lead mt-2">
							Personal Balance - <?php echo $login_seller_user_name; ?>
							<span class="text-success font-weight-bold"><?php echo $s_currency; ?><?php echo $current_balance; ?></span>
							</p>
						</div>
					</div>
					</div>
					</div>
				</div>
        <?php } ?>
				<div class="col-md-12 mb-3">
					<div class="card payment-options">
						<div class="card-header">
						<h5><i class="fa fa-credit-card"></i> Payment Options</h5>
						</div>
						<div class="card-body">
							<?php if($enable_paypal == "yes"){ ?>
							<div class="row">
							<div class="col-1">
							<input id="paypal" type="radio" name="method" class="form-control radio-input" 
							<?php
							if($current_balance < $sub_total){ echo "checked"; }
							?>>
							</div>
							<div class="col-11">
							<img src="images/paypal.png" height="50" class="ml-2 width-xs-100">
							</div>
							</div>
							<?php } ?>
							<?php if($enable_stripe == "yes"){ ?>
							<?php if($enable_paypal == "yes"){ ?>
							<hr>
							<?php } ?>
							<div class="row">
							<div class="col-1">
							<input id="credit-card" type="radio" name="method" class="form-control radio-input"
							<?php
							  if($current_balance < $sub_total){
							  if($enable_paypal == "no"){ echo "checked"; }
							  }
							?>>
							</div>
							<div class="col-11">
							<img src="images/credit_cards.jpg" height="50" class="ml-2 width-xs-100">
							</div>
							</div>
							<?php } ?>
							<?php if($enable_payza == "yes"){ ?>
							<?php if($enable_paypal == "yes" or $enable_stripe == "yes"){ ?>
							<hr>
							<?php } ?>
							<div class="row">
							<div class="col-1">
							<input id="payza" type="radio" name="method" class="form-control radio-input"
							<?php
							if($current_balance < $sub_total){
							if($enable_paypal == "no" and $enable_stripe == "no" and $enable_payza == "yes"){ 
							echo "checked";
							}
							}
							?>>
							</div>
							<div class="col-11">
							<img src="images/payza.jpg" height="50" class="ml-2 width-xs-100">
							</div>
							</div>
							<?php } ?>
							<?php if($enable_coinpayments == "yes"){ ?>
							<?php if($enable_payza == "yes" or $enable_paypal == "yes" or $enable_stripe == "yes"){ ?>
							<hr>
							<?php } ?>
							<div class="row">
							<div class="col-1">
							<input id="coinpayments" type="radio" name="method" class="form-control radio-input"
							<?php
							if($current_balance < $sub_total){
							if($enable_paypal == "no" and $enable_stripe == "no" and $enable_payza == "no"){ 
							echo "checked";
							}
							}
							?>>
							</div>
							<div class="col-11">
							<img src="images/coinpayments.png" height="50" class="ml-2 width-xs-100">
							</div>
							</div>
							<?php } ?>
							<?php if($enable_paystack == "yes"){ ?>
							<?php if($enable_payza == "yes" or $enable_paypal == "yes" or $enable_stripe == "yes" or $enable_coinpayments == "yes"){ ?>
							<hr>
							<?php } ?>
							<div class="row">
							<div class="col-1">
							<input id="paystack" type="radio" name="method" class="form-control radio-input"
							<?php
							if($current_balance < $sub_total){
							if($enable_paypal == "no" and $enable_stripe == "no" and $enable_payza == "no" and $enable_coinpayments == "no"){ 
							echo "checked";
							}
							}
							?>>
							</div>
							<div class="col-11">
							<img src="images/paystack.png" height="50" class="ml-2 width-xs-100">
							</div>
							</div>
							<?php } ?>
							<?php if($enable_dusupay == "yes"){ ?>
							<?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_payza == "yes" or $enable_paystack == "yes" or $enable_coinpayments == "yes"){ ?>
							<hr>
							<?php } ?>
							<div class="row">
								<div class="col-1">
									<input id="mobile-money" type="radio" name="method" class="form-control radio-input"
									<?php
									if($current_balance < $sub_total){
									if($enable_paypal == "no" and $enable_stripe == "no" and $enable_payza == "no" and $enable_coinpayments == "no" and $enable_paystack == "no"){ 
										echo "checked"; 
									}
									}
									?>>
								</div>
								<div class="col-11">
									<img src="images/mobile-money.png" height="50" class="ml-2 width-xs-100">
								</div>
							</div>
              <?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<div class="card checkout-details">
				<div class="card-header">
					<h5> <i class="fa fa-file-text-o"></i> Order Summary </h5>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4 mb-3">
						<img src="proposals/proposal_files/<?php echo $proposal_img1; ?>" class="img-fluid">
						</div>
						<div class="col-md-8">
						<h5><?php echo $proposal_title; ?></h5>
						</div>
					</div>
					<hr>
					<h6>Proposal's Price: <span class="float-right"><?php echo $s_currency; ?><?php echo $single_price; ?> </span></h6>
					<?php if(isset($_POST['proposal_extras'])){ ?>
					<hr>
					<h6>Proposal's Extras : <span class="float-right"><?php echo $s_currency; ?><?php echo $extra_price; ?></span> </h6>
					<?php } ?>
					<hr>
					<h6>Proposal's Quantity: <span class="float-right"><?php echo $proposal_qty; ?></span></h6>
					<hr>
					<h6 class="processing-fee">Processing Fee: <span class="float-right"><?php echo $s_currency; ?><?php echo $processing_fee; ?></span></h6>
					<hr class="processing-fee">
					<h6>Appy Coupon Code:</h6>
					<form class="input-group" method="post">
					<input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">
				    <input type="hidden" name="proposal_price" value="<?php echo $proposal_price; ?>">
					<input type="hidden" name="proposal_qty" value="<?php echo $proposal_qty; ?>">
					<?php if(@$proposals_extras){ ?>
					<input type="hidden" name="proposal_extras" value="<?php echo base64_encode(serialize($proposal_extras));?>">
					<?php } ?>
					<input type="text" name="code" class="form-control apply-disabled" placeholder="Enter Coupon Code">
					<button type="submit" name="coupon_submit" class="input-group-addon btn btn-success">Apply</button>
					</form>
          <?php if($coupon_usage == "not_valid"){ ?>
					<p class="coupon-response mt-2 p-2 bg-danger text-white"> Your Coupon Code Is Not Valid. </p>
          <?php }elseif($coupon_usage == "used"){ ?>
					<p class="coupon-response mt-2 p-2 bg-success text-white">Your coupon code has been applied successfully.</p>
					<?php }elseif($coupon_usage == "expired"){ ?>
					<p class="coupon-response mt-2 p-2 bg-danger text-white"> Your Coupon Code Is Expired. </p>
					<?php }elseif($coupon_usage == "a_used"){ ?>
					<p class="coupon-response mt-2 p-2 bg-success text-white"> Your Coupon Code Is Already Used. </p>
					<?php } ?>
					<hr>
					<h5 class="font-weight-bold">
					Proposal's Total: <span class="float-right total-price"><?php echo $s_currency; ?><?php echo $total; ?></span>					</h5>
					<hr>
          <?php include("checkoutPayMethods.php"); ?>          
		</div>
		<?php if($proposal_id == @$_SESSION['r_proposal_id']){ ?>
		<div class="card-footer">Referred By : <b><?php echo $referrer_user_name; ?></b></div>
		<?php } ?>
		</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){	
<?php if($current_balance >= $sub_total){ ?>	
$('.total-price').html('<?php echo $s_currency; ?><?php echo $sub_total; ?>');
$('.processing-fee').hide();
<?php }else{ ?>
$('.total-price').html('<?php echo $s_currency; ?><?php echo $total; ?>');
$('.processing-fee').show();
<?php } ?>
<?php if($current_balance >= $sub_total){ ?>
$('#payza-form').hide();
$('#mobile-money-form').hide();
$('#coinpayments-form').hide();
$('#paypal-form').hide();
$('#paystack-form').hide();
$('#credit-card-form').hide();
<?php }else{ ?>
$('#shopping-balance-form').hide();
<?php } ?>	
<?php if($current_balance < $sub_total){ ?>
<?php if($enable_paypal == "yes"){ ?>
<?php }else{ ?>
$('#paypal-form').hide();
<?php } ?>
<?php } ?>
<?php if($current_balance < $sub_total){ ?>
<?php if($enable_paypal == "yes"){ ?>
$('#credit-card-form').hide();
$('#mobile-money-form').hide();
$('#payza-form').hide();
$('#coinpayments-form').hide();
$('#paystack-form').hide();
<?php }elseif($enable_paypal == "no" and $enable_stripe == "yes"){ ?>
$('#coinpayments-form').hide();
$('#payza-form').hide();
$('#mobile-money-form').hide();
$('#paystack-form').hide();
<?php }elseif($enable_paypal == "no" and $enable_stripe == "no" and $enable_payza == "yes") { ?>
$('#coinpayments-form').hide();
$('#mobile-money-form').hide();
$('#paystack-form').hide();
<?php }elseif($enable_paypal == "no" and $enable_stripe == "no" and $enable_payza == "no" and $enable_coinpayments == "yes") { ?>
$('#mobile-money-form').hide();
$('#paystack-form').hide();
<?php }elseif($enable_paypal == "no" and $enable_stripe == "no" and $enable_payza == "no" and $enable_coinpayments == "no" and $enable_paystack == "yes") { ?>
$('#mobile-money-form').hide();
<?php } ?>
<?php } ?>
$('#shopping-balance').click(function(){
	$('.col-mi-5 .card br').show();
	$('.total-price').html('<?php echo $s_currency; ?><?php echo $sub_total; ?>');
	$('.processing-fee').hide();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').show();
});
$('#paypal').click(function(){
	$('.col-md-5 .card br').hide();
	$('.total-price').html('<?php echo $s_currency; ?><?php echo $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#paypal-form').show();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
});
$('#credit-card').click(function(){
	$('.col-md-5 .card br').hide();
	$('.total-price').html('<?php echo $s_currency; ?><?php echo $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').show();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
});
$('#mobile-money').click(function(){
	$('.col-md-5 .card br').hide();
	$('.total-price').html('<?php echo $s_currency; ?><?php echo $total; ?>');
	$('.processing-fee').show();
	$('#mobile-money-form').show();
	$('#credit-card-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#payza-form').hide();
});
$('#coinpayments').click(function(){
	$('.col-md-5 .card br').hide();
	$('.total-price').html('<?php echo $s_currency; ?><?php echo $total; ?>');
	$('.processing-fee').show();
	$('#payza-form').hide();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#coinpayments-form').show();
	$('#paystack-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
});
$('#paystack').click(function(){
	$('.col-md-5 .card br').hide();
	$('.total-price').html('<?php echo $s_currency; ?><?php echo $total; ?>');
	$('.processing-fee').show();
	$('#payza-form').hide();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').show();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
});
$('#payza').click(function(){
	$('.col-md-5 .card br').hide();
	$('.total-price').html('<?php echo $s_currency; ?><?php echo $total; ?>');
	$('.processing-fee').show();
	$('#payza-form').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#coinpayments-form').hide();
	$('#paystack-form').hide();
	$('#paypal-form').hide();
	$('#shopping-balance-form').hide();
});
});
</script>
<?php } ?>
<?php require_once("includes/footer.php"); ?>
</body>
</html>
<?php
}}elseif(isset($_POST['add_cart'])){
	$proposal_id = $input->post('proposal_id');	
	$proposal_qty = $input->post('proposal_qty');	
	$select_proposal = $db->select("proposals",array("proposal_id"=>$proposal_id));
	$row_proposal = $select_proposal->fetch();
	$proposal_price = $row_proposal->proposal_price;
	if(isset($_POST['package_id'])){
		$get_p_1 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_id"=>$input->post('package_id')));
		$proposal_price = $get_p_1->fetch()->price;
	}else{
		$proposal_price = $row_proposal->proposal_price;
	}
	$proposal_url = $row_proposal->proposal_url;
	$proposal_seller_id = $row_proposal->proposal_seller_id;
	$select_seller = $db->select("sellers",array("seller_id"=>$proposal_seller_id));
	$row_seller = $select_seller->fetch();
	$seller_user_name = $row_seller->seller_user_name;
	$count_cart = $db->count("cart",array("seller_id"=>$login_seller_id,"proposal_id"=>$proposal_id));
	if($count_cart == 1){
		echo "<script>
		alert('This proposal/service is already in your cart.');
		window.open('proposals/$seller_user_name/$proposal_url','_self');
		</script>";
	}else{
		$insert_cart = $db->insert("cart",array("seller_id"=>$login_seller_id,"proposal_id"=>$proposal_id,"proposal_price"=>$proposal_price,"proposal_qty"=>$proposal_qty));
		echo "<script>window.open('proposals/$seller_user_name/$proposal_url','_self');</script>";
	}
}

?>