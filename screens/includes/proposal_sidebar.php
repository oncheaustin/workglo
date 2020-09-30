<div class="card mb-5 rounded-0">
<?php if($proposal_price == 0){ include("sidebar/proposal_packages.php"); } ?>
<div class="card-body order-box tab-content"><!--- card-body Starts --->
  <?php 
   if($proposal_seller_vacation == "on"){ 
    include("sidebar/sellerVacationOn.php"); 
   }elseif($proposal_seller_vacation == "off"){
    include("sidebar/sellerVacationOff.php");
   }
  ?>
</div><!--- card-body Ends --->
</div>
<?php
  include('sidebar/referralBox.php');
  include('sidebar/sellerBio.php');
  include('sidebar/copyrightBox.php');
?>