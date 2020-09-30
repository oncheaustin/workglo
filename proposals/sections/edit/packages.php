<?php

@session_start();

if(isset($_POST['proposal_id'])){

require_once("../../../includes/db.php");

$proposal_id = $input->post('proposal_id');

}

$get_p_1 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Basic'));

$row_1 = $get_p_1->fetch();

$get_p_2 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Standard'));

$row_2 = $get_p_2->fetch();


$get_p_3 = $db->select("proposal_packages",array("proposal_id"=>$proposal_id,"package_name"=>'Advance'));

$row_3 = $get_p_3->fetch();


$prices = array(5,10,15,20,25,50,60,70,80,90,100);

$revisions = array(0,1,2,3,4,5,6,7,8,9,10);

?>
<table class="table table-bordered packages">
  
<thead>
  
<tr>
  
  <th></th>
  <th>Basic</th>
  <th>Standard</th>
  <th>Advance</th>

</tr>

</thead>

<tbody>
  
<form action="#" method="post" class="pricing-form" id="pricing-form">

<input type="hidden" name="proposal_packages[1][package_id]" value="<?= $row_1->package_id; ?>">
<input type="hidden" name="proposal_packages[2][package_id]" value="<?= $row_2->package_id; ?>">
<input type="hidden" name="proposal_packages[3][package_id]" value="<?= $row_3->package_id; ?>">

<tr>
  
<td>Description</td>

<td class="p-0"><textarea maxlength="35" name="proposal_packages[1][description]" class="form-control" placeholder="Description"><?= $row_1->description; ?></textarea></td>
<td class="p-0"><textarea maxlength="35" name="proposal_packages[2][description]" class="form-control" placeholder="Description"><?= $row_2->description; ?></textarea></td>
<td class="p-0"><textarea maxlength="35" name="proposal_packages[3][description]" class="form-control" placeholder="Description"><?= $row_3->description; ?></textarea></td>

</tr>

<?php

$i = 0;

$get_a = $db->select("package_attributes",array("package_id"=>$row_1->package_id));

while($row_a = $get_a->fetch()){

$a_id = $row_a->attribute_id;

$a_name = $row_a->attribute_name;

$a_value = $row_a->attribute_value;

$i++;

?>

<tr>

<td> <?php echo $a_name; ?> </td>

<td class="p-0"> 

<input type="hidden" name="package_attributes[<?= $i; ?>][attribute_id]" value="<?= $a_id; ?>">

<input type="text"name="package_attributes[<?= $i; ?>][attribute_value]"class="form-control"value="<?= $a_value; ?>"> 

<i class="fa fa-trash delete-attribute" data-attribute="<?php echo $a_name; ?>"></i>

</td>

<?php

$get_v = $db->query("select * from package_attributes where proposal_id='$proposal_id' and attribute_name='$a_name' and not attribute_id='$a_id'");

while($row_v = $get_v->fetch()){

$id = $row_v->attribute_id;

$value = $row_v->attribute_value;

$i++;

?>

<td class="p-0"> 

<input type="hidden" name="package_attributes[<?= $i; ?>][attribute_id]" value="<?= $id; ?>">

<input type="text"name="package_attributes[<?= $i; ?>][attribute_value]"class="form-control" value="<?= $value; ?>">

<i class="fa fa-trash delete-attribute" data-attribute="<?php echo $a_name; ?>"></i>

</td>

<?php } ?>

</tr>

<?php } ?>

<tr class="delivery-time">
  
<td>Delivery Time</td>

<td class="p-0">
  
<select name="proposal_packages[1][delivery_time]" class="form-control">
  
<?php

$get_delivery_times = $db->select("delivery_times");

while($row_delivery_times = $get_delivery_times->fetch()){

$delivery_time = $row_delivery_times->delivery_proposal_title;

echo "<option value='".intval($delivery_time)."' ".(intval($delivery_time) == $row_1->delivery_time ? "selected" : "").">$delivery_time</option>";

}

?>

</select>

</td>

<td class="p-0">

<select name="proposal_packages[2][delivery_time]" class="form-control">
  
<?php

$get_delivery_times = $db->select("delivery_times");

while($row_delivery_times = $get_delivery_times->fetch()){

$delivery_time = $row_delivery_times->delivery_proposal_title;

echo "<option value='".intval($delivery_time)."' ".(intval($delivery_time) == $row_2->delivery_time ? "selected" : "").">$delivery_time</option>";

}

?>

</select></td>

<td class="p-0">

<select name="proposal_packages[3][delivery_time]" class="form-control">
  
<?php

$get_delivery_times = $db->select("delivery_times");

while($row_delivery_times = $get_delivery_times->fetch()){

$delivery_time = $row_delivery_times->delivery_proposal_title;

echo "<option value='".intval($delivery_time)."' ".(intval($delivery_time) == $row_3->delivery_time ? "selected" : "").">$delivery_time</option>";

}

?>

</select>

</td>

</tr>

<tr>
  
<td>Revisions</td>

<td class="p-0">

<select name="proposal_packages[1][revisions]" class="form-control">

<?php 

foreach ($revisions as $rev) {
	echo "<option value='$rev'".($rev == $row_1->revisions ? "selected" : "").">$rev</option>";
}

?>

</select>

</td><td class="p-0">

<select name="proposal_packages[2][revisions]" class="form-control">

<?php 

foreach ($revisions as $rev) {
	echo "<option value='$rev'".($rev == $row_2->revisions ? "selected" : "").">$rev</option>";
}

?>

</select>

</td><td class="p-0">

<select name="proposal_packages[3][revisions]" class="form-control">

<?php 

foreach ($revisions as $rev) {
	echo "<option value='$rev'".($rev == $row_3->revisions ? "selected" : "").">$rev</option>";
}

?>

</select>

</td>

</tr>

<tr>
  
<td>Price</td>

<td class="p-0">

<select name="proposal_packages[1][price]" class="form-control">
  
<?php 

foreach ($prices as $price) {
	echo "<option value='$price'".($price == $row_1->price ? "selected" : "").">$s_currency$price</option>";
}

?>

</select>

</td><td class="p-0">

<select name="proposal_packages[2][price]" class="form-control">
  
<?php 

foreach ($prices as $price) {
	echo "<option value='$price'".($price == $row_2->price ? "selected" : "").">$s_currency$price</option>";
}

?>

</select>

</td><td class="p-0">

<select name="proposal_packages[3][price]" class="form-control">

<?php 

foreach ($prices as $price) {
	echo "<option value='$price'".($price == $row_3->price ? "selected" : "").">$s_currency$price</option>";
}

?>  

</select>

</td>

</tr>

</form>

</tbody>

</table>
