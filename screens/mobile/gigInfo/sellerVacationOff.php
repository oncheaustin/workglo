<?php 
if($proposal_price == 0){
	$i=0;
	$get_p = $db->select("proposal_packages",array("proposal_id"=>$proposal_id));
	while($row = $get_p->fetch()){
	$i++;
	$package_id = $row->package_id;
	$package_name = $row->package_name;
	$delivery_time = $row->delivery_time;
	$price = $row->price;
	$priceClass = "total-price-$i";
?>
<div class="tab-pane fade show <?php if($package_name=="Standard"){echo" active";} ?>" id="tab_<?php echo $package_id; ?>">
	<div class="purchase-form"><?php include('purchaseFormPackages.php'); ?></div>
</div>
<?php } ?>
<?php }else{ ?>
<?php include('purchaseForm.php'); ?>
<?php } ?>