<?php 

session_start();

include("../includes/db.php");
include("../functions/payment.php");
include("../functions/processing_fee.php");

if(!isset($_SESSION['seller_user_name'])){
  
echo "<script>window.open('login.php','_self');</script>";
  
}

if(isset($_POST['paystack'])){

$select_offers = $db->select("messages_offers",array("offer_id" => $_SESSION['c_message_offer_id']));

$row_offers = $select_offers->fetch();

$proposal_id = $row_offers->proposal_id;

$amount = $row_offers->amount;
$processing_fee = processing_fee($amount);


$payment = new Payment();

$data = [];

$data['amount'] = $amount + $processing_fee;

$data['redirect_url'] = "$site_url/paystack_order?message_offer_id={$_SESSION['c_message_offer_id']}";

$payment->paystack($data);

}else{

echo "<script>window.open('../index','_self');</script>";

}