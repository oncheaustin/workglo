<?php
if(isset($_SESSION['seller_user_name'])){
  $login_seller_user_name = $_SESSION['seller_user_name'];
  $select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
  $row_login_seller = $select_login_seller->fetch();
  $login_seller_id = $row_login_seller->seller_id;
  $login_seller_enable_sound = $row_login_seller->enable_sound;
}
?>
<script src="<?php echo $site_url; ?>/js/msdropdown.js"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/js/jquery.sticky.js"></script>
<script type="text/javascript" id="custom-js" src="<?php echo $site_url; ?>/js/customjs.js" data-logged-id="<?php if(isset($_SESSION['seller_user_name'])){ echo $login_seller_id; }?>" data-base-url="<?php echo $site_url; ?>" data-enable-sound="<?php if(isset($_SESSION['seller_user_name'])){ echo $login_seller_enable_sound; }?>"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/js/categoriesProposal.js"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/js/owl.carousel.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo $site_url; ?>/js/bootstrap.js"></script> -->
<script type="text/javascript" src="<?php echo $site_url; ?>/js/summernote.js"></script>

<script>
$(document).ready(function(){
  $("#languageSelect").change(function(){
    var url = $("#languageSelect option:selected").data("url");
    window.location.href = url;
  });

  $("#languageSelect").msDropdown({visibleRows:4});
  <?php if(isset($_SESSION['seller_user_name'])){ ?>
  var seller_id = "<?php echo $login_seller_id; ?>";
  var base_url = "<?php echo $site_url; ?>";
  <?php } ?>

  $(".cookies_footer .btn").click(function(){
    $.ajax({
    method: "POST",
    url: "<?php echo $site_url; ?>/includes/close_cookies_footer",
    data: {close : 'close'}
    }).done(function(data){
      $(".cookies_footer").fadeOut();
    });
  });
});
<?php if(!isset($proposals_stylesheet)){ ?>
$(window).scroll(function(){
  var scrollTop = $(window).scrollTop();
  if(scrollTop > 0){
    $('.home-header').addClass('affix')
  }else{
    $('.home-header').removeClass('affix')
  }
});
<?php } ?>
</script>