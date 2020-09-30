<?php

session_start();

require_once("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
	echo "<script>window.open('../login','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));

$row_login_seller = $select_login_seller->fetch();

$login_seller_id = $row_login_seller->seller_id;


$proposal_id = $input->post('proposal_id');

$request_id = $input->post('request_id');

$description = $input->post('description');

$delivery_time = $input->post('delivery_time');

$amount = $input->post('amount');


$get_requests = $db->select("buyer_requests",array("request_id" => $request_id));

$row_requests = $get_requests->fetch();

$seller_id = $row_requests->seller_id;



$select_buyer = $db->select("sellers",array("seller_id" => $seller_id));

$row_buyer = $select_buyer->fetch();

$buyer_user_name = $row_buyer->seller_user_name;

$buyer_email = $row_buyer->seller_email;


$insert_offer = $db->insert("send_offers",array("request_id"=>$request_id,"sender_id"=>$login_seller_id,"proposal_id"=>$proposal_id,"description"=>$description,"delivery_time"=>$delivery_time,"amount"=>$amount,"status"=>'active'));

$update_seller = $db->query("update sellers set seller_offers=seller_offers-1 where seller_id='$login_seller_id'");


$site_email_address = $row_general_settings->site_email_address;

$site_logo = $row_general_settings->site_logo;


require '../mailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

if($enable_smtp == "yes"){
$mail->isSMTP();
$mail->Host = $s_host;
$mail->Port = $s_port;
$mail->SMTPAuth = true;
$mail->SMTPSecure = $s_secure;
$mail->Username = $s_username;
$mail->Password = $s_password;
}

$mail->setFrom($site_email_address,$site_name);

$mail->addAddress($buyer_email);

$mail->addReplyTo($site_email_address,$site_name);

$mail->isHTML(true);

$mail->Subject = "$site_name: Offer received for your request";

$mail->Body = "

<html>

<head>

<style>

.container {
	background: rgb(238, 238, 238);
	padding: 80px;
	
}

@media only screen and (max-device-width: 690px) {

.container {
	background: rgb(238, 238, 238);
width:100%;
padding:1px;
	
}

}

.box {
	background: #fff;
	margin: 0px 0px 30px;
	padding: 8px 20px 20px 20px;
	border:1px solid #e6e6e6;
	box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);			
	
}

.lead {
	font-size:16px;
	
}

.btn{
	background:green;
	margin-top:20px;
	color:white !important;
	text-decoration:none;
	padding:10px 16px;
	font-size:18px;
	border-radius:3px;
	
}

hr{
	margin-top:20px;
	margin-bottom:20px;
	border:1px solid #eee;
	
}


@media only screen and (max-device-width: 690px) {

.container {
background: rgb(238, 238, 238);
width:100%;
padding:1px;

}

.btn{
background:green;
margin-top:15px;
color:white !important;
text-decoration:none;
padding:10px;
font-size:14px;
border-radius:3px;

}

.lead {

font-size:14px;

}

}

</style>

</head>

<body class='is-responsive'>

<div class='container'>

<div class='box'>

<center>

<img class='logo' src='$site_url/images/$site_logo' width='100' >

<h2> Offer received for your request. </h2>

</center>

<hr>

<p class='lead'> Dear $buyer_user_name </p>

<p class='lead'> You just received an offer from $login_seller_user_name for your request. </p>
<br>
<center>

<a href='$site_url/requests/view_offers?request_id=$request_id' class='btn'>

Click to view offer

</a>

</center>

</div>

</div>

</body>

</html>";
	
$mail->send();

if($update_seller){

echo "<script>alert('Your offer has been submitted successfully.')</script>";

echo "<script>window.open('$site_url/requests/buyer_requests','_self')</script>";

}

?>