<?php

@session_start();

if(!isset($_SESSION['admin_email'])){
	
echo "<script>window.open('login','_self');</script>";
	
}else{
	

if(isset($_GET['edit_box'])){
	
$edit_id = $input->get('edit_box');


$get_boxes = $db->select("section_boxes",array("box_id" => $edit_id));
	
if($get_boxes->rowCount() == 0){

  echo "<script>window.open('index?dashboard','_self');</script>";

}
    
$row_boxes = $get_boxes->fetch();

$box_id = $row_boxes->box_id;

$box_title = $row_boxes->box_title;

$box_desc = $row_boxes->box_desc;

$b_image = $row_boxes->box_image;


}

?>



<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1><i class="menu-icon fa fa-cog"></i> Settings / Insert Box</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Insert Box</li>
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

<h4 class="card-title">

<i class="fa fa-money-bill-alt fa-fw"></i> Edit Box

</h4>

</div><!--- card-header Ends --->

<div class="card-body"><!--- card-body Starts --->

<form action="" method="post" enctype="multipart/form-data"><!--- form Starts --->

<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Box Title : </label>

<div class="col-md-6">

<input type="text" name="box_title" class="form-control" value="<?php echo $box_title; ?>">

</div>

</div><!--- form-group row Ends --->


<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Box Description : </label>

<div class="col-md-6">

<textarea name="box_desc" class="form-control" cols="6"><?php echo $box_desc; ?></textarea>

</div>

</div><!--- form-group row Ends --->


<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"> Box Image : </label>

<div class="col-md-6">

<input type="file" name="box_image" class="form-control" >

<br><img src="../box_images/<?php if(empty($b_image)){echo "no.jpg"; }else{echo $b_image;} ?>" width="70">

</div>

</div><!--- form-group row Ends --->


<div class="form-group row"><!--- form-group row Starts --->

<label class="col-md-3 control-label"></label>

<div class="col-md-6">

<input type="submit" name="update_box" class="form-control btn btn-success" value="Update Box">

</div>

</div><!--- form-group row Ends --->


</form><!--- form Ends --->

</div><!--- card-body Ends --->

</div><!--- card Ends --->

</div><!--- col-lg-12 Ends --->

</div><!--- 2 row Ends --->
    
</div>

<?php

if(isset($_POST['update_box'])){
	
$rules = array(
"box_title" => "required",
"box_desc" => "required",
"box_image" => "required");

$messages = array("box_desc" => "Box description Is Required.");

$val = new Validator($_POST,$rules,$messages);

if($val->run() == false){

Flash::add("form_errors",$val->get_all_errors());

Flash::add("form_data",$_POST);

echo "<script> window.open(window.location.href,'_self');</script>";

}else{

$box_title = $input->post('box_title');

$box_desc = $input->post('box_desc');

$box_image = $_FILES['box_image']['name'];

$tmp_name = $_FILES['box_image']['tmp_name'];

move_uploaded_file($tmp_name,"../box_images/$box_image");

if(empty($box_image)){

$box_image = $b_image;

}


$allowed = array('jpeg','jpg','gif','png','tif','ico','webp');
  
$file_extension = pathinfo($box_image, PATHINFO_EXTENSION);

if(!in_array($file_extension,$allowed) & !empty($box_image)){
  
echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
  
}else{

$update_box = $db->update("section_boxes",array("box_title" => $box_title,"box_desc" => $box_desc, "box_image" => $box_image),array("box_id" => $box_id));
	
if($update_box){

$insert_log = $db->insert_log($admin_id,"box",$edit_id,"updated");

echo "<script>
      
     swal({
   
    type: 'success',
    text: 'Box Successfully Updated!',
    timer: 4000,
    onOpen: function(){
    swal.showLoading()
    }
    }).then(function(){

      window.open('index?layout_settings','_self')

    });

</script>";
	
}
	
}

}

}

?>

<?php } ?>