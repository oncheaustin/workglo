<?php

session_start();

require_once("../includes/db.php");
require_once("../functions/processing_fee.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_email = $row_login_seller->seller_email;

$get_payment_settings = $db->select("payment_settings");

$row_payment_settings = $get_payment_settings->fetch();

$enable_paypal = $row_payment_settings->enable_paypal;

$paypal_email = $row_payment_settings->paypal_email;

$paypal_currency_code = $row_payment_settings->paypal_currency_code;

$paypal_sandbox = $row_payment_settings->paypal_sandbox;

$featured_fee = $row_payment_settings->featured_fee;

$featured_duration = $row_payment_settings->featured_duration;

$enable_dusupay = $row_payment_settings->enable_dusupay;



$enable_stripe = $row_payment_settings->enable_stripe;

$enable_payza = $row_payment_settings->enable_payza;

$payza_test = $row_payment_settings->payza_test;

$payza_currency_code = $row_payment_settings->payza_currency_code;

$payza_email = $row_payment_settings->payza_email;

$enable_coinpayments = $row_payment_settings->enable_coinpayments;

$coinpayments_merchant_id = $row_payment_settings->coinpayments_merchant_id;

$coinpayments_currency_code = $row_payment_settings->coinpayments_currency_code;


$enable_paystack = $row_payment_settings->enable_paystack;


$processing_fee = processing_fee($featured_fee);
$total = $featured_fee+$processing_fee;

$select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
$row_seller_accounts = $select_seller_accounts->fetch();
$current_balance = $row_seller_accounts->current_balance;

$_SESSION['f_proposal_id'] = $input->post('proposal_id');
$_SESSION['f_createProposal'] = @$input->post('createProposal');

$proposal_id = $input->post('proposal_id');
$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
$row_proposals = $select_proposals->fetch();
$proposal_title = $row_proposals->proposal_title;
$site_logo_image = $row_general_settings->site_logo;

?>

<div id="featured-listing-modal" class="modal fade">


<div class="modal-dialog">

	<div class="modal-content">

		<div class="modal-header">

			<h5 class="modal-title"> Make Your Proposal/Service Featured</h5>

			<button class="close" data-dismiss="modal"><span>&times;</span></button>

		</div>

		<div class="modal-body p-0">

			<div class="order-details">

				<div class="request-div">

					<h4 class="mb-3">
						
					<b>FEATURE LISTING FEE & INFO:</b> <span class="price pull-right d-none d-sm-block mb-3 font-weight-bold"><?php echo $s_currency; ?><?php echo $featured_fee; ?></span>

					</h4>

					<p>
						
						You are about to pay a feature listing fee for your proposal/service. This will make this proposal/service feature on our "Featured proposal/service" spots. The fee is <?php echo $s_currency; ?><?php echo $featured_fee; ?> and the duration is <?php echo $featured_duration; ?> Days. Please use any of the following payment methods below to complete payment.

					</p>

					<h4><b>SUMMARY:</b></h4>
					<p><b>Proposal Title:</b> <?php echo $proposal_title; ?></p>
					<p><b>Feature Listing Fee:</b> <?php echo $s_currency; ?><?php echo $featured_fee; ?></p>
					<p><b>Processing Fee:</b> <?php echo $s_currency; ?><?php echo $processing_fee; ?></p>
					<p><b>Listing Duration:</b> <?php echo $featured_duration; ?> Days.</p>
				</div>

			</div>

			<div class="payment-options-list">
                
                <?php if($current_balance >= $featured_fee){ ?>

				<div class="payment-options mb-2">

					<input type="radio" name="payment_option" id="shopping-balance" class="radio-custom" checked>

					<label for="shopping-balance" class="radio-custom-label" ></label>

					<span class="lead font-weight-bold"> Shopping Balance </span>

					<p class="lead ml-5">

					Personal Balance - <?php echo $login_seller_user_name; ?> <span class="text-success font-weight-bold"> <?php echo $s_currency; ?><?php echo $current_balance; ?> </span>

					</p>

				</div>
                        
                <?php If($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_payza == "yes" or $enable_coinpayments == "yes" or $enable_dusupay == "yes"){ ?>

				<hr>
                        
                <?php } ?>
                        
                <?php } ?>
                        
                
                <?php if($enable_paypal == "yes"){ ?>

				<div class="payment-option">

					<input type="radio" name="payment_option" id="paypal" class="radio-custom"
                           
                        <?php

                        if($current_balance < $featured_fee){

                        echo "checked";

                        }

                        ?>
                    >

					<label for="paypal" class="radio-custom-label"></label>

					<img src="../images/paypal.png">

				</div>
                        
                <?php } ?>

                    <?php if($enable_stripe == "yes"){ ?>

                    <?php if($enable_paypal == "yes"){ ?>

				<hr>
                
                <?php } ?>

				<div class="payment-option">

					<input type="radio" name="payment_option" id="credit-card" class="radio-custom"
                           
                           <?php

                                if($current_balance < $featured_fee){

                                if($enable_paypal == "no"){

                                echo "checked";

                                }

                                }

                            ?>
                    >

					<label for="credit-card" class="radio-custom-label"></label>

					<img src="../images/credit_cards.jpg">

				</div>
                
            <?php } ?>



                <?php if($enable_payza == "yes"){ ?>

                <?php if($enable_paypal == "yes" or $enable_stripe == "yes"){ ?>

				<hr>
                
                <?php } ?>

					<div class="payment-option">

						<input type="radio" name="payment_option" id="payza" class="radio-custom"

                            <?php

                            if($current_balance < $featured_fee){

                            if($enable_paypal == "no" and $enable_stripe == "no" and $enable_payza == "yes"){ 
                        
                            echo "checked";

                            }

                            }

                            ?>
						>

						<label for="payza" class="radio-custom-label"></label>

						<img src="../images/payza.jpg">

					</div>
                    
                <?php } ?>   


                <?php if($enable_coinpayments == "yes"){ ?>

                <?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_payza == "yes"){ ?>

				<hr>
                
                <?php } ?>

					<div class="payment-option">

						<input type="radio" name="payment_option" id="coinpayments" class="radio-custom"
                            <?php

                            if($current_balance < $featured_fee){

                            if($enable_paypal == "no" and $enable_stripe == "no" and $enable_payza == "no"){ 

                            echo "checked";

                            }

                            }

                            ?>>

						<label for="coinpayments" class="radio-custom-label"></label>

						<img src="../images/coinpayments.png">

					</div>
                    
                <?php } ?>


                <?php if($enable_paystack == "yes"){ ?>

                <?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_payza == "yes" or $enable_coinpayments == "yes"){ ?>

				<hr>
                
                <?php } ?>

					<div class="payment-option">

						<input type="radio" name="payment_option" id="paystack" class="radio-custom"
                            <?php

                            if($current_balance < $featured_fee){

                            if($enable_paypal == "no" and $enable_stripe == "no" and $enable_payza == "no" and $enable_coinpayments == "no"){ 

                            echo "checked";

                            }

                            }

                            ?>>

						<label for="paystack" class="radio-custom-label"></label>

						<img src="../images/paystack.png">

					</div>
                    
                <?php } ?>   


                <?php if($enable_dusupay == "yes"){ ?>

                <?php if($enable_paypal == "yes" or $enable_stripe == "yes" or $enable_payza == "yes" or $enable_coinpayments =="yes" or $enable_paystack == "yes"){ ?>

				<hr>
                
                <?php } ?>

					<div class="payment-option">

						<input type="radio" name="payment_option" id="mobile-money" class="radio-custom"
	                           <?php

	                                if($current_balance < $featured_fee){

	                                if($enable_paypal == "no" and $enable_stripe == "no" and $enable_payza == "no" and $enable_coinpayments == "no" and $enable_paystack == "no"){ 

	                                	echo "checked"; 

	                                }

	                                }

	                            ?>
						>

						<label for="mobile-money" class="radio-custom-label"></label>

						<img src="../images/mobile-money.png">

					</div>
                    
                    <?php } ?>     

            
            </div>

		</div>

		<div class="modal-footer">

            <button class="btn btn-secondary" data-dismiss="modal"> Close </button>
            
            

             <?php if($current_balance >= $featured_fee){ ?>
            
            		<form action="../shopping_balance" method="post" id="shopping-balance-form">

						<button class="btn btn-success" type="submit" name="pay_featured_proposal_listing" onclick="return confirm('Are you sure you want to pay for the feature listing with your shopping balance ?')">

							Pay With Shopping Balance
						
						</button>
						
					</form>
            
                    <br>
            
                   <?php } ?>


            	<?php if($enable_paypal == "yes"){ ?>

				<form action="paypal_listing_charge" method="post" id="paypal-form">

                   <button type="submit" name="paypal" class="btn btn-success ">Pay With PayPal</button>

             	</form>
            
            <?php } ?>
            
            
            <?php if($enable_stripe == "yes"){ ?>

            <?php

            require_once("../stripe_config.php");

            $stripe_total_amount = $total * 100;

            ?>

             <form action="stripe_listing_charge" method="post" id="credit-card-form">

					<input

					type="submit"
					class="btn btn-success stripe-submit"
					value="Pay With Credit Card"
					data-dismiss="modal"
					data-key="<?php echo $stripe['publishable_key']; ?>"
					data-amount="<?php echo $stripe_total_amount; ?>"
					data-currency="<?php echo $stripe['currency_code']; ?>"
					data-email="<?php echo $login_seller_email; ?>"
					data-name="<?php echo $site_name ?>"
					data-image="../images/<?php echo $site_logo_image; ?>"
					data-description="<?php echo $proposal_title; ?>"
					data-allow-remember-me="true">

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
		    <input type="hidden" name="ap_amount" value="<?php echo $featured_fee; ?>"/>
		    <input type="hidden" name="ap_currency" value="<?php echo $payza_currency_code; ?>"/>    
		    <input type="hidden" name="ap_description" value="Feature Listing Payment"/>
		    <input type="hidden" name="ap_taxamount" value="<?php echo $processing_fee; ?>"/>
		    <input type="hidden" name="ap_ipnversion" value="2"/>
            
            <?php if($payza_test == "on"){ ?>

		    <input type="hidden" name="ap_testmode" value="1"/>
			
			<?php }else{ ?>
		    
		    <input type="hidden" name="ap_testmode" value="0"/>
			
			<?php } ?>

		    <input type="hidden" name="ap_returnurl" value="<?php echo $site_url; ?>/payza_order?proposal_id=<?php echo $proposal_id; ?>&featured_listing=1"/>
		    
		    <input type="hidden" name="ap_cancelurl" value="<?php echo $site_url; ?>/proposals/view_proposals.php"/>

			<input type="submit" class="btn btn-success" value="Pay With Payza">
		
		</form>

        <?php } ?>


        <?php if($enable_coinpayments == "yes"){ ?>

		<form action="https://www.coinpayments.net/index.php" method="post" id="coinpayments-form">
		
			<input type="hidden" name="cmd" value="_pay_simple">
		
			<input type="hidden" name="reset" value="1">
		
			<input type="hidden" name="merchant" value="<?php echo $coinpayments_merchant_id; ?>">
		
			<input type="hidden" name="item_name" value="<?php echo $proposal_title; ?>">
		
			<input type="hidden" name="item_desc" value="Feature Listing Payment">
		
			<input type="hidden" name="item_number" value="1">
		
			<input type="hidden" name="currency" value="<?php echo $coinpayments_currency_code; ?>">
		
			<input type="hidden" name="amountf" value="<?php echo $featured_fee; ?>">
		
			<input type="hidden" name="want_shipping" value="0">
		
			<input type="hidden" name="taxf" value="<?php echo $processing_fee; ?>">
		
			<input type="hidden" name="success_url" value="<?php echo $site_url; ?>/crypto_order?proposal_id=<?php echo $proposal_id; ?>&featured_listing=1">
		
			<input type="hidden" name="cancel_url" value="<?php echo $site_url; ?>/proposals/view_proposals.php">

			<input type="submit" class="btn btn-success btn-block" value="Pay With Coinpayments">
		
		</form>

        <?php } ?>


		<?php if($enable_paystack == "yes"){ ?>

		<form action="paystack_listing_charge" method="post" id="paystack-form"><!--- paystack-form Starts --->

		 <button type="submit" name="paystack" class="btn btn-success btn-block">Pay With Paystack</button>

		</form><!--- paystack-form Ends --->
		      
		<?php } ?>


        <?php if($enable_dusupay == "yes"){ ?>

		<form method="post" action="dusupay_charge" id="mobile-money-form">

		<input type="submit" name="dusupay" value="Pay With Mobile Money" class="btn btn-success">

		</form>

        <?php } ?>


        </div>

	</div>

</div>


</div>


<script>

$(document).ready(function(){
	
$("#featured-listing-modal").modal("show");


<?php if($current_balance >= $featured_fee){ ?>

$('#paypal-form').hide();

$('#credit-card-form').hide();

$('#coinpayments-form').hide();

$('#paystack-form').hide();

$('#payza-form').hide();
	
$('#mobile-money-form').hide();
	
<?php }else{ ?>
	
$('#shopping-balance-form').hide();

	
<?php } ?>




<?php if($current_balance < $featured_fee){ ?>


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
	
	$('#credit-card-form').hide();
	
	$('#paypal-form').hide();
	
	$('#shopping-balance-form').show();

	$('#coinpayments-form').hide();

	$('#paystack-form').hide();

	$('#payza-form').hide();
	
	$('#mobile-money-form').hide();
	
});
	
	
	
$('#paypal').click(function(){
	
	$('#credit-card-form').hide();
	
	$('#paypal-form').show();
	
	$('#shopping-balance-form').hide();

	$('#coinpayments-form').hide();

	$('#paystack-form').hide();

	$('#payza-form').hide();

	$('#mobile-money-form').hide();
	
});



$('#credit-card').click(function(){

	$('#credit-card-form').show();
	
	$('#paypal-form').hide();
	
	$('#shopping-balance-form').hide();

	$('#coinpayments-form').hide();

	$('#paystack-form').hide();

	$('#payza-form').hide();

	$('#mobile-money-form').hide();
	
});


$('#coinpayments').click(function(){
			
	$('#mobile-money-form').hide();
	
	$('#credit-card-form').hide();

	$('#paypal-form').hide();

    $('#coinpayments-form').show();

	$('#paystack-form').hide();

	$('#payza-form').hide();
	
	$('#shopping-balance-form').hide();
	
});



$('#payza').click(function(){
	
	$('#mobile-money-form').hide();
	
	$('#paypal-form').hide();

	$('#coinpayments-form').hide();

	$('#paystack-form').hide();

	$('#payza-form').show();
	
	$('#shopping-balance-form').hide();
	
});


$('#paystack').click(function(){
	
	$('#payza-form').hide();

	$('#mobile-money-form').hide();
	
	$('#credit-card-form').hide();

	$('#coinpayments-form').hide();

	$('#paystack-form').show();

	$('#paypal-form').hide();
	
	$('#shopping-balance-form').hide();
	
});


$('#mobile-money').click(function(){

	$('#credit-card-form').hide();
	
	$('#paypal-form').hide();
	
	$('#shopping-balance-form').hide();

	$('#coinpayments-form').hide();

	$('#paystack-form').hide();

	$('#payza-form').hide();

	$('#mobile-money-form').show();
	
});



});

</script>