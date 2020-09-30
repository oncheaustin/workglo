<?php 

session_start();
include("../includes/db.php");
include("../functions/payment.php");
include("../functions/processing_fee.php");

if(!isset($_SESSION['seller_user_name'])){
  
echo "<script>window.open('login.php','_self');</script>";
  
}

if(isset($_POST['paystack'])){
	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$featured_fee = $row_payment_settings->featured_fee;
	$processing_fee = processing_fee($featured_fee);

	$payment = new Payment();
	$data = [];
	$data['amount'] = $featured_fee + $processing_fee;
	$data['redirect_url'] = "$site_url/paystack_order?proposal_id={$_SESSION['f_proposal_id']}&featured_listing=1";
	$payment->paystack($data);
}else{
	echo "<script>window.open('../index','_self');</script>";
}