<?php

$order_id = $input->get('order_id');


$get_orders = $db->query("select * from orders where (seller_id=$login_seller_id or buyer_id=$login_seller_id) AND order_id=:o_id",array("o_id"=>$order_id));

$row_orders = $get_orders->fetch();

$order_id = $row_orders->order_id;

$order_number = $row_orders->order_number;

$proposal_id = $row_orders->proposal_id;

$seller_id = $row_orders->seller_id;

$buyer_id = $row_orders->buyer_id;

$order_price = $row_orders->order_price;

$order_qty = $row_orders->order_qty;

$order_date = $row_orders->order_date;

$order_duration = $row_orders->order_duration;

$order_time = $row_orders->order_time;

$order_fee = $row_orders->order_fee;

$order_desc = $row_orders->order_description;

$order_status = $row_orders->order_status;

$total = $order_price+$order_fee;


//// Select Order Proposal Details ///

$select_proposal = $db->select("proposals",array("proposal_id" => $proposal_id));

$row_proposal = $select_proposal->fetch();

$proposal_title = $row_proposal->proposal_title;

$proposal_img1 = $row_proposal->proposal_img1;

$proposal_url = $row_proposal->proposal_url;

$buyer_instruction = $row_proposal->buyer_instruction;



$get_buyer_instructions = $db->query("select buyer_instruction from proposals where proposal_id='$proposal_id'");

$count_buyer_instruction = $get_buyer_instructions->rowCount();


if($count_buyer_instruction == 0){

$update_order = $db->update("orders",array("order_status"=>"progress"),array("order_id"=>$order_id));

}


$get_payment_settings = $db->select("payment_settings");

$row_payment_settings = $get_payment_settings->fetch();

$comission_percentage = $row_payment_settings->comission_percentage;


function getPercentOfValue($amount, $percentage){

$calculate_percentage = ($percentage / 100 ) * $amount ;

return $amount-$calculate_percentage;

}


$seller_price = getPercentOfValue($order_price, $comission_percentage);


/// Select Order Seller Details ///

$select_seller = $db->select("sellers",array("seller_id" => $seller_id));

$row_seller = $select_seller->fetch();

$seller_user_name = $row_seller->seller_user_name;

$seller_email = $row_seller->seller_email;

$order_seller_rating = $row_seller->seller_rating;

if($order_seller_rating > "100"){

$update_seller_rating = $db->update("sellers",array("seller_rating" => 100),array("seller_id" => $seller_id));

}

//// Select Order Buyer Details ///

$select_buyer = $db->select("sellers",array("seller_id" => $buyer_id));

$row_buyer = $select_buyer->fetch();

$buyer_user_name = $row_buyer->seller_user_name;

$buyer_email = $row_buyer->seller_email;

$n_date = date("F d, Y");