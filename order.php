<?php

session_start();
require_once("includes/db.php");
require_once("functions/functions.php");

?>

<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
	<title> <?php echo $site_name; ?> - Order </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="<?php echo $site_author; ?>">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
	<link href="styles/bootstrap.css" rel="stylesheet">
	<link href="styles/styles.css" rel="stylesheet">
	<link href="styles/categories_nav_styles.css" rel="stylesheet">
	<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
	<link href="styles/owl.carousel.css" rel="stylesheet">
	<link href="styles/owl.theme.default.css" rel="stylesheet">
  <link href="styles/sweat_alert.css" rel="stylesheet">
	<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
	<script src="js/ie.js"></script>
  <script type="text/javascript" src="js/sweat_alert.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body class="is-responsive">
<img src="images/bg4.jpeg" alt="logout-pic">
</body>
</html>

<?php

require_once("includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('login','_self');</script>";
	
}

if(isset($_SESSION['seller_user_name'])){

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));

$row_login_seller = $select_login_seller->fetch();

$login_seller_id = $row_login_seller->seller_id;

/// Single Proposal Checkout Order Code Starts ///

if(isset($_SESSION['checkout_seller_id'])){

$buyer_id = $_SESSION['checkout_seller_id'];

$proposal_id = $_SESSION['proposal_id'];

$order_price = $_SESSION['proposal_price'];

$processing_fee = processing_fee($order_price);

$proposal_qty = $_SESSION['proposal_qty'];

$payment_method = $_SESSION['method'];


$select_proposal = $db->select("proposals",array("proposal_id" => $proposal_id));

$row_proposal = $select_proposal->fetch();

$proposal_title = $row_proposal->proposal_title;

$proposal_enable_referrals = $row_proposal->proposal_enable_referrals;

$proposal_referral_money = $row_proposal->proposal_referral_money;

$proposal_referral_code = $row_proposal->proposal_referral_code;

$buyer_instruction = $row_proposal->buyer_instruction;

$proposal_seller_id = $row_proposal->proposal_seller_id;

$delivery_id = $row_proposal->delivery_id;


$select_delivery_time = $db->select("delivery_times",array('delivery_id' => $delivery_id));

$row_delivery_time = $select_delivery_time->fetch();

$delivery_proposal_title = $row_delivery_time->delivery_proposal_title;


$add_days = intval($delivery_proposal_title);

date_default_timezone_set("UTC");

$order_date = date("F d, Y");

$date_time = date("M d, Y H:i:s");

$order_time = date("M d, Y H:i:s", strtotime($date_time . " + $add_days days"));

$order_number = mt_rand();

if(!empty($buyer_instruction)){

$order_status = "pending";

}else{
	
$order_status = "progress";

}

if($payment_method == "shopping_balance"){

$saleProcessingFee = 0;
		
$insert_order = $db->insert("orders",array("order_number" => $order_number,"order_duration" => $delivery_proposal_title,"order_time" => $order_time,"order_date" => $order_date,"seller_id" => $proposal_seller_id,"buyer_id" => $buyer_id,"proposal_id" => $proposal_id,"order_price" => $order_price,"order_qty" => $proposal_qty,"order_fee" => 0,"order_active" => 'yes',"order_status" => $order_status));


}else{

$saleProcessingFee = $processing_fee;
	
$insert_order = $db->insert("orders",array("order_number" => $order_number,"order_duration" => $delivery_proposal_title,"order_time" => $order_time,"order_date" => $order_date,"seller_id" => $proposal_seller_id,"buyer_id" => $buyer_id,"proposal_id" => $proposal_id,"order_price" => $order_price,"order_qty" => $proposal_qty,"order_fee" => $processing_fee,"order_active" => 'yes',"order_status" => $order_status));
}

$insert_order_id = $db->lastInsertId();

if(isset($_SESSION['proposal_extras'])){

foreach($_SESSION['proposal_extras'] as $value){

$get_extras = $db->select("proposals_extras",array("id" => $value));

$row_extras = $get_extras->fetch();

$name = $row_extras->name;

$price = $row_extras->price;

$insert_extra = $db->insert("order_extras",array("order_id" => $insert_order_id,"name" => $name,"price"=>$price));

}

}


if($insert_order){

// Insert Sale Here
// $adminProfit = "0.0";
// $sale = array("buyer_id" => $buyer_id,"work_id" => $insert_order_id,"payment_method" => $payment_method,"amount" => $order_price,"profit"=> $adminProfit,"processing_fee"=>$saleProcessingFee,"action"=>"checkout","date"=>date("Y-m-d"));
// insertSale($sale);

if($proposal_enable_referrals == "yes"){
	
if(isset($_SESSION['r_proposal_id'])){
	
if($_SESSION['r_referrer_id'] == $login_seller_id){
	
}else{
	
if($proposal_id == $_SESSION['r_proposal_id'] & $proposal_referral_code == $_SESSION['r_referral_code']){
	
$ip = $_SERVER['REMOTE_ADDR'];

$r_proposal_id = $_SESSION['r_proposal_id'];

$r_seller_id = $proposal_seller_id;

$r_referrer_id = $_SESSION['r_referrer_id'];

$r_comission = $proposal_referral_money;

$r_o_comission = ($order_price*$r_comission)/100;

$comission = round($r_o_comission,1);

$r_date = date("F d, Y");

$insert_referral = $db->insert("proposal_referrals",array("proposal_id"=>$r_proposal_id,"order_id"=>$insert_order_id,"seller_id"=>$r_seller_id,"referrer_id"=>$r_referrer_id,"buyer_id"=>$login_seller_id,"comission"=>$comission,"date"=>$r_date,"ip"=>$ip,"status"=>'pending'));

unset($_SESSION['r_proposal_id']);

unset($_SESSION['r_referral_code']);

unset($_SESSION['r_referrer_id']);

}
	
}

}

}


$select_proposal_seller = $db->select("sellers",array("seller_id"=>$proposal_seller_id));

$row_proposal_seller = $select_proposal_seller->fetch();

$proposal_seller_user_name = $row_proposal_seller->seller_user_name;

$proposal_seller_email = $row_proposal_seller->seller_email;


	
$site_email_address = $row_general_settings->site_email_address;

$site_logo = $row_general_settings->site_logo;

require 'mailer/PHPMailerAutoload.php';

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

$mail->addAddress($proposal_seller_email);

$mail->addReplyTo($site_email_address,$site_name);

$mail->isHTML(true);
	

$mail->Subject = "Congrats! You just received an order from $login_seller_user_name";
	
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

.table {
	
width:100%;	
	
background-color:#fff;

margin-bottom:20px;
	
}

.table thead tr th {
	
	border:1px solid #ddd;
	
	font-weight:bolder;
	
	padding:10px;
	
}

.table tbody tr td {
	
	border:1px solid #ddd;

	padding:10px;
	
}


</style>

</head>

<body class='is-responsive'>

<div class='container'>

<div class='box'>

<center>

<img src='$site_url/images/$site_logo' width='100' >

<h2> You just received an order from $login_seller_user_name </h2>

</center>

<hr>

<p class='lead'> Dear $proposal_seller_user_name, <br> these are the order details: </p>

<table class='table'>

<thead>

<tr>

<th> Proposal </th>

<th> Quantity </th>

<th> Duration </th>

<th> Amount </th>

<th> Buyer </th>

</tr>

</thead>

<tbody>

<tr>

<td>$proposal_title</td>

<td>$proposal_qty</td>

<td>$delivery_proposal_title</td>

<td>$$order_price</td>

<td>$login_seller_user_name</td>

</tr>

</tbody>

</table>
<br>
<center>

<a href='$site_url/order_details?order_id=$insert_order_id' class='btn'>

View Your Order

</a>

</center>

</div>

</div>

</body>

</html>";

$mail->send();


$select_my_buyer = $db->select("my_buyers",array("seller_id"=>$proposal_seller_id,"buyer_id"=>$login_seller_id));

$count_my_buyer = $select_my_buyer->rowCount();

if($count_my_buyer == 1){
		
	$update_my_buyer = $db->query("update my_buyers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where seller_id='$proposal_seller_id' AND buyer_id='$login_seller_id'");

}else{
	
	$insert_my_buyer = $db->insert("my_buyers",array("seller_id"=>$proposal_seller_id,"buyer_id"=>$login_seller_id,"completed_orders"=>1,"amount_spent"=>$order_price,"last_order_date"=>$order_date));

}


$select_my_seller = $db->select("my_sellers",array("buyer_id"=>$login_seller_id,"seller_id"=>$proposal_seller_id));

$count_my_seller = $select_my_seller->rowCount();

if($count_my_seller == 1){
	
	// $insert_seller = $db->update("my_sellers",array("completed_orders"=>'completed_orders+1',"amount_spent"=>'amount_spent+$order_price',"last_order_date"=>$order_date),array("buyer_id"=>$login_seller_id,"seller_id"=>$proposal_seller_id));

	$update_my_seller = $db->query("update my_sellers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where buyer_id='$login_seller_id' AND seller_id='$proposal_seller_id'");

}else{
	
	$insert_seller = $db->insert("my_sellers",array("buyer_id"=>$login_seller_id,"seller_id"=>$proposal_seller_id,"completed_orders"=>1,"amount_spent"=>$order_price,"last_order_date"=>$order_date));

}


$total_amount = $order_price + $processing_fee;

if($payment_method == "shopping_balance"){
	
$insert_purchase = $db->insert("purchases",array("seller_id"=>$login_seller_id,"order_id"=>$insert_order_id,"amount"=>$order_price,"date"=>$order_date,"method"=>$payment_method));

}else{
		
$insert_purchase = $db->insert("purchases",array("seller_id"=>$login_seller_id,"order_id"=>$insert_order_id,"amount"=>$total_amount,"date"=>$order_date,"method"=>$payment_method));

}


$insert_notification = $db->insert("notifications",array("receiver_id"=>$proposal_seller_id,"sender_id"=>$login_seller_id,"order_id"=>$insert_order_id,"reason"=>"order","date"=>$order_date,"status"=>"unread"));


unset($_SESSION['checkout_seller_id']);

unset($_SESSION['proposal_id']);

unset($_SESSION['proposal_qty']);

unset($_SESSION['proposal_price']);

unset($_SESSION['method']);

echo "

<script>
      
        swal({
        
          type: 'success',
          text: 'Processing...... ',
          timer: 5000,
      	  onOpen: function(){
		  swal.showLoading()
		  }
          }).then(function(){

            // Read more about handling dismissals
            window.open('order_details?order_id=$insert_order_id','_self')
        
         });

    </script>";
	
}


}

/// Single Proposal Checkout Order Code Ends ///




/// Cart Proposals Order Code Starts ///

if(isset($_SESSION['cart_seller_id'])){
	
$buyer_id = $_SESSION['cart_seller_id'];
	
$payment_method = $_SESSION['method'];


require 'mailer/PHPMailerAutoload.php';

$sel_cart = $db->select("cart",array("seller_id" => $buyer_id));
	
while($row_cart = $sel_cart->fetch()){

$proposal_id = $row_cart->proposal_id;

$proposal_price = $row_cart->proposal_price;

$proposal_qty = $row_cart->proposal_qty;

$sub_total = $proposal_price*$proposal_qty;

$order_price = $sub_total;

$processing_fee = processing_fee($order_price);

$select_proposal = $db->select("proposals",array("proposal_id" => $proposal_id));

$row_proposal = $select_proposal->fetch();

$proposal_title = $row_proposal->proposal_title;

$proposal_enable_referrals = $row_proposal->proposal_enable_referrals;

$proposal_referral_money = $row_proposal->proposal_referral_money;

$proposal_referral_code = $row_proposal->proposal_referral_code;

$buyer_instruction = $row_proposal->buyer_instruction;

$proposal_seller_id = $row_proposal->proposal_seller_id;

$delivery_id = $row_proposal->delivery_id;


$select_delivery_time = $db->select("delivery_times",array('delivery_id' => $delivery_id));

$row_delivery_time = $select_delivery_time->fetch();

$delivery_proposal_title = $row_delivery_time->delivery_proposal_title;


$add_days = intval($delivery_proposal_title);

date_default_timezone_set("UTC");

$order_date = date("F d, Y");

$date_time = date("M d, Y H:i:s");

$order_time = date("M d, Y H:i:s", strtotime($date_time . " + $add_days days"));

$order_number = mt_rand();


if(!empty($buyer_instruction)){

$order_status = "pending";

}else{
	
$order_status = "progress";

}

$insert_order = $db->insert("orders",array("order_number" => $order_number,"order_duration" => $delivery_proposal_title,"order_time" => $order_time,"order_date" => $order_date,"seller_id" => $proposal_seller_id,"buyer_id" => $buyer_id,"proposal_id" => $proposal_id,"order_price" => $order_price,"order_qty" => $proposal_qty,"order_fee" => 0,"order_active" => 'yes',"order_status" => $order_status));

$insert_order_id = $db->lastInsertId();

if($insert_order){

// Insert Sale Here
// $adminProfit = "0.0";
// $sale = array("buyer_id" => $buyer_id,"work_id" => $insert_order_id,"payment_method" => $payment_method,"amount" => $order_price,"profit"=> $adminProfit,"processing_fee"=>0,"action"=>"cart","date"=>date("Y-m-d"));
// insertSale($sale);

if($proposal_enable_referrals == "yes"){
	
if(isset($_SESSION['r_proposal_id'])){
	
if($_SESSION['r_referrer_id'] == $login_seller_id){
	
}else{
	
if($proposal_id == $_SESSION['r_proposal_id'] & $proposal_referral_code == $_SESSION['r_referral_code']){
	
$ip = $_SERVER['REMOTE_ADDR'];

$r_proposal_id = $_SESSION['r_proposal_id'];

$r_seller_id = $proposal_seller_id;

$r_referrer_id = $_SESSION['r_referrer_id'];

$r_comission = $proposal_referral_money;

$r_date = date("F d, Y");

$r_o_comission = ($order_price*$r_comission)/100;

$comission = round($r_o_comission,1);

$insert_referral = $db->insert("proposal_referrals",array("proposal_id"=>$r_proposal_id,"order_id"=>$insert_order_id,"seller_id"=>$r_seller_id,"referrer_id"=>$r_referrer_id,"buyer_id"=>$login_seller_id,"comission"=>$comission,"date"=>$r_date,"ip"=>$ip,"status"=>'pending'));

unset($_SESSION['r_proposal_id']);

unset($_SESSION['r_referral_code']);

unset($_SESSION['r_referrer_id']);

}

}

}

}


$select_proposal_seller = $db->select("sellers",array("seller_id"=>$proposal_seller_id));

$row_proposal_seller = $select_proposal_seller->fetch();

$proposal_seller_user_name = $row_proposal_seller->seller_user_name;

$proposal_seller_email = $row_proposal_seller->seller_email;



$site_email_address = $row_general_settings->site_email_address;

$site_logo = $row_general_settings->site_logo;

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

$mail->addAddress($proposal_seller_email);

$mail->addReplyTo($site_email_address,$site_name);

$mail->isHTML(true);


$mail->Subject = "Congrats! You just received an order from $login_seller_user_name";
	
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

.table {
	
width:100%;	
	
background-color:#fff;

margin-bottom:20px;
	
}

.table thead tr th {
	
	border:1px solid #ddd;
	
	font-weight:bolder;
	
	padding:10px;
	
}

.table tbody tr td {
	
	border:1px solid #ddd;
	
	padding:10px;
	
}


</style>

</head>

<body class='is-responsive'>

<div class='container'>

<div class='box'>

<center>

<img src='$site_url/images/$site_logo' width='100' >

<h2> You have just received an order from $login_seller_user_name. </h2>

</center>

<hr>

<p class='lead'> Dear $proposal_seller_user_name, <br> these are the order details: </p>

<table class='table'>

<thead>

<tr>

<th> Proposal </th>

<th> Quantity </th>

<th> Duration </th>

<th> Amount </th>

<th> Buyer </th>

</tr>

</thead>

<tbody>

<tr>

<td>$proposal_title</td>

<td>$proposal_qty</td>

<td>$delivery_proposal_title</td>

<td>$$order_price</td>

<td>$login_seller_user_name</td>

</tr>

</tbody>

</table>
<br>
<center>

<a href='$site_url/order_details?order_id=$insert_order_id' class='btn'>

View Your Order

</a>

</center>

</div>

</div>

</body>

</html>

";

$mail->send();



$select_my_buyer = $db->select("my_buyers",array("seller_id"=>$proposal_seller_id,"buyer_id"=>$login_seller_id));

$count_my_buyer = $select_my_buyer->rowCount();

if($count_my_buyer == 1){
		
	$update_my_buyer = $db->query("update my_buyers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where seller_id='$proposal_seller_id' AND buyer_id='$login_seller_id'");
	
}else{

	$insert_my_buyer = $db->insert("my_buyers",array("seller_id"=>$proposal_seller_id,"buyer_id"=>$login_seller_id,"completed_orders"=>1,"amount_spent"=>$order_price,"last_order_date"=>$order_date));

}


$select_my_seller = $db->select("my_sellers",array("buyer_id"=>$login_seller_id,"seller_id"=>$proposal_seller_id));

$count_my_seller = $select_my_seller->rowCount();

if($count_my_seller == 1){

	$update_my_seller = $db->query("update my_sellers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where buyer_id='$login_seller_id' AND seller_id='$proposal_seller_id'");
	
}else{

	$insert_my_seller = $db->insert("my_sellers",array("buyer_id"=>$login_seller_id,"seller_id"=>$proposal_seller_id,"completed_orders"=>1,"amount_spent"=>$order_price,"last_order_date"=>$order_date));
	
}


$insert_purchase = $db->insert("purchases",array("seller_id"=>$login_seller_id,"order_id"=>$insert_order_id,"amount"=>$order_price,"date"=>$order_date,"method"=>$payment_method));

$insert_notification = $db->insert("notifications",array("receiver_id"=>$proposal_seller_id,"sender_id"=>$login_seller_id,"order_id"=>$insert_order_id,"reason"=>"order","date"=>$order_date,"status"=>"unread"));


}
	
}

$delete_cart = $db->delete("cart",array("seller_id" => $buyer_id));

unset($_SESSION['cart_seller_id']);

unset($_SESSION['method']);

echo "<script>alert('Your order has been placed, Thank you.');</script>";
	
echo "<script>window.open('buying_orders','_self')</script>";
	
}

/// Cart Proposals Order Code Ends ///


/// Single Offer Order Code Starts ///


if(isset($_SESSION['offer_id'])){
	
$buyer_id = $_SESSION['offer_buyer_id'];

$offer_id = $_SESSION['offer_id'];

$payment_method = $_SESSION['method'];
	
	

$select_offers = $db->select("send_offers",array("offer_id" => $offer_id));

$row_offers = $select_offers->fetch();

$proposal_id = $row_offers->proposal_id;

$description = $row_offers->description;

$delivery_time = $row_offers->delivery_time;

$order_price = $row_offers->amount;

$processing_fee = processing_fee($order_price);

$proposal_qty = "1";
	


$select_proposal = $db->select("proposals",array("proposal_id" => $proposal_id));

$row_proposal = $select_proposal->fetch();

$proposal_title = $row_proposal->proposal_title;

$buyer_instruction = $row_proposal->buyer_instruction;

$proposal_seller_id = $row_proposal->proposal_seller_id;




$add_days = intval($delivery_proposal_title);

date_default_timezone_set("UTC");

$order_date = date("F d, Y");

$date_time = date("M d, Y H:i:s");

$order_time = date("M d, Y H:i:s", strtotime($date_time . " + $add_days days"));

$order_number = mt_rand();

if(!empty($buyer_instruction)){

$order_status = "pending";

}else{
	
$order_status = "progress";

}

if($payment_method == "shopping_balance"){	

$saleProcessingFee = 0;

$insert_order = $db->insert("orders",array("order_number" => $order_number,"order_duration" => $delivery_time,"order_time" => $order_time,"order_date" => $order_date,"seller_id" => $proposal_seller_id,"buyer_id" => $buyer_id,"proposal_id" => $proposal_id,"order_price" => $order_price,"order_qty" => $proposal_qty,"order_fee" => 0,"order_active" => 'yes',"order_status" => $order_status));

	
}else{

$saleProcessingFee = $processing_fee;
		
$insert_order = $db->insert("orders",array("order_number" => $order_number,"order_duration" => $delivery_time,"order_time" => $order_time,"order_date" => $order_date,"seller_id" => $proposal_seller_id,"buyer_id" => $buyer_id,"proposal_id" => $proposal_id,"order_price" => $order_price,"order_qty" => $proposal_qty,"order_fee" => $processing_fee,"order_active" => 'yes',"order_status" => $order_status));

}

$insert_order_id = $db->lastInsertId();


if($insert_order){

// Insert Sale Here
// $adminProfit = "0.0";
// $sale = array("buyer_id" => $buyer_id,"work_id" => $insert_order_id,"payment_method" => $payment_method,"amount" => $order_price,"profit"=> $adminProfit,"processing_fee"=>$saleProcessingFee,"action"=>"requestOffer","date"=>date("Y-m-d"));
// insertSale($sale);
	
$update_order = $db->update("send_offers",array("status"=>'send'),array("offer_id"=>$offer_id));


$select_proposal_seller = $db->select("sellers",array("seller_id"=>$proposal_seller_id));
$row_proposal_seller = $select_proposal_seller->fetch();
$proposal_seller_user_name = $row_proposal_seller->seller_user_name;
$proposal_seller_email = $row_proposal_seller->seller_email;

	
$site_email_address = $row_general_settings->site_email_address;
$site_logo = $row_general_settings->site_logo;


require 'mailer/PHPMailerAutoload.php';
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
$mail->addAddress($proposal_seller_email);
$mail->addReplyTo($site_email_address,$site_name);
$mail->isHTML(true);


$mail->Subject = "Congrats! You just received an order from $login_seller_user_name";
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

.table {
	
width:100%;	
	
background-color:#fff;

margin-bottom:20px;
	
}

.table thead tr th {
	
	border:1px solid #ddd;
	
	font-weight:bolder;
	
	padding:10px;
	
}

.table tbody tr td {
	
	border:1px solid #ddd;
	
	padding:10px;
	
}


</style>

</head>

<body class='is-responsive'>

<div class='container'>

<div class='box'>

<center>

<img src='$site_url/images/$site_logo' width='100' >

<h2> You have just received an order from $login_seller_user_name </h2>

</center>

<hr>

<p class='lead'> Dear $proposal_seller_user_name, these are the order details: </p>

<table class='table'>

<thead>

<tr>

<th> Proposal </th>

<th> Quantity </th>

<th> Duration </th>

<th> Amount </th>

<th> Buyer </th>

</tr>

</thead>

<tbody>

<tr>

<td>$proposal_title</td>

<td>$proposal_qty</td>

<td>$delivery_time</td>

<td>$$order_price</td>

<td>$login_seller_user_name</td>

</tr>

</tbody>

</table>
<br>
<center>

<a href='$site_url/order_details?order_id=$insert_order_id' class='btn'>

View Your Order

</a>

</center>

</div>

</div>

</body>

</html>";

$mail->send();


$select_my_buyer = $db->select("my_buyers",array("seller_id"=>$proposal_seller_id,"buyer_id"=>$login_seller_id));

$count_my_buyer = $select_my_buyer->rowCount();

if($count_my_buyer == 1){
		
	$update_my_buyer = $db->query("update my_buyers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where seller_id='$proposal_seller_id' AND buyer_id='$login_seller_id'");

}else{
	
	$insert_my_buyer = $db->insert("my_buyers",array("seller_id"=>$proposal_seller_id,"buyer_id"=>$login_seller_id,"completed_orders"=>1,"amount_spent"=>$order_price,"last_order_date"=>$order_date));

}


$select_my_seller = $db->select("my_sellers",array("buyer_id"=>$login_seller_id,"seller_id"=>$proposal_seller_id));

$count_my_seller = $select_my_seller->rowCount();

if($count_my_seller == 1){
	
	// $insert_seller = $db->update("my_sellers",array("completed_orders"=>'completed_orders+1',"amount_spent"=>'amount_spent+$order_price',"last_order_date"=>$order_date),array("buyer_id"=>$login_seller_id,"seller_id"=>$proposal_seller_id));

	$update_my_seller = $db->query("update my_sellers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where buyer_id='$login_seller_id' AND seller_id='$proposal_seller_id'");

}else{
	
	$insert_my_seller = $db->insert("my_sellers",array("buyer_id"=>$login_seller_id,"seller_id"=>$proposal_seller_id,"completed_orders"=>1,"amount_spent"=>$order_price,"last_order_date"=>$order_date));

}

$total_amount = $order_price + $processing_fee;


if($payment_method == "shopping_balance"){
	
$insert_purchase = $db->insert("purchases",array("seller_id"=>$login_seller_id,"order_id"=>$insert_order_id,"amount"=>$order_price,"date"=>$order_date,"method"=>$payment_method));

}else{
		
$insert_purchase = $db->insert("purchases",array("seller_id"=>$login_seller_id,"order_id"=>$insert_order_id,"amount"=>$total_amount,"date"=>$order_date,"method"=>$payment_method));

}


$insert_notification = $db->insert("notifications",array("receiver_id"=>$proposal_seller_id,"sender_id"=>$login_seller_id,"order_id"=>$insert_order_id,"reason"=>"order","date"=>$order_date,"status"=>"unread"));

unset($_SESSION['offer_id']);

unset($_SESSION['offer_buyer_id']);

unset($_SESSION['method']);

echo "

<script>
      
                  swal({
                  type: 'success',
                  text: 'Processing...... ',
                  timer: 5000,
              	  onOpen: function(){
				  swal.showLoading()
				  }
                  }).then(function(){
                  if (
                    // Read more about handling dismissals
                    window.open('order_details?order_id=$insert_order_id','_self')

                  ) {
                    console.log('Order submitted!')
                  }
                })

            </script>";


}	
	
}


/// Single Offer Order Code Ends ///


/// Message Offer Code Starts ///

if(isset($_SESSION['message_offer_id'])){
	
$message_offer_id = $_SESSION['message_offer_id'];

$buyer_id = $_SESSION['message_offer_buyer_id'];

$payment_method = $_SESSION['method'];
	

$select_offers = $db->select("messages_offers",array("offer_id" => $message_offer_id));

$row_offers = $select_offers->fetch();

$proposal_id = $row_offers->proposal_id;

$description = $row_offers->description;

$delivery_time = $row_offers->delivery_time;

$order_price = $row_offers->amount;

$processing_fee = processing_fee($order_price);

$proposal_qty = "1";
	

$select_proposal = $db->select("proposals",array("proposal_id" => $proposal_id));

$row_proposal = $select_proposal->fetch();

$proposal_title = $row_proposal->proposal_title;

$buyer_instruction = $row_proposal->buyer_instruction;

$proposal_seller_id = $row_proposal->proposal_seller_id;



$add_days = intval($delivery_proposal_title);

date_default_timezone_set("UTC");

$order_date = date("F d, Y");

$date_time = date("M d, Y H:i:s");

$order_time = date("M d, Y H:i:s", strtotime($date_time . " + $add_days days"));

$order_number = mt_rand();

if(!empty($buyer_instruction)){

$order_status = "pending";

}else{
	
$order_status = "progress";

}

if($payment_method == "shopping_balance"){

$saleProcessingFee = 0;

$insert_order = $db->insert("orders",array("order_number" => $order_number,"order_duration" => $delivery_time,"order_time" => $order_time,"order_date" => $order_date,"seller_id" => $proposal_seller_id,"buyer_id" => $buyer_id,"proposal_id" => $proposal_id,"order_price" => $order_price,"order_qty" => $proposal_qty,"order_fee" => 0,"order_active" => 'yes',"order_status" => $order_status));

	
}else{

$saleProcessingFee = $processing_fee;
		
$insert_order = $db->insert("orders",array("order_number" => $order_number,"order_duration" => $delivery_time,"order_time" => $order_time,"order_date" => $order_date,"seller_id" => $proposal_seller_id,"buyer_id" => $buyer_id,"proposal_id" => $proposal_id,"order_price" => $order_price,"order_qty" => $proposal_qty,"order_fee" => $processing_fee,"order_active" => 'yes',"order_status" => $order_status));

}

$insert_order_id = $db->lastInsertId();

if($insert_order){


// Insert Sale Here
// $adminProfit = "0.0";
// $sale = array("buyer_id" => $buyer_id,"work_id" => $insert_order_id,"payment_method" => $payment_method,"amount" => $order_price,"profit"=> $adminProfit,"processing_fee"=>$saleProcessingFee,"action"=>"messageOffer","date"=>date("Y-m-d"));
// insertSale($sale);
	
$update_order = $db->update("messages_offers",array("order_id"=>$insert_order_id,"status"=>'accepted'),array("offer_id"=>$message_offer_id));


$select_proposal_seller = $db->select("sellers",array("seller_id"=>$proposal_seller_id));
$row_proposal_seller = $select_proposal_seller->fetch();
$proposal_seller_user_name = $row_proposal_seller->seller_user_name;
$proposal_seller_email = $row_proposal_seller->seller_email;

	
$site_email_address = $row_general_settings->site_email_address;
$site_logo = $row_general_settings->site_logo;


require 'mailer/PHPMailerAutoload.php';

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

$mail->addAddress($proposal_seller_email);

$mail->addReplyTo($site_email_address,$site_name);

$mail->isHTML(true);
	

$mail->Subject = "Congrats! You just received a new order from $login_seller_user_name";
	
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

.table {
	
width:100%;	
	
background-color:#fff;

margin-bottom:20px;
	
}

.table thead tr th {
	
	border:1px solid #ddd;
	
	font-weight:bolder;
	
	padding:10px;
	
}

.table tbody tr td {
	
	border:1px solid #ddd;
	
	padding:10px;
	
}


</style>

</head>

<body class='is-responsive'>

<div class='container'>

<div class='box'>

<center>

<img src='$site_url/images/$site_logo' width='100' >

<h2> You have just received an order from $login_seller_user_name </h2>

</center>

<hr>

<p class='lead'> Dear $proposal_seller_user_name, these are the order details: </p>

<table class='table'>

<thead>

<tr>

<th> Proposal </th>

<th> Quantity </th>

<th> Duration </th>

<th> Amount </th>

<th> Buyer </th>

</tr>

</thead>

<tbody>

<tr>

<td>$proposal_title</td>

<td>$proposal_qty</td>

<td>$delivery_time</td>

<td>$$order_price</td>

<td>$login_seller_user_name</td>

</tr>

</tbody>

</table>
<br>
<center>

<a href='$site_url/order_details?order_id=$insert_order_id' class='btn'>

View Your Order

</a>

</center>

</div>

</div>

</body>

</html>

";

$mail->send();


$select_my_buyer = $db->select("my_buyers",array("seller_id"=>$proposal_seller_id,"buyer_id"=>$login_seller_id));

$count_my_buyer = $select_my_buyer->rowCount();

if($count_my_buyer == 1){
		
	$update_my_buyer = $db->query("update my_buyers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where seller_id='$proposal_seller_id' AND buyer_id='$login_seller_id'");

}else{
	
	$insert_my_buyer = $db->insert("my_buyers",array("seller_id"=>$proposal_seller_id,"buyer_id"=>$login_seller_id,"completed_orders"=>1,"amount_spent"=>$order_price,"last_order_date"=>$order_date));

}


$select_my_seller = $db->select("my_sellers",array("buyer_id"=>$login_seller_id,"seller_id"=>$proposal_seller_id));

$count_my_seller = $select_my_seller->rowCount();

if($count_my_seller == 1){
	
	$update_my_seller = $db->query("update my_sellers set completed_orders=completed_orders+1,amount_spent=amount_spent+$order_price,last_order_date='$order_date' where buyer_id='$login_seller_id' AND seller_id='$proposal_seller_id'");

}else{
	
	$insert_my_seller = $db->insert("my_sellers",array("buyer_id"=>$login_seller_id,"seller_id"=>$proposal_seller_id,"completed_orders"=>1,"amount_spent"=>$order_price,"last_order_date"=>$order_date));

}

$total_amount = $order_price + $processing_fee;

if($payment_method == "shopping_balance"){
	
$insert_purchase = $db->insert("purchases",array("seller_id"=>$login_seller_id,"order_id"=>$insert_order_id,"amount"=>$order_price,"date"=>$order_date,"method"=>$payment_method));

}else{
		
$insert_purchase = $db->insert("purchases",array("seller_id"=>$login_seller_id,"order_id"=>$insert_order_id,"amount"=>$total_amount,"date"=>$order_date,"method"=>$payment_method));

}

$insert_notification = $db->insert("notifications",array("receiver_id"=>$proposal_seller_id,"sender_id"=>$login_seller_id,"order_id"=>$insert_order_id,"reason"=>"order","date"=>$order_date,"status"=>"unread"));

unset($_SESSION['message_offer_id']);

unset($_SESSION['message_offer_buyer_id']);

unset($_SESSION['method']);

echo "

<script>

alert('Your order has been placed successfully, thank you.');

window.open('order_details?order_id=$insert_order_id','_self');

</script>";


}

	
	
}


/// Message Offer Code Ends ///




	
}


?>