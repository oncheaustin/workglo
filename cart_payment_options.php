<?php
session_start();
require_once("includes/db.php");
require_once("functions/payment.php");
require_once("functions/processing_fee.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('login','_self')</script>";
}

$get_payment_settings = $db->select("payment_settings");
$row_payment_settings = $get_payment_settings->fetch();
$enable_paypal = $row_payment_settings->enable_paypal;
$paypal_email = $row_payment_settings->paypal_email;
$paypal_currency_code = $row_payment_settings->paypal_currency_code;
$paypal_sandbox = $row_payment_settings->paypal_sandbox;
if($paypal_sandbox == "on"){
$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
}elseif($paypal_sandbox == "off"){
$paypal_url = "https://www.paypal.com/cgi-bin/webscr";	
}
$enable_stripe = $row_payment_settings->enable_stripe;
$enable_dusupay = $row_payment_settings->enable_dusupay;


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

$select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
$row_seller_accounts = $select_seller_accounts->fetch();
$current_balance = $row_seller_accounts->current_balance;

$select_cart =  $db->select("cart",array("seller_id" => $login_seller_id));
$count_cart = $select_cart->rowCount();
$sub_total = 0;
while($row_cart = $select_cart->fetch()){
	$proposal_price = $row_cart->proposal_price;
	$proposal_qty = $row_cart->proposal_qty;
	$cart_total = $proposal_price * $proposal_qty;
	$sub_total += $cart_total;
}
$processing_fee = processing_fee($sub_total);
$total = $sub_total + $processing_fee;

?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
	<title> <?php echo $site_name; ?> - Payment Options</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<meta name="author" content="<?php echo $site_author; ?>">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
	<link href="styles/bootstrap.css" rel="stylesheet">
    <link href="styles/custom.css" rel="stylesheet"> <!-- Custom css code from modified in admin panel --->
	<link href="styles/styles.css" rel="stylesheet">
	<link href="styles/categories_nav_styles.css" rel="stylesheet">
	<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
	<link href="styles/owl.carousel.css" rel="stylesheet">
	<link href="styles/owl.theme.default.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
  <?php if(!empty($site_favicon)){ ?>
  <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
  <?php } ?>
</head>
<body class="is-responsive">
<?php 
require_once("includes/header.php"); 
$site_logo_image = $row_general_settings->site_logo;
if($seller_verification != "ok"){
echo "
<div class='alert alert-danger rounded-0 mt-0 text-center'>
Please confirm your email to use this feature.
</div>";
}else{
?>
<div class="container mt-5 mb-5">
	<div class="row">
		<div class="col-md-12">
			<div class="card mb-3">
				<div class="card-body">
					<h5 class="float-left mt-2"> Your Cart (<?php echo $count_cart; ?>) </h5>
					<h5 class="float-right">
						<a href="index" class="btn btn-success"> Continue Shopping </a>
					</h5>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-7">
			<div class="row">
        <?php if($current_balance >= $sub_total ){ ?>
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
                   Personal Balance - <b><?php echo $login_seller_user_name; ?></b> <span class="text-success font-weight-bold"><?php echo $s_currency; ?><?php echo $current_balance; ?></span>
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
							<input id="paypal" type="radio" name="method" class="form-control radio-input" <?php if($current_balance < $sub_total){echo"checked";} ?>>
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
							<input id="credit-card" type="radio" name="method" class="form-control radio-input" <?php if($current_balance < $sub_total){if($enable_paypal=="no"){echo"checked";}} ?>>
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
	                                } ?>>
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
			<div class="card">
				<div class="card-body cart-order-details">
					<p>Cart Subtotal <span class="float-right"><?php echo $s_currency; ?><?php echo $sub_total; ?></span></p>
					<hr>
					<p class="processing-fee">Processing Fee <span class="float-right"><?php echo $s_currency; ?><?php echo $processing_fee; ?> </span></p>
					<hr class="processing-fee">
					<p>Total <span class="float-right font-weight-bold total-price"><?php echo $s_currency; ?><?php echo $total; ?></span></p>
					<hr>
		<?php if($current_balance >= $sub_total){ ?>
		<form action="shopping_balance" method="post" id="shopping-balance-form">
		<button type="submit" name="cart_submit_order" class="btn btn-lg btn-success btn-block" onclick="return confirm('Do you really want to order proposal/services from your shopping balance?')">
		Pay With Shopping Balance
		</button>
		</form>
		<?php } ?>
		<?php if($enable_paypal == "yes"){ ?>
		<form action="" method="post" id="paypal-form"><!--- paypal-form Starts --->
		  <button type="submit" name="paypal" class="btn btn-lg btn-success btn-block">
		  Pay With Paypal
		  </button>
		</form><!--- paypal-form Ends --->
		<?php 
		if(isset($_POST['paypal'])){
		$payment = new Payment();
		$data = [];
		$data['name'] = "All Cart Proposals Payment";
		$data['qty'] = 1;
		$data['price'] = $sub_total;
		$data['sub_total'] = $sub_total;
		$data['total'] = $total;
		$data['cancel_url'] = "$site_url/cart_payment_options";
		$data['redirect_url'] = "$site_url/paypal_order?cart_seller_id=$login_seller_id";
		$payment->paypal($data,$processing_fee);
		}
		}
		?>
    <?php if($enable_stripe == "yes"){ ?>
    <?php
    require_once("stripe_config.php");
    $stripe_total_amount = $total * 100;
    ?>
    <form action="cart_charge" method="post" id="credit-card-form"><!--- credit-card-form Starts --->
      <input
      type="submit"
      class="btn btn-lg btn-success btn-block strip-submit"
      data-key="<?php echo $stripe['publishable_key']; ?>"
      value="Pay With Credit Card"
      data-amount="<?php echo $stripe_total_amount; ?>"
      data-currency="<?php echo $stripe['currency_code']; ?>"
      data-email="<?php echo $login_seller_email; ?>"
      data-name="<?php echo $site_name; ?>"
      data-image="images/<?php echo $site_logo_image; ?>"
      data-description="All Cart Payment"
      data-allow-remember-me="false">
      <script>
      $(document).ready(function() {
                  $('.strip-submit').on('click', function(event) {
                      event.preventDefault();
                      var $button = $(this),
                          $form = $button.parents('form');
                      var opts = $.extend({}, $button.data(), {
                          token: function(result) {
                              $form.append($('<input>').attr({ type: 'hidden', name: 'stripeToken', value: result.id })).submit();
                          }
                      });
                      StripeCheckout.open(opts);
                  });
              });
      </script>
    </form><!--- credit-card-form Ends --->
  	<?php } ?>
    <?php if($enable_payza == "yes"){ ?>
		<form action="https://secure.payza.eu/checkout" method="post" id="payza-form">
		    <input type="hidden" name="ap_merchant" value="<?php echo $payza_email; ?>"/>
		    <input type="hidden" name="ap_purchasetype" value="item"/>
		    <input type="hidden" name="ap_itemname" value="Cart"/>
		    <input type="hidden" name="ap_amount" value="<?php echo $sub_total; ?>"/>
		    <input type="hidden" name="ap_currency" value="<?php echo $payza_currency_code; ?>"/>    
		    <input type="hidden" name="ap_description" value="Cart Payment"/>
		    <input type="hidden" name="ap_taxamount" value="<?php echo $processing_fee; ?>"/>
		    <input type="hidden" name="ap_ipnversion" value="2"/>
            <?php if($payza_test == "on"){ ?>
		    <input type="hidden" name="ap_testmode" value="1"/>
			<?php }else{ ?>
		    <input type="hidden" name="ap_testmode" value="0"/>
			<?php } ?>
		    <input type="hidden" name="ap_returnurl" value="<?php echo $site_url; ?>/payza_order?cart_seller_id=<?php echo $login_seller_id; ?>" />
		    <input type="hidden" name="ap_cancelurl" value="<?php echo $site_url; ?>/cart_payment_options.php" />
			<input type="submit" class="btn btn-lg btn-success btn-block" value="Pay With Payza">
		</form>
        <?php } ?>
        <?php if($enable_coinpayments == "yes"){ ?>
		<form action="https://www.coinpayments.net/index.php" method="post" id="coinpayments-form">
			<input type="hidden" name="cmd" value="_pay_simple">
			<input type="hidden" name="reset" value="1">
			<input type="hidden" name="merchant" value="<?php echo $coinpayments_merchant_id; ?>">
			<input type="hidden" name="item_name" value="Cart">
			<input type="hidden" name="item_desc" value="Cart Payment">
			<input type="hidden" name="item_number" value="1">
			<input type="hidden" name="currency" value="<?php echo $coinpayments_currency_code; ?>">
			<input type="hidden" name="amountf" value="<?php echo $sub_total; ?>">
			<input type="hidden" name="want_shipping" value="0">
			<input type="hidden" name="taxf" value="<?php echo $processing_fee; ?>">
			<input type="hidden" name="success_url" value="<?php echo $site_url; ?>/crypto_order?cart_seller_id=<?php echo $login_seller_id; ?>">
			<input type="hidden" name="cancel_url" value="<?php echo $site_url; ?>/cart_payment_options.php">
			<input type="submit" class="btn btn-lg btn-success btn-block" value="Pay With Coinpayments">
		</form>
        <?php } ?>
		<?php if($enable_paystack == "yes"){ ?>
		<form action="paystack_charge" method="post" id="paystack-form"><!--- paystack-form Starts --->
		 <button type="submit" name="paystack" class="btn btn-lg btn-success btn-block">Pay With Paystack</button>
		</form><!--- paystack-form Ends --->
		<?php } ?>
 		        <?php if($enable_dusupay == "yes"){ ?>
		<form method="post" action="" id="mobile-money-form">
			<input type="submit" name="dusupay" value="Pay With Mobile Money" class="btn btn-lg btn-success btn-block">
		</form>
		<?php 
		if(isset($_POST['dusupay'])){
		$payment = new Payment();
		$data = [];
		$data['name'] = "All Cart Proposals Payment";
		$data['amount'] = $total;
		$data['redirect_url'] = "$site_url/dusupay_order?cart_seller_id=$login_seller_id&";
		$payment->dusupay($data);
		}
		?>
        <?php } ?>
                </div>
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
$('#mobile-money-form').hide();
$('#paypal-form').hide();
$('#payza-form').hide();
$('#coinpayments-form').hide();
$('#credit-card-form').hide();
$('#paystack-form').hide();
<?php }else{ ?>
$('#shopping-balance-form').hide();
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
	$('.total-price').html('<?php echo $s_currency; ?><?php echo $sub_total; ?>');
	$('.processing-fee').hide();
	$('#credit-card-form').hide();
	$('#coinpayments-form').hide();
	$('#payza-form').hide();
	$('#paypal-form').hide();
	$('#paystack-form').hide();
	$('#shopping-balance-form').show();
});
$('#paypal').click(function(){
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
	$('.total-price').html('<?php echo $s_currency; ?><?php echo $total; ?>');
	$('.processing-fee').show();
	$('#payza-form').hide();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#coinpayments-form').show();
	$('#paypal-form').hide();
	$('#paystack-form').hide();
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
	$('.total-price').html('<?php echo $s_currency; ?><?php echo $total; ?>');
	$('.processing-fee').show();
	$('#payza-form').show();
	$('#mobile-money-form').hide();
	$('#credit-card-form').hide();
	$('#coinpayments-form').hide();
	$('#paypal-form').hide();
	$('#paystack-form').hide();
	$('#shopping-balance-form').hide();
});
});
</script>
<?php } ?>
<?php require_once("includes/footer.php"); ?>
</body>
</html>