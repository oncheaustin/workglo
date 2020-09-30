<?php

session_start();

require_once("includes/db.php");

require_once("social-config.php");

?>
<!DOCTYPE html>

<html lang="en" class="ui-toolkit">

<head>

  <title> Start selling on <?php echo $site_name; ?> </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $site_desc; ?>">
  <meta name="keywords" content="<?php echo $site_keywords; ?>">
  <meta name="author" content="<?php echo $site_author; ?>">

  <link href="styles/bootstrap.css" rel="stylesheet">
  
  <link href="styles/custom.css" rel="stylesheet"> <!-- Custom css code from modified in admin panel --->
    
  <link href="styles/styles.css" rel="stylesheet">
  
  <link href="styles/categories_nav_styles.css" rel="stylesheet">
  
  <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
  
  <link href="styles/owl.carousel.css" rel="stylesheet">
  
  <link href="styles/owl.theme.default.css" rel="stylesheet">
    
  <link href="styles/sweat_alert.css" rel="stylesheet">
    
  <link href="styles/animate.css" rel="stylesheet">
   
  <link rel="shortcut icon" href="images/gigtodoFav.ico" type="image/x-icon">
       
    <script type="text/javascript" src="js/sweat_alert.js"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  
  <style>
        
        .swal2-popup .swal2-styled.swal2-confirm {
    
        background-color: #28a745;
        
        
    }
    
    </style>

</head>

<body class="is-responsive">

<?php require_once("includes/header.php"); ?>

<header id="start_selling">
  
  <h2 class="text-center text-white">Become A Seller On Our Platform</h2>
  
  <h3 class="text-center text-white">You bring the skill. We'll make earnings as easy as 1,2,3</h3>
  
  
<?php
    
  if(isset($_SESSION['seller_user_name'])){
        
      
?>

<div class="text-center btn_start_selling">

<a href="proposals/create_proposal" class="btn btn-success btn-lg btn_start_selling"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
 Create A Proposal</a>

  </div>
  
<?php }?>
 
 
 <?php
    
  if(!isset($_SESSION['seller_user_name'])){
        
      
?>
 
 <div class="text-center btn_start_selling">

<button data-toggle="modal" data-target="#register-modal" class="btn btn-success btn-lg btn_start_selling"><i class="fa fa-user-plus" aria-hidden="true"></i>
 Create An Account</button>

  </div>
  
<?php } ?>  
  
</header><br><br>

<section id="start_selling_body">
   
   <div class="container">
    
    <h2 class="text-center pb-5 pt-5">How Does This Work?</h2>
    
    <div class="row">
               <div class="col-md-4">
           <!--<i class="fa fa-address-card-o pb-4" style="color:#3498db;" aria-hidden="true"></i>-->
           
           <img style="position: relative; left: 50px; padding: 15px;" src="images/comp/create-icon.png">
            
            <h3 class="pb-4" style="position: relative; left: 40px;">Create a Proposal</h3>
            
            <p>Once you create an account, all you have to do to become a seller is to create a proposal/service. Make sure you proposal is as captivating as possible. Potential customers actually read through your content.</p>

            
        </div>
                
        <div class="col-md-4">
<!--<i class="fa fa-archive pb-4" style="color:#e67e22;" aria-hidden="true"></i>-->

<img style="position: relative; left: 50px; padding: 15px;" src="images/comp/approve-icon.png">
            
            <h3 class="pb-4" style="position: relative; left: 50px;">Submit Proposal</h3>
            
            <p>After you've created your amazing proposal/service, submit it so the admin can make sure everything looks good. Admins rarely decline proposals, however, make sure everything looks good before submitting.</p>

            
        </div>
        
        <div class="col-md-4">

          <img style="position: relative; left: 50px; padding: 15px;" src="images/comp/receive-icon.png">
            
            <h3 class="pb-4" style="position: relative; left: 50px;">Get Orders. Worldwide.</h3>
            
            <p>Yay! so your proposal/service was approved by the admin. Now's the good part, start receiving a ton of orders from customer from all over the world. Just perform your very best on every single order.</p>
            
        </div>
        
    </div><br/><br/>
    <hr>
    <br/><br/>
    
    <span style="padding: 200px; margin:200px;"></span>
    
    
    <div class="row">
          
          <div class="col-md-4">
           <!--<i class="fa fa-address-card-o pb-4" style="color:#3498db;" aria-hidden="true"></i>-->
           
           <img style="position: relative; left: 67px; padding: 15px;" src="images/comp/delivered-icon.png">
            
            <h3 class="pb-4" style="position: relative; left: 40px;">Deliver Masterpieces</h3>
            
            <p>Once you've received orders, try your very best to satisfy your customers. This is very important for return customers and amazing reviews. Communication is key, make sure you are in touch with your customer.</p>

            
        </div>
                
        <div class="col-md-4">
<!--<i class="fa fa-archive pb-4" style="color:#e67e22;" aria-hidden="true"></i>-->

<img style="position: relative; left: 67px; padding: 15px;" src="images/comp/rate-icon.png">
            
            <h3 class="pb-4" style="position: relative; left: 50px;">Rate Your Customers</h3>
            
            <p>A lot of customers do check their own ratings. It is important to rate customers based on their behaviour during the order process. This is important for other sellers, and for the admins. Most sellers give 5 stars.</p>

            
        </div>
        
        <div class="col-md-4">
<!--<i class="fa fa-check-square-o pb-4" aria-hidden="true"></i>-->

<img style="position: relative; left: 67px; padding: 15px;" src="images/comp/earn-icon.png">
            
            <h3 class="pb-4" style="position: relative; left: 50px;">Get Paid. On Time.</h3>
            
            <p>Get paid on time, every time. After the clearnace period, payment is transferred to you. Our system lets you transfer funds from our system to your PayPal, Mobile Money, Payoneer or Crypto account.</p>

            
        </div>
        
    </div>
    
    
    
    </div><br/><br/><br/>
    
    
    
    
    
</section>

<?php
    
  if(isset($_SESSION['seller_user_name'])){
        
      
?>

<div class="text-center btn_start_selling">

<a href="proposals/create_proposal" class="btn btn-success btn-lg btn_start_selling"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
 Create A Proposal</a>

  </div>
  
<?php }?>
 
 
 <?php
    
  if(!isset($_SESSION['seller_user_name'])){
        
      
?>
 
 <div class="text-center btn_start_selling">

<button data-toggle="modal" data-target="#register-modal" class="btn btn-success btn-lg btn_start_selling"><i class="fa fa-user-plus" aria-hidden="true"></i>
 Create An Account</button>

  </div> 
  
  
  
<?php } ?>  
   

<div class="pb-5"></div><br><br>


<?php require_once("includes/footer.php"); ?>


</body>

</html>