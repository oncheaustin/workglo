<?php

@session_start();

if(!isset($_SESSION['admin_email'])){
  
echo "<script>window.open('login','_self');</script>";
  
}else{

  
    if(isset($_GET['approve_proposal'])){
        
        $proposal_id = $input->get('approve_proposal');

        $update_proposal = $db->update("proposals",array("proposal_status" => 'active'),array("proposal_id"=>$proposal_id));

        if($update_proposal){
        
        $select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));

        $row_proposals = $select_proposals->fetch();

        $proposal_title = $row_proposals->proposal_title;

        $proposal_seller_id = $row_proposals->proposal_seller_id;

        $proposal_url = $row_proposals->proposal_url;



        $get_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

        $row_seller = $get_seller->fetch();

        $seller_user_name = $row_seller->seller_user_name;

        $seller_email = $row_seller->seller_email;



        $site_logo = $row_general_settings->site_logo;

        $site_email_address = $row_general_settings->site_email_address;

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


        $mail->Subject = "$site_name: Your proposal/service has been successfully approved.";

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

        <p class='lead'> Your proposal/service has been successfully approved. Thanks for posting. </p>

        <hr>

        <a href='$site_url/proposals/$seller_user_name/$proposal_url' class='btn'>Click Here To View Proposal</a>

        </center>

        </div>

        </div>

        </body>

        </html>

        ";

        $mail->send();

        $last_update_date = date("F d, Y");

        $insert_notification = $db->insert("notifications",array("receiver_id" => $proposal_seller_id,"sender_id" => "admin_$admin_id","order_id" => $proposal_id,"reason" => "approved","date" => $last_update_date,"status" => "unread"));

        if($insert_notification){

        $insert_log = $db->insert_log($admin_id,"proposal",$proposal_id,"approved");

            echo "<script>
      
                   swal({
                 
                  type: 'success',
                  text: 'Proposal approved successfully!',
                  timer: 3000,
                  onOpen: function(){
                  swal.showLoading()
                  }
                  }).then(function(){
                    // Read more about handling dismissals
                    window.open('index?view_proposals_active','_self')
                })

            </script>";
        }
        
        }

    }



?>


<?php } ?>