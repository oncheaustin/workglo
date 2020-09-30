<?php

@session_start();

if(!isset($_SESSION['admin_email'])){
	
echo "<script>window.open('login','_self');</script>";
	
}else{    
	
?>


<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
  
<script type="text/javascript" src="../js/popper.min.js"></script>

<script type="text/javascript" src="../js/bootstrap.js"></script>

<script type="text/javascript" src="../js/summernote.js"></script>

<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1><i class="menu-icon fa fa-table"></i> Terms & Conditions </h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Add New Item</li>
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

            <div class="card">
                <!--- card Starts --->

                <div class="card-header">
                    <!--- card-header Starts --->

                    <h4 class="h4">Insert Term</h4>

                </div>
                <!--- card-header Ends --->

                <div class="card-body">
                    <!--- card-body Starts --->

                    <form action="" method="post">
                        <!--- form Starts --->


                        <div class="form-group row">
                            <!--- form-group row Starts --->

                            <label class="col-md-3 control-label"> Term Title : </label>

                            <div class="col-md-6">

                                <input type="text" name="term_title" class="form-control" required>

                            </div>

                        </div>
                        <!--- form-group row Ends --->


                        <div class="form-group row"><!--- form-group row Starts --->

                            <div class="col-md-3"> 

                            <label>Term Description :</label>
                            <br>
                            <small class="text-muted p">If you enter html mode, remember to turn it off before saving or updating.</small>

                            </div>

                            <div class="col-md-6">

                            <textarea class="form-control mb-0" name="term_description" rows="7" required></textarea>
                                        
                            </div>

                        </div><!--- form-group row Ends --->



                        <div class="form-group row"><!--- form-group row Starts --->

                            <label class="col-md-3 control-label"> Term Link : </label>

                            <div class="col-md-6">

                                <input type="text" name="term_link" class="form-control" required>

                            </div>

                        </div><!--- form-group row Ends --->



                        <div class="form-group row">
                            <!--- form-group row Starts --->

                            <label class="col-md-3 control-label"></label>

                            <div class="col-md-6">

                                <input type="submit" name="submit" class="btn btn-success form-control" value="Add Term">

                            </div>

                        </div>
                        <!--- form-group row Ends --->



                    </form>
                    <!--- form Ends --->

                </div>
                <!--- card-body Ends --->

            </div>
            <!--- card Ends --->

        </div>
        <!--- col-lg-12 Ends --->

    </div>
    <!--- 2 row Ends --->

    <script>

    $('textarea').summernote({
            placeholder: 'Start Typing Here...',
            height: 200,
            toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['height', ['height']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['misc', ['codeview']]
          ],
          });

    </script>

<?php

if(isset($_POST['submit'])){

$rules = array(
"term_title" => "required",
"term_description" => "required",
"term_link" => "required"
);

$val = new Validator($_POST,$rules);

if($val->run() == false){

Flash::add("form_errors",$val->get_all_errors());

Flash::add("form_data",$_POST);

echo "<script> window.open('index?insert_term','_self');</script>";

}else{


function removeJava($html){
  
$attrs = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
$dom = new DOMDocument;
@$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
$nodes = $dom->getElementsByTagName('*');//just get all nodes, 
foreach($nodes as $node){
  foreach ($attrs as $attr) { 
  if ($node->hasAttribute($attr)){  $node->removeAttribute($attr);  } 
  }
}

return strip_tags($dom->saveHTML(),"<div><br><a><b><i><u><span><h1><h2><h3><h4><h5><h6><p><ul><ol><li>");

}

$data = $input->post();

$data['term_description'] = removeJava($_POST['term_description']);

$data['language_id'] = $adminLanguage;

unset($data['files']);

unset($data['submit']);

$insert_term = $db->insert("terms",$data);
	
if($insert_term){
	
$insert_id = $db->lastInsertId();

$insert_log = $db->insert_log($admin_id,"term",$insert_id,"inserted");
    
echo "<script>alert('One Term has been Inserted.');</script>";
	
echo "<script>window.open('index?view_terms','_self');</script>";
	
}

}

}

?>

</div>

<?php } ?>