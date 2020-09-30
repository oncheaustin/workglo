<?php

session_start();

include("includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('login','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_email = $row_login_seller->seller_email;

$site_email_address = $row_general_settings->site_email_address;
$site_logo = $row_general_settings->site_logo;

$get_payment_settings = $db->select("payment_settings");
$row_payment_settings = $get_payment_settings->fetch();
$withdrawal_limit = $row_payment_settings->withdrawal_limit;

$select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $login_seller_id));
$row_seller_accounts = $select_seller_accounts->fetch();
$current_balance = $row_seller_accounts->current_balance;

if(isset($_POST['withdraw'])){

	$amount = $input->post('amount');

	if($amount > $withdrawal_limit or $amount == $withdrawal_limit){

	if($amount < $current_balance or $amount == $current_balance){

	$date = date("F d, Y");

	$method = $input->post('method');

	$fee = "0";

	if($method == "western_union"){

		$calculate_percentage = ($percentage / 100 ) * $amount;
		$amount = $amount-$calculate_percentage;
		$amount = round($amount-5,2);
		$fee = $calculate_percentage+5;

	}

	$range = range('A', 'Z');
	$index = array_rand($range);
	$index2 = array_rand($range);
	$ref = "P-" . mt_rand(100000,999999) . $range[$index] . $range[$index2];

	$insert_withdrawal = $db->insert("payouts",array("seller_id"=>$login_seller_id,"ref"=>$ref,"method"=>$method,"amount"=>$amount,"date"=>$date,"status"=>'pending'));

	if($insert_withdrawal){

		$update_seller = $db->query("update sellers set seller_payouts=seller_payouts+1 where seller_id='$login_seller_id'");

		require 'mailer/PHPMailerAutoload.php';

		$get_admins = $db->select("admins");
		while($row_admins = $get_admins->fetch()){
		$admin_id = $row_admins->admin_id;
		$admin_name = $row_admins->admin_name;
		$admin_email = $row_admins->admin_email;

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

		$mail->addAddress($admin_email);

		$mail->addReplyTo($site_email_address,$site_name);

		$mail->isHTML(true);

		$mail->Subject = "$site_name - You just received a new seller payout request.";
			
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

		.logo {

		margin-top:20px; 
		margin-bottom:5px;

		}

		h2{
		    margin-top: 0px;
		    margin-bottom: 0px;
		}

		.lead {
			margin-top: 10px;
		    margin-bottom: 0px;
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

		<img class='logo' src='$site_url/images/$site_logo' width='200' >

		<h2> Dear Admin $admin_name </h2>

		<p class='lead'> You Just Received A Payout Request From <b>$login_seller_user_name</b> </p>

		<br>

		<a href='$site_url/admin/index?pending_payouts' class='btn'>
		 Click Here To View All Payout Requests
		</a>

		<hr>

		<p class='lead'>
		If clicking the button above does not work, copy and paste the following url in a new browser window: $site_url/admin/index?view_payouts&status=pending
		</p>

		</center>

		</div>

		</div>

		</body>

		</html>";

		$mail->send();

		}
		
			echo "<script>window.open('withdrawal_requests','_self')</script>";
	
		}

		}else{
		
			echo "<script>alert('Opps! the amount you entered is higher than your current balance.');</script>";
			
			echo "<script>window.open('revenue','_self')</script>";
			
		}
	
	}else{
	
		echo "<script>alert('Minimum withdrawal amount is $$withdrawal_limit Dollars.');</script>";
			
		echo "<script>window.open('revenue','_self')</script>";
		
	}

	}else{

		echo "<script>window.open('revenue','_self')</script>";

	}