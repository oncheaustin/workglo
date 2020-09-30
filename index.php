
<?php
session_start();
require_once("includes/db.php");
if(strpos($_SERVER["REQUEST_URI"], 'index') !== false){
  header("location: $site_url");
}
require_once("social-config.php");
$site_title = $row_general_settings->site_title;

?>
<!DOCTYPE html>
<html>

<!-- Mirrored from www.workglo.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Feb 2020 15:01:01 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
<meta charset="utf-8">
<title><?php echo $site_title; ?></title>
<!--<link rel="icon" href="images/favicon.png">-->
<meta name="viewport" id="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<?php if($row_general_settings->knowledge_bank == 'yes'): ?>
  <link href="styles/knowledge_bank.css" rel="stylesheet">
<?php endif ?>

<?php if(!empty($site_favicon)){ ?>
<link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon" />
<?php } ?>

<!-- <link rel="stylesheet" type="text/css" href="css1/bootstrap.css" />
 -->
<link rel="stylesheet" type="text/css" href="css1/font-awesome.css" />

<link rel="stylesheet" type="text/css" href="css1/custom.css" />

<link rel="stylesheet" type="text/css" href="css1/responsive.css" />

<link href="https://fonts.googleapis.com/css?family=Montserrat:200,400,700" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"> 

<link href="css1/owl.carousel.css" rel="stylesheet"></head>

<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">






<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>






<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script> -->
<!--   -->
<body data-spy="scroll">



  





<?php

require_once("includes/header2.php");
if(!isset($_SESSION['seller_user_name'])){
  require_once("home.php");
}else{  
  require_once("user_home.php");
}
require_once("includes/footer.php"); 

?>
<?php if($row_general_settings->knowledge_bank == 'yes'): ?>



<div class="clearfix"></div>















<div class="sm popup-support-wrap">
  <div class="popup-support">
    <header class="hero-container" style="background-color: rgb(29, 191, 115); color: rgb(255, 255, 255);"><div class="hero"><h1 class="main-title"><a href="#" class="sm-back"><i class="pull-left fa fa-angle-left"></i></a> Knowledge Bank</h1><a class="support-nav" href="#">Our how to guides</a><h2 class="sub-title"></h2><div class="search-box"><div class="search-placeholder"><span class="svg-icon search-magnifier">
    <i class="fa fa-search"></i>
    </span>
    <!-- <span class="placeholder-text">What do you need help with?</span>-->
    </div><input type="text" id="sm-search" value=""></div></div></header>
    <div class="search-results">
      <div class="pull-left search-articles">
      <h3></h3>
      <ul></ul>
      </div>
      <div class="pull-left search-single">
      <div class="breadcrumbs"><a href="#" class="home-link" data-id=""><i class="fa fa-home"></i> <i class="fa fa-angle-right"></i> &nbsp;<span class="sm-category"></span></a></div>
      <div class="sm-title"></div>
      <div class="img imgtop"></div>
      <div class="sm-content"></div>
      <div class="img imgright"></div>
      <div class="img imgbottom"></div>
      </div>
    </div>
  </div>
</div>
<a class="support-que close pull-right">
  <i class="open-popup fa fa-question"></i>
  <i class="close-popup fa fa-remove"></i>
</a>



<script>var site_url='<?php echo $site_url; ?>';</script>
<script type="text/javascript" src="js/knowledge-bank.js"></script>
<?php endif; ?>






<style type="text/css">
  


</style>

</body>
</html>

