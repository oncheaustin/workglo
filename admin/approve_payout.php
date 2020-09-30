<?php

@session_start();

if(!isset($_SESSION['admin_email'])){
  
echo "<script>window.open('login.php','_self');</script>";
 
exit();

}

if(isset($_GET['approve_payout'])){

$id = $input->get('approve_payout');

$update = $db->update("payouts",["status"=>'completed'],["id"=>$id]);

if($update){

	$get = $db->select("payouts",array('id'=>$id));
	$row = $get->fetch();
	$seller_id = $row->seller_id;
	$method = $row->method;
	$amount = $row->amount;
	
	$date = date("F d, Y");

	$update_seller_account = $db->query("update seller_accounts set current_balance=current_balance-:minus,withdrawn=withdrawn+:plus where seller_id='$seller_id'",array("minus"=>$amount,"plus"=>$amount));

	$insert_notification = $db->insert("notifications",array("receiver_id" => $seller_id,"sender_id" => "admin_$admin_id","order_id" => $id,"reason" => "withdrawal_approved","date" => $date,"status" => "unread"));

	echo "
	<script>alert('One Payout Request Has Been Approved.');
	window.open('index?payouts&status=completed','_self');</script>";

}

?>

<?php } ?>