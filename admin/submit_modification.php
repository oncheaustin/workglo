<?php


@session_start();

if(!isset($_SESSION['admin_email'])){
	
echo "<script>window.open('login','_self');</script>";
	
}else{

$proposal_id = $input->get('submit_modification');


$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));

$row_proposals = $select_proposals->fetch();

$proposal_title = $row_proposals->proposal_title;

$proposal_seller_id = $row_proposals->proposal_seller_id;



$get_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

$row_seller = $get_seller->fetch();

$seller_user_name = $row_seller->seller_user_name;

$seller_email = $row_seller->seller_email;



$site_logo = $row_general_settings->site_logo;

$site_email_address = $row_general_settings->site_email_address;


$last_update_date = date("F d, Y");

?>


<div class="breadcrumbs">

<div class="col-sm-4">
<div class="page-header float-left">
<div class="page-title">
<h1><i class="menu-icon fa fa-table"></i> Proposal / Modification Request</h1>
</div>
</div>
</div>

<div class="col-sm-8">
<div class="page-header float-right">
<div class="page-title">
<ol class="breadcrumb text-right">
<li class="active">Submit Proposal/Service For Modification</li>
</ol>
</div>
</div>
</div>

</div>


<div class="container">
    
    <div class="row pt-2">
        
        <div class="col-lg-12">
            
            <div class="card">
                
                <div class="card-header">
                    
                <h4>Insert Reason For Modification Request</h4>
                    
                </div>
                
                <div class="card-body">
                    
                    <form action="" method="post">
                        

                        <div class="form-group row">
                            
                            <label class="col-md-3 control-label">Proposal Title</label>
                            
                            <div class="col-md-6">
                                
                                <p class="mt-2"><?php echo $proposal_title; ?></p>
                            
                            </div>
                        
                        </div>
                        
                        
                         <div class="form-group row">
                            
                            <label class="col-md-3 control-label">Describe Modification</label>
                            
                            <div class="col-md-6">
                                
                            <textarea name="proposal_modification" class="form-control"></textarea>
                            
                            </div>

                        </div>
                        
                        
                         <div class="form-group row">
                            
                            <label class="col-md-3 control-label"></label>
                            
                            <div class="col-md-6">
                                
                            <input type="submit" name="submit" class="btn btn-success form-control" value="Send Modification Request">
                            
                            </div>
                        
                        </div>
                    
            
                    </form>
                

                </div>
        
            </div>
        
        </div>
    
        </div>

</div>


<?php
    
  if(isset($_POST['submit'])){
      
    $proposal_modification = $input->post('proposal_modification');
    
    $insert_modification = $db->insert("proposal_modifications",array("proposal_id"=>$proposal_id,"modification_message" => $proposal_modification));

    $update_proposal = $db->update("proposals",array("proposal_status"=>'modification'),array("proposal_id"=>$proposal_id));

    if($update_proposal){

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

    $mail->addAddress($seller_email);

    $mail->addReplyTo($site_email_address,$site_name);

    $mail->isHTML(true);


    $mail->Subject = "$site_name: Admin Has Sent Modification To Your Proposal.";

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

    h2 {

    margin-top: 0px;
    margin-bottom: 10px;

    }

    .lead {
    margin-top: 0px;
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
      margin-top:10px;
      margin-bottom:20px;
      border:1px solid #eee;
      
    }


   @media only screen and (max-device-width: 690px) {
    
    .container {
    background: rgb(238, 238, 238);
    width:100%;
    padding:1px;
    
    }
        
    .btn{
      background:green;
      margin-top:15px;
      color:white !important;
      text-decoration:none;
      padding:10px;
      font-size:14px;
      border-radius:3px;
      
    }
    
    .lead {
      
    font-size:14px;
      
    }
    
    }

    </style>

    </head>

    <body>

    <div class='container'>

    <div class='box'>

    <center>

    <img class='logo' src='$site_url/images/$site_logo' width='100' >

    <h2> Hi Dear $seller_user_name </h2>

    <p class='lead'> Admin Has Sent Modification To Your Proposal. </p>

    <hr>

    <a href='$site_url/proposals/view_proposals.php' class='btn'>

    Click Here To View Modification
    
    </a>

    </center>

    </div>

    </div>
erastanveelkhan786@gmail.com
    </body>

    </html>

    ";

    $mail->send();

    $insert_notification = $db->insert("notifications",array("receiver_id" => $proposal_seller_id,"sender_id" => "admin_$admin_id","order_id" => $proposal_id,"reason" => "modification","date" => $last_update_date,"status" => "unread"));

    echo "<script>

    swal({
    type: 'success',
    text: 'Modification request sent!',
    timer: 3000,
    onOpen: function(){
    swal.showLoading()
    }
    }).then(function(){

    // Read more about handling dismissals
    window.open('index?view_proposals','_self')
  
    })

    </script>";

    }
   
    }  

?>

<?php } ?>