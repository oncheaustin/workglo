<?php

session_start();

require_once("includes/db.php");

require_once("functions/payment.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('login','_self');</script>";
	
}


if(isset($_GET['checkout_seller_id'])){
	
$payment = new Payment();

$payment->paypal_execute("proposal");

}


if(isset($_GET['cart_seller_id'])){
	
$payment = new Payment();

$payment->paypal_execute("cart");
	
}


if(isset($_GET['featured_listing'])){
	
$payment = new Payment();

$payment->paypal_execute("featured_listing");
	
}


if(isset($_GET["view_offers"])){

$payment = new Payment();

$payment->paypal_execute("view_offers");
	
}


if(isset($_GET['message_offer_id'])){
	
$payment = new Payment();

$payment->paypal_execute("message_offer");

}