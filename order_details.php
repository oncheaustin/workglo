<?php

session_start();

require_once("includes/db.php");

require_once("functions/email.php");
require_once("functions/functions.php");

if(!isset($_SESSION['seller_user_name'])){
  
echo "<script>window.open('login','_self')</script>";
  
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

$order_id = $input->get("order_id");

$get_orders = $db->query("select * from orders where (seller_id=$login_seller_id or buyer_id=$login_seller_id) AND order_id=:o_id",array("o_id"=>$order_id));

$count_orders = $get_orders->rowCount();

if($count_orders == 0){
  echo "<script>window.open('index.php?not_available','_self')</script>";
}

$row_orders = $get_orders->fetch();
$seller_id = $row_orders->seller_id;
$buyer_id = $row_orders->buyer_id;
$order_price = $row_orders->order_price;
$order_number = $row_orders->order_number;
$order_status = $row_orders->order_status;
$complete_time = $row_orders->complete_time;

$get_site_logo_image = $row_general_settings->site_logo_image;

$order_auto_complete = $row_general_settings->order_auto_complete;

if($order_status == "delivered"){
  
  $currentDate = new DateTime("now");
  if(!empty($complete_time)){
    $endDate = new DateTime($complete_time);
    if($currentDate >= $endDate){
      require_once("orderIncludes/orderComplete.php");
    }
  }
}

?>

<!DOCTYPE html>

<html lang="en" class="ui-toolkit">

<head>
  <title><?php echo $site_name; ?> - Order Management For: #<?php echo $order_number; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $site_desc; ?>">
  <meta name="keywords" content="<?php echo $site_keywords; ?>">
  <meta name="author" content="<?php echo $site_author; ?>">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
  <link href="styles/bootstrap.css" rel="stylesheet">
  <link href="styles/fontawesome-stars.css" rel="stylesheet">
  <link href="styles/custom.css" rel="stylesheet"> <!-- Custom css code from modified in admin panel --->
  <link href="styles/styles.css" rel="stylesheet">
      <link href="styles/proposalStyles.css" rel="stylesheet">
  <link href="styles/user_nav_styles.css" rel="stylesheet">
  <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="styles/owl.carousel.css" rel="stylesheet">
  <link href="styles/owl.theme.default.css" rel="stylesheet">
  <script type="text/javascript" src="js/jquery.min.js"></script>
    <link href="styles/sweat_alert.css" rel="stylesheet">
    <link href="styles/animate.css" rel="stylesheet">
    <script type="text/javascript" src="js/ie.js"></script>
    <script type="text/javascript" src="js/sweat_alert.js"></script>
  <script type="text/javascript" src="js/jquery.barrating.min.js"></script>
  <script type="text/javascript" src="js/jquery.sticky.js"></script>
    <?php if(!empty($site_favicon)){ ?>
    <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
    <?php } ?>
</head>

<body class="is-responsive">

<?php require_once("includes/user_header.php"); ?>

<?php require_once("orderIncludes/orderDetails.php"); ?>

<?php if($order_status == "pending" or $order_status == "progress" or $order_status == "delivered" or $order_status == "revision requested" or $order_status == "cancellation requested"){ ?>
<div id="order-status-bar">
  <div class="container">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <h5 class="float-left mt-2">
          <span class="border border-success rounded p-1">Order: #<?php echo $order_number; ?></span>
        </h5>
        <h5 class="float-right mt-2">
          Status: <span class="text-muted">
          <?php if($order_status == "progress"){ echo "In"; } ?> 
          <?php echo ucwords($order_status); ?>
          </span>
        </h5>
      </div>
    </div>
</div>
</div>
<?php }elseif($order_status == "cancelled"){ ?>
<div id="order-status-bar">
  <div class="container">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <h5 class="float-left mt-2">
        <i class="fa fa-lg fa-times-circle text-danger"></i> Order Cancelled, Payment Has Been Refunded To Buyer.
        </h5>
        <h5 class="float-right mt-2">
          Status: <span class="text-muted">Cancelled</span>
        </h5>
      </div>
    </div>
  </div>
</div>
<?php }elseif($order_status == "completed" ){ ?>
<div id="order-status-bar" class="bg-success text-white">
    <div class="row">
    <!--  <div class="col-md-10 offset-md-1"> -->
      <div class="container">
      <div class="col-md-10 offset-md-1"> 
        <?php if($seller_id == $login_seller_id){ ?>
        <h5 class="float-left mt-2">
          <i class="fa fa-lg fa-check-circle"></i> Order Delivered. You Earned <?php echo $s_currency; ?><?php echo $seller_price; ?>
        </h5>
        <h5 class="float-right mt-2">Status: Completed</h5>
      <?php }elseif($buyer_id == $login_seller_id){ ?>
        <h5 class="float-left mt-2">
          <i class="fa fa-lg fa-check-circle"></i> Delivery Submitted
        </h5>
        <h5 class="float-right mt-2">Status: Completed</h5>
      <?php } ?>
      </div>
      </div>
     </div>
</div>
<?php } ?>

<div class="container order-page mt-2">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-10 offset-md-1">
          <ul class="nav nav-tabs mb-3 mt-3">
            <li class="nav-item">
              <a href="#order-activity" data-toggle="tab" class="nav-link active make-black ">Order Activity</a>
            </li>
            <?php if($order_status == "pending" or $order_status == "progress" or $order_status == "delivered" or $order_status == "revision requested"){ ?>
            <li class="nav-item">
              <a href="#resolution-center" data-toggle="tab" class="nav-link make-black">Resolution Center</a>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-12 tab-content mt-2 mb-4">
      <div id="order-activity" class="tab-pane fade show active">
        <div class="row">
          <div class="col-md-10 offset-md-1">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-2">
                    <img src="proposals/proposal_files/<?php echo $proposal_img1; ?>" class="img-fluid d-lg-block d-md-block d-none">
                  </div>
                  <div class="col-md-10">
                    <?php if($seller_id == $login_seller_id){ ?>
                    <h1 class="text-success float-right d-lg-block d-md-block d-none"><?php echo $s_currency; ?><?php echo $order_price; ?>.00</h1>
                    <h4>
                      Order #<?php echo $order_number; ?>
                      <small>
                      <a href="proposals/<?php echo $seller_user_name; ?>/<?php echo $proposal_url; ?>" target="_blank" class="text-success">
                      View Proposal/Service
                      </a>
                      </small>
                    </h4>
                    <p class="text-muted">
                      <span class="font-weight-bold">Buyer: </span>
                      <a href="<?php echo $buyer_user_name; ?>" target="_blank" class="seller-buyer-name mr-1 text-success">
                      <?php echo ucfirst($buyer_user_name); ?>
                      </a>
                      | <span class="font-weight-bold ml-1"> Status: </span>
                      <?php echo $order_status; ?>
                      | <span class="font-weight-bold ml-1"> Date: </span>
                      <?php echo $order_date; ?>
                    </p>
                    <?php }elseif($buyer_id == $login_seller_id){ ?>
                    <h1 class="text-success float-right d-lg-block d-md-block d-none"><?php echo $s_currency; ?><?php echo $total; ?>.00</h1>
                    <h4><?php echo $proposal_title; ?>   </h4>
                    <p class="text-muted">
                      <span class="font-weight-bold">Seller: </span>
                      <a href="<?php echo $seller_user_name; ?>" target="_blank" class="seller-buyer-name mr-1 text-success">
                      <?php echo ucfirst($seller_user_name); ?>
                      </a>
                      | <span class="font-weight-bold ml-1"> Order: </span> #
                      <?php echo $order_number; ?>
                      | <span class="font-weight-bold ml-1"> Date: </span>
                      <?php echo $order_date; ?>
                    </p>
                    <?php } ?>
                  </div>
                </div>
                <div class="row d-lg-flex d-md-flex d-none">
                  <div class="col-md-12">
                    <table class="table table-bordered mt-3">
                      <thead>
                        <tr>
                          <th>Item</th>
                          <th>Quantity</th>
                          <th>Duration</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="font-weight-bold" width="600">
                            <?php echo $proposal_title; ?>
                            <?php
                              $get_extras = $db->select("order_extras",array("order_id"=>$order_id));
                              $count_extras = $get_extras->rowCount();
                              if($count_extras > 0){
                              ?>
                            <ul class="ml-5" style="list-style-type: circle;">
                              <?php
                                while($row_extras = $get_extras->fetch()){
                                  $id = $row_extras->id;
                                  $name = $row_extras->name;
                                  $price = $row_extras->price;
                                ?>
                              <li class="font-weight-normal text-muted">
                                <?php echo $name; ?> (+<span class="price"><?php echo $s_currency.$price; ?></span>)
                              </li>
                              <?php } ?>
                            </ul>
                            <?php } ?>
                          </td>
                          <td>
                            <?php echo $order_qty; ?>
                          </td>
                          <td>
                            <?php echo $order_duration; ?>
                          </td>
                          <td>
                            <?php if($seller_id == $login_seller_id){ ?>
                            <?php echo $s_currency; ?>
                            <?php echo $order_price; ?>
                            <?php }elseif($buyer_id == $login_seller_id){ ?>
                            <?php echo $s_currency; ?>
                            <?php echo $order_price; ?>
                            <?php } ?>
                          </td>
                        </tr>
                        <?php if($buyer_id == $login_seller_id){  ?>
                        <?php if(!empty($order_fee)){ ?>
                        <tr>
                          <td>Processing Fee</td>
                          <td></td>
                          <td></td>
                          <td>
                            <?php echo $s_currency; ?>
                            <?php echo $order_fee; ?>
                          </td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                        <tr>
                          <td colspan="4">
                            <span class="float-right mr-4">
                            <strong>Total : </strong>
                            <?php if($seller_id == $login_seller_id){ ?>
                            <?php echo $s_currency; ?><?php echo $order_price; ?>
                            <?php }elseif($buyer_id == $login_seller_id){ ?> 
                            <?php echo $s_currency; ?><?php echo $total; ?>
                            <?php } ?>
                            </span>
                        </tr>
                      </tbody>
                    </table>
                    <?php if(!empty($order_desc)){ ?>
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Description</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td width="600">
                            <?php echo $order_desc; ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <?php if($order_status == "progress" or $order_status == "revision requested"){ ?>
            <?php if($seller_id == $login_seller_id){ ?>
            <h2 class="text-center mt-4" id="countdown-heading">
              This Order Needs To Be Delivered Before This Day/Time:
            </h2>
            <?php }elseif($buyer_id == $login_seller_id){ ?>
            <h2 class="text-center mt-4" id="countdown-heading">
              Your Order Should Be Ready On or Before This Day/Time:
            </h2>
            <?php } ?>
            <div id="countdown-timer">
              <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 countdown-box">
                  <p class="countdown-number" id="days"></p>
                  <p class="countdown-title">Day(s)</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 countdown-box">
                  <p class="countdown-number" id="hours"></p>
                  <p class="countdown-title">Hours</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 countdown-box">
                  <p class="countdown-number" id="minutes"></p>
                  <p class="countdown-title">Minutes</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 countdown-box">
                  <p class="countdown-number" id="seconds"></p>
                  <p class="countdown-title">Seconds</p>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php if($buyer_id == $login_seller_id){ ?>
            <?php if(!empty($buyer_instruction)){ ?>
            <div class="card mb-3 mt-3">
              <!--- card mb-3 mt-3 Starts --->
              <div class="card-header">
                <h5>Getting Started</h5>
              </div>
              <div class="card-body">
                <h6>
                  <b><?php echo ucfirst(strtolower($seller_user_name)); ?></b>
                  requires the following information in order to get started:
                </h6>
                <p>
                  <?php echo $buyer_instruction; ?>
                </p>
              </div>
            </div>
            <!--- card mb-3 mt-3 Ends --->
            <?php } ?>
            <?php } ?>
            <div id="order-conversations" class="mt-3">
              <?php require_once("orderIncludes/order_conversations.php"); ?>
            </div>
            <div id="report-modal" class="modal fade">
              <!-- report-modal modal fade Starts -->
              <div class="modal-dialog">
                <!-- modal-dialog Starts -->
                <div class="modal-content">
                  <!-- modal-content Starts -->
                  <div class="modal-header p-2 pl-3 pr-3">
                    <!-- modal-header Starts -->
                    Report This Message
                    <button class="close" data-dismiss="modal"><span>&times;</span></button>
                  </div>
                  <!-- modal-header Ends -->
                  <div class="modal-body">
                    <!-- modal-body p-0 Starts -->
                    <h6>Let us know why you would like to report this user?.</h6>
                    <form action="" method="post">
                      <div class="form-group mt-3">
                        <!--- form-group Starts --->
                        <select class="form-control float-right" name="reason" required="">
                          <option value="">Select Reason</option>
                          <?php if($login_seller_id == $buyer_id){ ?>
                          <option>The Seller tried to abuse the rating system.</option>
                          <option>The Seller was using inappropriate language.</option>
                          <option>The Seller delivered something that infringes copyrights</option>
                          <option>The Seller delivered something partial or insufficient</option>
                          <?php }else{ ?>
                          <option>The Buyer tried to abuse the rating system.</option>
                          <option>The Buyer was using inappropriate language.</option>
                          <?php } ?>
                        </select>
                      </div>
                      <!--- form-group Ends --->
                      <br>
                      <br>
                      <div class="form-group mt-1 mb-3">
                        <!--- form-group Starts --->
                        <label> Additional Information </label>
                        <textarea name="additional_information" rows="3" class="form-control" required=""></textarea>
                      </div>
                      <!--- form-group Ends --->
                      <button type="submit" name="submit_report" class="float-right btn btn-sm btn-success">Submit Report</button>
                    </form>
                    <?php 
                      if(isset($_POST['submit_report'])){
                      $reason = $input->post('reason');
                      $additional_information = $input->post('additional_information');
                      $r_date = date("F d, Y");
                      $insert = $db->insert("reports",array("reporter_id"=>$login_seller_id,"content_id"=>$order_id,"content_type"=>'order',"reason"=>$reason,"additional_information"=>$additional_information,"date"=>$r_date));

                      if($insert){
                        send_report_email("order","No Author",$order_id,$r_date);
                        echo "<script>alert('Your Report Has Been Successfully Submited.')</script>";
                        echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
                      }
                      }
                      ?>
                  </div>
                  <!-- modal-body p-0 Ends -->
                </div>
                <!-- modal-content Ends -->
              </div>
              <!-- modal-dialog Ends -->
            </div>
            <!-- report-modal modal fade Ends -->
            <?php if($seller_id == $login_seller_id){ ?>
            <?php if($order_status == "progress" or $order_status == "revision requested"){ ?>
            <center>
              <button class="btn btn-success btn-lg mt-5 mb-3" data-toggle="modal" data-target="#deliver-order-modal">
              <i class="fa fa-upload"></i> Deliver Order
              </button>
            </center>
            <?php } ?>
            <?php if($order_status == "delivered"){ ?>
            <center>
              <button class="btn btn-success btn-lg mt-4 mb-2" data-toggle="modal" data-target="#deliver-order-modal">
              <i class="fa fa-upload"></i> Deliver Order Again
              </button>
            </center>
            <?php } ?>
            <?php } ?>
            <div class="proposal_reviews mt-5">
              <?php 
                if($order_status == "completed"){ 
                 include("orderIncludes/orderReviews.php");
                } 
              ?>
            </div>
            <?php if($order_status == "pending" or $order_status == "progress" or $order_status == "delivered" or $order_status == "revision requested"){ ?>
            <div class="insert-message-box">
              <?php if($buyer_id == $login_seller_id AND $order_status == "pending" ){ ?>
              <div class="float-left pt-2">
                <span class="font-weight-bold text-danger"> RESPOND SO THAT SELLER CAN START YOUR ORDER. </span>
              </div>
              <?php } ?>
              <div class="float-right">
                <?php

                if($seller_id == $login_seller_id){
                $select_buyer = $db->select("sellers",array("seller_id"=>$buyer_id));
                $row_buyer = $select_buyer->fetch();
                $buyer_user_name = $row_buyer->seller_user_name;
                $buyer_status = $row_buyer->seller_status;
                }elseif($buyer_id == $login_seller_id){
                $select_seller = $db->select("sellers",array("seller_id"=>$seller_id));
                $row_seller = $select_seller->fetch();
                $seller_user_name = $row_seller->seller_user_name;
                $seller_status = $row_seller->seller_status;
                }
                
                ?>
                <p class="text-muted mt-1">
                  <?php if($seller_id == $login_seller_id){ ?>
                  <?php echo ucfirst($buyer_user_name); ?>
                  <span <?php if($buyer_status=="online" ){ ?>
                    class="text-success font-weight-bold"
                    <?php }else{ ?>
                    style="color:#868e96; font-weight:bold;"
                    <?php } ?>>  
                  is <?php echo $buyer_status; ?> 
                  </span> | Local Time
                  <?php }elseif($buyer_id == $login_seller_id){ ?>
                  <?php echo ucfirst($seller_user_name); ?>
                  <span <?php if($seller_status=="online" ){ ?>
                    class="text-success font-weight-bold"
                    <?php }else{ ?>
                    style="color:#868e96; font-weight:bold;"
                    <?php } ?>> 
                  is <?php echo $seller_status; ?> 
                  </span> | Local Time
                  <?php } ?>
                  <i class="fa fa-sun-o"></i>
                  <?php echo date("h:i A"); ?>
                </p>
              </div>
              <form id="insert-message-form" class="clearfix">
                <textarea name="message" rows="5" placeholder="Type Your Message Here..." class="form-control mb-2" onkeyup="matchWords(this)"></textarea>
                <div class="float-left b-2">
                  <p class="mt-1 text-danger d-none"><i class="fa fa-warning"></i> You seem to have typed word(s) that are in violation of our policy. No direct payments or emails allowed.</p>
                </div>
                <button type="submit" class="btn btn-success float-right">Send</button>
                <div class="clearfix"></div>
                <p></p>
                <div class="form-row align-items-center message-attacment">
                  <!-- form-row align-items-center message-attacment Starts -->
                  <label class="h6 ml-2 mt-1"> Attach File (optional) </label>
                  <input type="file" name="file" class="form-control-file p-1 mb-2 mb-sm-0">
                </div>
                <!-- form-row align-items-center message-attacment Ends -->
              </form>
            </div>
            <div id="upload_file_div"></div>
            <div id="message_data_div"></div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div id="resolution-center" class="tab-pane fade">
        <div class="row">
          <div class="col-md-10 offset-md-1">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8 offset-md-2">
                    <div class="card">
                      <div class="card-body">
                        <h3 class="text-center"> Order Cancellation Request</h3>
                      </div>
                    </div>
                    <form method="post">
                      <div class="form-group">
                        <textarea name="cancellation_message" placeholder="Please be as detailed as possible..." rows="10" class="form-control" required></textarea>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold"> Cancellation Request Reason </label>
                        <select name="cancellation_reason" class="form-control">
                          <option class="hidden"> Select Cancellation Reason </option>
                          <?php if($seller_id == $login_seller_id){ ?>
                          <option> Buyer is not responding. </option>
                          <option> Buyer is extremely rude. </option>
                          <option> Buyer requested that I cancel this order.</option>
                          <option> Buyer expects more than what this gig can offer.</option>
                          <?php }elseif($buyer_id == $login_seller_id){ ?>
                          <option> Seller is not responding. </option>
                          <option> Seller is extremely rude. </option>
                          <option> Order does meet requirements. </option>
                          <option> Seller asked me to cancel. </option>
                          <option> Seller cannot do required task. </option>
                          <?php }  ?>
                        </select>
                      </div>
                      <input type="submit" name="submit_cancellation_request" value="Submit Cancellation Request" class="btn btn-success float-right">
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
  if(isset($_POST['submit_cancellation_request'])){
    $cancellation_message = $input->post('cancellation_message');
    $cancellation_reason = $input->post('cancellation_reason');
    $last_update_date = date("h:i: M d, Y");
    if($seller_id == $login_seller_id){
    $receiver_id = $buyer_id;
    }else{
    $receiver_id = $seller_id;
    }

    if(send_cancellation_request($order_id,$order_number,$login_seller_id,$row_orders->proposal_id,$row_orders->seller_id,$row_orders->buyer_id,$last_update_date)){
      $insert_order_conversation = $db->insert("order_conversations",array("order_id" => $order_id,"sender_id" => $login_seller_id,"message" => $cancellation_message,"date" => $last_update_date,"reason" => $cancellation_reason,"status" => "cancellation_request"));
  
      if($insert_order_conversation){
      $insert_notification = $db->insert("notifications",array("receiver_id" => $receiver_id,"sender_id" => $login_seller_id,"order_id" => $order_id,"reason" => "cancellation_request","date" => $n_date,"status" => "unread"));
      $update_order = $db->update("orders",array("order_status" => "cancellation requested"),array("order_id" => $order_id));
      echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
      }
    }
  }
?>

<?php if($seller_id == $login_seller_id){ ?>
<div id="deliver-order-modal" class="modal fade">
  <!--- deliver-order-modal Starts --->
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Deliver Your Order Now </h5>
        <button class="close" data-dismiss="modal"> <span>&times;</span> </button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label class="font-weight-bold" > Message </label>
            <textarea name="delivered_message" placeholder="Type Your Message Here..." class="form-control mb-2"></textarea>
          </div>
          <div class="form-group clearfix">
            <input type="file" name="delivered_file" class="mt-1">
            <input type="submit" name="submit_delivered" value="Deliver Order" class="btn btn-success float-right">
          </div>
        </form>
        <?php
          if(isset($_POST['submit_delivered'])){
          $d_message = $input->post('delivered_message');
          $d_file = $_FILES['delivered_file']['name'];
          $d_file_tmp = $_FILES['delivered_file']['tmp_name'];
          $allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav');
          $file_extension = pathinfo($d_file, PATHINFO_EXTENSION);
          if(!in_array($file_extension,$allowed) & !empty($d_file)){
            echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
            echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
          }else{
            move_uploaded_file($d_file_tmp,"order_files/$d_file");
            $last_update_date = date("h:m: M d Y");
            $update_messages = $db->update("order_conversations",array("status" => "message"),array("order_id" => $order_id,"status" => "delivered"));
            $insert_delivered_message = $db->insert("order_conversations",array("order_id" => $order_id,"sender_id" => $seller_id,"message" => $d_message,"file" => $d_file,"date" => $last_update_date,"status" => "delivered"));
            if($insert_delivered_message){
              $insert_notification = $db->insert("notifications",array("receiver_id" => $buyer_id,"sender_id" => $seller_id,"order_id" => $order_id,"reason" => "order_delivered","date" => $n_date,"status" => "unread"));
              $site_logo = $row_general_settings->site_logo;
              $order_auto_complete = $row_general_settings->order_auto_complete;
              $date_time = date("M d, Y H:i:s");
              $complete_time = date("M d, Y H:i:s",strtotime($date_time." + $order_auto_complete days"));
              $update_order = $db->update("orders",array("order_status" => "delivered","complete_time" => $complete_time),array("order_id" => $order_id));
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
              $mail->addAddress($buyer_email);
              $mail->addReplyTo($site_email_address,$site_name);
              $mail->isHTML(true);
              $mail->Subject = "$get_site_name: Congrats! $login_seller_user_name has delivered your order.";
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
                margin-top:50px;
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
              <img src='$site_url/images/$site_logo' width='100' >
              <h2> $login_seller_user_name has delivered your order. </h2>
              </center>
              <hr>
              <p class='lead'> Dear $login_seller_user_name, </p>
              <p class='lead'> $d_message </p><br>
              <center>
              <a href='$site_url/order_details?order_id=$order_id' class='btn'>
              View Your Order
              </a>
              </center>
              </div>
              </div>
              </body>
              </html>
              ";
              $mail->send();
              echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
            }
          }
          }
          ?>
      </div>
    </div>
  </div>
</div>
<?php }elseif($buyer_id == $login_seller_id){ ?>
<div id="revision-request-modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Submit Your Revision Request Here </h5>
        <button class="close" data-dismiss="modal"> <span>&times;</span> </button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label class="font-weight-bold" > Request Message </label>
            <textarea name="revison_message" placeholder="Type Your Message Here..." class="form-control mb-2" required=""></textarea>
          </div>
          <div class="form-group clearfix">
            <input type="file" name="revison_file" class="mt-1">
            <input type="submit" name="submit_revison" value="Submit Request" class="btn btn-success float-right">
          </div>
        </form>
        <?php
          if(isset($_POST['submit_revison'])){
          $revison_message = $input->post('revison_message');
          $revison_file = $_FILES['revison_file']['name'];
          $revison_file_tmp = $_FILES['revison_file']['tmp_name'];
          $allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav');
          $file_extension = pathinfo($revison_file, PATHINFO_EXTENSION);
          if(!in_array($file_extension,$allowed) & !empty($revison_file)){
          echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
          echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
          }else{
          move_uploaded_file($revison_file_tmp,"order_files/$revison_file");
          $last_update_date = date("h:i: M d, Y");
          $update_messages = $db->update("order_conversations",array("status"=>"message"),array("order_id" => $order_id,"status" => "delivered"));
          $insert_revision_message = $db->insert("order_conversations",array("order_id"=>$order_id,"sender_id"=>$buyer_id,"message"=>$revison_message,"file"=>$revison_file,"date"=>$last_update_date,"status" =>"revision"));
          if($insert_revision_message){
          $insert_notification = $db->insert("notifications",array("receiver_id" => $seller_id,"sender_id" => $buyer_id,"order_id" => $order_id,"reason" => "order_revision","date" => $n_date,"status" => "unread"));
          $update_order = $db->update("orders",array("order_status"=>"revision requested"),array("order_id"=>$order_id));
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
          $mail->addAddress($seller_email);
          $mail->addReplyTo($site_email_address,$site_name);
          $mail->isHTML(true);
          $mail->Subject = "$site_name - Revison Requested By $buyer_user_name";
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
          @media only screen and (max-device-width: 690px) {
          .container {
          background: rgb(238, 238, 238);
          width:100%;
          padding:1px;
          }
          .btn{
          background:green;
          margin-top:25px;
          color:white !important;
          text-decoration:none;
          padding:10px;
          font-size:14px;
          border-radius:3px;
          }
          .lead { font-size:14px; }
          }
          </style>
          </head>
          <body class='is-responsive'>
          <div class='container'>
          <div class='box'>
          <center>
          <img class='logo' src='$site_url/images/$site_logo' width='100' >
          <h2> Revison Request For Your Order. </h2>
          </center>
          <hr>
          <p class='lead'> Dear $seller_user_name </p>
          <p class='lead'> You just received an revision request from $buyer_user_name for your order. </p>
          <br>
          <center>
          <a href='$site_url/order_details?order_id=$order_id' class='btn'>Click to view order</a>
          </center>
          </div>
          </div>
          </body>
          </html>";
          $mail->send();
          echo "<script>window.open('order_details?order_id=$order_id','_self')</script>";
          }
          }
          }
          ?>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<script>
function matchWords(input){
var value = $(input).val();
$.ajax({
url:"conversations/match_words",
method:"POST",
data : {value : value},
success: function(val){
  if(val == "match"){
  $('.text-danger').removeClass("d-none");
  }else{
  $('.text-danger').addClass("d-none");
  }
}
});
}
$(document).ready(function(){
// Sticky Code start //
$("#order-status-bar").sticky({ topSpacing:0,zIndex:500});
// Sticky code ends //
<?php if($order_status != "completed"){ ?>
////  Countdown Timer Code Starts  ////
// Set the date we're counting down to
var countDownDate = new Date("<?php echo $order_time; ?>").getTime();
// Update the count down every 1 second
var x = setInterval(function(){
 var now = new Date();
   var nowUTC = new Date(now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate(), now.getUTCHours(), now.getUTCMinutes(), now.getUTCSeconds());
   var distance = countDownDate - nowUTC;
// Time calculations for days, hours, minutes and seconds
var days = Math.floor(distance / (1000 * 60 * 60 * 24));
var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((distance % (1000 * 60)) / 1000);
document.getElementById("days").innerHTML = days;
document.getElementById("hours").innerHTML = hours;
document.getElementById("minutes").innerHTML = minutes;
document.getElementById("seconds").innerHTML = seconds;
// If the count down is over, write some text 
if (distance < 0){
clearInterval(x);
<?php if(isset($_GET["selling_order"])){ ?>
document.getElementById("countdown-heading").innerHTML = "You Failed To Deliver Your Order On Time";
<?php }elseif (isset($_GET["buying_order"])) { ?>
  document.getElementById("countdown-heading").innerHTML = "Your Seller Failed To Deliver Your Order On Time";
<?php } ?>
$("#countdown-timer .countdown-number").addClass("countdown-number-late");
document.getElementById("days").innerHTML = "<span class='red-color'>The</span>";
document.getElementById("hours").innerHTML = "<span class='red-color'>Order</span>";
document.getElementById("minutes").innerHTML = "<span class='red-color'>is</span>";
document.getElementById("seconds").innerHTML = "<span class='red-color'>Late!</span>";
}
}, 1000);
////  Countdown Timer Code Ends  ////
<?php } ?>
$('#insert-message-form').submit(function(e){
e.preventDefault();
var form_data = new FormData(this);
form_data.append('order_id',<?= $order_id; ?>);
$("#insert-message-form button[type='submit']").html("<i class='fa fa-spinner fa-pulse fa-lg fa-fw'></i>");
$.ajax({
method: "POST",
url: "orderIncludes/insert_order_message",
data : form_data,
cache: false,contentType: false,processData: false
}).done(function(data){
$('#message_data_div').html(data);  
$("#insert-message-form button[type='submit']").html("Send");
$("#insert-message-form").trigger("reset");
});
});
setInterval(function(){
order_id = "<?php echo $order_id; ?>";
$.ajax({
method: "GET",
url: "orderIncludes/order_conversations",
data: {order_id: order_id}
}).done(function(data){
$("#order-conversations").empty();
$("#order-conversations").append(data);
});
}, 1000); 
});
</script>

<?php require_once("includes/footer.php"); ?>

</body>

</html>