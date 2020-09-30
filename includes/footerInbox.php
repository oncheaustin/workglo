
<?php if(!isset($_COOKIE['close_cookie'])){ ?>

<section class="clearfix cookies_footer row animated slideInLeft">

<div class="col-md-4">

<img src="<?php echo $site_url; ?>/images/cookie.png" class="img-fluid" alt="">

</div>

<div class="col-md-8">

<div class="float-right close btn btn-sm"><i class="fa fa-times"></i></div>

<h4 class="mt-0 mt-lg-2">Our site uses cookies</h4>

<p class="mb-1">We use cookies to ensure you get the best experience. By using our website you agree <br>to our <a href='<?php echo $site_url; ?>/terms_and_conditions'>Privacy Policy</a>.</p>

<a href="#" class="btn btn-success btn-sm">Got It.</a>

</div>

</section>

<?php } ?>

<section class="messagePopup animated slideInRight">
</section>

<link rel="stylesheet" href="<?php echo $site_url; ?>/styles/msdropdown.css"/>

<?php require("footerJs.php"); ?>