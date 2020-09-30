<?php 
session_start();
include("../includes/db.php");
include("../functions/payment.php");
require_once("../functions/functions.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('login.php','_self');</script>";
}
if(isset($_POST['dusupay'])){

	$featured_fee = $row_payment_settings->featured_fee;
	$processing_fee = processing_fee($featured_fee);

	$payment = new Payment();
	$data = [];
	$data['name'] = "Payment For Proposal Featured Listing";
	$data['amount'] = $featured_fee+$processing_fee;
	$data['redirect_url'] = "$site_url/dusupay_order?proposal_id={$_SESSION['f_proposal_id']}&featured_listing=1&";
	$payment->dusupay($data);
}else{
echo "<script>window.open('../index','_self');</script>";
}