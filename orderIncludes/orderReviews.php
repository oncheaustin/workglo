<?php  

$get_buyer_reviews = $db->select("buyer_reviews",array("order_id"=>$order_id));

$count_buyer_reviews = $get_buyer_reviews->rowCount();

$row_buyer_reviews = $get_buyer_reviews->fetch();

if($count_buyer_reviews == 1){

$buyer_rating = $row_buyer_reviews->buyer_rating;

$buyer_review = $row_buyer_reviews->buyer_review;

$review_buyer_id = $row_buyer_reviews->review_buyer_id;

$review_date = $row_buyer_reviews->review_date;


$select_buyer = $db->select("sellers",array("seller_id" => $review_buyer_id));

$row_buyer = $select_buyer->fetch();

$buyer_user_name = $row_buyer->seller_user_name;

$buyer_image = $row_buyer->seller_image;

}


$get_seller_reviews = $db->select("seller_reviews",array("order_id"=>$order_id));

$count_seller_reviews =  $get_seller_reviews->rowCount();

$row_seller_reviews = $get_seller_reviews->fetch();

if($count_seller_reviews == 1){

$seller_rating = $row_seller_reviews->seller_rating;

$seller_review = $row_seller_reviews->seller_review;

$review_seller_id = $row_seller_reviews->review_seller_id;


$select_seller = $db->select("sellers",array("seller_id" => $review_seller_id));

$row_seller = $select_seller->fetch();

$seller_image = $row_seller->seller_image;

}


$count_all_reviews = "$count_buyer_reviews$count_seller_reviews";


if($count_all_reviews == "00"){


}else{

?>

<div class="card rounded-0 mt-3">

<div class="card-header bg-fivGrey">

<h5 class="text-center mt-2"><i class="fa fa-star"></i> Order Reviews </h5>

</div>

<div class="card-body">

<div class="proposal-reviews">

<ul class="reviews-list">

<?php if(!$count_buyer_reviews == 0){ ?>

<li class="star-rating-row">

<span class="user-picture">

<img src="user_images/<?php echo $buyer_image; ?>" width="60" height="60">

</span>

<h4>

<a href="#" class="mr-1 text-success"><?php echo $buyer_user_name; ?> </a>

<?php

for($buyer_i=0; $buyer_i<$buyer_rating; $buyer_i++){

echo "<img src='images/user_rate_full.png'>";

}

for($buyer_i=$buyer_rating; $buyer_i<5; $buyer_i++){

echo "<img src='images/user_rate_blank.png'>";

}

?>

</h4>

<div class="msg-body">

<?php echo $buyer_review; ?>

</div>

<span class="rating-date"><?php echo $review_date; ?> </span>

</li>

<hr class="mb-4">

<?php } ?>

<?php if(!$count_seller_reviews == 0){ ?>

<li class="rating-seller">

<h4>

<span class="mr-1">Seller's Feedback</span>

<?php 

for($seller_i=0; $seller_i<$seller_rating; $seller_i++){

echo "<img src='images/user_rate_full.png'>";

}

for($seller_i=$seller_rating; $seller_i<5; $seller_i++){

echo "<img src='images/user_rate_blank.png'>";

}

?>


</h4>

<span class="user-picture">

<img src="user_images/<?php echo $seller_image; ?>" width="40" height="40">


</span>

<div class="msg-body">

<?php echo $seller_review; ?>

</div>

</li>

<?php } ?>

<hr>

</ul>

</div>

</div>

</div> 

<?php } ?>



<?php if($seller_id == $login_seller_id){ ?>

<?php if($count_seller_reviews == 0){ ?>

<div class="order-review-box mb-3 p-3">

<h3 class="text-center text-white"> Please Submit a Review For Your Buyer</h3>

<div class="row">

<div class="col-md-8 offset-md-2">

<form method="post" align="center">

<div class="form-group">

<label class="h6 text-white">Review Rating</label>

<select name="rating" class="rating-select">

<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>



</select>

<script type="text/javascript">

$(document).ready(function(){

   $('.rating-select').barrating({

         theme: 'fontawesome-stars'

          });

        });

</script>


</div>

<textarea name="review" class="form-control mb-3" rows="5" placeholder="What was your Experience?"></textarea>

<input type="submit" name="seller_review_submit" class="btn btn-success" value="Submit Review">


</form>
            
<?php 

if(isset($_POST['seller_review_submit'])){

$rating = $input->post('rating');

$review = $input->post('review');

$insert_review = $db->insert("seller_reviews",array("order_id"=>$order_id,"review_seller_id"=>$seller_id,"seller_rating"=>$rating,"seller_review"=>$review));

$last_update_date = date("F d, Y");

$insert_notification = $db->insert("notifications",array("receiver_id" => $buyer_id,"sender_id" => $login_seller_id,"order_id" => $order_id,"reason" => "seller_order_review","date" => $last_update_date,"status" => "unread"));

echo "<script>

    swal({
      type: 'success',
      text: 'Review submitted successfully!',
      timer: 3000,
      onOpen: function(){
      swal.showLoading()
      }
      }).then(function(){
      if (
        // Read more about handling dismissals
        window.open('order_details?order_id=$order_id','_self')

      ) {
        console.log('Review submitted successfully')
      }
    })

    </script>";


}

?>

</div>


</div>

</div>

<?php }else{ ?>


<?php } ?>

<?php }elseif($buyer_id == $login_seller_id){ ?>


<?php if($count_buyer_reviews == 0){ ?>

<div class="order-review-box mb-3 p-3">

<h3 class="text-center text-white"> Please Submit a Review For Your Seller</h3>

<div class="row">

<div class="col-md-8 offset-md-2">

<form method="post" align="center">

<div class="form-group">

<label class="h6 text-white">Review Rating</label>

<select name="rating" class="rating-select">

<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>

</select>

<script type="text/javascript">

$(document).ready(function(){

                             $('.rating-select').barrating({

                                   theme: 'fontawesome-stars'

                                          });

                                  });

</script>


</div>

<textarea name="review" class="form-control mb-3" rows="5" placeholder="What was your Experience?"></textarea>

<input type="submit" name="buyer_review_submit" class="btn btn-success" value="Submit Review">


</form>

<?php

if(isset($_POST['buyer_review_submit'])){

$rating = $input->post('rating');

$review = $input->post('review');

$date = date("M d Y");

$insert_review = $db->insert("buyer_reviews",array("proposal_id"=>$proposal_id,"order_id"=>$order_id,"review_buyer_id"=>$buyer_id,"buyer_rating"=>$rating,"buyer_review"=>$review,"review_seller_id"=>$seller_id,"review_date"=>$date));

$last_update_date = date("F d, Y");

$insert_notification = $db->insert("notifications",array("receiver_id" => $seller_id,"sender_id" => $buyer_id,"order_id" => $order_id,"reason" => "buyer_order_review","date" => $last_update_date,"status" => "unread"));

$ratings = array();


$sel_proposal_reviews = $db->select("buyer_reviews",array("proposal_id"=>$proposal_id));
    
while($row_proposals_reviews = $sel_proposal_reviews->fetch()){
  
  $proposal_buyer_rating = $row_proposals_reviews->buyer_rating;
  
  array_push($ratings,$proposal_buyer_rating);
  
}
  
array_push($ratings,$rating);
  
$total = array_sum($ratings);
  
$avg = $total/count($ratings);
  
$updated_propoasl_rating = substr($avg,0,1);


if($rating == "5"){

if($order_seller_rating == "100"){

}else{

$update_seller_rating = $db->query("update sellers set seller_rating=seller_rating+7 where seller_id='$seller_id'");  


}


}elseif($rating == "4"){

if($order_seller_rating == "100"){

}else{

$update_seller_rating = $db->query("update sellers set seller_rating=seller_rating+2 where seller_id='$seller_id'");  

}

}elseif($rating == "3"){


$update_seller_rating = $db->query("update sellers set seller_rating=seller_rating-3 where seller_id='$seller_id'");  

}elseif($rating == "2"){


$update_seller_rating = $db->query("update sellers set seller_rating=seller_rating-5 where seller_id='$seller_id'");  


}elseif($rating == "1"){

$update_seller_rating = $db->query("update sellers set seller_rating=seller_rating-7 where seller_id='$seller_id'");  

}

$update_proposal_rating = $db->update("proposals",array("proposal_rating" => $updated_propoasl_rating),array("proposal_id" => $proposal_id));

if($update_proposal_rating){

echo "<script>

          swal({
            type: 'success',
            text: 'Review submitted successfully!',
            timer: 3000,
            onOpen: function(){
            swal.showLoading()
            }
            }).then(function(){
             window.open('order_details?order_id=$order_id','_self')
          });

        </script>";

}


}

?>

</div>


</div>

</div>

<?php }else{ ?>



<?php } ?>
<?php } ?>