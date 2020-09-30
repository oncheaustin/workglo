<?php

session_start();

require_once("includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('login','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

?>

<!DOCTYPE html>
<html lang="en" class="ui-toolkit">

<head>

	<title><?php echo $site_name; ?> - All Your Purchases.</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php echo $site_desc; ?>">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<meta name="author" content="<?php echo $site_author; ?>">

	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">

	<link href="styles/bootstrap.css" rel="stylesheet">
    <link href="styles/custom.css" rel="stylesheet"> <!-- Custom css code from modified in admin panel --->
	<link href="styles/styles.css" rel="stylesheet">
	<link href="styles/user_nav_styles.css" rel="stylesheet">
	<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery.min.js"></script>

    <?php if(!empty($site_favicon)){ ?>
   
    <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
       
    <?php } ?>

</head>

<body class="is-responsive">

<?php require_once("includes/user_header.php"); ?>

<div class="container">

	<div class="row">

		<div class="col-md-12 mt-5">

			<h2 class="mb-5 <?=($lang_dir == "right" ? 'text-right':'')?>"> <?php echo $lang["titles"]["purchases"]; ?> </h2>

			<div class="table-responsive box-table">

				<table class="table table-bordered">

					<thead>

						<tr>

							<th>Date</th>

							<th>For</th>

							<th>Amount</th>

						</tr>

					</thead>

					<tbody>
                        
                        <?php 
                
                            $get_purchases = $db->select("purchases",array("seller_id" => $login_seller_id),"DESC");
                        
                            $count_purchases = $get_purchases->rowCount();

                            while($row_purchases = $get_purchases->fetch()){

                            $order_id = $row_purchases->order_id;

                            $amount = $row_purchases->amount;

                            $date = $row_purchases->date;

                            $method = $row_purchases->method;

                        ?>

						<tr>

							<td> <?php echo $date; ?> </td>

							<td> 
                                
                            <?php if($method == "shopping_balance"){ ?>

                                Proposal/Service purchased with Shopping Balance  
                                (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success"> View Order </a>)

                                <?php }elseif($method == "stripe"){ ?>

                                Deposit from credit card / stripe
                                (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success"> View Order </a>)

                                <?php }elseif($method == "paypal"){ ?>

                                Payment for purchase with paypal
                                (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success">View Order</a>)

                                <?php }elseif($method == "payza"){ ?>

                                Payment for purchase with payza
                                (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success">View Order</a>)

                                <?php }elseif($method == "coinpayments"){ ?>

                                Payment for purchase with coinpayments
                                (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success"> View Order </a>)

                                <?php }elseif($method == "mobile_money"){ ?>

                                Payment for purchase with mobile money
                                (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success"> View Order </a>)

                                <?php }elseif($method == "order_cancellation"){ ?>

                                Cancelled order payment refunded to your shopping  balance
                                (<a href="order_details?order_id=<?php echo $order_id; ?>" class="text-success"> View Order </a>)

                            <?php } ?>
                                
							</td>

							<td class="text-danger"> 
                                
                                
                                <?php 

                                    if($method == "order_cancellation"){

                                    echo "<span class='text-success'>+$s_currency$amount.00</span>";

                                    }else{

                                    echo "-$s_currency$amount.00";

                                    }

                                ?> 
                            
                          </td>

						</tr>
                        
                        <?php } ?>
                        
					</tbody>


				</table>
                
                
                <?php
                
                
                  if($count_purchases == 0){
                      
                      echo "<center><h3 class='pb-4 pt-4'><i class='fa fa-meh-o'></i> You have no purchases to display.</h3></center>";
                  }
                
                
                
                ?>


			</div>


		</div>


	</div>


</div>



<?php require_once("includes/footer.php"); ?>



</body>

</html>