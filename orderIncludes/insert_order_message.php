<?php

@session_start();

require_once("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('login','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$order_id = $input->post('order_id');


$get_orders = $db->select("orders",array("order_id" => $order_id));
$row_orders = $get_orders->fetch();
$seller_id = $row_orders->seller_id;
$buyer_id = $row_orders->buyer_id;
$order_status = $row_orders->order_status;
$order_duration = substr($row_orders->order_duration,0,1);


date_default_timezone_set("UTC");
$date_time = date("M d, Y H:i:s");
$order_time = date("M d, Y H:i:s", strtotime($date_time . " + $order_duration days"));
$message = $input->post('message');
@$file = $_FILES["file"]["name"];
@$file_tmp = $_FILES["file"]["tmp_name"];
date_default_timezone_set($site_timezone);
$last_update_date = date("h:i: M d, Y");


$count_order_conversations = $db->count("order_conversations",array("order_id" => $order_id,"sender_id" => $buyer_id));

if($buyer_id == $login_seller_id AND $order_status == "pending"){
	
if($count_order_conversations == 0){
    
$update_order = $db->update("orders",array("order_status" => "progress","order_time" => $order_time),array("order_id" => $order_id));

echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
	
}

}


$allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav');
	
$file_extension = pathinfo($file, PATHINFO_EXTENSION);

if(!in_array($file_extension,$allowed) & !empty($file)){
	
	echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
	
}else{

if(!empty($file)){

	$file = pathinfo($file, PATHINFO_FILENAME);
	$file = $file."_".time().".$file_extension";
	move_uploaded_file($file_tmp, "../order_files/$file");

}else{ $file = ""; }

if($seller_id == $login_seller_id){ $receiver_id = $buyer_id; }else{ $receiver_id = $seller_id; }

$insert_order_conversation = $db->insert("order_conversations",array("order_id" => $order_id,"sender_id" => $login_seller_id,"message" => $message,"file" => $file,"date" => $last_update_date,"status" => "message"));

if($insert_order_conversation){

	$insert_notification = $db->insert("notifications",array("receiver_id" => $receiver_id,"sender_id" => $login_seller_id,"order_id" => $order_id,"reason" => "order_message","date" => $last_update_date,"status" => "unread"));

	$words = "";
	$get_words = $db->select("spam_words");
	while($row_words = $get_words->fetch()){
	$words .= $row_words->word . "|";
	}

	if(preg_match("/\b($words)\b/i", $message)){
	$n_date = date("F d, Y");
	$insert_notification = $db->insert("admin_notifications",array("seller_id" => $login_seller_id,"content_id" => $order_id,"reason" => "order_spam","date" => $n_date,"status" => "unread"));
	}
	
}


}