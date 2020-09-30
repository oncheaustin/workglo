<?php
require_once("../includes/db.php");
$seller_id = $input->post('seller_id');
$message_group_id = $input->post('message_group_id');
$select = $db->select("seller_type_status",array("seller_id"=>$seller_id,"message_group_id"=>$message_group_id));
$count = $select->rowCount();
if($count != 0){
	$row = $select->fetch();
	$status = $row->status;
	$select_seller = $db->select("sellers",array("seller_id"=>$seller_id));
	$row_seller = $select_seller->fetch();
	$seller_user_name = $row_seller->seller_user_name;
	if($status == "typing"){
		echo "<b class='text-success'>$seller_user_name</b> is $status ...";
	}else{
		echo ""; 
	}
}