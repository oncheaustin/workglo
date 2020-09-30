
<h5 class="font-weight-normal">Description</h5>

<hr>

<p class="small mb-2"> Project Details </p>

<form action="#" method="post" class="proposal-form" id="form1"><!--- form Starts -->

<div class="form-group">

<textarea name="proposal_desc" rows="7" placeholder="Enter Your Proposal's Description"  class="form-control proposal-desc"><?php echo $d_proposal_desc; ?></textarea>

<small class="form-text text-danger"><?php echo ucfirst(@$form_errors['proposal_description']); ?></small>

</div>

</form><!--- form Ends -->

<hr class="mt-0">

<h5 class="font-weight-normal"> Frequently Asked Questions  <small class="float-right"><a data-toggle="collapse" href="#insert-faq" class="text-success">+ Add Faq</a></small></h5>

<hr>

<div class="tabs accordion mt-2" id="faqTabs"><!--- All Tabs Starts --->

<?Php include("faqs.php"); ?>

</div><!--- All Tabs Ends --->


<div class="form-group mb-0"><!--- form-group Starts --->

<a href="#" class="btn btn-secondary float-left back-to-pricing">Back</a>

<input class="btn btn-success float-right" type="submit" form="form1" value="Save & Continue">

</div><!--- form-group Starts --->

<script>
  
$(document).ready(function(){

$('.back-to-pricing').click(function(){

<?php if($d_proposal_status == "draft"){ ?>

$("input[type='hidden'][name='section']").val("pricing");

$('#description').removeClass('show active');

$('#pricing').addClass('show active');

$('#tabs a[href="#description"]').removeClass('active');

<?php }else{ ?>

$('.nav a[href="#pricing"]').tab('show');

<?php } ?>

});


});

</script>