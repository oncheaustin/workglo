<?php
session_start();
include("../includes/db.php");
include("../functions/payment.php");
include("../functions/processing_fee.php");
include("../stripe_config.php");

if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('login.php','_self');</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_email = $row_login_seller->seller_email;

$get_payment_settings = $db->select("payment_settings");
$row_payment_settings = $get_payment_settings->fetch();
$featured_fee = $row_payment_settings->featured_fee;
$processing_fee = processing_fee($featured_fee);
  
$data = [];
$data['type'] = "featured_listing";
$data['proposal_id'] = $_SESSION['f_proposal_id'];
$data['amount'] = $featured_fee + $processing_fee;
$data['desc'] = 'Featured Listing Payment';
$data['stripeToken'] = $input->post('stripeToken');
$payment = new Payment();
$payment->stripe($data);