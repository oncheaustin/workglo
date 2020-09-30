<?php
session_start();
include("../includes/db.php");
include("../functions/payment.php");
include("../functions/processing_fee.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('login.php','_self');</script>";
}
include("../stripe_config.php");

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_email = $row_login_seller->seller_email;

$select_offers = $db->select("send_offers",array("offer_id" => $_SESSION['c_offer_id']));
$row_offers = $select_offers->fetch();
$amount = $row_offers->amount;
$processing_fee = processing_fee($amount);

$data = [];
$data['type'] = "request_offer";
$data['offer_id'] = $_SESSION['c_offer_id'];
$data['offer_buyer_id'] = $login_seller_id;
$data['amount'] = $amount + $processing_fee;
$data['desc'] = 'Request Offer Payment';
$data['stripeToken'] = $input->post('stripeToken');
$payment = new Payment();
$payment->stripe($data);