<?php
session_start();
require_once("includes/db.php");
require_once("functions/processing_fee.php");
if(!isset($_SESSION['seller_user_name'])){
echo "<script>window.open('login','_self')</script>";
}
$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

$total = 0;
$select_cart = $db->select("cart",array("seller_id" => $login_seller_id));
while($row_cart = $select_cart->fetch()){
    $proposal_price = $row_cart->proposal_price;
    $proposal_qty = $row_cart->proposal_qty;
    $sub_total = $proposal_price * $proposal_qty;
    $total += $sub_total;
}
$processing_fee = processing_fee($total);

?>

<div class="col-md-7"><!--- col-md-7 Starts --->
<div class="card mb-3"><!--- card mb-3 Starts --->
<div class="card-body"><!--- card-body Starts --->
<?php

$select_cart = $db->select("cart",array("seller_id" => $login_seller_id));
while($row_cart = $select_cart->fetch()){
    $proposal_id = $row_cart->proposal_id;
    $proposal_price = $row_cart->proposal_price;
    $proposal_qty = $row_cart->proposal_qty;

    $select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));
    $row_proposals = $select_proposals->fetch();
    $proposal_title = $row_proposals->proposal_title;
    $proposal_url = $row_proposals->proposal_url;
    $proposal_img1 = $row_proposals->proposal_img1;
    $proposal_seller_id = $row_proposals->proposal_seller_id;

    $get_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));
    $row_seller = $get_seller->fetch();
    $proposal_seller_user_name = $row_seller->seller_user_name;

    $sub_total = $proposal_price * $proposal_qty;
?>

<div class="cart-proposal"><!--- cart-proposal Starts --->
<div class="row"><!--- row Starts --->
<div class="col-lg-3 mb-2"><!--- col-lg-3 mb-2 Starts --->
<a href="proposals/<?php echo $proposal_url; ?>">
<img src="proposals/proposal_files/<?php echo $proposal_img1; ?>" class="img-fluid">
</a>
</div><!--- col-lg-3 mb-2 Ends --->
<div class="col-lg-9"><!--- col-lg-9 Starts --->
<a href="proposals/<?php echo $proposal_url; ?>">
<h6 class="make-black"> <?php echo $proposal_title; ?> </h6>
</a>
<a href="cart?remove_proposal=<?php echo $proposal_id; ?>" class="remove-link text-muted">
<i class="fa fa-times"></i> Remove Proposal
</a>
</div><!--- col-lg-9 Ends --->
</div><!--- row Ends --->
<hr>
<h6 class="clearfix">
Proposal/Service Quantity
<strong class="float-right price ml-2 mt-2"> <?php echo $s_currency; ?><?php echo $sub_total; ?> </strong>
<input type="text" name="quantity" class="float-right form-control quantity" min="1" data-proposal_id="<?php echo $proposal_id; ?>" value="<?php echo $proposal_qty; ?>">
</h6>
<hr>
</div><!--- cart-proposal Ends --->

<?php } ?>

<h3 class="float-right"> Total : <?php echo $s_currency; ?><?php echo $total; ?> </h3>

</div><!--- card-body Ends --->

</div><!--- card mb-3 Ends --->

</div><!--- col-md-7 Ends --->

<div class="col-md-5"><!--- col-md-5 Starts --->
  <div class="card">
    <div class="card-body cart-order-details">
      <p>Cart Subtotal <span class="float-right"><?php echo $s_currency; ?><?php echo $total; ?></span></p>
      <hr>
      <p>Apply Coupon Code</p>
      <form class="input-group" method="post">
      <input type="text" name="code" class="form-control apply-disabled" placeholder="Enter Coupon Code">
      <button type="submit" name="coupon_submit" class="input-group-addon btn btn-success">Apply</button>
      </form>
      <?php
      $coupon_usage = "no";
      if(isset($_POST['coupon_submit'])){
        $coupon_code = $input->post('code');
        $select_coupon = $db->select("coupons",array("coupon_code"=>$coupon_code));
        $count_coupon = $select_coupon->rowCount();
        if($count_coupon == 1){
          $row_coupon = $select_coupon->fetch();
          $coupon_proposal = $row_coupon->proposal_id;
          $coupon_limit = $row_coupon->coupon_limit;
          $coupon_used = $row_coupon->coupon_used;
          $coupon_price = $row_coupon->coupon_price;
          $coupon_type = $row_coupon->coupon_type;
          if($coupon_limit <= $coupon_used){
            $coupon_usage = "expired";
            echo "
            <script>
            $('.coupon-response').html('Your coupon code expired.').attr('class','coupon-response p-2 mt-3 bg-danger text-white');
            </script>";
          }else{
            $select_cart = $db->select("cart",array("proposal_id" => $coupon_proposal,"seller_id" => $login_seller_id,"coupon_used" => 0));
            $count_cart = $select_cart->rowCount();
            if($count_cart == 1){
              if($coupon_type == "fixed_price"){
                $coupon_price = $coupon_price;
              }else{
                $row_cart = $select_cart->fetch();
                $proposal_price = $row_cart->proposal_price;
                $numberToAdd = ($proposal_price / 100) * $coupon_price;
                $coupon_price = $proposal_price - $numberToAdd;
              }
              $update_coupon = $db->query("update coupons set coupon_used=coupon_used+1 where coupon_code=:c_code",array("c_code"=>$coupon_code));
              $update_cart = $db->update("cart",array("proposal_price" => $coupon_price,"coupon_used" => 1),array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));
              $coupon_usage = "used";
              echo "<script>window.open('cart?coupon_applied','_self')</script>";
            }else{
              $coupon_usage = "not_apply";
            }
          }
        }else{
          $coupon_usage = "not_valid"; 
        }
      }
      ?>
      <hr>
      <?php if($coupon_usage == "not_valid"){ ?>
      <p class="coupon-response mt-2 p-2 bg-danger text-white"> Your Coupon Code Is Not Valid. </p>
      <?php }elseif($coupon_usage == "no" & isset($_GET['coupon_applied'])){ ?>
      <p class="coupon-response mt-2 p-2 bg-success text-white">Your coupon code has been applied successfully.</p>
      <?php }elseif($coupon_usage == "expired"){ ?>
      <p class="coupon-response mt-2 p-2 bg-danger text-white"> Your Coupon Code Is Expired. </p>
      <?php }elseif($coupon_usage == "not_apply"){ ?>
      <p class="coupon-response mt-2 p-2 bg-success text-white"> Your coupon code does not apply to proposal/service in your cart. </p>
      <?php } ?>
      <?php if($coupon_usage != "no"){ ?>
      <hr>
      <?php } ?>
      <p>Processing Fee <span class="float-right"><?php echo $s_currency; ?><?php echo $processing_fee; ?></span></p>
      <hr>
      <p>Total<span class="font-weight-bold float-right"><?php echo $s_currency; ?><?php echo $total + $processing_fee; ?> </span></p>
      <hr>
      <a href="cart_payment_options" class="btn btn-lg btn-success btn-block">Proceed To Payment</a>
    </div>
  </div>
</div><!--- col-md-5 Ends --->