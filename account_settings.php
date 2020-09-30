<?php
  @session_start();
  require_once("includes/db.php");
  if(!isset($_SESSION['seller_user_name'])){
  echo "<script>window.open('login','_self')</script>";
  }
  ?>
<h5 class="mb-4"> PayPal For Withdrawing Revenue  </h5>
<form method="post" class="clearfix mb-3">
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Enter Paypal Email </label>
    <div class="col-md-8">
      <input type="text" name="seller_paypal_email" value="<?php echo $login_seller_paypal_email; ?>" placeholder="Enter paypal email" class="form-control" required >
    </div>
  </div>
  <button type="submit" name="submit_paypal_email" class="btn btn-success <?= $floatRight ?>">Change Paypal Email</button>
</form>
<?php 
  if(isset($_POST['submit_paypal_email'])){
  $seller_paypal_email = strip_tags($input->post('seller_paypal_email'));
  $update_seller = $db->update("sellers",array("seller_paypal_email" => $seller_paypal_email),array("seller_id" => $login_seller_id));
  if($update_seller){
  echo "<script>
      swal({
        type: 'success',
        text: 'PayPal email updated successfully!',
        timer: 3000,
        onOpen: function(){
        swal.showLoading()
        }
        }).then(function(){
            if (
              // Read more about handling dismissals
              window.open('settings?account_settings','_self')
            ) {
              console.log('email updated successfully')
            }
          })
  </script>";
  }
  }
  ?>
<hr>
<h5 class="mb-4"> Payoneer For Withdrawing Revenue  </h5>
<form method="post" class="clearfix mb-3">
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Enter Payoneer Email </label>
    <div class="col-md-8">
      <input type="text" name="seller_payoneer_email" value="<?php echo $login_seller_payoneer_email; ?>" placeholder="Enter payoneer email" class="form-control" required >
    </div>
  </div>
  <button type="submit" name="submit_payoneer_email"class="btn btn-success <?= $floatRight ?>">Change Payoneer Email</button>
</form>
<?php 
  if(isset($_POST['submit_payoneer_email'])){
  $seller_payoneer_email = strip_tags($input->post('seller_payoneer_email'));
  $update_seller = $db->update("sellers",array("seller_payoneer_email" => $seller_payoneer_email),array("seller_id" => $login_seller_id));
  if($update_seller){
  echo "<script>
    swal({
      type: 'success',
      text: 'Payoneer email updated successfully!',
      timer: 3000,
      onOpen: function(){
      swal.showLoading()
      }
      }).then(function(){
          if (
            // Read more about handling dismissals
            window.open('settings?account_settings','_self')
          ) {
            console.log('email updated successfully')
          }
        })
  </script>";
  }
  }
  ?>
<hr>
<h5 class="mb-4"> Mobile Money For Withdrawing Revenue  </h5>
<form method="post" class="clearfix mb-3">
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Account Number </label>
    <div class="col-md-8">
      <input type="text" name="m_account_number" value="<?php echo $login_seller_account_number; ?>" placeholder="Enter Account Number" class="form-control" required>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Account/Owner Name </label>
    <div class="col-md-8">
      <input type="text" name="m_account_name" value="<?php echo $login_seller_account_name; ?>" placeholder="Enter Account/Owner Name" class="form-control" required>
    </div>
  </div>
  <button type="submit" name="update_mobile_money" class="btn btn-success <?= $floatRight ?>">Update Mobile Money</button>
</form>
<?php 
  if(isset($_POST['update_mobile_money'])){
  $m_account_number = strip_tags($input->post('m_account_number'));
  $m_account_name = strip_tags($input->post('m_account_name'));
  $update_seller = $db->update("sellers",array("seller_m_account_number" => $m_account_number,"seller_m_account_name" => $m_account_name),array("seller_id" => $login_seller_id));
  if($update_seller){
  echo "<script>
  swal({
  type: 'success',
  text: 'Mobile Money Updated Successfully!',
  timer: 3000,
  onOpen: function(){
  swal.showLoading()
  }
  }).then(function(){
  window.open('settings?account_settings','_self')
  });
  </script>";
  }
  }
  ?>
<hr>
<h5 class="mb-4"> Bitcoin Wallet For Withdrawing Revenue </h5>
<form method="post" class="clearfix mb-3">
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Wallet Address </label>
    <div class="col-md-8">
      <input type="text" name="seller_wallet" value="<?php echo $login_seller_wallet; ?>" placeholder="Enter Wallet Address" class="form-control"/>
      <small class="text-danger">! Warning You Only Need To Enter Your Bitcoin Wallet Address Not Any Other.</small>
    </div>
  </div>
  <button type="submit" name="submit_wallet" class="btn btn-success <?= $floatRight ?>">Update Wallet Address</button>
</form>
<?php
  if(isset($_POST['submit_wallet'])){
  $seller_wallet = $input->post('seller_wallet');
  $update_seller = $db->update("sellers",array("seller_wallet" => $seller_wallet),array("seller_id" => $login_seller_id));
  if($update_seller){
  echo "<script>
          swal({
            type: 'success',
            text: 'Wallet Address updated successfully!',
            timer: 3000,
            onOpen: function(){
            swal.showLoading()
            }
            }).then(function(){
            window.open('settings?account_settings','_self')
            });
        </script>";
  }
  }
  ?>
<hr>
<h5 class="mb-4"> REAL-TIME NOTIFICATIONS </h5>
<form method="post" class="clearfix">
  <div class="form-group row mb-3">
    <label class="col-md-4 col-form-label"> Enable/disable sound </label>
    <div class="col-md-8">
      <select name="enable_sound" class="form-control">
        <?php if($login_seller_enable_sound == "yes"){ ?>
        <option value="yes"> Yes </option>
        <option value="no"> No </option>
        <?php }elseif($login_seller_enable_sound == "no"){ ?>
        <option value="no"> No </option>
        <option value="yes"> Yes </option>
        <?php } ?>
      </select>
    </div>
  </div>
  <button type="submit" name="update_sound" class="btn btn-success mt-1 <?= $floatRight ?>">Update Changes</button>
</form>
<?php 
  if(isset($_POST['update_sound'])){
  $enable_sound = strip_tags($input->post('enable_sound'));
  $update_seller = $db->update("sellers",array("enable_sound"=>$enable_sound),array("seller_id"=>$login_seller_id));
  if($update_seller){
  echo "<script>
      swal({
      type: 'success',
      text: 'Realtime notifications settings updated successfully.',
      timer: 2000,
      onOpen: function(){
      swal.showLoading()
      }
      }).then(function(){
        window.open('settings?account_settings','_self')
      });
      </script>";
  }
  }
  ?>
<hr>
<h5 class="mb-4"> Change Password </h5>
<?php 
  $form_errors = Flash::render("change_pass_errors");
  $form_data = Flash::render("form_data");
  if(is_array($form_errors)){
  ?>
<div class="alert alert-danger">
  <!--- alert alert-danger Starts --->
  <ul class="list-unstyled mb-0">
    <?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
    <li class="list-unstyled-item"><?php echo $i ?>. <?php echo ucfirst($error); ?></li>
    <?php } ?>
  </ul>
</div>
<!--- alert alert-danger Ends --->
<?php } ?>
<form method="post" class="clearfix mb-3">
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Enter Old Password </label>
    <div class="col-md-8">
      <input type="text" name="old_pass" class="form-control" required="">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Enter New Password </label>
    <div class="col-md-8">
      <input type="text" name="new_pass" class="form-control" required="">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-4 col-form-label"> Confirm New Password </label>
    <div class="col-md-8">
      <input type="text" name="new_pass_again" class="form-control" required="">
    </div>
  </div>
  <button type="submit" name="change_password" class="btn btn-success <?= $floatRight ?>">Change Password</button>
</form>
<?php 
  if(isset($_POST['change_password'])){
  $rules = array(
  "old_pass" => "required",
  "new_pass" => "required",
  "new_pass_again" => "required");
  $messages = array("old_pass" => "Old Password Is Required.","new_pass" => "New Password Is Required.","new_pass_again"=>"New Password Again Is Required.");
  $val = new Validator($_POST,$rules,$messages);
  if($val->run() == false){
  Flash::add("change_pass_errors",$val->get_all_errors());
  Flash::add("form_data",$_POST);
  echo "<script> window.open('settings?account_settings','_self');</script>";
  }else{
  $old_pass = $input->post('old_pass');
  $new_pass = $input->post('new_pass');
  $new_pass_again = $input->post('new_pass_again');
  $get_seller = $db->select("sellers",array("seller_id"=>$login_seller_id));
  $row_seller = $get_seller->fetch();
  $hash_password = $row_seller->seller_pass;
  $decrypt_password = password_verify($old_pass,$hash_password);
  if($decrypt_password == 0){
  echo "<script>
        swal({
        type: 'warning',
        html: $('<div>').addClass('some-class').text('Your password is invalid. Please try again!'),
        animation: false,
        customClass: 'animated tada'
        });
        </script>";
  }else{
  if($new_pass!=$new_pass_again){
  echo "<script>alert(' Your New Password dose not match. ');</script>";
  }else{
  $encrypted_password = password_hash($new_pass, PASSWORD_DEFAULT);
  $update_pass = $db->update("sellers",array("seller_pass" => $encrypted_password),array("seller_id" => $login_seller_id));
  echo "<script>
        swal({
          type: 'success',
          text: 'Password updated successfully. Login with your new password.',
          timer: 3000,
          onOpen: function(){
          swal.showLoading()
          }
          }).then(function(){
          // Read more about handling dismissals
          window.open('logout','_self')
        });
        </script>";
  }
  }
  }
  }
  ?>
<hr>
<h5 class="mb-1"> ACCOUNT DEACTIVATION </h5>
<ul class="list-unstyled <?= $floatRight ?>">
  <li class="lead mb-2">
    <strong> What happens when you deactivate your account? </strong>
  </li>
  <li><i class="fa fa-hand-o-right"></i> Your profile and services won't be shown on <?php echo $site_name; ?> anymore. </li>
  <li><i class="fa fa-hand-o-right"></i> Any open orders will be canceled and refunded. </li>
  <li><i class="fa fa-hand-o-right"></i> You won't be able to re-activate your proposals/services. </li>
  <li><i class="fa fa-hand-o-right"></i> You won't be able to restore your account. </li>
</ul>
<div class="clearfix"></div>
<form method="post">
  <?php 
    if(!$current_balance == 0){
    ?>
  <div class="form-group">
    <!-- form-group Starts -->
    <h5 class="pt-3 pb-3"> Please withdraw your revenues before deactivating your account. </h5>
  </div>
  <!-- form-group Ends -->
  <button type="submit" name="deactivate_account" disabled class="btn btn-danger <?= $floatRight ?>">
  <i class="fa fa-frown-o"></i> Deactivate Account
  </button>
  <?php }elseif($current_balance == 0){ ?>
  <div class="form-group">
    <label> Why Are You Leaving? </label>
    <select name="deactivate_reason" class="form-control" required>
      <option class="hidden"> Choose A Reason </option>
      <option> The quality of service was less than expected </option>
      <option>I just don't have the time</option>
      <option>I can’t find what I am looking for</option>
      <option>I had a bad experience with a seller / buyer</option>
      <option>I found the site difficult to use</option>
      <option>The level of customer service was less than expected</option>
      <option>I have another <?php echo $site_name; ?> account</option>
      <option>I'm not receiving enough orders</option>
      <option>Other</option>
    </select>
  </div>
  <button type="submit" name="deactivate_account" class="btn btn-danger <?= $floatRight ?>">
  <i class="fa fa-frown-o"></i> Deactivate Account
  </button>
  <?php } ?>   
</form>
<?php
  if(isset($_POST['deactivate_account'])){
  $update_seller = $db->update("sellers",array("seller_status" => 'deactivated'),array("seller_id" => $login_seller_id));
  if($update_seller){
  $sel_orders = $db->select("orders",array("seller_id" => $login_seller_id,"order_active" => "yes"));
  while($row_orders = $sel_orders->fetch()){
  $order_id = $row_orders->order_id;
  $seller_id = $row_orders->seller_id;
  $buyer_id = $row_orders->buyer_id;
  $order_price = $row_orders->order_price;
  $notification_date =  date("F d, Y");
  $purchase_date = date("F d, Y");
  $insert_notification = $db->insert("notifications",array("receiver_id" => $buyer_id,"sender_id" => $seller_id,"order_id" => $order_id,"reason" => "order_cancelled","date" => $notification_date,"status" => "unread"));
  $insert_purchase = $db->insert("purchases",array("seller_id" => $buyer_id,"order_id" => $order_id,"amount" => $order_price,"date" => $purchase_date,"method" => "order_cancellation"));
  $update_balance = $db->update("seller_accounts",array("used_purchases" => "used_purchases-$order_price","current_balance" => "current_balance+$order_price"),array("seller_id" => $buyer_id));
  $update_orders = $db->update("orders",array("order_status" => 'cancelled',"order_active" => 'no'),array("order_id" => $order_id));
  }
  // $delete_proposals = $db->delete("proposals",array("proposal_seller_id" => $seller_id));
  $update_proposals = $db->update("proposals",array("proposal_status" => 'pause'),array("proposal_seller_id" => $seller_id));
  unset($_SESSION['seller_user_name']);
  echo "<script>
      swal({
        type: 'success',
        text: 'Your account has been deactivated successfully. Goodbye!',
        timer: 3000,
        onOpen: function(){
        swal.showLoading()
        }
        }).then(function(){
            if (
              // Read more about handling dismissals
              window.open('index','_self')
            ) {
              console.log('Account deactivated successfully')
            }
          })
    </script>";
  }
  }
  ?>