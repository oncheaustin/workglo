<?php if($current_balance >= $sub_total){ ?>
<form action="shopping_balance" method="post" id="shopping-balance-form">
<button class="btn btn-lg btn-success btn-block" type="submit" name="checkout_submit_order" onclick="return confirm('Are you sure you want to pay for this with your shopping balance?')">
	Pay With Shopping Balance
</button>
</form>
<?php } ?>
      
<?php if($enable_paypal == "yes"){ ?>
<form action="paypal_charge" method="post" id="paypal-form"><!--- paypal-form Starts --->
 <button type="submit" name="paypal" class="btn btn-lg btn-success btn-block">Pay With Paypal</button>
</form>
<?php } ?>

<?php 
if($enable_stripe == "yes"){
require_once("stripe_config.php");
$stripe_total_amount = $total * 100;
?>
<form action="checkout_charge" method="post" id="credit-card-form"><!--- credit-card-form Starts --->
<input
type="submit"
class="btn btn-lg btn-success btn-block stripe-submit"
value="Pay With Credit Card"
data-key="<?php echo $stripe['publishable_key']; ?>"
data-amount="<?php echo $stripe_total_amount; ?>"
data-currency="<?php echo $stripe['currency_code']; ?>"
data-email="<?php echo $login_seller_email; ?>"
data-name="<?php echo $site_name; ?>"
data-image="images/<?php echo $site_logo_image; ?>"
data-description="<?php echo $proposal_title; ?>"
data-allow-remember-me="false">
<script>
$(document).ready(function() {
	$('.stripe-submit').on('click', function(event) {
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
</form>
<?php } ?>


<?php if($enable_payza == "yes"){ ?>
<form action="https://secure.payza.eu/checkout" method="post" id="payza-form">
<input type="hidden" name="ap_merchant" value="<?php echo $payza_email; ?>"/>
<input type="hidden" name="ap_purchasetype" value="item"/>
<input type="hidden" name="ap_itemname" value="<?php echo $proposal_title; ?>"/>
<input type="hidden" name="ap_amount" value="<?php echo $sub_total; ?>"/>
<input type="hidden" name="ap_currency" value="<?php echo $payza_currency_code; ?>"/>    
<input type="hidden" name="ap_quantity" value="<?php echo $proposal_qty; ?>"/>
<input type="hidden" name="ap_description" value="Proposal Payment"/>
<input type="hidden" name="ap_taxamount" value="<?php echo $processing_fee; ?>"/>
<input type="hidden" name="ap_ipnversion" value="2"/>
<?php if($payza_test == "on"){ ?>
<input type="hidden" name="ap_testmode" value="1"/>
<?php }else{ ?>
<input type="hidden" name="ap_testmode" value="0"/>
<?php } ?>
<input type="hidden" name="ap_returnurl" value="<?php echo $site_url; ?>/payza_order?checkout_seller_id=<?php echo $login_seller_id; ?>&proposal_id=<?php echo $proposal_id; ?>&proposal_qty=<?php echo $proposal_qty; ?>&proposal_price=<?php echo $sub_total; ?>&proposal_extras=<?php echo base64_encode(serialize(@$proposal_extras)); ?>"/>
<input type="hidden" name="ap_cancelurl" value="<?php echo $site_url; ?>/proposals/<?php echo $proposal_seller_user_name; ?>/<?php echo $proposal_url; ?>" />
<input type="submit" class="btn btn-lg btn-success btn-block" value="Pay With Payza">
</form>
<?php } ?>

<?php if($enable_coinpayments == "yes"){ ?>
<form action="https://www.coinpayments.net/index.php" method="post" id="coinpayments-form">
<input type="hidden" name="cmd" value="_pay_simple">
<input type="hidden" name="reset" value="1">
<input type="hidden" name="merchant" value="<?php echo $coinpayments_merchant_id; ?>">
<input type="hidden" name="item_name" value="<?php echo $proposal_title; ?>">
<input type="hidden" name="item_desc" value="Proposal Payment">
<input type="hidden" name="item_number" value="1">
<input type="hidden" name="currency" value="<?php echo $coinpayments_currency_code; ?>">
<input type="hidden" name="amountf" value="<?php echo $sub_total; ?>">
<input type="hidden" name="want_shipping" value="0">
<input type="hidden" name="taxf" value="<?php echo $processing_fee; ?>">
<input type="hidden" name="success_url" value="<?php echo $site_url; ?>/crypto_order?checkout_seller_id=<?php echo $login_seller_id; ?>&proposal_id=<?php echo $proposal_id; ?>&proposal_qty=<?php echo $proposal_qty; ?>&proposal_price=<?php echo $sub_total; ?>&proposal_extras=<?php echo base64_encode(serialize(@$proposal_extras)); ?>">
<input type="hidden" name="cancel_url" value="<?php echo $site_url; ?>/proposals/<?php echo $proposal_seller_user_name; ?>/<?php echo $proposal_url; ?>">
<input type="submit" class="btn btn-lg btn-success btn-block" value="Pay With Coinpayments">
</form>
<?php } ?>

<?php if($enable_paystack == "yes"){ ?>
<form action="paystack_charge" method="post" id="paystack-form"><!--- paypal-form Starts --->
 <button type="submit" name="paystack" class="btn btn-lg btn-success btn-block">Pay With Paystack</button>
</form>
<?php } ?>

<?php if($enable_dusupay == "yes"){ ?>
<form method="post" action="dusupay_charge" id="mobile-money-form">
<input type="submit" name="dusupay" value="Pay With Mobile Money" class="btn btn-lg btn-success btn-block">
</form>
<?php } ?>