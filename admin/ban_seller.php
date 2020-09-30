<?php 

@session_start();

if(!isset($_SESSION['admin_email'])){
	
echo "<script>window.open('login','_self');</script>";
	
}else{

?>

<?php

if(isset($_GET['ban_seller'])){

$seller_id = $input->get('ban_seller');


$update_seller = $db->update("sellers",array("seller_status" => 'block-ban'),array("seller_id" => $seller_id));

if($update_seller){

$update_proposals = $db->update("proposals",array("proposal_status" => 'pause'),array("proposal_seller_id" => $seller_id,"proposal_status"=>'active'));

$insert_log = $db->insert_log($admin_id,"seller",$seller_id,"block-ban");


$get_seller = $db->select("sellers",array("seller_id" => $seller_id));

$row_seller = $get_seller->fetch();

$seller_user_name = $row_seller->seller_user_name;

$seller_email = $row_seller->seller_email;



$site_logo = $row_general_settings->site_logo;

$site_email_address = $row_general_settings->site_email_address;


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
 
$mail->Subject = "$site_name: You Are Banned";

$mail->Body = "

<html>

<head>

<style>

.container {
	background: rgb(238, 238, 238);
	padding: 80px;
	
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

</style>

</head>

<body>

<div class='container'>

<div class='box'>

<center>

<img class='logo' src='$site_url/images/$site_logo' width='100' >

<h2> Dear $seller_user_name </h2>

<p class='lead'> You account on $site_name has been blocked. </p>

<hr>

<p class='lead'>
For Further Any Information, Please Contact Our <a href='$site_url/customer_support' class='link'>Customer Support.</a>
</p>

</center>

</div>

</div>

</body>

</html>";

$mail->send();

	
echo "<script>alert('Seller has been blocked/banned successfully.');</script>";
	
echo "<script>window.open('index?view_sellers','_self');</script>";

}

	
}

?>

<?php } ?>