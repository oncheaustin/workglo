<?php
@session_start();
require_once("db.php");
$seller_id = $input->post('seller_id');
$enable_sound = $input->post('enable_sound');
$data = array();
$i = 0;
$select_notofications = $db->query("select * from notifications where receiver_id=:r_id AND bell='active' AND status='unread'",array("r_id"=>$seller_id));
while($row_notifications = $select_notofications->fetch()){
	$i++;
	$notification_id = $row_notifications->notification_id;
	$data[$i]['notification_id'] = $row_notifications->notification_id;
	$data[$i]['sender_id'] = $row_notifications->sender_id;
	$data[$i]['order_id'] = $row_notifications->order_id;
	$reason = $row_notifications->reason;
	$data[$i]['reason'] = $row_notifications->reason;
	$data[$i]['date'] = $row_notifications->date;
	$data[$i]['status'] = $row_notifications->status;
	// Select Sender Details
	$select_sender = $db->select("sellers",array("seller_id" => $data[$i]['sender_id']));
	$row_sender = $select_sender->fetch();
	$sender_user_name = @$row_sender->seller_user_name;
	$sender_image = "user_images/" . @$row_sender->seller_image;
	if(empty($row_sender->seller_image)){ $sender_image = "user_images/empty-image.png"; }
	if(strpos($data[$i]['sender_id'],'admin') !== false){
	$admin_id = trim($data[$i]['sender_id'], "admin_");
	$get_admin = $db->select("admins",array("admin_id" => $admin_id));
	$sender_user_name = "Admin";
	@$sender_image = "admin/admin_images/" . $get_admin->fetch()->admin_image;
	}
	$data[$i]['sender_user_name'] = $sender_user_name;
	$data[$i]['sender_image'] = $sender_image;
	$data[$i]['message'] = include("comp/notification_reasons.php");
	$update = $db->update("notifications",array("bell" => 'over'),array("receiver_id" => $seller_id,"status" => 'unread',"notification_id" => $data[$i]['notification_id']));
}
echo json_encode($data); 
