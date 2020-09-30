<?php

session_start();

require_once("includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('login','_self');</script>";

}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

$status = (isset($_GET['status'])) ? $_GET['status'] : '';

if(isset($_GET['checkout_seller_id']) & $status == "COMPLETED"){
	
$seller_id = $input->get('checkout_seller_id');

$proposal_id = $input->get('proposal_id');

$proposal_qty = $input->get('proposal_qty');

$proposal_price = $input->get('proposal_price');

$_SESSION['checkout_seller_id'] = $seller_id;

$_SESSION['proposal_id'] = $proposal_id;

$_SESSION['proposal_qty'] = $proposal_qty;

$_SESSION['proposal_price'] = $proposal_price;

if(isset($_GET['proposal_extras'])){

$_SESSION['proposal_extras'] = unserialize(base64_decode($input->get('proposal_extras')));

}

$_SESSION['method'] = "mobile_money";

echo "<script>window.open('order','_self');</script>";
	
}


if(isset($_GET['cart_seller_id']) & $status == "COMPLETED"){
	
$seller_id = $input->get('cart_seller_id');
	
$_SESSION['cart_seller_id'] = $seller_id;

$_SESSION['method'] = "mobile_money";

echo "<script>window.open('order','_self');</script>";


}


if(isset($_GET['featured_listing']) & $status == "COMPLETED"){
	
$proposal_id = $input->get('proposal_id');
	
$_SESSION['proposal_id'] = $proposal_id;

echo "<script>window.open('order','_self');</script>";

	
}


if(isset($_GET["view_offers"]) & $status == "COMPLETED"){
	
$offer_id = $_GET["offer_id"];

$_SESSION['offer_id'] = $offer_id;

$_SESSION['offer_buyer_id'] = $login_seller_id;

$_SESSION['method'] = "mobile_money";
	
echo "<script>window.open('order','_self');</script>";

	
}


if(isset($_GET['message_offer_id']) & $status == "COMPLETED"){
	
$offer_id = $input->get('message_offer_id');
	
$_SESSION['message_offer_id'] = $offer_id;

$_SESSION['message_offer_buyer_id'] = $login_seller_id;

$_SESSION['method'] = "mobile_money";
	
echo "<script>window.open('order','_self');</script>";
	
}


if($status == "CANCELLED" or $status == "FAILED"){

echo "<script>window.open('index','_self');</script>";

}


?>