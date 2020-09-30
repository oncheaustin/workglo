<?php
class Payment{

/// Paypal Payment Code Starts ////
public function paypal_api_setup(){
	global $db;
	global $dir;
	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$paypal_app_client_id = $row_payment_settings->paypal_app_client_id;
	$paypal_app_client_secret = $row_payment_settings->paypal_app_client_secret;
	$paypal_sandbox = $row_payment_settings->paypal_sandbox;
	if($paypal_sandbox == "on"){
	$mode = "sandbox";
	}elseif($paypal_sandbox == "off"){
	$mode = "live";
	}
	require_once "$dir/vendor/autoload.php";
	$api = new PayPal\Rest\ApiContext(
		new PayPal\Auth\OAuthTokenCredential(
			$paypal_app_client_id,
			$paypal_app_client_secret
		)
	);
	$api->setConfig([
		"mode" => $mode
	]);
	return $api;
}

public function paypal($data,$processing_fee){
	global $db;
	global $site_url;
	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$paypal_currency_code = $row_payment_settings->paypal_currency_code;;
	$api = $this->paypal_api_setup();
	$payer = new PayPal\Api\Payer();
	$item1 = new PayPal\Api\Item();
	$itemList = new PayPal\Api\ItemList();
	$details = new PayPal\Api\Details();
	$amount = new PayPal\Api\Amount();
	$transaction = new PayPal\Api\Transaction();
	$payment = new PayPal\Api\Payment();
	$redirecturls = new PayPal\Api\RedirectUrls();
	//Payer
	$payer->setPaymentMethod("paypal");
	// ### Itemized information
	$item1->setName($data['name'])->setCurrency("$paypal_currency_code")->setQuantity($data['qty'])->setPrice($data['price']);
	$itemList->setItems(array($item1));
	// ### Additional payment details
	$details->setShipping(0)->setTax($processing_fee)->setSubtotal($data['sub_total']);
	//Amount
	$amount->setCurrency("$paypal_currency_code")->setTotal($data['total'])->setDetails($details);
	//Transaction
	$transaction->setAmount($amount)->setItemList($itemList)->setDescription("");
	//Redirect Urls
	$redirecturls->setReturnUrl("{$data['redirect_url']}")->setCancelUrl("{$data['cancel_url']}");
	//Payment
	$payment->setIntent("sale")->setPayer($payer)->setRedirectUrls($redirecturls)->setTransactions([$transaction]);
	try{
		$payment->create($api);
		//Generate Payment-id
		$payment_id = $payment->getId();
		$approvalUrl = $payment->getApprovalLink();
		echo "<script>window.open('$approvalUrl','_self')</script>";
	}catch (Exception $ex){
		echo "there is an error connecting to paypal api.";
	}
}

public function paypal_execute($type){
  global $db;
  global $input;
  global $site_url;
  $login_seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;
  // paypal api
  $api = $this->paypal_api_setup();
  //Get The Paypal Payment
  $paymentId = $_GET["paymentId"];
  $PayerID = $_GET["PayerID"];
  $payment = PayPal\Api\Payment::get($paymentId, $api);
  $execution = new PayPal\Api\PaymentExecution();
  $execution->setPayerId($PayerID);
  try {
    // Execute the payment
    $result = $payment->execute($execution, $api);
    if($result){
	    if($type == "proposal"){
			  $_SESSION['checkout_seller_id'] = $input->get('checkout_seller_id');
			  $_SESSION['proposal_id'] = $input->get('proposal_id');
			  $_SESSION['proposal_qty'] = $input->get('proposal_qty');
			  $_SESSION['proposal_price'] = $input->get('proposal_price');
			  if(isset($_GET['proposal_extras'])){
			  $_SESSION['proposal_extras'] = unserialize(base64_decode($_GET['proposal_extras']));
			  }
		  }elseif($type == "cart"){
		  	$_SESSION['cart_seller_id'] = $input->get('cart_seller_id');
		  }elseif($type == "featured_listing"){
		 	 $_SESSION['featured_listing'] = $input->get('featured_listing');
		   $_SESSION['proposal_id'] = $input->get('proposal_id');
		  }elseif($type == "view_offers"){
		  	$offer_id = $_GET["offer_id"];
		  	$_SESSION['offer_id'] = $input->get('offer_id');
		  	$_SESSION['offer_buyer_id'] = $login_seller_id;
		  }elseif($type == "message_offer"){ 
		  	$_SESSION['message_offer_id'] = $input->get('message_offer_id');
		  	$_SESSION['message_offer_buyer_id'] = $login_seller_id;
		  }
		  
      $_SESSION['method'] = "paypal";

      if($type == "featured_listing"){
		  	echo "<script>window.open('$site_url/proposals/featured_proposal','_self')</script>";
		  }else{
		  	echo "<script>window.open('$site_url/order','_self')</script>";
		  }
    }
  }catch(Exception $ex){
    exit(1);
  }
}
/// Paypal Payment Code Ends ////

/// Stripe Payment Code Starts ////
public function stripe_api_setup(){
	global $db;
	global $dir;
	require_once "$dir/vendor/autoload.php";
	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$stripe_secret_key = $row_payment_settings->stripe_secret_key;
	$stripe_publishable_key = $row_payment_settings->stripe_publishable_key;
	$stripe_currency_code = $row_payment_settings->stripe_currency_code;
	$stripe = array(
	  "secret_key"      => $stripe_secret_key,
	  "publishable_key" => $stripe_publishable_key,
	  "currency_code"   => $stripe_currency_code
	);
	\Stripe\Stripe::setApiKey($stripe["secret_key"]);
	return $stripe;
}

public function stripe($data){
	global $site_url;
	global $db;
	$login_seller_user_name = $_SESSION['seller_user_name'];
	$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	$row_login_seller = $select_login_seller->fetch();
	$login_seller_id = $row_login_seller->seller_id;
	$login_seller_email = $row_login_seller->seller_email;
	$stripe = $this->stripe_api_setup();
	$customer = \Stripe\Customer::create(array(
		'email' => $login_seller_email,
		'card'  => $data['stripeToken']
	));
	$charge = \Stripe\Charge::create(array(
		'customer' => $customer->id,
		'amount'   => intval($data['amount']) * 100,
		'currency' => $stripe['currency_code'],
		'description' => $data['desc']
	));
	if($charge){
	  if($data['type'] == "proposal"){
	  $_SESSION['checkout_seller_id'] = $login_seller_id;
	  $_SESSION['proposal_id'] = $data['proposal_id'];
	  $_SESSION['proposal_qty'] = $data['proposal_qty'];
	  $_SESSION['proposal_price'] = $data['amount'];
	  if(isset($data['proposal_extras'])){
	  $_SESSION['proposal_extras'] = $data['proposal_extras'];
	  }
	  }elseif ($data['type'] == "cart") {
	  $_SESSION['cart_seller_id'] = $login_seller_id;
	  }elseif($data['type'] == "featured_listing"){
	  $_SESSION['proposal_id'] = $data['proposal_id'];
	  }elseif($data['type'] == "request_offer"){
	  $offer_id = $data["offer_id"];
	  $_SESSION['offer_id'] = $data['offer_id'];
	  $_SESSION['offer_buyer_id'] = $data['offer_buyer_id'];
	  }elseif($data['type'] == "message_offer"){ 
	  $_SESSION['message_offer_id'] = $data['message_offer_id'];
	  $_SESSION['message_offer_buyer_id'] = $data['message_offer_buyer_id'];
	  }
	  $_SESSION['method'] = "stripe";
	  if($data['type'] == "featured_listing"){
	  echo "<script>window.open('$site_url/proposals/featured_proposal','_self');</script>";
	  }else{
	  echo "<script>window.open('$site_url/order','_self');</script>";
	  }
	}
}
/// Stripe Payment Code Ends ////

/// Dusupay Payment Code Starts ////
public function dusupay($data){
	global $db;
	$login_seller_user_name = $_SESSION['seller_user_name'];
	$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	$row_login_seller = $select_login_seller->fetch();
	$login_seller_id = $row_login_seller->seller_id;
	$login_seller_email = $row_login_seller->seller_email;
	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$dusupay_api_key = $row_payment_settings->dusupay_api_key;
	$dusupay_currency_code = $row_payment_settings->dusupay_currency_code;
	$dusupay_sandbox = $row_payment_settings->dusupay_sandbox;
	$test_mode = ($dusupay_sandbox == "on" ? ',"test_webhook_url": "#"' : '');
	$url = ($dusupay_sandbox == "on" ? 'https://dashboard.dusupay.com/api-sandbox/v1/collections' : 'https://api.dusupay.com/v1/collections');
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",    
	  CURLOPT_POSTFIELDS => '{ 
	    "api_key": "'.$dusupay_api_key.'", 
	    "currency": "'.$dusupay_currency_code.'", 
	    "amount": '.$data['amount'].',
	    "method": "CARD", 
	    "provider_id": "international_usd", 
	    "merchant_reference": "'.mt_rand().'", 
	    "narration": "'.$data['name'].'",
	    "redirect_url": "'.$data['redirect_url'].'",
	    "account_name": "'.$login_seller_user_name.'",
	    "account_email": "'.$login_seller_email.'"
	    '.$test_mode.'
	  }',
	  CURLOPT_HTTPHEADER => array(
	    "cache-control: no-cache",
	    "content-type: application/json"
	  ),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if($err){ echo "cURL Error #:" . $err; } else {
	    $data = json_decode($response, TRUE);
		// header('Location: '.$data['data']['payment_url']);
		echo "<script>window.open('".$data['data']['payment_url']."','_self')</script>";
	}
}
/// Dusupay Payment Code Ends ////

/// Paystack Payment Code Starts ////
public function paystack_api_setup(){
	global $db;
	global $dir;
	require_once "$dir/vendor/autoload.php";
	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$enable_paystack = $row_payment_settings->enable_paystack;
	$paystack_public_key = $row_payment_settings->paystack_public_key;
	$paystack_secret_key = $row_payment_settings->paystack_secret_key;
	$paystack = new Yabacon\Paystack($paystack_secret_key);
	return $paystack;
}

public function paystack($data){
	global $db;
	$login_seller_user_name = $_SESSION['seller_user_name'];
	$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	$row_login_seller = $select_login_seller->fetch();
	$login_seller_id = $row_login_seller->seller_id;
	$login_seller_email = $row_login_seller->seller_email;
	$paystack = $this->paystack_api_setup();
	try{
	$tranx = $paystack->transaction->initialize([
	'amount'=>$data['amount']*100, /* 20 naira */
	'email'=> $login_seller_email,
	'reference'=> mt_rand(),
	'callback_url'=>$data['redirect_url'],
	// 'metadata'=>json_encode([
	// 'custom_fields'=> [
	//     [
	//       'display_name'=> "type",
	//       'variable_name'=> "desc",
	//       'value'=> 'Website'
	//     ]
	// ]
	// ])
	]);
	} catch(\Yabacon\Paystack\Exception\ApiException $e){
	print_r($e->getResponseObject());
	die($e->getMessage());
	}
	header('Location: ' . $tranx->data->authorization_url);
}

function paystack_execute($type){
global $input;
global $site_url;
$paystack = $this->paystack_api_setup();
$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
try
    {
      // verify using the library
      $tranx = $paystack->transaction->verify([
        'reference'=>$reference, // unique to transactions
      ]);
    } catch(\Yabacon\Paystack\Exception\ApiException $e){
      print_r($e->getResponseObject());
      die($e->getMessage());
    }
    if ('success' === $tranx->data->status) {
    // transaction was successful...
    // please check other things like whether you already gave value for this ref
    // if the email matches the customer who owns the product etc
    // Give value
    if($type == "proposal"){
	  $_SESSION['checkout_seller_id'] = $input->get('checkout_seller_id');
	  $_SESSION['proposal_id'] = $input->get('proposal_id');
	  $_SESSION['proposal_qty'] = $input->get('proposal_qty');
	  $_SESSION['proposal_price'] = $input->get('proposal_price');
	  if(isset($_GET['proposal_extras'])){
	  $_SESSION['proposal_extras'] = unserialize(base64_decode($_GET['proposal_extras']));
	  }
	  }elseif($type == "cart"){
	  $_SESSION['cart_seller_id'] = $input->get('cart_seller_id');
	  }elseif($type == "featured_listing"){
	  $_SESSION['featured_listing'] = $input->get('featured_listing');
	  $_SESSION['proposal_id'] = $input->get('proposal_id');
	  }elseif($type == "view_offers"){
	  $offer_id = $_GET["offer_id"];
	  $_SESSION['offer_id'] = $input->get('offer_id');
	  $_SESSION['offer_buyer_id'] = $login_seller_id;
	  }elseif($type == "message_offer"){ 
	  $_SESSION['message_offer_id'] = $input->get('message_offer_id');
	  $_SESSION['message_offer_buyer_id'] = $login_seller_id;
	  }
      $_SESSION['method'] = "paystack";
      if($type == "featured_listing"){
	  	echo "<script>window.open('$site_url/proposals/featured_proposal','_self')</script>";
	  }else{
	  	echo "<script>window.open('$site_url/order','_self')</script>";
	  }
    }
}
/// Paystack Payment Code Ends ////

}