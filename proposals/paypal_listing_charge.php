<?php 
session_start();
include("../includes/db.php");
include("../functions/payment.php");
include("../functions/processing_fee.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('login.php','_self');</script>";
}

if(isset($_POST['paypal'])){
	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$featured_fee = $row_payment_settings->featured_fee;
	$processing_fee = processing_fee($featured_fee);

	$select_proposals = $db->select("proposals",array("proposal_id" => $_SESSION['f_proposal_id']));
	$row_proposals = $select_proposals->fetch();
	$proposal_title = $row_proposals->proposal_title;
	
	$payment = new Payment();
	$data = [];
	$data['name'] = $proposal_title;
	$data['qty'] = 1;
	$data['price'] = $featured_fee;
	$data['sub_total'] = $featured_fee;
	$data['total'] = $featured_fee + $processing_fee;
	$data['cancel_url'] = "$site_url/proposals/view_proposals";
	$data['redirect_url'] = "$site_url/paypal_order?proposal_id={$_SESSION['f_proposal_id']}&featured_listing=1";
	$payment->paypal($data,$processing_fee);
}else{
	echo "<script>window.open('../ndex','_self');</script>";
}