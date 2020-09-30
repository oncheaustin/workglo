<div class="mp-gig-top-nav">
  <nav>
    <ul class="container text-center" id="mainNav">
      <li class="selected">
        <a href="#introduction" class="gig-page-nav-link">Introduction</a>
      </li>
      <li>
        <a href="#details" class="gig-page-nav-link">Proposal Details</a>
      </li>
      <?php if($count_faq != 0){ ?>
      <li>
        <a href="#faq" class="gig-page-nav-link">FAQ</a>
      </li>
      <?php } ?>
      <li>
        <a href="#reviews" class="gig-page-nav-link">Reviews</a>
      </li>
      <li>
        <a href="#related" class="gig-page-nav-link">Related Proposals</a>
      </li>
      <?php if($proposal_seller_vacation == "off"){ ?>
      <li>
      <a href="#redirect" onclick="window.location.href='../../conversations/message.php?seller_id=<?php echo $proposal_seller_id; ?>'" class="gig-page-nav-link"> <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> Message the Seller</a>
      </li>
      <?php } ?>
      <?php if($proposal_price != 0){ ?>
      <li class="btns d-none">
      <button class="order-now btn btn-secondary">Order Now (<?php echo $s_currency; ?><span class="total-price"><?php echo $proposal_price; ?></span>)</button>
      </li>
      <?php } ?>
      <li class="btns d-none <?php if($proposal_price == 0){ echo "float-right"; }?>">
      <?php if(@$count_p_cart == 1){ ?>
      <button class="btn btn-secondary"><?php include("../images/svg/cart.svg"); ?> Already Added</button>
      <?php }else{ ?>
      <button class="add-to-cart btn btn-secondary"><?php include("../images/svg/cart.svg"); ?> Add To Cart</button>
      <?php } ?>
      </li>
    </ul>
  </nav>
</div>

<div class="container mt-5" id="introduction"> <!-- Container starts -->
  <div class="row">
  <div class="col-lg-8 col-md-7 mb-3"><!--- col-lg-8 col-md-7 mb-3 Starts --->
    <div class="card rounded-0 mb-5 border-0">
      <div class="card-body details pt-0">
        <div class="proposal-info <?=($lang_dir == "right" ? 'text-right':'')?>">
        <h3><?php echo ucfirst($proposal_title); ?></h3>
        <hr>
        <nav class="breadcrumbs h-text-truncate mb-2">
        <a href="../../">Home</a>
        <a href="../../categories/<?php echo $proposal_cat_url; ?>"> <?php echo $proposal_cat_title; ?> </a> 
        <a href="../../categories/<?php echo $proposal_cat_url; ?>/<?php echo $proposal_child_url; ?>">
        <?php echo $proposal_child_title; ?>
        </a>
        </nav>
        <?php
        for($proposal_i=0; $proposal_i<$proposal_rating; $proposal_i++){
        echo " <img class='mb-2' src='../../images/user_rate_full.png' > ";
        }
        for($proposal_i=$proposal_rating; $proposal_i<5; $proposal_i++){
        echo " <img class='mb-2' src='../../images/user_rate_blank.png' > ";
        }
        ?>
        <span class="text-muted span"> (<?php echo $count_reviews; ?>) &nbsp;&nbsp; <?php echo $proposal_order_queue; ?> Order(s) In Queue.</span>
        <div class="sharethis-inline-share-buttons <?=($lang_dir == "right" ? 'float-left':'')?>" style="margin-top: -32px;"></div>
        </div>
        <?php include("includes/proposal_slider.php"); ?>
      </div>
    </div>
    <?php if($proposal_price == 0){ ?>
    <div class="card rounded-0 mb-3 <?=($lang_dir == "right" ? 'text-right':'')?>" id="compare">
    <div class="card-header"><h5>Compare Packages</h5></div>
    <div class="card-body p-0">
    <div class="table-responsive">
    <table class="table table-bordered mb-0">
    <tbody>
    <?php
    $get_p_1 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Basic'));
    $row_1 = $get_p_1->fetch();
    $p_id_1 = $row_1->package_id;
    $p_name_1 = $row_1->package_name;
    $p_description_1 = $row_1->description;
    $p_revisions_1 = $row_1->revisions;
    $p_delivery_time_1 = $row_1->delivery_time;
    $p_price_1 = $row_1->price;
    $get_p_2 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Standard'));
    $row_2 = $get_p_2->fetch();
    $p_id_2 = $row_2->package_id;
    $p_name_2 = $row_2->package_name;
    $p_description_2 = $row_2->description;
    $p_revisions_2 = $row_2->revisions;
    $p_delivery_time_2 = $row_2->delivery_time;
    $p_price_2 = $row_2->price;
    $get_p_3 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Advance'));
    $row_3 = $get_p_3->fetch();
    $p_id_3 = $row_3->package_id;
    $p_name_3 = $row_3->package_name;
    $p_description_3 = $row_3->description;
    $p_revisions_3 = $row_3->revisions;
    $p_delivery_time_3 = $row_3->delivery_time;
    $p_price_3 = $row_3->price;
    ?>
    <tr class="<?=($lang_dir == "right" ? 'text-right':'')?>">
    <td class="b-ccc">  </td>
    <td><h5><?php echo $p_name_1; ?></h5></td>
    <td><h5><?php echo $p_name_2; ?></h5></td>
    <td><h5><?php echo $p_name_3; ?></h5></td>
    </tr>
    <tr class="<?=($lang_dir == "right" ? 'text-right':'')?>" width="20">
      <td class="b-ccc">Description</td>
      <td><?php echo $p_description_1; ?></td>
      <td><?php echo $p_description_2; ?></td>
      <td><?php echo $p_description_3; ?></td>
    </tr>

    <?php
    $get_a = $db->select("package_attributes",array("package_id"=>$p_id_1));
    while($row_a = $get_a->fetch()){
    $a_id = $row_a->attribute_id;
    $a_name = $row_a->attribute_name;
    $a_value = $row_a->attribute_value;
    ?>
    <tr>
      <td class="b-ccc" width="150"> <?php echo $a_name; ?> </td>
      <td><?php echo $a_value; ?> </td>
      <?php
      $get_v = $db->query("select * from package_attributes where proposal_id='$proposal_id' and attribute_name='$a_name' and not attribute_id='$a_id'");
      while($row_v = $get_v->fetch()){
      $value = $row_v->attribute_value;
      ?>
      <td><?php echo $value; ?> </td>
    <?php } ?>
    </tr>
    <?php } ?>
    
    <tr>
      <td class="b-ccc" width="150"> Revisions </td>
      <td><?= $p_revisions_1; ?></td>
      <td><?= $p_revisions_2; ?></td>
      <td><?= $p_revisions_3; ?></td>
    </tr>
    <tr>
      <td class="b-ccc" width="150"> Delivery Time </td>
      <td><?php echo $p_delivery_time_1; ?> Days</td>
      <td><?php echo $p_delivery_time_2; ?> Days</td>
      <td><?php echo $p_delivery_time_3; ?> Days</td>
    </tr>
    <tr>
      <td class="b-ccc"> Qty </td>
      <td>
        <form method="post" action="../../checkout">
          <input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">
          <input type="hidden" name="package_id" value="<?php echo $p_id_1; ?>">
          <select class="form-control mb-2" name="proposal_qty">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          </select>
          <?php if($proposal_seller_id == @$login_seller_id){ ?>
          <a class="btn btn-success text-white btn-block" href="../edit_proposal?proposal_id=<?php echo $proposal_id; ?>&pricing">Edit Package</a>
          <?php }else{ ?>
          <button class="btn btn-success text-white btn-block" type="submit" name="add_order">Select <?php echo $s_currency; ?><?php echo $p_price_1; ?></button>
          <?php } ?>
        </form>
      </td>
      <td>
        <form method="post" action="../../checkout">
          <input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">
          <input type="hidden" name="package_id" value="<?php echo $p_id_2; ?>">
          <select class="form-control mb-2" name="proposal_qty">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          </select>
          <?php if($proposal_seller_id == @$login_seller_id){ ?>
          <a class="btn btn-success text-white btn-block" href="../edit_proposal?proposal_id=<?php echo $proposal_id; ?>&pricing">Edit Package</a>
          <?php }else{ ?>
          <button class="btn btn-success text-white btn-block" type="submit" name="add_order">Select <?php echo $s_currency; ?><?php echo $p_price_2; ?></button>
          <?php } ?>
        </form>
      </td>
      <td>
        <form method="post" action="../../checkout">
          <input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">
          <input type="hidden" name="package_id" value="<?php echo $p_id_3; ?>">
          <select class="form-control mb-2" name="proposal_qty">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          </select>
          <?php if($proposal_seller_id == @$login_seller_id){ ?>
          <a class="btn btn-success text-white btn-block" href="../edit_proposal?proposal_id=<?php echo $proposal_id; ?>&pricing">Edit Package</a>
          <?php }else{ ?>
          <button class="btn btn-success text-white btn-block" type="submit" name="add_order">Select <?php echo $s_currency; ?><?php echo $p_price_3; ?></button>
          <?php } ?>
        </form>
      </td>
    </tr>
    </tbody>
    </table>
    </div>
    </div>
    </div>
    <?php } ?>

    <div class="card rounded-0 mb-5 <?=($lang_dir == "right" ? 'text-right':'')?>" id="details">
      <div class="card-header"><h4>About This Proposal</h4></div>
      <div class="card-body proposal-desc"><?php echo $proposal_desc; ?></div>
    </div>

    <?php if($count_faq > 0){ ?>
    <div class="card mb-5 <?=($lang_dir == "right" ? 'text-right':'')?>" id="faq"><!-- card Starts -->
    <div class="card-header"><!-- card-header Starts -->
    <h4>Frequently Asked Questions</h4>
    </div><!-- card-header Ends -->
    <div class="card-body tabs pl-0 pr-0 pt-2"><!-- card-body Starts -->
      <?php 
      while($row_faq = $get_faq->fetch()){
      $id = $row_faq->id;
      $title = $row_faq->title;
      $content = $row_faq->content;
      ?>
      <div class="tab rounded"><!-- tab rounded Starts -->
      <div class="tab-header" data-toggle="collapse" href="#tab-<?php echo $id; ?>">
      <?php echo $title; ?>
      </div>
      <div class="tab-body p-3 collapse" id="tab-<?php echo $id; ?>"><?php echo $content; ?></div>
      </div><!-- tab rounded Ends -->
      <?php } ?>
      <div class="clearfix"></div>
    </div><!-- card-body Ends -->
    </div><!-- card mb-3 Ends -->
    <?php } ?>

    <div class="card proposal-reviews rounded-0 mb-5" id="reviews">
      <div class="card-header">
        <h4 class="mb-0 <?=($lang_dir == "right" ? 'text-right':'')?>">
        <div class="float-left">
        <span class="mr-2"> <?php echo $count_reviews; ?> Reviews </span>
        <?php
        for($proposal_i=0; $proposal_i<$proposal_rating; $proposal_i++){
        echo " <img class='mb-2' src='../../images/user_rate_full_big.png' > ";
        }
        for($proposal_i=$proposal_rating; $proposal_i<5; $proposal_i++){
        echo " <img class='mb-2' src='../../images/user_rate_blank_big.png' > ";
        }
        ?> <span class="text-muted ml-2"> <?php
        if($proposal_rating == "0"){
        echo "0.0"; 
        }else{
        printf("%.1f", $average_rating);
        }
        ?> </span>
        </div>
        <div class="float-right">
        <button id="dropdown-button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"> Most Recent </button>
        <ul class="dropdown-menu proposalDropdown" style="width: auto !important;">
        <li class="dropdown-item active all">Most Recent</li>
        <li class="dropdown-item  good">Positive Reviews</li>
        <li class="dropdown-item  bad">Negative Reviews</li>
        </ul>
        </div>
        </h4>
      </div>
      <div class="card-body <?=($lang_dir == "right" ? 'text-right':'')?>">
      <?php include("includes/proposal_reviews.php") ?>
      </div>
    </div>
    <div class="proposal-tags-container mt-2 <?=($lang_dir == "right" ? 'text-right':'')?>"><!--- proposal-tags-container Starts --->
      <?php
      $tags = explode(",", $proposal_tags);
      foreach($tags as $tag){
      ?>
      <div class="proposal-tag mb-3" style="<?=($lang_dir == "right" ? 'float: right;':'')?>"><a href="../../tags/<?php echo $tag; ?>"><span><?php echo $tag; ?></span></a></div>
      <?php } ?>
    </div><!--- proposal-tags-container Ends --->

  </div><!--- col-lg-8 col-md-7 mb-3 Ends --->

  <div class="col-lg-4 col-md-5 proposal-sidebar"> <!-- Col starts -->
  <?php include("includes/proposal_sidebar.php"); ?>
  </div> <!-- Col ends -->

  </div>
</div><!--Container ends -->

<script>
$(document).ready(function(){

  $(".order-now").click(function(){
    $('<input />').attr('type', 'hidden').attr('name', "add_order").attr('value', " ").appendTo('#checkoutForm');
    $("#checkoutForm").submit();
  });
  $(".add-to-cart").click(function(){
    $('<input />').attr('type', 'hidden').attr('name', "add_cart").attr('value', " ").appendTo('#checkoutForm');
    $("#checkoutForm").submit();
  });

  $(window).scroll(function(){
    var scrollTop = $(window).scrollTop();
    if(scrollTop > 0){
      $('.mp-gig-top-nav li.btns').removeClass("d-none");
      $('.mp-gig-top-nav').css({ position : 'fixed', zIndex : "100", top : "0px" });
    }else{
      $('.mp-gig-top-nav li.btns').addClass("d-none");
      $('.mp-gig-top-nav').css({ position : 'sticky', zIndex : "10" });
    }
  });

  <?php if(isset($_SESSION['seller_user_name'])){ ?>
  $(document).on("click", "#favorite_<?php echo $proposal_id; ?>", function(event){
    event.preventDefault();
    var seller_id = "<?php echo $login_seller_id; ?>";
    var proposal_id = "<?php echo $proposal_id; ?>";
    $.ajax({
        type: "POST",
        url: "../../includes/add_delete_favorite",
        data: { seller_id: seller_id, proposal_id: proposal_id, favorite: "add_favorite" },
        success: function(){
        $("#favorite_<?php echo $proposal_id; ?>").attr({id: "unfavorite_<?php echo $proposal_id; ?>",});
        $("#unfavorite_<?php echo $proposal_id; ?>").html("<i class='fa fa-heart dil'></i>");
        }
    });
  });

  $(document).on("click", "#unfavorite_<?php echo $proposal_id; ?>", function(event){
    event.preventDefault();
    var seller_id = "<?php echo $login_seller_id; ?>";
    var proposal_id = "<?php echo $proposal_id; ?>";
    $.ajax({
        type: "POST",
        url: "../../includes/add_delete_favorite",
        data: { seller_id: seller_id, proposal_id: proposal_id, favorite: "delete_favorite" },
        success: function(){
        $("#unfavorite_<?php echo $proposal_id; ?>").attr({id: "favorite_<?php echo $proposal_id; ?>"});
        $("#favorite_<?php echo $proposal_id; ?>").html("<i class='fa fa-heart dil1'></i>");
        }
    });
  });
  <?php } ?>

  $('.increase').click(function(){
    var current = parseInt($('.quantity').text());
    var num = current+1;
    var value = parseInt($('.total-price').first().text());
    $('.quantity').html(num);
    $('form input[name="proposal_qty"]').val(num);
  });

  $('.decrease').click(function(){
    var current = parseInt($('.quantity').text());
    if(current > 1){
    var num = current-1;
    var value = parseInt($('.total-price').first().text());
    $('.quantity').html(num);
    $('form input[name="proposal_qty"]').val(num);
    }
  });

  $('.all').click(function(){
    $("#dropdown-button").html("Most Recent");
    $(".all").attr('class','dropdown-item all active');
    $(".bad").attr('class','dropdown-item bad');
    $(".good").attr('class','dropdown-item good');
    $("#all").show();
    $("#good").hide();
    $("#bad").hide();
  }); 

  $('.good').click(function(){
    $("#dropdown-button").html("Positive Reviews");
    $(".all").attr('class','dropdown-item all');
    $(".bad").attr('class','dropdown-item bad');
    $(".good").attr('class','dropdown-item good active');
    $("#all").hide();
    $("#good").show();
    $("#bad").hide();
  }); 

  $('.bad').click(function(){
    $("#dropdown-button").html("Negative Reviews");
    $(".all").attr('class','dropdown-item all');
    $(".bad").attr('class','dropdown-item bad active');
    $(".good").attr('class','dropdown-item good');
    $("#all").hide();
    $("#good").hide();
    $("#bad").show();
  });

});
</script>