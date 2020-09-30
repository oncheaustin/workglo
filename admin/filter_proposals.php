<?php

session_start();

include("includes/db.php");

if(!isset($_SESSION['admin_email'])){
	
echo "<script>window.open('login','_self');</script>";
	
}

if((time() - $_SESSION['loggedin_time']) > 3600){
	
echo "<script>window.open('logout.php?session_expired','_self');</script>";
	
}


if(!$_SESSION['adminLanguage']){

$_SESSION['adminLanguage'] = 1;

}

$adminLanguage = $_SESSION['adminLanguage'];

$row_language = $db->select("languages",array("id"=>$adminLanguage))->fetch();

$currentLanguage = $row_language->title;


$admin_email = $_SESSION['admin_email'];

$get_admin = $db->query("select * from admins where admin_email=:a_email OR admin_user_name=:a_user_name",array("a_email"=>$admin_email,"a_user_name"=>$admin_email));

$row_admin = $get_admin->fetch();

$admin_id = $row_admin->admin_id;

$login_admin_id = $row_admin->admin_id;

$admin_name = $row_admin->admin_name;

$admin_user_name = $row_admin->admin_user_name;

$admin_image = $row_admin->admin_image;

$admin_country = $row_admin->admin_country;

$admin_job = $row_admin->admin_job;

$admin_contact = $row_admin->admin_contact;

$admin_about = $row_admin->admin_about;


$count_sellers = $db->count("sellers");

$count_orders = $db->count("orders",array("order_active" => "yes"));

$count_proposals = $db->count("proposals",array("proposal_status" => "pending"));

$count_support_tickets = $db->count("support_tickets",array("status" => "open"));

$count_requests = $db->count("buyer_requests",array("request_status" => "pending"));

$count_referrals = $db->count("referrals",array("status" => "pending"));

$count_proposals_referrals = $db->count("proposal_referrals",array("status" => "pending"));

?>
<!doctype html>

<html class="no-js">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Panel - Control Your Entire Site.</title>
    <meta name="description" content="With the GigToDoScript admin panel, controlling your website has never been eassier.">
    <meta name="author" content="GigToDoScript">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="../styles/custom.css" rel="stylesheet"> <!-- Custom css code from modified in admin panel --->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="assets/scss/style.css">
    <link href="assets/css/lib/vector-map/jqvmap.min.css" rel="stylesheet">

    <?php if(!empty($site_favicon)){ ?>
   
    <link rel="shortcut icon" href="../images/<?php echo $site_favicon; ?>" type="image/x-icon">
       
    <?php } ?>
    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    
    <link rel="stylesheet" href="assets/css/sweat_alert.css" >

    <script type="text/javascript" src="assets/js/ie.js"></script>
    <script type="text/javascript" src="assets/js/sweat_alert.js"></script>

    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
        
</head>

<body>

  <script src="assets/js/secret.js"></script>

  <script src="../js/jquery.min.js"></script>

    <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./"><?php echo $site_name; ?> <span class="badge badge-success p-2 font-weight-bold">ADMIN</span></a>
                <a class="navbar-brand hidden" href="./"><span class="badge badge-success pt-2 pb-2">A</span></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                
                <?php include("includes/sidebar.php"); ?>
                
                
            </div>
        </nav>
    </aside>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">
        

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <?php include("includes/admin_header.php"); ?>
                
                
            </div>

        </header>
        <!-- Header-->
        
<div class="container">
        
<div class="row"><!--- 1 row Starts --->

<div class="col-lg-12"><!--- col-lg-12 Starts --->

<div class="p-3 mb-3"><!--- p-3 mb-3 filter-form Starts --->

<h2 class="pb-4">Filter Proposals</h2>

<form class="form-inline pb-2" method="get" action="filter_proposals.php">

<div class="form-group">

<label> Delivery Time : </label>

<select name="delivery_id" required class="form-control mb-2 mr-sm-2 mb-sm-0">

<?php

$get_delivery_id = $input->get('delivery_id');


$get_delivery_times = $db->select("delivery_times");

while($row_delivery_times = $get_delivery_times->fetch()){

$delivery_id = $row_delivery_times->delivery_id;

$delivery_title = $row_delivery_times->delivery_title;
    
echo "<option ".($get_delivery_id == $delivery_id ? "selected" : "")." value='$delivery_id'>$delivery_title</option>";
    
}


?>

</select>

</div>

<div class="form-group">

<label> Seller Level : </label>

<select name="level_id" required class="form-control mb-2 mr-sm-2 mb-sm-0">

<?php

$get_level_id = $input->get('level_id');

$get_seller_levels = $db->select("seller_levels");

while($row_seller_levels = $get_seller_levels->fetch()){
    
$level_id = $row_seller_levels->level_id;

$level_title = $row_seller_levels->level_title;
    
echo "<option ".($get_level_id == $level_id ? "selected" : "")." value='$level_id'>$level_title</option>";
    
}


?>

</select>

</div>


<div class="form-group">

<label> Category : </label>

<select name="cat_id" required class="form-control mb-2 mr-sm-2 mb-sm-0">

<?php

$get_cat_id = $input->get('cat_id');

	
$get_categories = $db->select("categories");

while($row_categories = $get_categories->fetch()){
    
$cat_id = $row_categories->cat_id;

$get_meta = $db->select("cats_meta",array("cat_id" => $cat_id, "language_id" => $adminLanguage));

$cat_title = $get_meta->fetch()->cat_title;
    
echo "<option ".($get_cat_id == $cat_id ? "selected" : "")." value='$cat_id'>$cat_title</option>";

}

?>

</select>

</div>

<button type="submit" class="btn btn-success"> Filter</button>

</form>

</div><!--- p-3 mb-3 filter-form Ends --->

</div><!--- col-lg-12 Ends --->

</div><!--- 1 row Ends --->


<div class="row mt-3"><!--- 2 row mt-3 Starts --->

<div class="col-lg-12"><!--- col-lg-12 Starts --->

<div class="card"><!--- card Starts --->

<div class="card-header"><!--- card-header Starts --->

<h4 class="h4">View Proposals</h4>

</div><!--- card-header Ends --->

<div class="card-body"><!--- card-body Starts --->

<div class="table-responsive"><!--- table-responsive mt-4 Starts --->

<table class="table table-bordered"><!--- table table-hover table-bordered Starts --->

<thead><!--- thead Starts --->

<tr>

<th>Proposal's Title</th>

<th>Proposal's Display Image</th>

<th>Proposal's Price</th>

<th>Proposal's Category</th>

<th>Proposal's Order Queue</th>

<th>Proposal's Status</th>

<th>Proposal's Action Options</th>

</tr>

</thead><!--- thead Ends --->

<tbody><!--- tbody Starts --->

<?php


$get_proposals = $db->query("select * from proposals where delivery_id=:d_id or level_id=:l_id or proposal_cat_id=:c_id order by 1 DESC",array("d_id"=>$get_delivery_id,"l_id"=>$get_level_id,"c_id"=>$get_cat_id));

while($row_proposals = $get_proposals->fetch()){

$proposal_id = $row_proposals->proposal_id;

$proposal_title = $row_proposals->proposal_title;

$proposal_url = $row_proposals->proposal_url;

$proposal_price = $row_proposals->proposal_price;

$proposal_img1 = $row_proposals->proposal_img1;

$proposal_cat_id = $row_proposals->proposal_cat_id;

$proposal = $row_proposals->proposal_cat_id;

$proposal_seller_id = $row_proposals->proposal_seller_id;

$proposal_status = $row_proposals->proposal_status;

$proposal_seller_id = $row_proposals->proposal_seller_id;

$proposal_featured = $row_proposals->proposal_featured;

if($proposal_price == 0){

$proposal_price = "";

$get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id));

while($row = $get_p->fetch()){

$proposal_price .=" | $s_currency" . $row->price;

}

}else{

$proposal_price = "$s_currency" . $proposal_price;

}


$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

$seller_user_name = $select_seller->fetch()->seller_user_name;


$select_orders = $db->query("select * from orders where proposal_id='$proposal_id' AND NOT order_status='complete' AND proposal_id='$proposal_id' AND NOT order_status='cancelled'");

$proposal_order_queue = $select_orders->rowCount();


$get_meta = $db->select("cats_meta",array("cat_id" => $proposal_cat_id, "language_id" => $adminLanguage));

$cat_title = $get_meta->fetch()->cat_title;

?>

<tr>

<td><?php echo $proposal_title; ?></td>

<td>

<img src="../proposals/proposal_files/<?php echo $proposal_img1; ?>" width="70" height="60">

</td>

<td><?php echo $proposal_price; ?></td>

<td><?php echo $cat_title; ?></td>

<td><?php echo $proposal_order_queue; ?></td>

<td><?php echo ucfirst($proposal_status); ?></td>
<?php if($proposal_status == "active"){ ?>

<td>

<a title="View Proposal" href="../proposals/<?php echo $seller_user_name; ?>/<?php echo $proposal_url; ?>" target="_blank">

<i class="fa fa-eye"></i> 

</a>

<a <?php if($proposal_featured == "yes"){ ?> class="text-success" href="#" title="Proposal Already Featured" <?php }else{ ?> href="index?feature_proposal=<?php echo $proposal_id; ?>" title="Make Your Proposal Featured" <?php } ?>>

<i class="fa fa-star"></i>

</a>

<a title="Pause/Deactivate Proposal" href="index?pause_proposal=<?php echo $proposal_id; ?>">

<i class="fa fa-pause-circle"></i> 

</a>


<a title="Delete Proposal" href="index?move_to_trash=<?php echo $proposal_id; ?>">

<i class="fa fa-trash"></i>

</a>


</td>

<?php }elseif($proposal_status == "pause"){ ?>

<td>

<a title="View Proposal" href="../proposals/<?php echo $seller_user_name; ?>/<?php echo $proposal_url; ?>" target="_blank">

<i class="fa fa-eye"></i> Preview

</a>

<br>

<a href="index?unpause_proposal=<?php echo $proposal_id; ?>" >

<i class="fa fa-refresh"></i> Unpause 

</a>
    
<br>

<a href="index?move_to_trash=<?php echo $proposal_id; ?>">

<i class="fa fa-trash"></i> Trash Proposal

</a>

</td>

<?php }elseif($proposal_status == "pending"){ ?>

<td>

<a title="Decline this Proposal" href="index?decline_proposal=<?php echo $proposal_id; ?>">

<i class="fa fa-ban"></i> Decline

</a>

<br/>

<a href="index?approve_proposal=<?php echo $proposal_id; ?>">

<i class="fa fa-check-square-o"></i> Approve

</a>

<br/>
    
<a title="View Proposal" href="../proposals/<?php echo $seller_user_name; ?>/<?php echo $proposal_url; ?>" target="_blank">

<i class="fa fa-eye"></i> Preview

</a>

<br>

<a href="index?submit_modification=<?php echo $proposal_id; ?>">

<i class="fa fa-edit"></i> Submit For Modification

</a>

</td>

<?php }elseif($proposal_status == "declined"){ ?>

<td>

<a href="index?approve_proposal=<?php echo $proposal_id; ?>">

<i class="fa fa-check-square-o"></i> Approve

</a>

<br/>

<a href="index?submit_modification=<?php echo $proposal_id; ?>">

<i class="fa fa-edit"></i> Submit For Modification

</a>

<br>
    
<a title="View Proposal" href="../proposals/<?php echo $seller_user_name; ?>/<?php echo $proposal_url; ?>" target="_blank">

<i class="fa fa-eye"></i> Preview

</a>

<br/>

<a href="index?delete_proposal=<?php echo $proposal_id; ?>">

<i class="fa fa-trash"></i> Delete Permanently

</a>

</td>

<?php }elseif($proposal_status == "trash"){ ?>

<td>

<a href="index?restore_proposal=<?php echo $proposal_id; ?>">

<i class="fa fa-reply"></i> Restore Proposal

</a>

<br/>

<a href="index?delete_proposal=<?php echo $proposal_id; ?>">

<i class="fa fa-trash"></i> Delete Permanently

</a>

</td>

<?php } ?>


</tr>

<?php } ?>
    
</tbody><!--- tbody Ends --->

</table><!--- table table-hover table-bordered Ends --->

</div><!--- table-responsive mt-4 Ends --->



</div><!--- card-body Ends --->

</div><!--- card Ends --->

</div><!--- col-lg-12 Ends --->

</div><!--- 2 row mt-3 Ends --->

</div>       

<script>
$(document).ready(function(){

    $("#languageSelect").change(function(){
        var url = $("#languageSelect option:selected").data("url");
        window.location.href = url;
    });
});
</script>

</div><!-- Right Panel -->

<script src="assets/js/popper.min.js"></script>

<script src="assets/js/plugins.js"></script>

</body>
</html>
