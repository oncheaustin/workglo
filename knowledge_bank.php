<?php
  session_start();
  require_once("includes/db.php");
?>
<!DOCTYPE html>
<html lang="en" class="ui-toolkit">
  <head>
    <title> <?php echo $site_name; ?> - Knowledge Bank </title>
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
    <link href="styles/knowledge_base.css" rel="stylesheet">
    <link href="styles/categories_nav_styles.css" rel="stylesheet">
    <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
    <link href="styles/owl.carousel.css" rel="stylesheet">
    <link href="styles/owl.theme.default.css" rel="stylesheet">
    <link href="styles/sweat_alert.css" rel="stylesheet">
    <link href="styles/animate.css" rel="stylesheet">
    <?php if(!empty($site_favicon)){ ?>
    <link rel="shortcut icon" href="images/<?php echo $site_favicon; ?>" type="image/x-icon">
    <?php } ?>
    <script type="text/javascript" src="js/ie.js"></script>
    <script type="text/javascript" src="js/sweat_alert.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <style>
      .form-control{
      width: 200px;
      }
    </style>
  </head>
  <body class="is-responsive">
    <div class="header" style="<?=($lang_dir == "right" ? 'direction: rtl;':'')?>">
      <div class="container">
        <a class="navbar-brand logo text-success" href="<?php echo $site_url; ?>/index">
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
              <input type="text" name="search_query" class="form-control" value="" required  placeholder="Search Questions">
              <div class="input-group-append move-icon-up" style="cursor:pointer;">
                <button name="search_article" type="submit" class="search_button">
                <img src="images/srch2.png" class="srch2">
                </button>
              </div>
            </div>
          </form>
          <?php
            if(isset($_POST['search_article'])){
            $search_query = $input->post('search_query');
            echo "<script>window.open('$site_url/search_articles?search=$search_query','_self')</script>";
            }
          ?>
        </div>
      </div>
    </div>
    <div class="container mt-5 mb-5">
      <div class="row" style="<?=($lang_dir == "right" ? 'direction: rtl;':'')?>">
        <?php
          $get_cats = $db->select("article_cat",array("language_id" => $siteLanguage));
          while($row_cats = $get_cats->fetch()){
          $article_cat_id = $row_cats->article_cat_id;
          $article_cat_title = $row_cats->article_cat_title;
        ?>
        <div class="col-md-6">
          <h3 class="make-black pb-1"><i class="fa fa-bars"></i> <?php echo $article_cat_title; ?> </h3>
          <!-- Category -->
          <?php 
            $get_articles = "select * from knowledge_bank where cat_id='$article_cat_id' AND language_id='$siteLanguage'";
            $get_articles = $db->select("knowledge_bank",array("cat_id" => $article_cat_id,"language_id" => $siteLanguage));
            $count_articles = $get_articles->rowCount();
            if($count_articles == 0){
              echo "No articles to display at the moment.";
            }
            while($row_articles = $get_articles->fetch()){
            $article_id = $row_articles->article_id;
            $article_url = $row_articles->article_url;
            $article_heading = $row_articles->article_heading;
          ?>
            <h6><a href="article/<?php echo $article_url; ?>" class="text-success">
              <i class="fa fa-book"></i> <?php echo $article_heading; ?></a>
            </h6>
          <?php } ?>
          <br><br>
        </div>
        <?php } ?>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>
  </body>
</html>