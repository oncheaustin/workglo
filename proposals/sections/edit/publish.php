<?php 
$get_payment_settings = $db->select("payment_settings");
$row_payment_settings = $get_payment_settings->fetch();
$featured_proposal_while_creating = $row_payment_settings->featured_proposal_while_creating;
$featured_proposal = $db->select("featured_proposals", array("proposal_id"=>$proposal_id))->rowCount();
$approve_proposals = $row_general_settings->approve_proposals;
if($approve_proposals == "yes"){ $text = "Save & Submit For Approval"; }else{ $text = "Save & Publish"; } 
?>

<h1><img style="position:relative; top:-5px;" src="../images/comp/winner.png">  Yay! You are almost done!</h1>
<h6 class="font-weight-normal line-height-normal">
Congrats! you're almost done submitting this proposal. <br>
You can go back and check if you entered all the details for this proposal correctly. If all looks good and you agree with <a href="<?= $site_url; ?>/terms_and_conditions" target="_black" class="text-primary">all our policies</a>, please click on the “Save & Submit For Approval” button.<br><br>
<span class="text-muted">
If you do not wish to submit this proposal for approval at this time, please exit this page. You can easily retrieve this proposal by clicking on "Selling => My Proposals => Drafts". Cheers!
</span>
</h6>

<form action="" method="post">
  <?php if($featured_proposal_while_creating == 1){ ?>
  <?php if($featured_proposal == 0){ ?>
  <h1 class="h3">Make Proposal Featured (Optional)</h1>
  <h6 class="font-weight-normal line-height-normal">
    Let your proposal appear on several places on <?PHP echo $site_name; ?><br>
    Proposal will always be at the top section of search results <br>
    WIth <?PHP echo $site_name; ?> feature, your proposal already has a 50% chance of getting ordered by potential buyers
    <p class="ml-4 mt-3">
      <label for="checkid" style="word-wrap:break-word">
        <input type="checkbox" name="proposal_featured" value="1" style="vertical-align:middle;margin-left: -1.25rem;"> Make Proposal Featured
      </label>
    </p>
  </h6>
  <?php }} ?>
  <div class="form-group mb-0 mt-3"><!--- form-group Starts --->
    <a href="#" class="btn btn-secondary back-to-gallery">Back</a>
    <input class="btn btn-success" type="submit" name="submit_proposal" value="<?= $text; ?>">
    <a href="#" class="btn btn-success d-none" id="featured-button">Make Proposal Featured</a>
  </div><!--- form-group Starts --->
</form>

<script>
$('.back-to-gallery').click(function(){
  $("input[type='hidden'][name='section']").val("gallery");
  $('#publish').removeClass('show active');
  $('#gallery').addClass('show active');
  $('#tabs a[href="#publish"]').removeClass('active');
});

$("input[name='proposal_featured']").change(function(){
  if (this.checked) {
    $("#featured-button").removeClass("d-none");
    $("input[name='submit_proposal'").addClass("d-none");
  }else{
    $("#featured-button").addClass("d-none");
    $("input[name='submit_proposal'").removeClass("d-none");
  }
});

$("#featured-button").click(function(){
  proposal_id = "<?php echo $proposal_id; ?>";
  $.ajax({
    method: "POST",
    url: "pay_featured_listing",
    data: {proposal_id: proposal_id, createProposal:1}
  }).done(function(data){
    $("#featured-proposal-modal").html(data); 
  });
});
</script>
<?php 
if(isset($_POST['submit_proposal'])){
  if($approve_proposals == "yes"){ 
  $status = "pending";
  $text = "Your Proposal Has Been Successfully Submitted For Approval."; 
  }else{ 
  $status = "active"; 
  $text = "Your Proposal Has Been Successfully Publish. Now Its Live"; 
  }
  $update_proposal = $db->update("proposals",array("proposal_status"=>$status),array("proposal_id"=>$proposal_id));
  if($update_proposal){
    if($row_general_settings->proposal_email == "yes"){
      $site_email_address = $row_general_settings->site_email_address;
      $get_meta = $db->select("cats_meta",array("cat_id" => $d_proposal_cat_id, "language_id" => $siteLanguage));
      $cat_title = $get_meta->fetch()->cat_title;
      require '../mailer/PHPMailerAutoload.php';
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
      $mail->addAddress($site_email_address);
      $mail->addReplyTo($site_email_address,$site_name);
      $mail->isHTML(true);
      $mail->Subject = "$site_name - $login_seller_user_name Has Just Created A New Proposal.";
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
      .table {
        width:100%; 
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
      <img src='$site_url/images/$site_logo_image' width='100' >
      <h2> $login_seller_user_name has just created a new proposal. </h2>
      </center>
      <hr>
      <p class='lead'> Proposal Short Details: </p>
      <table class='table'>
      <thead>
      <tr>
      <th> Proposal Title </th>
      <th> Proposal Category </th>
      <th> Proposal Seller </th>
      <th> Proposal Status </th>
      </tr>
      </thead>
      <tbody align='center'>
      <tr>
      <td>$d_proposal_title</td>
      <td>$cat_title</td>
      <td>$login_seller_user_name</td>
      <td>".ucfirst($status)."</td>
      </tr>
      </tbody>
      </table>
      <br>
      <center>
      <a href='$site_url/admin/index?view_proposals' class='btn pt-2'>
      Click To View All Proposals
      </a>
      </center>
      </div>
      </div>
      </body>
      </html>";
      $mail->send();
    }
    echo "<script>
    swal({
    type: 'success',
    text: '$text',
    timer: 2000,
    onOpen: function(){
    swal.showLoading()
    }
    }).then(function(){
    window.open('view_proposals','_self');
    });
    </script>";
  }
}
?>