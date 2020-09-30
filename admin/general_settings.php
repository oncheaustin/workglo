<?php

@session_start();
if(!isset($_SESSION['admin_email'])){
echo "<script>window.open('login','_self');</script>";
}else{

$get_general_settings = $db->select("general_settings");   
$row_general_settings = $get_general_settings->fetch();
$site_title = $row_general_settings->site_title;
$site_www = $row_general_settings->site_www;
$site_desc = $row_general_settings->site_desc;
$site_keywords = $row_general_settings->site_keywords;
$site_author = $row_general_settings->site_author;
$site_favicon = $row_general_settings->site_favicon;
$s_favicon = $row_general_settings->site_favicon;
$site_logo_type = $row_general_settings->site_logo_type;
$site_logo_text = $row_general_settings->site_logo_text;
$site_logo_image = $row_general_settings->site_logo_image;
$s_logo_image = $row_general_settings->site_logo_image;
$site_name = $row_general_settings->site_name;
$site_logo = $row_general_settings->site_logo;
$s_logo = $row_general_settings->site_logo;
$site_url = $row_general_settings->site_url;
$site_email_address = $row_general_settings->site_email_address;
$site_copyright = $row_general_settings->site_copyright;
$site_timezone = $row_general_settings->site_timezone;
$site_currency = $row_general_settings->site_currency;
$recaptcha_site_key = $row_general_settings->recaptcha_site_key;
$recaptcha_secret_key = $row_general_settings->recaptcha_secret_key;
$enable_social_login = $row_general_settings->enable_social_login;
$fb_app_id = $row_general_settings->fb_app_id;
$fb_app_secret = $row_general_settings->fb_app_secret;
$g_client_id = $row_general_settings->g_client_id;
$g_client_secret = $row_general_settings->g_client_secret;
$jwplayer_code = $row_general_settings->jwplayer_code;
$level_one_rating = $row_general_settings->level_one_rating;
$level_one_orders = $row_general_settings->level_one_orders;
$level_two_orders = $row_general_settings->level_two_orders;
$level_two_rating = $row_general_settings->level_two_rating;
$level_top_rating = $row_general_settings->level_top_rating;
$level_top_orders = $row_general_settings->level_top_orders;
$approve_proposals = $row_general_settings->approve_proposals;
$proposal_email = $row_general_settings->proposal_email;
$signup_email = $row_general_settings->signup_email;
$relevant_requests = $row_general_settings->relevant_requests;
$enable_referrals = $row_general_settings->enable_referrals;
$knowledge_bank = $row_general_settings->knowledge_bank;
$referral_money = $row_general_settings->referral_money;
$enable_maintenance_mode = $row_general_settings->enable_maintenance_mode;
$order_auto_complete = $row_general_settings->order_auto_complete;
$wish_do_manual_payouts = $row_general_settings->wish_do_manual_payouts;

require 'updateHtaccess.php';
require 'timezones.php';

?>
<script src="../js/jquery.min.js"></script>
<div class="breadcrumbs">
<div class="col-sm-4"><!--- col-sm-4 Ends --->
<div class="page-header float-left">
<div class="page-title">
<h1><i class="menu-icon fa fa-cog"></i> Settings / General Settings</h1>
</div>
</div>
</div><!--- col-sm-4 Ends --->
<div class="col-sm-8"><!--- col-sm-8 Starts --->
<div class="page-header float-right">
<div class="page-title">
<ol class="breadcrumb text-right">
<li class="active">General Settings</li>
</ol>
</div>
</div>
</div><!--- col-sm-8 Ends --->
</div>
<div class="container">
<div class="row"><!--- 2 row Starts --->
<div class="col-lg-12"><!--- col-lg-12 Starts --->
<div class="card mb-5"><!--- card mb-5 Starts --->
<div class="card-header"><!--- card-header Starts --->
<h4 class="h4"><i class="fa fa-cog"></i> General Settings </h4>
</div><!--- card-header Ends --->
<div class="card-body"><!--- card-body Starts --->

<form method="post" enctype="multipart/form-data"><!--- form Starts --->

<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Site Title : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon">

<b><i class="fa fa-laptop"></i></b>

</span>

<input type="text" name="site_title" class="form-control" value="<?php echo $site_title; ?>" required="">

</div>

</div>

</div><!--- form-group row Ends --->

<div class="form-group row"><!--- form-group row Starts --->
<label class="col-md-3 control-label"> Enable Site (WWW) : </label>
<div class="col-md-6">
	<div class="input-group">
	<span class="input-group-addon"><b><i class="fa fa-link" aria-hidden="true"></i></b></span>
	<select name="site_www" class="form-control site_www" required="">
		<option value="1" <?php if($site_www == 1){ echo "selected"; } ?>> Yes </option>
		<option value="0" <?php if($site_www == 0){ echo "selected"; } ?>> No </option>
	</select>
	</div>
</div>
</div><!--- form-group row Ends --->
<div class="form-group row"><!--- form-group row Starts --->
<label class="col-md-3 control-label"> Do you wish to do Manual Payouts : </label>
<div class="col-md-6">
  <div class="input-group">
  <span class="input-group-addon"><b><i class="fa fa-link" aria-hidden="true"></i></b></span>
  <select name="wish_do_manual_payouts" class="form-control" required="">
    <option value="1" <?php if($wish_do_manual_payouts == 1){ echo "selected"; } ?>> Yes </option>
    <option value="0" <?php if($wish_do_manual_payouts == 0){ echo "selected"; } ?>> No </option>
  </select>
  </div>
</div>
</div><!--- form-group row Ends --->

<div class="form-group row"><!--- form-group row Starts --->
<label class="col-md-3 control-label"> Site Description : </label>
<div class="col-md-6">
<textarea name="site_desc" class="form-control" rows="5" required=""><?php echo $site_desc; ?></textarea>
</div>
</div><!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Site Keywords : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon"><b><i class="fa fa-flash"></i></b></span>

<input type="text" name="site_keywords" class="form-control" value="<?php echo $site_keywords; ?>" required="">

</div>

</div>

</div>
<!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Site Author : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon"><b><i class="fa fa-user"></i></b></span>

<input type="text" name="site_author" class="form-control" value="<?php echo $site_author; ?>" required="">

</div>

</div>

</div>
<!--- form-group row Ends --->



<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Site Name : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon"> <b><i class="fa fa-check-square-o"></i></b> </span>

<input type="text" name="site_name" class="form-control" value="<?php echo $site_name; ?>" required="">

</div>

</div>

</div><!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Site Favicon : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon"><b><i class="fa fa-paper-plane"></i></b></span>

<input type="file" name="site_favicon" class="form-control">

</div>

<img style="margin-top:7px;" src="../images/<?php echo $site_favicon; ?>" width="30" height="30">

</div>

</div>
<!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Site Logo Type : </label>

<div class="col-md-6">

<select name="site_logo_type" class="form-control site_logo_type" required="">

<?php if($site_logo_type == "text"){ ?>

<option value="text"> Text </option>

<option value="image"> Image </option>

<?php }elseif($site_logo_type == "image"){ ?>

<option value="image"> Image </option>

<option value="text"> Text </option>

<?php } ?>

</select>

</div>

</div>
<!--- form-group row Ends --->

<div class="form-group row site_logo_text">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Site Logo Text : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon">

<b><i class="fa fa-check-square-o"></i></b>

</span>

<input type="text" name="site_logo_text" class="form-control" value="<?php echo $site_logo_text; ?>">

</div>

</div>

</div>
<!--- form-group row Ends --->



<div class="form-group row site_logo_image">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Site Logo Image : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon">

<b><i class="fa fa-paper-plane"></i></b>

</span>

<input type="file" name="site_logo_image" class="form-control">

</div>

<img style="margin-top:7px;" src="../images/<?php echo $site_logo_image; ?>" width="90" height="30">

</div>

</div>
<!--- form-group row Ends --->


<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Site Email Logo : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon">

<b><i class="fa fa-paper-plane"></i></b>

</span>

<input type="file" name="site_logo" class="form-control">

</div>

<img style="margin-top:7px;" src="../images/<?php echo $site_logo; ?>" width="60" height="57">

</div>

</div><!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Site Url : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon">

<b><i class="fa fa-globe"></i></b>

</span>

<input type="text" name="site_url" class="form-control" value="<?php echo $site_url; ?>" required="">

</div>

<small class="form-text text-muted">

<span class="text-danger font-weight-bold">NB:</span>

Enter the complete url. Ex: https://www.GigToDo.com

</small>

</div>

</div>
<!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Site Email Address : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon"> <b><i class="fa fa-envelope-o"></i></b> </span>

<input type="text" name="site_email_address" class="form-control" value="<?php echo $site_email_address; ?>">

</div>

</div>

</div>
<!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Copyright Text : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon"> <b><i class="fa fa-copyright"></i></b> </span>

<input type="text" name="site_copyright" class="form-control" value="<?php echo $site_copyright; ?>">

</div>

</div>

</div><!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Site Timezone : </label>

<div class="col-md-6">

<select name="site_timezone" class="form-control site_logo_type" required="">

<?php foreach ($timezones as $key => $zone) { ?>

<option <?=($site_timezone == $zone)?"selected=''":""; ?> value="<?= $zone; ?>"><?= $zone; ?></option>

<?php } ?>

</select>

</div>

</div>
<!--- form-group row Ends --->


<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Google Recaptcha Site Key : <br/>
    
<small><a target="_blank" href="http://help.gigtodoscript.com/knowledge/details/9/How-to-get-Google-Recaptcha-site-and-secret-key.html" class="text-success">How To?</a></small>    
</label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon"> <b><i class="fa fa-key"></i></b> </span>

<input type="text" name="recaptcha_site_key" class="form-control" value="<?php echo $recaptcha_site_key; ?>">

</div>

</div>

</div><!--- form-group row Ends --->


<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Google Re captcha Secret Key  : <br/>
    
<small><a target="_blank" href="http://help.gigtodoscript.com/knowledge/details/9/How-to-get-Google-Recaptcha-site-and-secret-key.html" class="text-success">How To?</a></small>

</label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon"> <b><i class="fa fa-key"></i></b> </span>

<input type="text" name="recaptcha_secret_key" class="form-control" value="<?php echo $recaptcha_secret_key; ?>">

</div>

</div>

</div><!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> JwPlayer Code : <br>
<small><a target="_blank" href="http://help.gigtodoscript.com/knowledge/details/3/.html" class="text-success">How To?</a></small>
</label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon">

<b><i class="fa fa-play"></i></b>

</span>

<input type="text" name="jwplayer_code" class="form-control" value="<?php echo $jwplayer_code; ?>">

</div>

</div>

</div>
<!--- form-group row Ends --->

<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Site Currency : </label>

<div class="col-md-6">

<select name="site_currency" class="form-control" required="">

<?php 

$get_currencies = $db->select("currencies");

while($row_currencies = $get_currencies->fetch()){

$id = $row_currencies->id;

$name = $row_currencies->name;

$symbol = $row_currencies->symbol;

?>

<option <?php if(@$site_currency == $id){ echo "selected"; } ?> value="<?php echo $id; ?>"> 

<?php echo $name . " ($symbol)"; ?> 

</option>

<?php } ?>

</select>

<small class="form-text text-muted">

Select Currency for the website.

</small>

</div>

</div><!--- form-group row Ends --->

<div class="form-group row" required=""><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Enable Referrals : </label>

<div class="col-md-6">

<select name="enable_referrals" class="form-control">

<?php if($enable_referrals == "yes"){ ?>

<option value="yes"> Yes </option>

<option value="no"> No </option>

<?php }elseif($enable_referrals == "no"){ ?>

<option value="no"> No </option>

<option value="yes"> Yes </option>

<?php } ?>

</select>

<small class="form-text text-muted">

Enable or disable referrals on the website.

</small>

</div>

</div><!--- form-group row Ends --->
    
<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Enable knowledge bank popup : </label>

<div class="col-md-6">

<select name="knowledge_bank" class="form-control" required="">

<?php if($knowledge_bank == "yes"){ ?>

<option value="yes"> Yes </option>

<option value="no"> No </option>

<?php }else{ ?>

<option value="no"> No </option>

<option value="yes"> Yes </option>

<?php } ?>

</select>

<small class="form-text text-muted">Enable or disable knowledge bank popup on the website.</small>

</div>

</div><!--- form-group row Ends --->
    
<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Payment for each referral : </label>

<div class="col-md-6">

<div class="input-group">
<!--- input-group Starts --->

<span class="input-group-addon">

<b>$</b>

</span>


<input type="number" name="referral_money" class="form-control" min="1" value="<?php echo $referral_money; ?>">

</div>
<!--- input-group Ends --->

<small class="form-text text-muted">

Amount to pay after a referral has been approved. <br>
<span class="text-danger font-weight-bold">NB:</span> Type in numbers only.
</small>

</div>

</div>
<!--- form-group row Ends --->

<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Order Auto Complete : </label>

<div class="col-md-6">

<div class="input-group"><!--- input-group Starts --->

<input type="number" name="order_auto_complete" class="form-control" min="1" value="<?php echo $order_auto_complete; ?>">
<span class="input-group-addon"><b>days</b></span>

</div><!--- input-group Ends --->

<small class="form-text text-muted">
No of days required for order to automatically completed. <br>
<span class="text-danger font-weight-bold">NB:</span> Type in numbers only.
</small>

</div>

</div><!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Enable Maintenance Mode : </label>

<div class="col-md-6">

<select name="enable_maintenance_mode" class="form-control" required="">

<?php if($enable_maintenance_mode == "yes"){ ?>

<option value="yes"> Yes </option>

<option value="no"> No </option>

<?php }elseif($enable_maintenance_mode == "no"){ ?>

<option value="no"> No </option>

<option value="yes"> Yes </option>

<?php } ?>

</select>

<small class="form-text text-muted">

Enable or Disable Maintenance Mode on the website.

</small>

</div>

</div>
<!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"></label>

<div class="col-md-6">

<input type="submit" name="general_settings_update" class="form-control btn btn-success" value="Update General Settings">

</div>

</div>
<!--- form-group row Ends --->



</form>
<!--- form Ends --->

</div>
<!--- card-body Ends --->

</div>
<!--- card mb-5 Ends --->

</div>
<!--- col-lg-12 Ends --->

</div>
<!--- 2 row Ends --->



<div class="row"><!--- 2 row Starts --->

<div class="col-lg-12"><!--- col-lg-12 Starts --->

<div class="card mb-5"><!--- card mb-5 Starts --->

<div class="card-header"><!--- card-header Starts --->

<h4 class="h4"> Seller Settings </h4>

</div><!--- card-header Ends --->

<div class="card-body"><!--- card-body Starts --->

<form method="post" enctype="multipart/form-data"><!--- form Starts --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Level One Seller Ratings : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon">

<b>%</b>

</span>

<input type="text" name="level_one_rating" class="form-control" value="<?php echo $level_one_rating; ?>">

</div>

<small class="form-text text-muted">

Positive ratings (in percentage) required to become a level one seller.

</small>

</div>

</div>
<!--- form-group row Ends --->



<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Level One Completed <br>Orders : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon">

<b><i class="fa fa-archive"></i></b>

</span>

<input type="text" name="level_one_orders" class="form-control" value="<?php echo $level_one_orders; ?>">

</div>

<small class="form-text text-muted">
No. of orders required to be completed to become level one seller.
</small>

</div>

</div>
<!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Level Two Seller Ratings: </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon"><b>%</b></span>

<input type="text" name="level_two_rating" class="form-control" value="<?php echo $level_two_rating; ?>">

</div>

<small class="form-text text-muted">
Positive ratings (in percentage) required to become a level two seller.
</small>

</div>

</div>
<!--- form-group row Ends --->



<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Level Two Seller Completed Orders: </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon">

<b><i class="fa fa-archive"></i></b>

</span>

<input type="text" name="level_two_orders" class="form-control" value="<?php echo $level_two_orders; ?>">

</div>

<small class="form-text text-muted">
No. of orders required to be completed to become level two seller.
</small>

</div>

</div>
<!--- form-group row Ends --->



<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Top Rated Seller Ratings : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon"><b>%</b></span>

<input type="text" name="level_top_rating" class="form-control" value="<?php echo $level_top_rating; ?>">

</div>

<small class="form-text text-muted">
Positive ratings (in percentage) required to become a top rated seller.
</small>

</div>

</div>
<!--- form-group row Ends --->



<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Top Rated Seller Completed Orders : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon">

<b><i class="fa fa-archive"></i></b>

</span>

<input type="text" name="level_top_orders" class="form-control" value="<?php echo $level_top_orders; ?>">

</div>

<small class="form-text text-muted">
No. of orders required to be completed to become top rated seller.
</small>

</div>

</div>
<!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Manually Approve Proposals : </label>

<div class="col-md-6">

<select name="approve_proposals" class="form-control" required="">

<?php if($approve_proposals == "yes"){ ?>

<option value="yes"> Yes </option>

<option value="no"> No </option>

<?php }elseif($approve_proposals == "no"){ ?>

<option value="no"> No </option>

<option value="yes"> Yes </option>

<?php } ?>

</select>

<small class="form-text text-muted"> &nbsp; </small>

</div>

</div>
<!--- form-group row Ends --->



<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Send Confirmation Email After Sign Up : </label>

<div class="col-md-6">

<select name="signup_email" class="form-control" required="">

<?php if($signup_email == "yes"){ ?>

<option value="yes"> Yes </option>

<option value="no"> No </option>

<?php }elseif($signup_email == "no"){ ?>

<option value="no"> No </option>

<option value="yes"> Yes </option>

<?php } ?>

</select>

<small class="form-text text-muted">&nbsp;</small>

</div>

</div>
<!--- form-group row Ends --->


<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> New Proposal Email : </label>

<div class="col-md-6">

<select name="proposal_email" class="form-control" required="">

<?php if($proposal_email == "yes"){ ?>
<option value="yes">Yes</option>
<option value="no">No</option>
<?php }elseif($proposal_email == "no"){ ?>
<option value="no">No</option>
<option value="yes">Yes</option>
<?php } ?>

</select>

<small class="form-text text-muted">When enabled (yes) each time a user publishes a proposal, admin will be notified.</small>

</div>

</div><!--- form-group row Ends --->


<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Buyer Requests : </label>

<div class="col-md-6">

<select name="relevant_requests" class="form-control" required="">

<?php if($relevant_requests == "yes"){ ?>
<option value="yes">Show Relevant Buyer Requests To Sellers</option>
<option value="no">Show All Buyer Requests To Sellers</option>
<?php }elseif($relevant_requests == "no"){ ?>
<option value="no">Show All Buyer Requests To Sellers</option>
<option value="yes">Show Relevant Buyer Requests To Sellers</option>
<?php } ?>

</select>

<small class="form-text text-muted">&nbsp;</small>

</div>

</div><!--- form-group row Ends --->


<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"></label>

<div class="col-md-6">

<input type="submit" name="seller_settings_update" class="form-control btn btn-success" value="Update Seller Settings">

</div>

</div><!--- form-group row Ends --->


</form><!--- form Ends --->

</div><!--- card-body Ends --->

</div><!--- card mb-5 Ends --->

</div><!--- col-lg-12 Ends --->

</div><!--- 2 row Ends --->



<div class="row">
<!--- 2 row Starts --->

<div class="col-lg-12">
<!--- col-lg-12 Starts --->

<div class="card mb-5">
<!--- card mb-5 Starts --->

<div class="card-header">
<!--- card-header Starts --->

<h4 class="h4"><i class="fa fa-facebook-square" style="color:blue" aria-hidden="true"></i> <i  style="color:red" class="fa fa-google-plus-square" aria-hidden="true"></i> Social Media Login Settings </h4>

</div>
<!--- card-header Ends --->

<div class="card-body">
<!--- card-body Starts --->

<form method="post" enctype="multipart/form-data">
<!--- form Starts --->

<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Enable Social Login : </label>

<div class="col-md-6">

<select name="enable_social_login" class="form-control" required="">

<?php if($enable_social_login == "yes"){ ?>

<option value="yes"> Yes </option>

<option value="no"> No </option>

<?php }elseif($enable_social_login == "no"){ ?>

<option value="no"> No </option>

<option value="yes"> Yes </option>

<?php } ?>

</select>

<small class="form-text text-muted">

Enable or disable social media on the website.
</small>

</div>

</div>
<!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Facebook App Id :

<small><a target="_blank" href="http://help.gigtodoscript.com/knowledge/details/6/.html" class="text-success">How To?</a></small>


</label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon">

<b><i class="fa fa-facebook"></i></b>

</span>

<input type="text" name="fb_app_id" class="form-control" value="<?php echo $fb_app_id; ?>">

</div>

</div>

</div>
<!--- form-group row Ends --->



<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Facebook App Secret : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon">

<b><i class="fa fa-facebook"></i></b>

</span>

<input type="text" name="fb_app_secret" class="form-control" value="<?php echo $fb_app_secret; ?>">

</div>

</div>

</div>
<!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Google Client Id : 

<small><a target="_blank" href="http://help.gigtodoscript.com/knowledge/details/7/.html" class="text-success">How To?</a></small>


</label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon">

<b><i class="fa fa-google"></i></b>

</span>

<input type="text" name="g_client_id" class="form-control" value="<?php echo $g_client_id; ?>">

</div>

</div>

</div>
<!--- form-group row Ends --->


<div class="form-group row">
<!--- form-group row Starts --->

<label class="col-md-3 control-label"> Google Client Secret : </label>

<div class="col-md-6">

<div class="input-group">

<span class="input-group-addon">

<b><i class="fa fa-google"></i></b>

</span>

<input type="text" name="g_client_secret" class="form-control" value="<?php echo $g_client_secret; ?>">

</div>

</div>

</div>
<!--- form-group row Ends --->


<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"></label>

<div class="col-md-6">

<input type="submit" name="social_settings_update" class="form-control btn btn-success" value="Update Social Login Settings">

</div>

</div><!--- form-group row Ends --->


</form>
<!--- form Ends --->

</div>
<!--- card-body Ends --->

</div>
<!--- card mb-5 Ends --->

</div>
<!--- col-lg-12 Ends --->

</div>
<!--- 2 row Ends --->

<script>
$(document).ready(function(){
	<?php if($site_logo_type == "text"){ ?>
	$('.site_logo_image').hide();
	<?php }else{ ?>
	$('.site_logo_text').hide();
	<?php } ?>
	$(".site_logo_type").change(function(){
		var value = $(this).val();
		if(value == "text"){
			$('.site_logo_image').hide();
			$('.site_logo_text').show();
		}else if(value == "image"){
			$('.site_logo_text').hide();
			$('.site_logo_image').show();
		}
	});
});
</script>

<?php

if(isset($_POST['general_settings_update'])){
	$site_title = $input->post('site_title');
	$site_www = $input->post('site_www');
  $wish_do_manual_payouts = $input->post('wish_do_manual_payouts');


	$site_name = $input->post('site_name');
	$site_logo_type = $input->post('site_logo_type');
	$site_logo_text = $input->post('site_logo_text');
	$site_desc = $input->post('site_desc');
	$site_keywords = $input->post('site_keywords');
	$site_author = $input->post('site_author');
	$site_url = $input->post('site_url');
	$site_email_address = $input->post('site_email_address');
	$site_copyright = $input->post('site_copyright');
  $site_timezone = $input->post('site_timezone');
	$site_currency = $input->post('site_currency');
	$recaptcha_site_key = $input->post('recaptcha_site_key');
	$recaptcha_secret_key = $input->post('recaptcha_secret_key');
	$jwplayer_code = $input->post('jwplayer_code');
	$level_one_rating = $input->post('level_one_rating');
	$enable_referrals = $input->post('enable_referrals');
	$knowledge_bank = $input->post('knowledge_bank');
	$referral_money = $input->post('referral_money');
	$enable_maintenance_mode = $input->post('enable_maintenance_mode');
	$order_auto_complete = $input->post('order_auto_complete');
	$site_favicon = $_FILES['site_favicon']['name'];
	$site_favicon_tmp = $_FILES['site_favicon']['tmp_name'];
	$site_logo = $_FILES['site_logo']['name'];
	$site_logo_tmp = $_FILES['site_logo']['tmp_name'];
	$site_logo_image = $_FILES['site_logo_image']['name'];
	$site_logo_image_tmp = $_FILES['site_logo_image']['tmp_name'];
	$favicon_extension = pathinfo($site_favicon, PATHINFO_EXTENSION);
	$logo_extension = pathinfo($site_logo, PATHINFO_EXTENSION);
	$logo_image_extension = pathinfo($site_logo_image, PATHINFO_EXTENSION);
	$allowed = array('jpeg','jpg','gif','png','tif','ico','webp');

	if(!in_array($favicon_extension,$allowed) & !empty($site_favicon) or !in_array($logo_extension,$allowed) & !empty($site_logo) or !in_array($logo_image_extension,$allowed) & !empty($site_logo_image)){
		echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
	}else{
		if(empty($site_favicon)){
			$site_favicon = $s_favicon;
		}
		if(empty($site_logo)){
			$site_logo = $s_logo;
		}
		if(empty($site_logo_image)){
			$site_logo_image = $s_logo_image;
		}
		move_uploaded_file($site_favicon_tmp,"../images/$site_favicon");
		move_uploaded_file($site_logo_tmp,"../images/$site_logo");
		move_uploaded_file($site_logo_image_tmp,"../images/$site_logo_image");

		$update_general_settings = $db->update("general_settings",array("site_title" => $site_title,"site_www" => $site_www,"site_name" => $site_name,"site_favicon" => $site_favicon,"site_logo_type" => $site_logo_type,"site_logo_text" => $site_logo_text,"site_logo_image" => $site_logo_image,"site_logo" => $site_logo,"site_desc" => $site_desc,"site_keywords" => $site_keywords,"site_author" => $site_author,"site_url" => $site_url,"site_email_address" => $site_email_address,"site_copyright" => $site_copyright,"site_timezone"=>$site_timezone,"site_currency" => $site_currency,"recaptcha_site_key" => $recaptcha_site_key,"recaptcha_secret_key" => $recaptcha_secret_key,"jwplayer_code" => $jwplayer_code,"approve_proposals" => $approve_proposals,"enable_referrals" => $enable_referrals,"knowledge_bank" => $knowledge_bank,"referral_money" => $referral_money,"enable_maintenance_mode"=>$enable_maintenance_mode,"order_auto_complete" => $order_auto_complete,"wish_do_manual_payouts" => $wish_do_manual_payouts));

		if($update_general_settings){
			$insert_log = $db->insert_log($admin_id,"general_settings","","updated");
			if(updateHtaccess($site_www)){
				echo "<script>alert_success('General Settings has been updated successfully.','index?general_settings');</script>";
		  }
		}
	}
}

if(isset($_POST['seller_settings_update'])){
	$data = $input->post();
	unset($data['seller_settings_update']);
	$update_settings = $db->update("general_settings",$data);
	if($update_settings){
	 $insert_log = $db->insert_log($admin_id,"seller_settings","","updated");
	 echo "<script>alert_success('Seller Settings has been updated successfully.','index?general_settings');</script>";
	}
}

if(isset($_POST['social_settings_update'])){
	$enable_social_login = $input->post('enable_social_login');
	$fb_app_id = $input->post('fb_app_id');
	$fb_app_secret = $input->post('fb_app_secret');
	$g_client_id = $input->post('g_client_id');
	$g_client_secret = $input->post('g_client_secret');
	$update_social_settings = $db->update("general_settings",array("enable_social_login" => $enable_social_login, "fb_app_id" => $fb_app_id, "fb_app_secret" => $fb_app_secret, "g_client_id" => $g_client_id, "g_client_secret" => $g_client_secret));
	if($update_social_settings){
	$insert_log = $db->insert_log($admin_id,"social_login_settings","","updated");
	echo "<script>alert_success('Social Login Settings has been updated successfully.','index?general_settings');</script>";
	}
}

?>

<?php } ?>