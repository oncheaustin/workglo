<?php

session_start();

require_once("db.php");

if(!isset($_SESSION['seller_user_name'])){
	
	echo "<script> window.open('../login.php','_self'); </script>";
	
}

$seller_user_name = $_SESSION['seller_user_name'];

$get_seller = $db->select("sellers",array("seller_user_name" => $seller_user_name));

$row_seller = $get_seller->fetch();

$seller_email = $row_seller->seller_email;

$seller_verification = $row_seller->seller_verification;



$get_general_settings = $db->select("general_settings");   

$row_general_settings = $get_general_settings->fetch();
	
$site_name = $row_general_settings->site_name;

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

$mail->addAddress($seller_email);

$mail->addReplyTo($site_email_address,$site_name);

$mail->isHTML(true);

$mail->Subject = "$site_name: Activate Your New Account!";

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

<img class='logo' src='$site_url/images/$site_logo' width='100' >

<h2> Hi $seller_user_name, Welcome To $site_name! </h2>

<p class='lead'> Are you ready to get started? </p>

<br>

<a href='$site_url/includes/verify_email.php?code=$seller_verification' class='btn'>
 Click Here To Activate Your Account 
</a>

<hr>

<p class='lead'>
If clicking the button above does not work, copy and paste the following url in a new browser window: $site_url/includes/verify_email.php?code=$seller_verification
</p>

</center>

</div>

</div>

</body>

</html>";

$mail->send();

?>