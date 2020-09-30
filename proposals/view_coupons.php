<?php
session_start();
require_once("../includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('../login','_self')</script>";
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;
$login_seller_vacation = $row_login_seller->seller_vacation;
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
<head>
  <title><?php echo $site_name; ?> - View My Proposals.</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $site_desc; ?>">
  <meta name="keywords" content="<?php echo $site_keywords; ?>">
  <meta name="author" content="<?php echo $site_author; ?>">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
  <link href="../styles/bootstrap.css" rel="stylesheet">
    <link href="../styles/custom.css" rel="stylesheet"> <!-- Custom css code from modified in admin panel --->
  <link href="../styles/styles.css" rel="stylesheet">
  <link href="../styles/user_nav_styles.css" rel="stylesheet">
  <link href="../font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="../styles/owl.carousel.css" rel="stylesheet">
  <link href="../styles/owl.theme.default.css" rel="stylesheet">
  <script type="text/javascript" src="../js/jquery.min.js"></script>
    <link href="../styles/sweat_alert.css" rel="stylesheet">
    <link href="../styles/animate.css" rel="stylesheet">
    <script type="text/javascript" src="../js/ie.js"></script>
    <script type="text/javascript" src="../js/sweat_alert.js"></script>
  <script src="https://checkout.stripe.com/checkout.js"></script>
  <?php if(!empty($site_favicon)){ ?>
    <link rel="shortcut icon" href="../images/<?php echo $site_favicon; ?>" type="image/x-icon">
    <?php } ?>
</head>
<body class="is-responsive">
<?php require_once("../includes/user_header.php"); ?>
<div class="container"><!-- container-fluid Starts -->
<div class="row"><!-- row Starts -->
<div class="col-lg-12 col-md-12 mt-5 mb-5"><!-- col-lg-10 col-md-10 mt-5 mb-5 Starts -->
<div class="card rounded-0"><!-- card rounded-0 Starts -->
<div class="card-body pt-4"><!-- card-body Starts -->
<h2 class="mb-0 float-left"> <?php echo $lang['titles']['view_coupons']; ?> </h2>
<p class="lead float-right">
<button class="btn btn-success" data-toggle="modal" data-target="#add"><i class="fa fa-plus-circle"></i> Add New Coupon</button>
</p>
<div class="clearfix mb-2"></div>
<div class="table-responsive border border-secondary rounded" style="min-height: 200px;"><!-- table-responsive border border-secondary rounded Starts -->
<table class="table table-hover"><!-- table table-hover Starts -->
<thead>
<tr align="center" class="card-header">
<th>Coupon Title</th>
<th>Coupon Code</th>
<th>Coupon Price</th>
<th>Coupon Limit</th>
<th>Coupon Used</th>
<th>Coupon Actions</th>
</tr>
</thead>
<tbody>
<?php
$i = 0;
$proposal_id = $_GET['proposal_id'];
$get_coupons = $db->select("coupons",array("proposal_id"=>$proposal_id));
$count_coupons = $get_coupons->rowCount();
if($count_coupons == 0){
echo "<td colspan='6' align='center'><h5>You Have Not Created Any Coupons Of This Proposal Yet.</h5></td>";
}
while($row_coupons = $get_coupons->fetch()){
$coupon_id = $row_coupons->coupon_id;
$coupon_title = $row_coupons->coupon_title;
$coupon_type = $row_coupons->coupon_type;
$coupon_price = $row_coupons->coupon_price;
$coupon_code = $row_coupons->coupon_code;
$coupon_limit = $row_coupons->coupon_limit;
$coupon_used = $row_coupons->coupon_used;
$proposal_id = $row_coupons->proposal_id;
?>
<tr align="center">
<td><?php echo $coupon_title; ?></td>
<td><?php echo $coupon_code; ?></td>
<td>
<?php if($coupon_type == "fixed_price"){ ?>
<?= $s_currency.$coupon_price; ?>
<?php }else{ ?>
%<?= $coupon_price; ?>
<?php } ?>
</td>
<td><?php echo $coupon_limit; ?></td>
<td><?php echo $coupon_used; ?></td>
<td>
<div class="dropdown"><!--- dropdown Starts --->
<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">Actions</button>
<div class="dropdown-menu"><!--- dropdown-menu Starts --->
<a class="dropdown-item" data-toggle="modal" href="#" data-target="#edit-<?php echo $coupon_id; ?>">
<i class="fa fa-pencil-alt"></i> Edit
</a>
<a class="dropdown-item" href="view_coupons?proposal_id=<?php echo $proposal_id; ?>&delete_coupon=<?php echo $coupon_id; ?>">
<i class="fa fa-trash-alt"></i> Delete
</a>
</div><!--- dropdown-menu Ends --->
</div><!--- dropdown Ends --->
</td>
</tr>
<div id="edit-<?php echo $coupon_id; ?>" class="modal fade" ><!-- edit modal fade Starts -->
<div class="modal-dialog"><!-- modal-dialog Starts -->
<div class="modal-content"><!-- modal-content Starts -->
<div class="modal-header"><!-- modal-header Starts -->
<h5 class="modal-title"> Edit Coupon </h5> 
<button class="close" data-dismiss="modal"> <span> &times; </span> </button>
</div><!-- modal-header Ends -->
<div class="modal-body"><!-- modal-body Starts -->
<form action="" method="post"><!--- form Starts --->
<input type="hidden" name="coupon_id" value="<?php echo $coupon_id; ?>">
<div class="form-group row"><!--- form-group row Starts --->
<label class="col-md-4 control-label"> Coupon Title : </label>
<div class="col-md-8">
<input type="text" name="coupon_title" class="form-control" required value="<?php echo $coupon_title; ?>">
</div>
</div><!--- form-group row Ends --->
<div class="form-group row"><!--- form-group row Starts --->
<label class="col-md-4 control-label"> Coupon Price : </label>
<div class="col-md-8">
<input type="number" name="coupon_price" class="form-control" value="<?php echo $coupon_price; ?>" min="1" required>
</div>
</div><!--- form-group row Ends --->
<div class="form-group row"><!--- form-group row Starts --->
<label class="col-md-4 control-label"> Coupon Price : </label>
<div class="col-md-4 pr-0">
<select name="coupon_type" class="coupon-type form-control">
<?php if($coupon_type == "fixed_price"){ ?>
<option value="fixed_price"> Fixed Price </option>
<option value="discount_price"> Discount Percentage </option>
<?php }else{ ?>
<option value="discount_price"> Discount Percentage </option>
<option value="fixed_price"> Fixed Price </option>
<?Php } ?>
</select>
</div>
<div class="col-md-4">
<div class="input-group">
<?php if($coupon_type == "fixed_price"){ ?>
<span class="input-group-addon">
<b><?php echo $s_currency; ?></b>
</span>
<input type="number" name="coupon_price" class="form-control" value="<?php echo $coupon_price; ?>" min="1" required>
<?php }else{ ?> 
<span class="input-group-addon"><b>%</b></span>
<input type="number" name="coupon_price" class="form-control" value="<?php echo $coupon_price; ?>" min="1" required>
<?php } ?>
</div>
</div>
</div><!--- form-group row Ends --->
<div class="form-group row"><!--- form-group row Starts --->
<label class="col-md-4 control-label"> Coupon Code : </label>
<div class="col-md-8">
<input type="text" name="coupon_code" class="form-control" required value="<?php echo $coupon_code; ?>">
</div>
</div><!--- form-group row Ends --->
<div class="form-group row"><!--- form-group row Starts --->
<label class="col-md-4 control-label"> Coupon Limit : </label>
<div class="col-md-8">
<input type="number" name="coupon_limit" class="form-control" value="<?php echo $coupon_limit; ?>" min="1">
</div>
</div><!--- form-group row Ends --->
<div class="form-group row"><!--- form-group row Starts --->
<label class="col-md-4 control-label"></label>
<div class="col-md-8">
<input type="submit" name="update" class="btn btn-success form-control" value="Update Coupon">
</div>
</div><!--- form-group row Ends --->
</form><!--- form Ends --->
</div><!-- modal-body Ends -->
</div><!-- modal-content Ends -->
</div><!-- modal-dialog Ends -->
</div><!-- edit modal fade Ends -->
<?php  
}
?>
</tbody>
</table><!-- table table-hover Ends -->
</div><!-- table-responsive border border-secondary rounded Ends -->
</div><!-- card-body Ends -->
</div><!-- card rounded-0 Ends -->
</div><!-- col-lg-10 col-md-10 mt-5 mb-5 Ends -->
</div><!-- row Ends -->
</div><!-- container-fluid Ends -->
<div id="add" class="modal fade" ><!-- edit modal fade Starts -->
<div class="modal-dialog"><!-- modal-dialog Starts -->
<div class="modal-content"><!-- modal-content Starts -->
<div class="modal-header"><!-- modal-header Starts -->
<h5 class="modal-title"> Add Coupon </h5> 
<button class="close" data-dismiss="modal"> <span> &times; </span> </button>
</div><!-- modal-header Ends -->
<div class="modal-body"><!-- modal-body Starts -->
<form action="" method="post"><!--- form Starts --->
<div class="form-group row"><!--- form-group row Starts --->
<label class="col-md-4 control-label"> Coupon Title : </label>
<div class="col-md-8">
<input type="text" name="coupon_title" class="form-control" required>
</div>
</div><!--- form-group row Ends --->
<div class="form-group row"><!--- form-group row Starts --->
  <label class="col-md-4 control-label"> Coupon Price : </label>
  <div class="col-md-4 pr-0"><!--- col-md-4 Starts --->
    <select name="coupon_type" class="coupon-type form-control" required>
      <option value="fixed_price"> Fixed Price </option>
      <option value="discount_price"> Discount Percentage </option>
    </select>
  </div><!--- col-md-4 Ends --->
  <div class="col-md-4"><!--- col-md-4 Starts --->
   <div class="input-group">
      <span class="input-group-addon"> <b><?php echo $s_currency; ?></b> </span>
      <input type="number" name="coupon_price" class="form-control" value="1" min="1" required>
   </div>  
  </div><!--- col-md-4 Ends --->
</div><!--- form-group row Ends --->
<div class="form-group row"><!--- form-group row Starts --->
<label class="col-md-4 control-label"> Coupon Code : </label>
<div class="col-md-8">
<input type="text" name="coupon_code" class="form-control" required>
</div>
</div><!--- form-group row Ends --->
<div class="form-group row"><!--- form-group row Starts --->
<label class="col-md-4 control-label"> Coupon Limit : </label>
<div class="col-md-8">
<input type="number" name="coupon_limit" class="form-control" value="1" min="1">
</div>
</div><!--- form-group row Ends --->
<div class="form-group row"><!--- form-group row Starts --->
<label class="col-md-4 control-label"></label>
<div class="col-md-8">
<input type="submit" name="add" class="btn btn-success form-control" value="Insert Coupon">
</div>
</div><!--- form-group row Ends --->
</form><!--- form Ends --->
</div><!-- modal-body Ends -->
</div><!-- modal-content Ends -->
</div><!-- modal-dialog Ends -->
</div><!-- edit modal fade Ends -->
<?php 
if(isset($_GET['delete_coupon'])){
$delete_id = $_GET['delete_coupon'];
$delete_coupon = $db->delete("coupons",array('coupon_id' => $delete_id));
if($delete_coupon){
    echo "
    <script>
      swal.fire({
      type: 'success',
      timer : 2000,
      text: 'One Coupon Code Has been Deleted.',
      onOpen: function(){
        swal.showLoading()
      }
      }).then(function(){
        window.open('view_coupons?proposal_id=$proposal_id','_self');
      });
    </script>";
}
}
if(isset($_POST['update'])){
$coupon_id = $input->post('coupon_id');
$coupon_code = $input->post('coupon_code');
$check_coupons = $db->query("select * from coupons where coupon_code=:c_code AND NOT coupon_id=:c_id",array("c_code"=>$coupon_code,"c_id"=>$coupon_id))->rowCount();
if($check_coupons == 1){
echo "<script>
Swal.fire('','Coupon Code Has Been Applied Already.','error');
</script>";
}else{
$data = $input->post();
unset($data['update']);
$update_coupon = $db->update("coupons",$data,array("coupon_id"=>$coupon_id));
if($update_coupon){
    echo "
    <script>
      swal.fire({
      type: 'success',
      timer : 2000,
      text: 'One Coupon Code Has been Updated.',
      onOpen: function(){
        swal.showLoading()
      }
      }).then(function(){
        window.open('view_coupons?proposal_id=$proposal_id','_self');
      });
    </script>";
}
}
} 
if(isset($_POST['add'])){
$coupon_code = $input->post('coupon_code');
$data = $input->post();
unset($data['add']);
$check_coupons = $db->count("coupons",array("coupon_code" => $coupon_code));
if($check_coupons == 1){
echo "<script>
Swal.fire('','Coupon Code Has Been Applied Already.','error');
</script>";
}else{
$data['proposal_id'] = $proposal_id;
$insert_coupon = $db->insert("coupons",$data);
if($insert_coupon){
    echo "
    <script>
      swal.fire({
      type: 'success',
      timer : 2000,
      text: 'One Coupon Code Has been Inserted.',
      onOpen: function(){
        swal.showLoading()
      }
      }).then(function(){
        window.open('view_coupons?proposal_id=$proposal_id','_self');
      });
    </script>";
} 
}
}
?>
 <script>
  $(document).ready(function(){
    $('.coupon-type').change(function(){
      if($(this).val() == 'fixed_price'){ 
          $('.input-group-addon b').html('$');
      }
      if($(this).val() == 'discount_price'){ 
          $('.input-group-addon b').html('%');
      }
    });
  });
  </script>
<?php include("../includes/footer.php"); ?>
</body>
</html>