<?php
  session_start();
  require_once("includes/db.php");
  require_once("social-config.php");
  if(isset($_SESSION['seller_user_name'])){
  $login_seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;
  $login_seller_email = $row_login_seller->seller_email;
  $login_seller_user_name = $row_login_seller->seller_user_name;
  }
  $recaptcha_site_key = $row_general_settings->recaptcha_site_key;
  $recaptcha_secret_key = $row_general_settings->recaptcha_secret_key;

  if ($lang_dir == "right") {
    $floatRight = "float-right";
  } else {
    $floatRight = "float-left";
  }

?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
  <head>
    <title><?php echo $site_name; ?> - Customer Support</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $site_desc; ?>">
    <meta name="keywords" content="<?php echo $site_keywords; ?>">
    <meta name="author" content="<?php echo $site_author; ?>">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <link href="styles/bootstrap.css" rel="stylesheet">
    <link href="styles/custom.css" rel="stylesheet">
    <!-- Custom css code from modified in admin panel --->
    <link href="styles/styles.css" rel="stylesheet">
    <link href="styles/categories_nav_styles.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
    <link href="styles/sweat_alert.css" rel="stylesheet">
    <script type="text/javascript" src="js/ie.js"></script>
    <script type="text/javascript" src="js/sweat_alert.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/sweat_alert.js"></script>
    <?php if(!empty($site_favicon)){ ?>
    <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
    <?php } ?>
  </head>
  <body class="is-responsive">
    <?php require_once("includes/header.php"); ?>
    <div class="container pb-4">
      <!-- Container starts -->
      <div class="row">
        <?php
          $get_contact_support = $db->select("contact_support");
          $row_contact_support = $get_contact_support->fetch();
          $contact_email = $row_contact_support->contact_email;
          $get_meta = $db->select("contact_support_meta",array('language_id' => $siteLanguage));
          $row_meta = $get_meta->fetch();
          $contact_heading = $row_meta->contact_heading;
          $contact_desc = $row_meta->contact_desc;
        ?>
        <div class="col-md-12 mt-4">
          <?php if(!isset($_SESSION['seller_user_name'])){ ?>
          <div class="alert alert-warning rounded-0">
            <p class="lead mt-1 mb-1 text-center">
              <strong>Sorry!</strong> You can't submit a support request without logging in first. If you have a general question, please email us at <?php echo $contact_email; ?>.
            </p>
          </div>
          <?php } ?>
        </div>
      </div>
      <div class="row customer-support" style="<?=($lang_dir == "right" ? 'direction: rtl;':'')?>">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header text-center make-white">
              <h2><?php echo $contact_heading; ?></h2>
              <p class="text-muted pt-1"><?php echo $contact_desc; ?></p>
            </div>
            <div class="card-body">
              <center>
                <form class="col-md-8 contact-form" action="" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="<?= $floatRight ?>">Select Relevant inquiry Subject</label>
                    <select name="enquiry_type" class="form-control select_tag" required>
                      <option value="" url="customer_support">Select Inquiry Subject</option>
                      <?php
                        $get_enquiry_types = $db->select("enquiry_types");
                        while($row_enquiry_types = $get_enquiry_types->fetch()){
                            $enquiry_id = $row_enquiry_types->enquiry_id;
                            $enquiry_title = $row_enquiry_types->enquiry_title;
                            echo "<option value='$enquiry_id' ".(@$_GET['enquiry_id'] == $enquiry_id ? "selected " : "") ."url='customer_support?enquiry_id=$enquiry_id'>
                            $enquiry_title
                            </option>";
                            }
                        ?>
                    </select>
                  </div>
                  <?php if(isset($_GET['enquiry_id'])){ ?>
                  <div class="form-group">
                    <label class="<?= $floatRight ?>">Subject *</label>
                    <input type="text" class="form-control" name="subject" required="">
                  </div>
                  <div class="form-group">
                    <label class="<?= $floatRight ?>">Message</label>
                    <textarea class="form-control" rows="6" name="message" required></textarea>
                  </div>
                  <?php if($_GET['enquiry_id'] == 1 or $_GET['enquiry_id'] == 2){ ?>
                  <div class="form-group">
                    <label class="<?= $floatRight ?>">Order Number *</label>
                    <input type="text" class="form-control" name="order_number" required="">
                  </div>
                  <div class="form-group">
                    <label class="<?= $floatRight ?>">User Role *</label>
                    <select name="user_role" class="form-control" required>
                      <option value="" class="hidden">Select user role</option>
                      <option>Buyer</option>
                      <option>Seller</option>
                    </select>
                  </div>
                  <?php } ?>
                  <div class="form-group">
                    <label class="<?= $floatRight ?>">Attachment</label>
                    <input type="file" class="form-control" name="file">
                  </div>
                  <div class="form-group">
                    <label>Please verify that you're part of humanity.</label>
                    <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_site_key; ?>"></div>
                  </div>
                  <div class="text-center">
                    <button class="btn btn-success btn-lg" name="submit" type="submit">
                    <i class="fa fa-paper-plane"> Submit Request</i>
                    </button>
                  </div>
                  <?php } ?>
                </form>
              </center>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Container ends -->
    <?php
      if(isset($_POST['submit'])){
      if(!isset($_SESSION['seller_user_name'])){
      echo "
       <script>
      swal({
        type: 'warning',
        text: 'Opps! You need to be logged in to submit support requests.',
        timer: 6000,
          onOpen: function(){
        swal.showLoading()
        }
        }).then(function(){
          // Read more about handling dismissals
          window.open('login.php','_self')
        });
      </script>
      ";
      exit();
      }else{
      $secret_key = "$recaptcha_secret_key";
      $response = $input->post('g-recaptcha-response');
      $remote_ip = $_SERVER['REMOTE_ADDR'];
      $url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$response&remoteip=$remote_ip");
      $result = json_decode($url, TRUE);
      if($result["success"] == 1 ){
      $enquiry_type = $input->post('enquiry_type');
      $subject = $input->post('subject');
      $message = $input->post('message');
      if($enquiry_type == 1 or $enquiry_type == 2){
      $order_number = $input->post('order_number');
      $order_rule = $input->post('user_role');
      }else{
      $order_number = "";
      $order_rule = "";
      }
      $file = $_FILES['file']['name'];
      $file_tmp = $_FILES['file']['tmp_name'];
      $allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4', 'zip','rar','mp3','wav');
      $file_extension = pathinfo($file, PATHINFO_EXTENSION);
      if(!in_array($file_extension,$allowed) & !empty($file)){
      echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
      }else{
      $file = pathinfo($file, PATHINFO_FILENAME);
      $file = $file."_".time().".$file_extension";
      move_uploaded_file($file_tmp , "ticket_files/$file");
      $date = date("h:i M d, Y");
      $insert_support_ticket = $db->insert("support_tickets",array("enquiry_id" => $enquiry_id,"sender_id" => $login_seller_id,"subject" => $subject,"message" => $message,"order_number" => $order_number,"order_rule" => $order_rule,"attachment" => $file,"date" => $date,"status" => 'open'));
      if($insert_support_ticket){
      $get_enquiry_types = $db->select("enquiry_types",array("enquiry_id" => $enquiry_id));
      $row_enquiry_types = $get_enquiry_types->fetch();
      $enquiry_title = $row_enquiry_types->enquiry_title;
      // Send Email To Admin Code Starts
      if(!empty($file)){
      $email_message = "
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
      hr{
        margin-top:20px;
        margin-bottom:20px;
        border:1px solid #eee;
      }
      .table {
        max-width:100%;
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
      <img class='logo' src='$site_url/images/logo.png' width='100' >
      <h2> Hello  Admin!</h2>
      <h2> This message has been sent from the customer support form. </h2>
      </center>
      <hr>
      <table class='table'>
      <thead>
      <tr>
      <th> Enquiry Type </th>
      <th> Email Address </th>
      <th> Subject </th>
      <th> Message </th>
      <th> Attachment </th>
      <th> Sender Username </th>
      </tr>
      </thead>
      <tbody>
      <tr>
      <td> $enquiry_title </td>
      <td> $login_seller_email </td>
      <td> $subject </td>
      <td> $message </td>
      <td> $file </td>
      <td> $login_seller_user_name </td>
      </tr>
      </tbody>
      </table>
      </div>
      </div>
      </body>
      </html>
      ";
      }else{
      $email_message = "
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
      hr{
        margin-top:20px;
        margin-bottom:20px;
        border:1px solid #eee;
      }
      .table {
      max-width:100%; 
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
      <img class='logo' src='$site_url/images/logo.png' width='100' >
      <h2> Hello Admin! </h2>
      <h2> This message has been sent from the customer support form. </h2>
      </center>
      <hr>
      <table class='table'>
      <thead>
      <tr>
      <th> Enquiry Type </th>
      <th> Email Address </th>
      <th> Subject </th>
      <th> Message </th>
      <th> Sender Username </th>
      </tr>
      </thead>
      <tbody>
      <tr>
      <td> $enquiry_title </td>
      <td> $login_seller_email </td>
      <td> $subject </td>
      <td> $message </td>
      <td> $login_seller_user_name </td>
      </tr>
      </tbody>
      </table>
      </div>
      </div>
      </body>
      </html>
      ";
      }
      $headers = "From: $contact_email\r\n";
      $headers .= "Reply-To: $login_seller_email\r\n";
      $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
      $get_contact_support = $db->select("contact_support");
      $row_contact_support = $get_contact_support->fetch();
      $contact_email = $row_contact_support->contact_email;
      mail($contact_email, $subject, $email_message, $headers,'-faaaa@abc.com');
      // Send Email To Admin Code Ends
      /// Send Email To Sender Code Starts 
      $subject = "Message has been received.";
      $message = "
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
      hr{
        margin-top:20px;
        margin-bottom:20px;
        border:1px solid #eee;
      }
      .lead {
        font-size:16px;
      }
      </style>
      </head>
      <body class='is-responsive'>
      <div class='container'>
      <div class='box'>
      <center>
      <img src='$site_url/images/logo.png' width='100'>
      <h3> Hello $login_seller_user_name, </h3>
      <p class='lead'> Thank you for contacting us. </p>
      <hr>
      <p class='lead'>
      A customer repressentative will be in touch with you shortly.
      </p>
      </center>
      </div>
      </div>
      </body>
      </html>
      ";
      $headers = "From: $contact_email\r\n";
      $headers .= "Reply-To: $contact_email\r\n";
      $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
      mail($login_seller_email, $subject, $message, $headers,'-faaaa@abc.com');
      /// Send Email To Sender Code Ends  
      echo "
      <script>
      swal({
        type: 'success',
        text: 'Message submitted successfully!',
        timer: 6000,
      })
      </script>
      ";
      }
      }
      }else{
      echo "
      <script>
      swal({
        type: 'warning',
        text: 'Please select captcha and try again!',
        timer: 6000,
      })
      </script>"; 
      }
      }
      }
      ?>
    <?php require_once("includes/footer.php"); ?>
    <script>
      $(document).ready(function(){
      $(".select_tag").change(function(){
      url = $(".select_tag option:selected").attr('url');
      window.location.href = url;
      });
      });
    </script>
  </body>
</html>