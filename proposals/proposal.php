<?php

session_start();
require_once("../includes/db.php");
require_once("../social-config.php");
require_once("../functions/email.php");

require_once "$dir/screens/detect.php";
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

if($deviceType == "phone"){
	$proposals_stylesheet = '<link href="styles/mobile_proposals.css" rel="stylesheet">'; 
}else{
	$proposals_stylesheet = '<link href="styles/desktop_proposals.css" rel="stylesheet">'; 
}

$username = $input->get('username');
$select_proposal_seller = $db->select("sellers",array("seller_user_name"=>$username));
$row_proposal_seller = $select_proposal_seller->fetch();
$proposal_seller_id = $row_proposal_seller->seller_id;

$proposal_url = urlencode($input->get('proposal_url'));

if(isset($_SESSION['admin_email'])){
	$get_proposal = $db->query("select * from proposals where proposal_url=:url and proposal_seller_id='$proposal_seller_id'",array("url"=>$proposal_url));
}elseif(isset($_SESSION['seller_user_name']) AND $_SESSION['seller_user_name'] == $username){
	$get_proposal = $db->query("select * from proposals where proposal_url=:url and proposal_seller_id='$proposal_seller_id' and not proposal_status in ('trash')",array("url"=>$proposal_url));
}else{
	$get_proposal = $db->query("select * from proposals where proposal_url=:url and proposal_seller_id='$proposal_seller_id' and not proposal_status in ('pause','pending','trash','declined','modification')",array("url"=>$proposal_url));
}
$count_proposal = $get_proposal->rowCount();
if($count_proposal == 0){
	echo "<script> window.open('../../index.php?not_available','_self') </script>";
}

$proposal_id = $get_proposal->fetch()->proposal_id;

// Select proposal Details From Proposal Id
$select_proposal = $db->select("proposals",array("proposal_id" => $proposal_id));
$row_proposal = $select_proposal->fetch();
$proposal_title = $row_proposal->proposal_title;
$proposal_cat_id = $row_proposal->proposal_cat_id;
$proposal_child_id = $row_proposal->proposal_child_id;
$proposal_price = $row_proposal->proposal_price;
$proposal_img1 = $row_proposal->proposal_img1;
$proposal_img2 = $row_proposal->proposal_img2;
$proposal_img3 = $row_proposal->proposal_img3;
$proposal_img4 = $row_proposal->proposal_img4;
$proposal_video = $row_proposal->proposal_video;
$proposal_desc = $row_proposal->proposal_desc;
$proposal_short_desc = strip_tags(substr($row_proposal->proposal_desc,0,160));
$proposal_tags = $row_proposal->proposal_tags;
$proposal_seller_id = $row_proposal->proposal_seller_id;
$delivery_id = $row_proposal->delivery_id;
$proposal_rating = $row_proposal->proposal_rating;
// $proposal_enable_faqs = $row_proposal->proposal_enable_faqs;
$proposal_enable_referrals = $row_proposal->proposal_enable_referrals;
$proposal_referral_money = $row_proposal->proposal_referral_money;
$proposal_referral_code = $row_proposal->proposal_referral_code;

// Select Proposal Category
$get_cat = $db->select("categories",array('cat_id'=>$proposal_cat_id));
$proposal_cat_url = $get_cat->fetch()->cat_url;

$get_meta = $db->select("cats_meta",array("cat_id"=>$proposal_cat_id,"language_id"=>$siteLanguage));
$row_meta = $get_meta->fetch();
@$proposal_cat_title = $row_meta->cat_title;


// Select Proposal Child Category
$get_child = $db->select("categories_children",array('child_id'=>$proposal_child_id));
$proposal_child_url = $get_child->fetch()->child_url;


$get_meta = $db->select("child_cats_meta",array("child_id"=>$proposal_child_id,"language_id"=>$siteLanguage));
$row_meta = $get_meta->fetch();
@$proposal_child_title = $row_meta->child_title;

// Select Proposal Delivery Time
$get_delivery_time = $db->select("delivery_times",array('delivery_id' => $delivery_id));
$row_delivery_time = $get_delivery_time->fetch();
$delivery_proposal_title = $row_delivery_time->delivery_proposal_title;

// Select Proposal Active Orders
$select_orders = $db->select("orders",["proposal_id"=>$proposal_id,"order_active"=>"yes"]);
$proposal_order_queue = $select_orders->rowCount();

// Select Proposal Reviews Then Count Them
$proposal_reviews = array();
$select_buyer_reviews = $db->select("buyer_reviews",array("proposal_id" => $proposal_id));
$count_reviews = $select_buyer_reviews->rowCount();
while($row_buyer_reviews = $select_buyer_reviews->fetch()){
$proposal_buyer_rating = $row_buyer_reviews->buyer_rating;
array_push($proposal_reviews,$proposal_buyer_rating);
}
$total = array_sum($proposal_reviews);
@$average_rating = $total/count($proposal_reviews);

// Select Proposal Seller Details
$select_proposal_seller = $db->select("sellers",array("seller_id"=>$proposal_seller_id));
$row_proposal_seller = $select_proposal_seller->fetch();
$proposal_seller_user_name = $row_proposal_seller->seller_user_name;
$proposal_seller_image = $row_proposal_seller->seller_image;
$proposal_seller_country = $row_proposal_seller->seller_country;
$proposal_seller_about = $row_proposal_seller->seller_about;
$proposal_seller_level = $row_proposal_seller->seller_level;
$proposal_seller_recent_delivery = $row_proposal_seller->seller_recent_delivery;
$proposal_seller_rating = $row_proposal_seller->seller_rating;
$proposal_seller_vacation = $row_proposal_seller->seller_vacation;
$proposal_seller_status = $row_proposal_seller->seller_status;

// Select Proposal Seller Level
@$level_title = $db->select("seller_levels_meta",array("level_id"=>$proposal_seller_level,"language_id"=>$siteLanguage))->fetch()->title;

// Update Proposal Views
if(!isset($_SESSION['seller_user_name'])){
	$update_proposal_views = $db->query("update proposals set proposal_views=proposal_views+1 where proposal_id='$proposal_id'");
}


if(isset($_SESSION['seller_user_name'])){
	$login_seller_user_name = $_SESSION['seller_user_name'];
	$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	$row_login_seller = $select_login_seller->fetch();
	$login_seller_id = $row_login_seller->seller_id;
	if($proposal_seller_id != $login_seller_id ){
		$update_proposal_views = $db->query("update proposals set proposal_views=proposal_views+1 where proposal_id='$proposal_id'");
	}
	$select_recent_proposal = $db->select("recent_proposals",array("seller_id"=>$login_seller_id,"proposal_id"=>$proposal_id));
	$count_recent_proposal = $select_recent_proposal->rowCount();
	if($count_recent_proposal == 1){
		if($proposal_seller_id != $login_seller_id){
			$delete_recent = $db->delete("recent_proposals",array("seller_id"=>$login_seller_id,"proposal_id"=>$proposal_id));
			$insert_recent = $db->insert("recent_proposals",array("seller_id"=>$login_seller_id,"proposal_id"=>$proposal_id));
		}
	}else{
		if($proposal_seller_id != $login_seller_id){
			$insert_recent = $db->insert("recent_proposals",array("seller_id"=>$login_seller_id,"proposal_id"=>$proposal_id));
		}
	}
}

$get_extras = $db->select("proposals_extras",array("proposal_id"=>$proposal_id));
$count_extras = $get_extras->rowCount();

$get_faq = $db->select("proposals_faq",array("proposal_id"=>$proposal_id));
$count_faq = $get_faq->rowCount();

$favorites = $db->select("favorites",array("proposal_id"=>$proposal_id,"seller_id",@$login_seller_id));
$countfavorites = $favorites->rowCount();
if($countfavorites == 0){
	$show_favorite_id = "favorite_$proposal_id";
	$show_favorite_class = "dil1";
	$show_favorite_text = "Favourite";
}else{
	$show_favorite_id = "unfavorite_$proposal_id";
	$show_favorite_class = "dil";
	$show_favorite_text = "Unfavourite";
}

$cart = $db->select("cart",array("proposal_id"=>$proposal_id,"seller_id",@$login_seller_id));
$countcart = $cart->rowCount();

$ratings = array();
$sel_proposal_reviews = $db->select("buyer_reviews",array("proposal_id"=>$proposal_id));
while($row_proposals_reviews = $sel_proposal_reviews->fetch()){
  $proposal_buyer_rating = $row_proposals_reviews->buyer_rating;
  array_push($ratings,$proposal_buyer_rating);
}
$total = array_sum($ratings);
if($total!=0){
	$avg = $total/count($ratings);
	$proposal_rating = substr($avg,0,1);
}else{
	$proposal_rating=0;
}

if(empty($proposal_rating) or $proposal_rating=="N"){
  $proposal_rating = 0;
}

?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
<title><?php echo $site_name; ?> - <?php echo $proposal_title; ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="<?php echo $proposal_short_desc; ?>">
<meta name="keywords" content="<?php echo $proposal_tags; ?>">
<meta name="author" content="<?php echo $proposal_seller_user_name; ?>">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
<link href="../../styles/bootstrap.css" rel="stylesheet">
<link href="../../styles/custom.css" rel="stylesheet"> <!-- Custom css code from modified in admin panel --->
<link href="../../styles/styles.css" rel="stylesheet">
<link href="../../styles/proposalStyles.css" rel="stylesheet">
<?php 
if($deviceType == "phone"){
echo '<link href="../../styles/mobile_proposals.css" rel="stylesheet">'; 
}else{
echo '<link href="../../styles/desktop_proposals.css" rel="stylesheet">'; 
}
?>
<link href="../../styles/categories_nav_styles.css" rel="stylesheet">
<link href="../../font_awesome/css/font-awesome.css" rel="stylesheet">
<link href="../../styles/owl.carousel.css" rel="stylesheet">
<link href="../../styles/owl.theme.default.css" rel="stylesheet">
<link href="../../styles/sweat_alert.css" rel="stylesheet">
<script type="text/javascript" src="../../js/sweat_alert.js"></script>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a39d50ac9681a6c"></script>
<?php if(!empty($site_favicon)){ ?>
<link rel="shortcut icon" href="../../images/<?php echo $site_favicon; ?>" type="image/x-icon">
<?php } ?>
</head>
<body class="is-responsive">
<script src="//platform-api.sharethis.com/js/sharethis.js#property=5c812224d11c6a0011c485fd&product=inline-share-buttons"></script>
<?php

require_once("../includes/header.php");

$show_img1 = "../proposal_files/{$proposal_img1}";
$show_img2 = "../proposal_files/{$proposal_img2}";
$show_img3 = "../proposal_files/$proposal_img3";
$show_img4 = "../proposal_files/$proposal_img4";
$show_video = "../proposal_files/$proposal_video";

if($deviceType == "phone"){
	include("../screens/mobile_proposal.php");
}else{
	include("../screens/desktop_proposal.php"); 
}

?>

<div id="report-modal" class="modal fade"><!-- report-modal modal fade Starts -->
<div class="modal-dialog"><!-- modal-dialog Starts -->
<div class="modal-content"><!-- modal-content Starts -->
<div class="modal-header p-2 pl-3 pr-3"><!-- modal-header Starts -->
Report This Proposal <button class="close" data-dismiss="modal"><span>&times;</span></button>
</div><!-- modal-header Ends -->
<div class="modal-body"><!-- modal-body p-0 Starts -->
<h6>Let us know why you would like to report this Proposal.</h6>
<form action="" method="post">
<div class="form-group mt-3"><!--- form-group Starts --->
<select class="form-control float-right" name="reason" required="">
<option value="">Select</option>
<option>Non Original Content</option>
<option>Inappropriate Proposal</option>
<option>Trademark Violation</option>
<option>Copyrights Violation</option>
</select>
</div><!--- form-group Ends --->
<br>
<br>
<div class="form-group mt-1 mb-3"><!--- form-group Starts --->
<label> Additional Information </label>
<textarea name="additional_information" rows="3" class="form-control" required=""></textarea>
</div><!--- form-group Ends --->
<button type="submit" name="submit_report" class="float-right btn btn-sm btn-success">Submit Report</button>
</form>
<?php 
if(isset($_POST['submit_report'])){
	$reason = $input->post('reason');
	$additional_information = $input->post('additional_information');
	$date = date("F d, Y");
	$insert = $db->insert("reports",array("reporter_id"=>$login_seller_id,"content_id"=>$proposal_id,"content_type"=>"proposal","reason"=>$reason,"additional_information"=>$additional_information,"date"=>$date));
	if($insert){
		send_report_email("proposal",$proposal_seller_user_name,$proposal_url,$date);
		echo "<script>alert('Your Report Has Been Successfully Submitted.')</script>";
		echo "<script>window.open('$proposal_url','_self')</script>";
	}
}
?>
</div><!-- modal-body p-0 Ends -->
</div><!-- modal-content Ends -->
</div><!-- modal-dialog Ends -->
</div><!-- report-modal modal fade Ends -->
<script type="text/javascript">
$(document).ready(function(){
	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
	  var newForm = e.target.getAttribute("formid"); // newly activated tab
	  var prevForm = e.relatedTarget.getAttribute("formid"); // previous active tab
	  $("select[form="+prevForm+"]").attr('form',newForm);
	  $("input[form="+prevForm+"]").attr('form',newForm);
	})

	function changePrice(name,price,checked){
		var value = $(name).first().text();
		var num = parseInt(value);
		var calc = num+price;
		if(checked){
			$(name).html(calc);
		}else{
			$(name).html(num-price);
		}
	}

	$(".buyables li label input").click(function(event){
		var price = parseInt($(this).parent().find(".price").text().replace(/\D/g,''));
		changePrice('.total-price',price,this.checked);
		changePrice('.total-price-1',price,this.checked);
		changePrice('.total-price-2',price,this.checked);
		changePrice('.total-price-3',price,this.checked);
	});
	
	$('#good').hide();
	$('#bad').hide();
});
</script>
<?php 
	include("../screens/includes/proposal_footer.php");
	include("../includes/footer.php");
?>
</body>
</html>