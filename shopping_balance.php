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


if(isset($_POST['checkout_submit_order'])){
	
$proposal_id = $_SESSION['c_proposal_id'];

$proposal_qty = $_SESSION['c_proposal_qty'];

$amount = $_SESSION["c_sub_total"];

$update_buyer_balance = $db->query("update seller_accounts set used_purchases=used_purchases+:plus,current_balance=current_balance-:minus where seller_id='$login_seller_id'",array("plus"=>$amount,"minus"=>$amount));

if($update_buyer_balance){

$_SESSION['checkout_seller_id'] = $login_seller_id;

$_SESSION['proposal_id'] = $proposal_id;

$_SESSION['proposal_qty'] = $proposal_qty;

$_SESSION['proposal_price'] = $amount;

if(isset($_SESSION['c_proposal_extras'])){

$_SESSION['proposal_extras'] = $_SESSION['c_proposal_extras'];

}

$_SESSION['method'] = "shopping_balance";

echo "<script>window.open('order','_self');</script>";
	
}

		
}


if(isset($_POST['cart_submit_order'])){
	
$select_cart =  $db->select("cart",array("seller_id" => $login_seller_id));

$count_cart = $select_cart->rowCount();

$sub_total = 0;

while($row_cart = $select_cart->fetch()){

$proposal_price = $row_cart->proposal_price;

$proposal_qty = $row_cart->proposal_qty;

$cart_total = $proposal_price * $proposal_qty;
	
$sub_total += $cart_total;
	
}

$amount = $sub_total;
	
$update_balance = $db->query("update seller_accounts set used_purchases=used_purchases+:plus,current_balance=current_balance-:minus where seller_id='$login_seller_id'",array("plus"=>$amount,"minus"=>$amount));

if($update_balance){
	
$_SESSION['cart_seller_id'] = $login_seller_id;
	
$_SESSION['method'] = "shopping_balance";
	
echo "<script>window.open('order','_self');</script>";
	
}


}



if(isset($_POST['pay_featured_proposal_listing'])){
	
$proposal_id = $_SESSION['f_proposal_id'];


$get_payment_settings = $db->select("payment_settings");

$row_payment_settings = $get_payment_settings->fetch();

$amount = $row_payment_settings->featured_fee;

		
$update_balance = $db->query("update seller_accounts set used_purchases=used_purchases+:plus,current_balance=current_balance-:minus where seller_id='$login_seller_id'",array("plus"=>$amount,"minus"=>$amount));

if($update_balance){
	
$_SESSION['proposal_id'] = $proposal_id;
	
echo "<script>window.open('proposals/featured_proposal.php','_self');</script>";
	
}
	
	
}

if(isset($_POST['view_offers_submit_order'])){
	
$offer_id = $_SESSION['c_offer_id'];


$select_offers = $db->select("send_offers",array("offer_id"=>$offer_id));

$row_offers = $select_offers->fetch();

$amount = $row_offers->amount;

	
$update_balance = $db->query("update seller_accounts set used_purchases=used_purchases+:plus,current_balance=current_balance-:minus where seller_id='$login_seller_id'",array("plus"=>$amount,"minus"=>$amount));

if($update_balance){
	
$_SESSION['offer_id'] = $offer_id;

$_SESSION['offer_buyer_id'] = $login_seller_id;

$_SESSION['method'] = "shopping_balance";
	
echo "<script>window.open('order','_self');</script>";
	
}
	
	
}


if(isset($_POST['message_offer_submit_order'])){
	
$offer_id = $_SESSION['c_message_offer_id'];


$select_offers = $db->select("messages_offers",array("offer_id"=>$offer_id));

$row_offers = $select_offers->fetch();

$amount = $row_offers->amount;


$update_balance = $db->query("update seller_accounts set used_purchases=used_purchases+:plus,current_balance=current_balance-:minus where seller_id='$login_seller_id'",array("plus"=>$amount,"minus"=>$amount));
		
if($update_balance){
	
$_SESSION['message_offer_id'] = $offer_id;

$_SESSION['message_offer_buyer_id'] = $login_seller_id;

$_SESSION['method'] = "shopping_balance";
	
echo "<script>window.open('order','_self');</script>";

}

	
	
}

?>