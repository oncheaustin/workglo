<?php

@session_start();

require_once("../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){
	
echo "<script>window.open('../login','_self')</script>";
	
}

$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));

$row_login_seller = $select_login_seller->fetch();

$login_seller_id = $row_login_seller->seller_id;


$proposal_id = $input->post('proposal_id');

$message = $input->post('message');

$file = $input->post('file');

$receiver_id = $input->post('receiver_id');



$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));

$row_proposals = $select_proposals->fetch();

$proposal_title = $row_proposals->proposal_title;

?>

<div class="modal-content"><!-- modal-content Starts -->

<div class="modal-header"><!-- modal-header Starts -->

<h5 class="modal-title"> Specify Your Proposal Details </h5>

<button class="close" data-dismiss="modal">
<span> &times; </span>
</button>

</div><!-- modal-header Ends -->

<div class="modal-body p-0"><!-- modal-body p-0 Starts -->

<form id="proposal-details-form"><!--- proposal-details-form Starts --->

<div class="selected-proposal p-3"><!--- selected-proposal p-3 Starts --->

<h5> <?php echo $proposal_title; ?> </h5>

<hr>

<input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>">

<input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>">

<input type="hidden" name="message" value="<?php echo $message; ?>">

<input type="hidden" name="file" value="<?php echo $file; ?>">

<div class="form-group"><!--- form-group Starts --->

<label class="font-weight-bold"> Description :  </label>

<textarea name="description" class="form-control" required=""></textarea>

</div><!--- form-group Ends --->

<hr>

<div class="form-group"><!--- form-group Starts --->

<label class="font-weight-bold"> Delivery Time :  </label>

<select class="form-control float-right" name="delivery_time" required="">

<option value="1 Day"> 1 Day </option>

<option value="2 Days"> 2 Days </option>

<option value="3 Days"> 3 Days </option>

</select>

</div><!--- form-group Ends --->

<hr>

<div class="form-group"><!--- form-group Starts --->

<label class="font-weight-bold"> Total Offer Amount :  </label>

<div class="input-group float-right">

<span class="input-group-addon font-weight-bold"> <?php echo $s_currency; ?> </span>

<input type="number" name="amount" class="form-control" min="5" placeholder="5 Minimum" required="">

</div>

</div><!--- form-group Ends --->


</div><!--- selected-proposal p-3 Ends --->

<div class="modal-footer"><!--- modal-footer Starts --->

<button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#send-offer-modal">Back</button>

<button type="submit" class="btn btn-success">Submit Offer</button>

</div><!--- modal-footer Ends --->

</form><!--- proposal-details-form Ends --->

</div><!-- modal-body p-0 Ends -->

</div><!-- modal-content Ends -->


<div id="insert_offer"></div>


<script>

$(document).ready(function(){
	

$("#proposal-details-form").submit(function(event){
	
event.preventDefault();
	

description = $("textarea[name='description']").val();

delivery_time = $("select[name='delivery_time']").val();

amount = $("input[name='amount']").val();

if(description == "" | delivery_time == "" | amount == ""){

swal({
type: 'warning',
text: 'You Must Need To Fill Out All Fields Before Submitting Offer.'
});

}else{

$.ajax({
	
method: "POST",
url: "<?php echo $site_url; ?>/conversations/insert_offer",
data: $('#proposal-details-form').serialize()

}).done(function(data){
	
$("#submit-proposal-details").modal('hide');

$("#insert_offer").html(data);
	
});

}
	
});

	
});

</script>
