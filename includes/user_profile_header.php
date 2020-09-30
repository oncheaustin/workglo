<?php
$select_seller = $db->select("sellers",array("seller_user_name" => $get_seller_user_name)); 
$row_seller = $select_seller->fetch();
$seller_id = $row_seller->seller_id;
$seller_user_name = $row_seller->seller_user_name;
$seller_image = $row_seller->seller_image;
$seller_cover_image = $row_seller->seller_cover_image;
if(empty($seller_cover_image)){ 
$seller_cover_image = "images/user-background.jpg";
}else{
$seller_cover_image = "cover_images/".rawurlencode($seller_cover_image)."";
}
$seller_country = $row_seller->seller_country;
$seller_headline = $row_seller->seller_headline;
$seller_about = $row_seller->seller_about;
$seller_level = $row_seller->seller_level;
$seller_rating = $row_seller->seller_rating;
$seller_register_date = $row_seller->seller_register_date;
$seller_recent_delivery = $row_seller->seller_recent_delivery;
$seller_status = $row_seller->seller_status;
$select_buyer_reviews = $db->select("buyer_reviews",array("review_seller_id"=>$seller_id)); 
$count_reviews = $select_buyer_reviews->rowCount();
if(!$count_reviews == 0){
  $rattings = array();
  while($row_buyer_reviews = $select_buyer_reviews->fetch()){
    $buyer_rating = $row_buyer_reviews->buyer_rating;
    array_push($rattings,$buyer_rating);
  }
  $total = array_sum($rattings);
  @$average = $total/count($rattings);
  $average_rating = substr($average ,0,1);
}else{
 $average = "0";  
 $average_rating = "0";
}
$level_title = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;
$count_proposals = $db->count("proposals",array("proposal_seller_id" => $seller_id,"proposal_status" => 'active'));
?>
<div class="col-md-12 user-header pl-5 pr-5 pt-5 pb-5" style="background: url(<?php echo $seller_cover_image; ?>);">
  <?php if(isset($_SESSION['seller_user_name'])){ ?>
  <?php if($_SESSION['seller_user_name'] == $seller_user_name){ ?>
  <a href="settings?profile_settings" class="btn btn-edit btn-success" ><i class="fa fa-pencil"></i> Edit&nbsp;</a>    
  <?php } ?>
  <?php } ?>
  <div class="profile-image float-lg-left flaot-md-left float-none mr-4">
    <?php if(!empty($seller_image)){ ?>
      <img src="user_images/<?php echo $seller_image; ?>" class="rounded-circle">
    <?php }else{ ?>
      <img src="user_images/empty-image.png" class="rounded-circle">
    <?php } ?>
    <?php if($seller_level == 2){ ?>
      <img src="images/level_badge_1.png" class="level_badge">
    <?php } ?>
    <?php if($seller_level == 3){ ?>
      <img src="images/level_badge_2.png" class="level_badge">
    <?php } ?>
    <?php if($seller_level == 4){ ?>
      <img src="images/level_badge_3.png" class="level_badge">
    <?php } ?>
  </div>
  <div class="content-bar mt-3">
    <h1> Hi, I'm <?php echo ucfirst($seller_user_name); ?> </h1>
    <span class="headline">
      <?php echo $seller_headline; ?>
    </span>
    <div class="star-rating">
      <?php
      for($seller_i=0; $seller_i<$average_rating; $seller_i++){
        echo " <i class='fa fa-star'></i> ";
      }
      for($seller_i=$average_rating; $seller_i<5; $seller_i++){
        echo " <i class='fa fa-star-o'></i> ";
      }
      ?>
      <span class="text-white m-1"><strong><?php printf("%.1f", $average); ?></strong> (<?php echo $count_reviews; ?>)</span>
      <span class="text-white">
        <i class="fa fa-map-marker m-1"></i> <?php echo $seller_country; ?>
      </span>
    </div>
    <?php if($seller_status == "online"){ ?>
    <span class="user-is-online">
      <span class="text-success h6"><i class="fa fa-circle"></i></span>
      <span>online</span>
    </span>
    <?php } ?>
  </div> 
  <?php if($count_proposals != 0){ ?>
  <?php if(!isset($_SESSION['seller_user_name'])){ ?>
  <a class="btn btn-success mt-3" href="login.php"> Contact <small>(<?php echo $seller_user_name; ?>)</small></a>
  <?php }else{ ?>
  <?php if($_SESSION['seller_user_name'] != $seller_user_name){ ?>
  <a class="btn btn-success mt-3" href="<?php echo $site_url; ?>/conversations/message.php?seller_id=<?php echo $seller_id ?>"> 
  Contact <small>(<?php echo $seller_user_name; ?>)</small>
  </a>
  <?php } ?>
  <?php } ?>
  <?php } ?>
</div>
<div class="col-md-12 user-status" >
  <ul>
    <li>
    <i class="fa fa-user"></i>
    <strong>Member Since: </strong> <?php echo $seller_register_date; ?>
    </li>
    <?php if($seller_recent_delivery != "none"){ ?>
    <li>
    <i class="fa fa-truck fa-flip-horizontal"></i>
    <strong>Recent Delivery: </strong> <?php echo $seller_recent_delivery; ?> 
    </li>
    <?php } ?>
    <?php if($seller_level != 1){ ?>
    <li>
    <i class="fa fa-bars"></i>
    <strong>Seller Level: </strong> <?php echo $level_title; ?>
    </li>
    <?php } ?>
  </ul>
</div>
