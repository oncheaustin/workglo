<?php

session_start();
include("includes/db.php");
include("functions/payment.php");
require_once("functions/functions.php");
if(!isset($_SESSION['seller_user_name'])){
	echo"<script>window.open('login.php','_self');</script>";
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

$processing_fee = processing_fee($_SESSION['c_sub_total']);

if(isset($_POST['paypal'])){
	$payment = new Payment();
	$data = [];
	$data['type'] = "proposal";
	$select_proposals = $db->select("proposals",array("proposal_id" => $_SESSION['c_proposal_id']));
	$row_proposals = $select_proposals->fetch();
	$proposal_url = $row_proposals->proposal_url;
	$data['name'] = $row_proposals->proposal_title;
	$data['qty'] = $_SESSION['c_proposal_qty'];
	$data['price'] = $_SESSION['c_proposal_price'];
	$data['sub_total'] = $_SESSION['c_sub_total'];
	$data['total'] = $_SESSION['c_sub_total'] + $processing_fee;
	if(isset($_SESSION['c_proposal_extras'])){
		$extras = "&proposal_extras=" . base64_encode(serialize($_SESSION['c_proposal_extras']));
	}else{
		$extras = "";
	}
	$data['cancel_url'] = "$site_url/proposals/$proposal_url";
	$data['redirect_url'] = "$site_url/paypal_order?checkout_seller_id=$login_seller_id&proposal_id={$_SESSION['c_proposal_id']}&proposal_qty={$_SESSION['c_proposal_qty']}&proposal_price={$_SESSION['c_sub_total']}$extras";
	$payment->paypal($data,$processing_fee);
}else{
	echo "<script>window.open('index','_self')</script>";
}