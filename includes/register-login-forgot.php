<?php

$get_general_settings = $db->select("general_settings");   
$row_general_settings = $get_general_settings->fetch();
$site_email_address = $row_general_settings->site_email_address;
$site_logo = $row_general_settings->site_logo;
$site_name = $row_general_settings->site_name;
$signup_email = $row_general_settings->signup_email;
$referral_money = $row_general_settings->referral_money;

if(isset($_POST['register'])){
		$rules = array(
		"name" => "required",
		"u_name" => "required",
		"email" => "email|required",
		"pass" => "required",
		"con_pass" => "required");

		$messages = array("name" => "Full Name Is Required.","u_name" => "User Name Is Required.","pass" => "Password Is Required.","con_pass" => "Confirm Password Is Required.");

		$val = new Validator($_POST,$rules,$messages);

		if($val->run() == false){
			$_SESSION['error_array'] = array();
			Flash::add("register_errors",$val->get_all_errors());
			Flash::add("form_data",$_POST);
			echo "<script>window.open('index','_self')</script>";
		}else{
		$error_array = array();
		$name = strip_tags($input->post('name'));
		$name = strip_tags($name);
		$name = ucfirst(strtolower($name));
		$_SESSION['name']= $name;
		$u_name = strip_tags($input->post('u_name'));
		$u_name = strip_tags($u_name);
		$_SESSION['u_name']= $u_name;
		$email = strip_tags($input->post('email'));
		$email = strip_tags($email);
		$_SESSION['email']=$email;
		$pass = strip_tags($input->post('pass'));
		$con_pass = strip_tags($input->post('con_pass'));
		$referral = strip_tags($input->post('referral'));
		// $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=$ip");
		// $country = $xml->geoplugin_countryName;
		$country = '';
		$regsiter_date = date("F d, Y");
		$date = date("F d, Y");

	
		$check_seller_username = $db->count("sellers",array("seller_user_name" => $u_name));
		$check_seller_email = $db->count("sellers",array("seller_email" => $email));
		if($check_seller_username > 0 ){
		    array_push($error_array, "Opps! This username has already been taken. Please try another one");
		}
		if($check_seller_email > 0){
		  array_push($error_array, "Email has already been taken. Try logging in instead.");
		}
		if($pass != $con_pass){
      array_push($error_array, "Passwords don't match. Please try again.");
		}
    
		if(empty($error_array)){

		$referral_code = mt_rand();

		if($signup_email == "yes"){
		$verification_code = mt_rand();
		}else{
		$verification_code = "ok";
		}

		$encrypted_password = password_hash($pass, PASSWORD_DEFAULT);
		
		$insert_seller = $db->insert("sellers",array("seller_name" => $name,"seller_user_name" => $u_name,"seller_email" => $email,"seller_pass" => $encrypted_password,"seller_country"=>$country,"seller_level" => 1,"seller_recent_delivery" => 'none',"seller_rating" => 100,"seller_offers" => 10,"seller_referral" => $referral_code,"seller_ip" => $ip,"seller_verification" => $verification_code,"seller_vacation" => 'off',"seller_register_date" => $regsiter_date,"seller_status" => 'online'));
				
		$regsiter_seller_id = $db->lastInsertId();
		
		if($insert_seller){
			
	    $_SESSION['seller_user_name'] = $u_name;
			$insert_seller_account = $db->insert("seller_accounts",array("seller_id" => $regsiter_seller_id));

			if($insert_seller_account){

			if(!empty($referral)){
			
	    $sel_seller = $db->select("sellers",array("seller_referral" => $referral));		
			$row_seller = $sel_seller->fetch();
			$seller_id = $row_seller->seller_id;	
			$seller_ip = $row_seller->seller_ip;
				
			if($seller_ip == $ip){
				
			echo "<script>alert('You Cannot Referral Yourself To Make Money.');</script>";
				
			}else{
				$count_referrals = $db->count("referrals",array("ip" => $ip));	
				if($count_referrals == 1){
			    echo "<script>alert('You are trying to referral yourself more then one time.');</script>";
				}else{
					$insert_referral = $db->insert("referrals",array("seller_id" => $seller_id,"referred_id" => $regsiter_seller_id,"comission" => $referral_money,"date" => $date,"ip" => $ip,"status" => 'pending'));
				}
			}	
			
			}


			if($signup_email == "yes"){

				require "$dir/mailer/PHPMailerAutoload.php";
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
				$mail->addAddress($email);
				$mail->addReplyTo($site_email_address,$site_name);
				$mail->isHTML(true);
				$mail->Subject = "$site_name: Activate Your New Account!";
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
				h2{
				    margin-top: 0px;
				    margin-bottom: 0px;
				}
				.lead {
					margin-top: 10px;
					margin-bottom: 0px;
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
				<h2> Hi $u_name, Welcome To $site_name! </h2>
				<p class='lead'> Are you ready to get started? </p>
				<br>
				<a href='$site_url/includes/verify_email.php?code=$verification_code' class='btn'>
				Click Here To Activate Your Account 
				</a>
				<hr>
				<p class='lead'>
				If clicking the button above does not work, copy and paste the following url in a new browser window: $site_url/includes/verify_email.php?code=$verification_code
				</p>
				</center>
				</div>
				</div>
				</body>
				</html>";
		    $mail->send();
		  }

			echo "
			<script>
			swal({
			type: 'success',
			text: 'Successfully Registered! Welcome onboard, $name. ',
			timer: 6000,
			onOpen: function(){
			swal.showLoading()
			}
			}).then(function(){
			if (
			// Read more about handling dismissals
			window.open('$site_url','_self')
			) {
			console.log('Successful Registration')
			}
			})
			</script>
			";
			$_SESSION['name'] = "";
			$_SESSION['u_name']="";
			$_SESSION['email']= "";
			$_SESSION['error_array'] = array();
				
			}
				
		}
					
		}
			
		if($check_seller_username > 0 || $check_seller_email > 0 || $pass != $con_pass ) {
			$_SESSION['error_array'] = $error_array;
			echo "
			<script>
			swal({
			type: 'warning',
			html: $('<div>').text('Opps! There are some errors on the form. Please try again.'),
			animation: false,
			customClass: 'animated tada'
			}).then(function(){
			window.open('index','_self')
			});
			</script>";
		}

	}
	
}



if(isset($_POST['login'])){
	
	$rules = array(
	"seller_user_name" => "required",
	"seller_pass" => "required"
	);
	$messages = array("seller_user_name" => "Username Is Required.","seller_pass" => "Password Is Required.");

	$val = new Validator($_POST,$rules,$messages);

	if($val->run() == false){

	Flash::add("login_errors",$val->get_all_errors());

	Flash::add("form_data",$_POST);

	echo "<script>window.open('index','_self')</script>";

	}else{

	$seller_user_name = $input->post('seller_user_name');
	
	$seller_pass = $input->post('seller_pass');

	$select_seller = $db->query("select * from sellers where binary seller_user_name like :u_name",array(":u_name"=>$seller_user_name));
		
	$row_seller = $select_seller->fetch();
	
	@$hashed_password = $row_seller->seller_pass;

	@$seller_status = $row_seller->seller_status;
	
	$decrypt_password = password_verify($seller_pass, $hashed_password);
	
	if($decrypt_password == 0){
		echo "
		<script>
            swal({
              type: 'warning',
              html: $('<div>')
                .text('Opps! password or username is incorrect. Please try again.'),
              animation: false,
              customClass: 'animated tada'
            })
    </script>
		";
	}else{

	if($seller_status == "block-ban"){
		echo "
		<script>
            swal({
              type: 'warning',
              html: $('<div>')
                .text('You have been blocked by the Admin. Please contact customer support.'),
              animation: false,
              customClass: 'animated tada'
            })
    	</script>";
	}elseif($seller_status == "deactivated"){
		echo "
		<script>
		swal({
		  type: 'warning',
		  html: $('<div>').text('You have deactivated your account, please contact us for more details.'),
		  animation: false,
		  customClass: 'animated tada'
		})
		</script>";
	}else{
		$select_seller = $db->select("sellers",array("seller_user_name"=>$seller_user_name,"seller_pass"=>$hashed_password));
		if($select_seller){
	        $_SESSION['seller_user_name'] = $seller_user_name;
	        if(isset($_SESSION['seller_user_name']) and $_SESSION['seller_user_name'] === $seller_user_name){
			$update_seller_status = $db->update("sellers",array("seller_status"=>'online',"seller_ip"=>$ip),array("seller_user_name"=>$seller_user_name,"seller_pass"=>$hashed_password));
            $seller_user_name = ucfirst(strtolower($seller_user_name));
			$url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            echo "
            <script>
                  swal({
                  type: 'success',
                  text: 'Hey $seller_user_name, welcome back!',
                  timer: 2000,
                  onOpen: function(){
                    swal.showLoading()
                  }
                  }).then(function(){
                    window.open('$url','_self')
                });
            </script>";
            }
		}
	}
	
	}
		
  }
	
}



if(isset($_POST['forgot'])){
	
	$forgot_email = $input->post('forgot_email');
	
	$select_seller_email = $db->select("sellers",array("seller_email" => $forgot_email));
		
	$count_seller_email = $select_seller_email->rowCount();
	
	if($count_seller_email == 0){
		
		echo "
		
		<script>
      
           swal({
           
          type: 'warning',
          text: 'Hmm! We don\'t seem to have this email in our system.',

          })

        </script>";
		
	}else{
		
		$row_seller_email = $select_seller_email->fetch();
		
		$seller_user_name = $row_seller_email->seller_user_name;
		
		$seller_pass = $row_seller_email->seller_pass;
		
	    require "$dir/mailer/PHPMailerAutoload.php";

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

		$mail->addAddress($forgot_email);

		$mail->addReplyTo($site_email_address,$site_name);

		$mail->isHTML(true);
		 
		$mail->Subject = "$site_name: Password Reset";
		
		$mail->Body = "
		
		<html>
		
		<head>
		
		<style>
		
        .container {
        background: rgb(238, 238, 238);
        padding: 80px;
        
        }


		.box {
			background: #fff;
			margin: 0px 0px 30px;
			padding: 8px 20px 20px 20px;
            border:1px solid #e6e6e6;
            box-shadow:0px 1px 5px rgba(0, 0, 0, 0.1);			
		}


		h2{

		margin-top: 0px;
		margin-bottom: 0px;

		}
		
		.lead {
		    margin-top: 10px;
            margin-bottom: 0px;
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
		
		<h2> Dear $seller_user_name </h2>
		
		<p class='lead'> Are You Ready To Change Your Password. </p>
		
		<br>
		
		<a href='$site_url/change_password?code=$seller_pass".""."&username=$seller_user_name' class='btn'>
		 Click Here To Change Your Password
		</a>
		
		<hr>
		
		<p class='lead'>
		If clicking the button above does not work, copy and paste the following url in a new browser window: $site_url/change_password?code=$seller_pass".""."&username=$seller_user_name
		</p>
		
		</center>
		
		</div>
		
		</div>
		
		</body>
		
		</html>
		
		";
		
       $mail->send();
		
		echo "
        
        <script>

          swal({
           
          type: 'success',
          text: 'An email has been sent to your email address with instructions on how to change your password.',

          });

        </script>
		
		";

	
		
	}
	
}

?>