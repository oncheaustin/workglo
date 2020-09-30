<?php

session_start();

require_once("../includes/db.php");

$article_url = $input->get('article_url');

$get_articles = $db->select("knowledge_bank",array("article_url" => $article_url));

$row_articles = $get_articles->fetch();

$article_id = $row_articles->article_id;

$article_heading = $row_articles->article_heading;

$article_body = $row_articles->article_body;

$right_image = $row_articles->right_image;

$top_image = $row_articles->top_image;

$bottom_image = $row_articles->bottom_image;

?>

<!DOCTYPE html>

<html>

<head>

	<title> <?php echo $site_name; ?> - <?php echo $article_heading; ?> </title>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<meta name="description" content="<?php echo $site_desc; ?>">

	<meta name="keywords" content="<?php echo $site_keywords; ?>">

	<meta name="author" content="<?php echo $site_author; ?>">

	<link href="../styles/bootstrap.css" rel="stylesheet">

    <link href="../styles/custom.css" rel="stylesheet"> <!-- Custom css code from modified in admin panel --->

	<link href="../styles/styles.css" rel="stylesheet">

	<link href="../styles/knowledge_base.css" rel="stylesheet">

	<link href="../styles/categories_nav_styles.css" rel="stylesheet">

	<link href="../font_awesome/css/font-awesome.css" rel="stylesheet">

	<link href="../styles/owl.carousel.css" rel="stylesheet">

	<link href="../styles/owl.theme.default.css" rel="stylesheet">

	<link href="../styles/sweat_alert.css" rel="stylesheet">

	<link href="../styles/animate.css" rel="stylesheet">

	<?php if(!empty($site_favicon)){ ?>
   
    <link rel="shortcut icon" href="../images/<?php echo $site_favicon; ?>" type="image/x-icon">
       
    <?php } ?>
	
    <script type="text/javascript" src="js/sweat_alert.js"></script>
	
	<script type="text/javascript" src="js/jquery.min.js"></script>

	<style>

    .form-control{

    width: 200px;

    }

    </style>

</head>

<body>

<div class="header" 
<?php if(!empty($top_image)){ ?>
style="background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url(article_images/<?php echo $top_image; ?>);"
<?php } ?>
>

  <div class="container">

   <a class="navbar-brand logo text-success " href="<?php echo $site_url; ?>/index">
       
       <?php if($site_logo_type == "image"){ ?>

        <img src="<?php echo $site_url; ?>/images/<?php echo $site_logo_image; ?>" width="150" style="margin-top:8%;">

        <?php }else{ ?>

        <?php echo $site_logo_text; ?>

        <?php } ?>
       
   </a>

   <div class="text-center">

       <h2 class="text-white mt-5">KNOWLEDGE BANK FOR <?php echo strtoupper($site_name);?></h2>

       <h4 class="text-white">Everything you need to know</h4>

   </div>

   <div class="text-center reduceForm">

	<form action="" method="post">

	<div class="input-group space50">

	<input type="text" name="search_query" class="form-control" value=""  placeholder="Search Questions">

	<div class="input-group-append move-icon-up" style="cursor:pointer;">

	<button name="search_article" type="submit" class="search_button">

	<img src="../images/srch2.png" class="srch2">

	</button>

	</div>

	</div>

	</form>
    
</div>

</div>

</div>


		    <?php

            if(isset($_POST['search_article'])){

            $search_query = $input->post('search_query');

			echo "<script>window.open('$site_url/search_articles?search=$search_query','_self')</script>";


            }

            ?>


<div class="container mt-5">


      <div class="row">

      <div 
	  <?php if(!empty($right_image)){ ?>
	  class="col-md-9"
	  <?php }else{ ?>
	  class="col-md-12"
	  <?php } ?>
	  >

         <h3 class="make-black pb-1"><i class="text-success fa fa-book"></i> <?php echo $article_heading; ?> </h3> 
		 
		 <hr>
		 		 
		  <p><?php echo $article_body; ?></p>
		  

          <br><br>

      </div>
		
<?php if(!empty($right_image)){ ?>

	<div class="col-md-3">
			  
	<img src="article_images/<?php echo $right_image; ?>" class="img-fluid mt-5"> 
	
	</div>
	
   <?php } ?>

   </div>


</div>


<section class="text-center p-5" 
<?php if(!empty($bottom_image)){ ?>
style="background-image:url(article_images/<?php echo $bottom_image; ?>); color:white;"
<?php }else{ ?>
style="background-color:#F7F7F7; "
<?php } ?>
>

<h1 style=" font-family: 'Montserrat-Regular';" >Do you still have questions ?</h1>

<h6 style="    font-family:'Montserrat-Light';" class=" mt-2">Our support agents are ready with the answers.</h6>
<?php if(!empty($bottom_image)){ ?>
<a href="../customer_support" class="mt-2 btn btn-lg btn-outline-secondary">Contact Us</a>
<?php }else{ ?>
<a href="../customer_support" class="mt-2 btn btn-lg btn-outline-success">Contact Us</a>
<?php } ?>
</section>

<?php include "../includes/footer.php"; ?>

</body>

</html>
