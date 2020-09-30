<?php


@session_start();

if(!isset($_SESSION['admin_email'])){
	
echo "<script>window.open('login','_self');</script>";
	
}else{
    
if(isset($_GET['edit_cat'])){
	
$edit_id = $input->get('edit_cat');
		
$edit_cat = $db->select("categories",array('cat_id' => $edit_id));
	
if($edit_cat->rowCount() == 0){

  echo "<script>window.open('index?dashboard','_self');</script>";

}

$row_edit = $edit_cat->fetch();
	

$get_meta = $db->select("cats_meta",array("cat_id" => $edit_id, "language_id" => $adminLanguage));

$row_meta = $get_meta->fetch();

$c_title = $row_meta->cat_title;

$c_desc = $row_meta->cat_desc;


$c_image = $row_edit->cat_image;

$c_featured = $row_edit->cat_featured;
	
}
	
?>

<div class="breadcrumbs">

            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1><i class="menu-icon fa fa-cubes"></i> Category</h1>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Edit Category</li>
                        </ol>
                    </div>
                </div>
            </div>
    
</div>

<div class="container">

<div class="row"><!--- 2 row Starts --->

<div class="col-lg-12"><!--- col-lg-12 Starts --->

<?php 

$form_errors = Flash::render("form_errors");

$form_data = Flash::render("form_data");

if(is_array($form_errors)){

?>

<div class="alert alert-danger"><!--- alert alert-danger Starts --->
    
<ul class="list-unstyled mb-0">
<?php $i = 0; foreach ($form_errors as $error) { $i++; ?>
<li class="list-unstyled-item"><?php echo $i ?>. <?php echo ucfirst($error); ?></li>
<?php } ?>
</ul>

</div><!--- alert alert-danger Ends --->

<?php } ?>

<div class="card"><!--- card Starts --->

<div class="card-header"><!--- card-header Starts --->

<h4 class="h4">

<i class="fa fa-money-bill-alt"></i> Edit Category

</h4>

</div><!--- card-header Ends --->

<div class="card-body"><!--- card-body Starts --->

<form action="" method="post" enctype="multipart/form-data"><!--- form Starts --->

<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Category Title : </label>

<div class="col-md-6">

<input type="text" name="cat_title" class="form-control" value="<?php echo $c_title; ?>" required>

</div>

</div><!--- form-group row Ends --->

<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Category Description : </label>

<div class="col-md-6">

<textarea name="cat_desc" class="form-control" required=""><?php echo $c_desc; ?></textarea>

</div>

</div><!--- form-group row Ends --->


<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label">Featured Category : </label>

<div class="col-md-6">

<input type="radio" name="cat_featured" value="yes" required

<?php

if($c_featured == "yes"){
	
echo "checked='checked'";
	
}

?>

>

<label> Yes </label>

<input type="radio" name="cat_featured" value="no" required

<?php

if($c_featured == "no"){
	
echo "checked='checked'";
	
}

?>

>

<label> No </label>

</div>

</div><!--- form-group row Ends --->



<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Category Image : </label>

<div class="col-md-6">

<input type="file" name="cat_image" class="form-control">

<br>

<?php if(!empty($c_image)){ ?>

<img src="../cat_images/<?php echo $c_image; ?>" width="70" height="55">

<?php }else{ ?>

<img src="../cat_images/empty-image.jpg" width="70" height="55">

<?php } ?>

</div>

</div><!--- form-group row Ends --->



<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"></label>

<div class="col-md-6">

<input type="submit" name="update_cat" value="Update Category" class="btn btn-success form-control">

</div>

</div><!--- form-group row Ends --->



</form><!--- form Ends --->

</div><!--- card-body Ends --->

</div><!--- card Ends --->

</div><!--- col-lg-12 Ends --->

</div><!--- 2 row Ends --->

<?php

if(isset($_POST['update_cat'])){
	
$rules = array(
"cat_title" => "required",
"cat_desc" => "required",
"cat_featured" => "required");

$messages = array("cat_title" => "Category Title Is Required.","cat_desc" => "Category Description Is Required.","cat_featured" => "Your Must Need To Chose Category Featured As Yes Or No");

$val = new Validator($_POST,$rules,$messages);

if($val->run() == false){

Flash::add("form_errors",$val->get_all_errors());

Flash::add("form_data",$_POST);

echo "<script> window.open(window.location.href,'_self');</script>";

}else{


$cat_title = $input->post('cat_title');

$cat_desc = $input->post('cat_desc');

$cat_featured = $input->post('cat_featured');
	
$cat_image = $_FILES['cat_image']['name'];

$tmp_cat_image = $_FILES['cat_image']['tmp_name'];


$allowed = array('jpeg','jpg','gif','png','tif','ico','webp');
  
$file_extension = pathinfo($cat_image, PATHINFO_EXTENSION);

if(!in_array($file_extension,$allowed) & !empty($cat_image)){
  
echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
  
}else{


move_uploaded_file($tmp_cat_image,"../cat_images/$cat_image");
	
if(empty($cat_image)){
	
$cat_image = $c_image;
	
}
	
$update_cat = $db->update("categories",array("cat_image"=>$cat_image,"cat_featured"=>$cat_featured),array("cat_id"=>$edit_id));

if($update_cat){

$update_meta = $db->update("cats_meta",array("cat_title" => $cat_title,"cat_desc" => $cat_desc),array("cat_id" => $edit_id, "language_id" => $adminLanguage));

$insert_log = $db->insert_log($admin_id,"cat",$edit_id,"updated");

echo "<script>alert('One Category Has Been Updated.');</script>";
	
echo "<script>window.open('index?view_cats','_self');</script>";
	
}	


}

}	
	
}

?>

</div>

<?php } ?>