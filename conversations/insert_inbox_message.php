<?php
@session_start();
require_once("../includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('../login','_self')</script>";
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
function removeJava($html){
	$attrs = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
  $dom = new DOMDocument;
  // @$dom->loadHTML($html);
  @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
  $nodes = $dom->getElementsByTagName('*');//just get all nodes, 
  foreach($nodes as $node){
    foreach ($attrs as $attr) { 
    	if ($node->hasAttribute($attr)){  $node->removeAttribute($attr);  } 
    }
  }
return strip_tags($dom->saveHTML(),"<div><img>");
}

$message_group_id = $input->post('single_message_id');
$get_inbox_sellers = $db->select("inbox_sellers",array("message_group_id" => $message_group_id));
$row_inbox_sellers = $get_inbox_sellers->fetch();
$sender_id = $row_inbox_sellers->sender_id;
$receiver_id = $row_inbox_sellers->receiver_id;
if($login_seller_id == $sender_id){
$receiver_seller_id = $receiver_id;
}else{
$receiver_seller_id = $sender_id;
}

$message = removeJava($_POST['message']);
$file = $input->post('file');
$message_date = date("h:i: F d, Y");
$dateAgo = date("Y-m-d H:i:s");
$message_status = "unread";
$insert_message = $db->insert("inbox_messages",array("message_sender" => $login_seller_id,"message_receiver" => $receiver_seller_id,"message_group_id" => $message_group_id,"message_desc" => $message,"message_file" => $file,"message_date" => $message_date,"dateAgo" => $dateAgo,"bell" => 'active',"message_status" => $message_status));
$last_message_id = $db->lastInsertId();
$update_inbox_sellers = $db->update("inbox_sellers",array("sender_id" => $login_seller_id,"receiver_id" => $receiver_seller_id,"message_status" => $message_status,"message_id" => $last_message_id,'popup'=>'1'),array("message_group_id" => $message_group_id));
if($update_inbox_sellers){
	$words = "";
	$get_words = $db->select("spam_words");
	while($row_words = $get_words->fetch()){
		$words .= $row_words->word . "|";
	}
	if(preg_match("/\b($words)\b/i", $message)){
		$n_date = date("F d, Y");
		$insert_notification = $db->insert("admin_notifications",array("seller_id" => $login_seller_id,"content_id" => $message_group_id,"reason" => "message_spam","date" => $n_date,"status" => "unread"));
	}
	$select_hide_seller_messages = $db->query("select * from hide_seller_messages where hider_id='$login_seller_id' AND hide_seller_id='$receiver_seller_id' or hider_id='$receiver_seller_id' AND hide_seller_id='$login_seller_id'");
	$count_hide_seller_messages = $select_hide_seller_messages->rowCount();
	if($count_hide_seller_messages == 1){
		$delete_hide_seller_messages = $db->query("delete from hide_seller_messages where hider_id='$login_seller_id' and hide_seller_id='$receiver_seller_id' or hider_id='$receiver_seller_id' AND hide_seller_id='$login_seller_id'");
	}
	$site_logo = $row_general_settings->site_logo;
	$site_email_address = $row_general_settings->site_email_address;
	$get_seller = $db->select("sellers",array("seller_id" => $receiver_seller_id));
	$row_seller = $get_seller->fetch();
	$seller_user_name = $row_seller->seller_user_name;
	$seller_email = $row_seller->seller_email;
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
	$mail->Subject = "You've received a message from $login_seller_user_name";
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
	</style>
	</head>
	<body class='is-responsive'>
	<div class='container'>
	<div class='box'>
	<center>
	<img src='$site_url/images/$site_logo' width='100'>
	<h2> You've received a message from $login_seller_user_name </h2>
	</center>
	<hr>
	<p class='lead'> Dear $seller_user_name, </p>
	<p class='lead'> $login_seller_user_name left you a message in your inbox. </p>
	<p class='lead'> $message </p>
	<center>
	<a href='$site_url/conversations/inbox?single_message_id=$message_group_id' class='btn'>View & Reply</a>
	</center>
	</div>
	</div>
	</body>
	</html>";
	$mail->send();	
}