<?php
	@session_start();
	require_once("../../includes/db.php");
	if(!isset($_SESSION['seller_user_name'])){
		echo "<script>window.open('../../login','_self')</script>";
	}

	$login_seller_user_name = $_SESSION['seller_user_name'];
	$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	$row_login_seller = $select_login_seller->fetch();
	$login_seller_id = $row_login_seller->seller_id;

	if(isset($_POST["message_group_id"])){
		$message_group_id = $_POST["message_group_id"];
  }

	$get_inbox_messages = $db->select("inbox_messages",array("message_group_id" => $message_group_id));
	while($row_inbox_messages = $get_inbox_messages->fetch()){
	$message_id = $row_inbox_messages->message_id;
	$message_sender = $row_inbox_messages->message_sender;
	$message_desc = $row_inbox_messages->message_desc;
	$message_date = $row_inbox_messages->message_date;
	$message_file = $row_inbox_messages->message_file;
	$message_offer_id = $row_inbox_messages->message_offer_id;

	if(!$message_offer_id == 0){
		$select_offer = $db->select("messages_offers",array("offer_id" => $message_offer_id));	
		$row_offer = $select_offer->fetch();
		$sender_id = $row_offer->sender_id;
		$proposal_id = $row_offer->proposal_id;
		$description = $row_offer->description;
		$order_id = $row_offer->order_id;
		$delivery_time = $row_offer->delivery_time;
		$amount = $row_offer->amount;
		$offer_status = $row_offer->status;
		$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
		$row_proposals = $select_proposals->fetch();
		$proposal_title = $row_proposals->proposal_title;
    $proposal_img1 = $row_proposals->proposal_img1;
	}

  $select_sender = $db->select("sellers",array("seller_id" => $message_sender));
  $row_sender = $select_sender->fetch();
  $sender_user_name = $row_sender->seller_user_name;
  $sender_image = $row_sender->seller_image;
                
	if($login_seller_id == $message_sender){
		$sender_user_name = "Me";
	}

	$allowed = array('jpeg','jpg','gif','png');

	?>
	
	<li href="#" class="inboxMsg media inboxMsg">
	<?php if(!empty($sender_image)){ ?>
    <img src="../user_images/<?php echo $sender_image; ?>" class="rounded-circle mr-3" width="40">
	<?php }else{ ?>
	<img src="../user_images/empty-image.png"  class="rounded-circle mr-3" width="40">
	<?php } ?>
    <div class="media-body">
      <h6 class="mt-0 mb-1">
      	<?php echo $sender_user_name; ?> <small class="text-muted"><?php echo $message_date; ?></small>
      	<?php if($login_seller_id != $message_sender){ ?>
				<small>| <a href="#" data-toggle="modal" data-target="#report-modal" class="text-muted"><small><i class="fa fa-flag"></i> Report</small></a> </small>
				<?php } ?>
      </h6>
      <?php echo $message_desc; ?>
      <?php if(!empty($message_file)){ ?>
      <?php if(in_array(pathinfo($message_file,PATHINFO_EXTENSION),$allowed)){ ?>
      <br>
      <img src="conversations_files/<?php echo $message_file; ?>" alt="..." class="img-thumbnail" width="100">
      <?php } ?>
			<a href="conversations_files/<?php echo $message_file; ?>" download class="d-block mt-2 ml-1">
			<i class="fa fa-download"></i> <?php echo $message_file; ?>
			</a>
			<?php } ?>
			<?php if(!$message_offer_id == 0){ ?>
			<div class="message-offer card mb-3"><!--- message-offer Starts --->
			<div class="card-header p-2">
		   <h6 class="mt-md-0 mt-2">
			<?php echo $proposal_title; ?>
			<span class="price float-right d-sm-block d-none"> <?php echo $s_currency; ?><?php echo $amount; ?> </span>
			</h6>
		  </div>
		<div class="card-body p-2"><!--- card-body Starts --->
		<p> <?php echo $description; ?> </p>
		<p class="d-block d-sm-none"> <b> Price / Amount : </b> <?php echo $amount; ?> </p>
		<p> <b> <i class="fa fa-calendar"></i> Delivery Time : </b> <?php echo $delivery_time; ?> </p>
		<?php if($offer_status == "active"){ ?>
		<?php if($login_seller_id == $sender_id){ ?>
		<?php }else{ ?>
		<button id="accept-offer-<?php echo $message_offer_id; ?>" class="btn btn-success float-right">
		Accept Offer 
		</button>
		<script>
		$("#accept-offer-<?php echo $message_offer_id; ?>").click(function(){
			single_message_id = "<?php echo $message_group_id; ?>";
			offer_id = "<?php echo $message_offer_id; ?>";
			$.ajax({
			method: "POST",
			url: "accept_offer_modal",
			data: {single_message_id: single_message_id, offer_id: offer_id}
			})
			.done(function(data){
				$("#accept-offer-div").html(data);
			});
		});
		</script>
		<?php } ?>
		<?php }elseif($offer_status == "accepted"){ ?>
		<button class="btn btn-success rounded-0 mt-2 float-right" disabled>
		Offer Accepted
		</button>
		<a href="../order_details.php?order_id=<?php echo $order_id; ?>" class="mt-3 mr-3 float-right text-success">
		View Order
		</a>
		<?php } ?>
		</div><!--- card-body Ends --->
		</div><!--- message-offer Ends --->
	<?php } ?>
  </div>
  </li>
<?php } ?>