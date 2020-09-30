<?php

session_start();
include("includes/db.php");
include("functions/payment.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('login.php','_self');</script>";
}

$data = [];
$data['type'] = 'proposal';
$data['stripeToken'] = $input->post('stripeToken');
$data['proposal_id'] = $_SESSION['c_proposal_id'];
$data['proposal_qty'] = $_SESSION['c_proposal_qty'];
if(isset($_SESSION['c_proposal_extras'])){
	$data['proposal_extras'] = $_SESSION['c_proposal_extras'];
}

$data['amount'] = $_SESSION["c_sub_total"];
$data['desc'] = "Proposal Payment";
$payment = new Payment();
$payment->stripe($data);