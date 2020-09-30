<?php

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_level = $row_login_seller->seller_level;

$get_payment_settings = $db->select("payment_settings");
$row_payment_settings = $get_payment_settings->fetch();
$days_before_withdraw = $row_payment_settings->days_before_withdraw;

$select = $db->select("seller_payment_settings",["level_id"=>$login_seller_level]);;
$row = $select->fetch();
$comission_percentage = $row->commission_percentage;

function getPercentOfNumber($amount, $percentage){
	$calculate_percentage = ($percentage / 100 ) * $amount ;
	return $amount-$calculate_percentage;
}

$seller_price = getPercentOfNumber($order_price, $comission_percentage);

$revenue_date = date("F d, Y", strtotime(" + $days_before_withdraw days"));
$end_date = date("F d, Y h:i:s", strtotime(" + $days_before_withdraw days"));
$recent_delivery_date = date("F d, Y");
	

$update_seller = $db->update("sellers",array("seller_recent_delivery" => $recent_delivery_date),array("seller_id" => $seller_id));

$update_order = $db->update("orders",array("order_status" => "completed","order_active" => "no"),array("order_id" => $order_id));


$update_messages = $db->update("order_conversations",array("status" => "message"),array("order_id" => $order_id,"status" => "delivered"));


$last_update_date = date("F d, Y");


$insert_notification = $db->insert("notifications",array("receiver_id" => $seller_id,"sender_id" => $buyer_id,"order_id" => $order_id,"reason" => "order_completed","date" => $last_update_date,"status" => "unread"));


//// $update_seller_account = $db->update("seller_accounts",array("pending_clearance" => "pending_clearance+$seller_price","month_earnings" => "month_earnings+$seller_price"),array("seller_id" => $seller_id));

$update_seller_account = $db->query("update seller_accounts set pending_clearance=pending_clearance+:p_plus,month_earnings=month_earnings+:m_plus where seller_id='$seller_id'",array("p_plus"=>$seller_price,"m_plus"=>$seller_price));


$insert_revenue = $db->insert("revenues",array("seller_id" => $seller_id,"order_id" => $order_id,"amount" => $seller_price,"date" => $revenue_date,"end_date" => $end_date,"status" => "pending"));

$adminProfit = getAdminCommission($order_price);
$select = $db->select("purchases",array("order_id" => $order_id));
$row = $select->fetch();
$payment_method = $row->method;

$sale = array("buyer_id" => $buyer_id,"work_id" => $order_id,"payment_method" => $payment_method,"amount" => $order_price,"profit"=> $adminProfit,"processing_fee"=>"0.0","action"=>"order_completed","date"=>date("Y-m-d"));
insertSale($sale);


echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";