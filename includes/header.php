


<?php
require_once("db.php");
require_once("extra_script.php");
if(!isset($_SESSION['error_array'])){ $error_array = array(); }else{ $error_array = $_SESSION['error_array']; }

if(isset($_SESSION['seller_user_name'])){
  require_once("seller_levels.php");
  $seller_user_name = $_SESSION['seller_user_name'];
  $get_seller = $db->select("sellers",array("seller_user_name" => $seller_user_name));
  $row_seller = $get_seller->fetch();
  $seller_id = $row_seller->seller_id;
  $seller_email = $row_seller->seller_email;
  $seller_verification = $row_seller->seller_verification;
  $seller_image = $row_seller->seller_image;
  $count_cart = $db->count("cart",array("seller_id" => $seller_id));
  $select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $seller_id));
  $count_seller_accounts = $select_seller_accounts->rowCount();
  if ($count_seller_accounts == 0) {
    $db->insert("seller_accounts",array("seller_id" => $seller_id));
  }
  $row_seller_accounts = $select_seller_accounts->fetch();
  $current_balance = $row_seller_accounts->current_balance;
  
  $get_general_settings = $db->select("general_settings");   
  $row_general_settings = $get_general_settings->fetch();
  $enable_referrals = $row_general_settings->enable_referrals;
  $count_active_proposals = $db->count("proposals",array("proposal_seller_id"=>$seller_id,"proposal_status"=>'active'));
}

function get_real_user_ip(){
  //This is to check ip from shared internet network
  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}

$ip = get_real_user_ip();

?>



<link rel="stylesheet" type="text/css" href="<?php echo $site_url; ?>css1/bootstrap.css" />

<link rel="stylesheet" type="text/css" href="<?php echo $site_url; ?>css1/font-awesome.css" />

<link rel="stylesheet" type="text/css" href="<?php echo $site_url; ?>css1/custom.css" />

<link rel="stylesheet" type="text/css" href="<?php echo $site_url; ?>css1/responsive.css" />

<link href="https://fonts.googleapis.com/css?family=Montserrat:200,400,700" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"> 


<link rel="stylesheet" type="text/css" href="<?php echo $site_url; ?>css1/owl.carousel.css" />

</head>






<?php include("comp/categories_nav.php"); ?>

<!-- Registration Modal starts -->
<div class="modal fade" id="register-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- modal-header Starts -->
        <i class="fa fa-user-plus"></i> 
        <h5 class="modal-title"> <?php echo $lang['modals']['register']['title']; ?> </h5>
        <button class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <!-- modal-header Ends -->
      <div class="modal-body">
        <!-- modal-body Starts -->
        <?php 
          $form_errors = Flash::render("register_errors");
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
        <script type="text/javascript">
          $(document).ready(function(){
            $('#register-modal').modal('show');
          });
        </script>
        <?php } ?>
        <form action="" method="post" class="pb-3">
          <div class="form-group">
            <label class="form-control-label font-weight-bold"> Full Name: </label>
            <input type="text" class="form-control" name="name" placeholder="Enter Your Full Name" value="<?php if(isset($_SESSION['name'])) echo $_SESSION['name']; ?>" required="">
          </div>
          <div class="form-group">
            <label class="form-control-label font-weight-bold"> Username: </label>
            <input type="text" class="form-control" name="u_name" placeholder="Enter Your Username" value="<?php if(isset($_SESSION['u_name'])) echo $_SESSION['u_name']; ?>" required="">
            <small class="form-text text-muted">Note: You will not be able to change username once your account has been created.</small>
            <?php if(in_array("Opps! This username has already been taken. Please try another one", $error_array)) echo "<span style='color:red;'>This username has already been taken. Please try another one.</span> <br>"; ?>
            <?php if(in_array("Username must be greater that 4 characters long or less than 25 characters.", $error_array)) echo "<span style='color:red;'>Username must be greater that 4 characters or less than 25.</span> <br>"; ?>
          </div>
          <div class="form-group">
            <label class="form-control-label font-weight-bold"> Email: </label>
            <input type="email" class="form-control" name="email" placeholder="Enter Email" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?>" required="">
            <?php if(in_array("Email has already been taken. Try logging in instead.", $error_array)) echo "<span style='color:red;'>Email has already been taken. Try logging in instead.</span> <br>"; ?>
          </div>
          <div class="form-group">
            <label class="form-control-label font-weight-bold"> Password: </label>
            <input type="password" class="form-control" name="pass" placeholder="Enter Password" required="">
          </div>
          <div class="form-group">
            <label class="form-control-label font-weight-bold"> Confirm Password: </label>
            <input type="password" class="form-control" name="con_pass" placeholder="Confirm Password" required="">
            <?php if(in_array("Passwords don't match. Please try again.", $error_array)) echo "<span style='color:red;'>Passwords don't match. Please try again.</span> <br>"; ?>
          </div>
          <?php if(isset($_GET['referral'])){ ?>
          <input type="hidden" class="form-control" name="referral" value="<?php echo $_GET['referral']; ?>">
          <?php }else{ ?>
          <input type="hidden" class="form-control" name="referral" value="">
          <?php } ?>
          <input type="submit" name="register" class="btn btn-success btn-block" value="Register Now">
        </form>
        <?php if($enable_social_login == "yes"){ ?>
        <div class="clearfix"></div>
        <div class="text-center">or, register with either:</div>
        <hr class="">
        <div class="line mt-3"><span></span></div>
        <div class="text-center">
          <a href="#" onclick="window.location = '<?php echo $fLoginURL ?>';" class="btn btn-primary btn-fb-connect" >
          <i class="fa fa-facebook"></i> FACEBOOK
          </a>
          <a href="#" onclick="window.location = '<?php echo $gLoginURL ?>';" class="btn btn-danger btn-gplus-connect " >
          <i class="fa fa-google-plus"></i> GOOGLE
          </a>
        </div>
        <div class="clearfix"></div>
        <?php } ?>
        <div class="text-center mt-3 text-muted">
          <?php echo $lang['modals']['register']['already_account']; ?>
          <a href="#" class="text-success" data-toggle="modal" data-target="#login-modal" data-dismiss="modal">Log In.</a>
        </div>
      </div>
      <!-- modal-body Ends -->
    </div>
  </div>
</div>
<!-- Registration modal ends -->
<!-- Login modal start -->
<div class="modal fade login" id="login-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- Modal header start -->
        <i class="fa fa-sign-in fa-log"></i> 
        <h5 class="modal-title"><?php echo $lang['modals']['login']['title']; ?></h5>
        <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <!-- Modal header end -->
      <div class="modal-body">
        <!-- Modal body start -->
        <?php 
          $form_errors = Flash::render("login_errors");
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
        <script type="text/javascript">
          $(document).ready(function(){
            $('#login-modal').modal('show');
          });
        </script>
        <?php } ?>
        <form action="" method="post">
          <div class="form-group">
            <label class="form-group-label"> Username:</label>
            <input type="text" class="form-control" name="seller_user_name" placeholder="Enter Username"  value= "<?php if(isset($_SESSION['seller_user_name'])) echo $_SESSION['seller_user_name']; ?>" required="">
          </div>
          <div class="form-group">
            <label class="form-group-label"> Password:</label>
            <input type="password" class="form-control" name="seller_pass" placeholder="Enter Password" required="">
          </div>
          <input type="submit" name="login" class="btn btn-success btn-block" value="Login Now">
        </form>
        <?php if($enable_social_login == "yes"){ ?>
        <div class="clearfix"></div>
        <div class="text-center pt-4 pb-2"><?php echo $lang['modals']['login']['or']; ?></div>
        <hr class="">
        <div class="line mt-3"><span></span></div>
        <div class="text-center">
          <a href="#" onclick="window.location = '<?php echo $fLoginURL ?>';" class="btn btn-primary btn-fb-connect" >
          <i class="fa fa-facebook"></i> FACEBOOK
          </a>
          <a href="#" onclick="window.location = '<?php echo $gLoginURL ?>';" class="btn btn-danger btn-gplus-connect " >
          <i class="fa fa-google-plus"></i> GOOGLE
          </a>
        </div>
        <div class="clearfix"></div>
        <?php } ?>
        <div class="text-center mt-3">
          <a href="#" class="text-success" data-toggle="modal" data-target="#register-modal" data-dismiss="modal">
          <?php echo $lang['modals']['login']['not_registerd']; ?>
          </a>
          &nbsp; &nbsp; | &nbsp; &nbsp;
          <a href="#" class="text-success" data-toggle="modal" data-target="#forgot-modal" data-dismiss="modal">
          <?php echo $lang['modals']['login']['forgot_password']; ?>
          </a>
        </div>
      </div>
      <!-- Modal body ends -->
    </div>
  </div>
</div>
<!-- Login modal end -->
<!-- Forgot password starts -->
<div class="modal fade login" id="forgot-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- Modal header starts -->
        <i class="fa fa-meh-o fa-log"></i>
        <h5 class="modal-title"> <?php echo $lang['modals']['forgot']['title']; ?> </h5>
        <button type="button" class="close" data-dismiss="modal">
        <span>&times;</span>
        </button>
      </div>
      <!-- Modal header ends -->
      <div class="modal-body">
        <!-- Modal body starts -->
        <p class="text-muted text-center mb-2">
          <?php echo $lang['modals']['forgot']['desc']; ?>
        </p>
        <form action="" method="post">
          <div class="form-group">
            <input type="text" name="forgot_email" class="form-control" placeholder="Enter Email" required>
          </div>
          <input type="submit" class="btn btn-success btn-block" value="submit" name="forgot">
          <p class="text-muted text-center mt-4">
            <?php echo $lang['modals']['forgot']['not_member_yer']; ?>
            <a href="#"class="text-success" data-toggle="modal" data-target="#register-modal" data-dismiss="modal">Join Now.</a>
          </p>
        </form>
      </div>
      <!-- Modal body ends -->
    </div>
  </div>
</div>
<!-- Forgot password ends -->

<!-- Forgot password ends -->
<?php require_once("register-login-forgot.php"); ?>


