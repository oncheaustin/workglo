<?php

@session_start();

if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login','_self');</script>";

}else{

?>

<?php

    $edit_id = $input->get('edit_article');

    $get_articles = $db->select("knowledge_bank",array("article_id" => $edit_id));

    if($get_articles->rowCount() == 0){

      echo "<script>window.open('index?dashboard','_self');</script>";

    }

		$row_articles = $get_articles->fetch();

    $article_id = $row_articles->article_id;
    
    $cat_id = $row_articles->cat_id;
    
    $article_url = $row_articles->article_url;

    $article_heading = $row_articles->article_heading;
		
		$article_body = $row_articles->article_body;
		
    $r_image = $row_articles->right_image;
    
    $t_image = $row_articles->top_image;
    
    $b_image = $row_articles->bottom_image;
		
    $article_status = $row_articles->article_status;
		

    $get_categories = $db->select("article_cat",array("article_cat_id" => $cat_id));

    $row_categories = $get_categories->fetch();

    $article_cat_title = $row_categories->article_cat_title;

?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
  
<script type="text/javascript" src="../js/popper.min.js"></script>

<script type="text/javascript" src="../js/bootstrap.js"></script>

<script type="text/javascript" src="../js/summernote.js"></script>

<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1><i class="menu-icon fa fa-book"></i> Knowledge Bank</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Insert Article</li>
                        </ol>
                    </div>
                </div>
            </div>

    </div>


<div class="container">

<div class="row">

  <div class="col-md-12">

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

      <div class="card-header">

        <h4 class="h4">Edit Article</h4>

      </div>

      <div class="card-body card-block">
        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

          <div class="row form-group">
            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Article Heading</label></div>
            <div class="col-12 col-md-9"><input value="<?php echo $article_heading; ?>" type="text" id="text-input" name="article_heading" class="form-control"></div>
          </div>

          <div class="row form-group">
		  
            <div class="col col-md-3"><label for="select" class=" form-control-label">Article Status</label></div>
          
		  <div class="col-12 col-md-9">

		  <select name="article_status" id="select" class="form-control">
		  
                <option value="active">Active</option>
                <option value="draft">Not Active</option>
          
		  </select>

			  </div>

			  </div>




              <div class="form-group row">
                           <!--- form-group row Starts --->

                           <label class="col-md-3 control-label"> Select Article's Category : </label>

                           <div class="col-md-6">

                               <select name="cat_id" class="form-control" required>

                                   <option value="<?php echo $cat_id; ?>"> <?php echo $article_cat_title; ?> </option>

                                   <?php

                                  $get_cats = $db->query("select * from article_cat where not article_cat_id='$cat_id'");

                                  while($row_cats = $get_cats->fetch()){

                                  $article_cat_id = $row_cats->article_cat_id;

                                  $article_cat_title = $row_cats->article_cat_title;

                                  echo "<option value='$cat_article_id'>$article_cat_title</option>";

                                  }

                                  ?>

                                  </select>

                           </div>

                       </div>
                       <!--- form-group row Ends --->


          <div class="row form-group">
            <div class="col col-md-3"><label for="textarea-input" class=" form-control-label">Article Body</label></div>
            <div class="col-12 col-md-9"><textarea name="article_body" id="textarea-input" rows="9" placeholder="Start Typing Here..." class="form-control"><?php echo $article_body; ?></textarea></div>
          </div>
		  
		  <div class="row form-group">
            
			<div class="col col-md-3">
			
			<label for="file-input" class=" form-control-label">Right Image (optional)</label></div>
			
      <div class="col-12 col-md-9">
			
			<input type="file" id="file-input" name="right_image" class="form-control-file">
			
			<br>
			
        <?php if(!empty($r_image)){ ?>

        <img src="../article/article_images/<?php echo $r_image; ?>" width="70" height="55">
      
        <?php }else{ ?>
      
        <img src="../article/article_images/No-image.jpg" width="70" height="55">
      
        <?php } ?>

			</div>
			
          </div>

          <div class="row form-group">
           
            <div class="col col-md-3">
			
			     <label for="file-input" class=" form-control-label">Top Image (optional)</label></div>
			
            <div class="col-12 col-md-9">
			
      			<input type="file" id="file-input" name="top_image" class="form-control-file">
      			
      			<br>
      			
			     <?php if(!empty($t_image)){ ?>
			
              <img src="../article/article_images/<?php echo $t_image; ?>" width="70" height="55">
            
            <?php }else{ ?>
            
              <img src="../article/article_images/No-image.jpg" width="70" height="55">
            
            <?php } ?>
			
			</div>
			
          </div>
          <div class="row form-group">
            <div class="col col-md-3"><label for="file-multiple-input" class=" form-control-label">Bottom Image (optional)</label></div>
            <div class="col-12 col-md-9">
			
        			<input type="file" id="file-multiple-input" name="bottom_image" class="form-control-file">
        			
        			<br>
        			
            <?php if(!empty($b_image)){ ?>
			
            <img src="../article/article_images/<?php echo $b_image; ?>" width="70" height="55">
            
            <?php }else{ ?>            
            
              <img src="../article/article_images/No-image.jpg" width="70" height="55">
            
            <?php } ?>
            
			</div>
			
          </div>

          <div class="row form-group">

            <div class="col col-md-3"></div>
            <div class="col-12 col-md-9">
            <button type="submit" name="submit" class="btn btn-success">Update Article</button>
          </div>

          </div>

        </form>
      </div>


    </div>

  </div>

</div>

</div>

<script>

$('textarea').summernote({
        placeholder: 'Start Typing Here...',
        height: 150
      });

</script>

<?php

if(isset($_POST['submit'])){

$rules = array(
"article_heading" => "required",
"article_status" => "required",
"cat_id" => "required",
"article_body" => "required");

$messages = array("cat_id" => "You must need to select a category for Article.");

$val = new Validator($_POST,$rules,$messages);

if($val->run() == false){

Flash::add("form_errors",$val->get_all_errors());

Flash::add("form_data",$_POST);

echo "<script> window.open(window.location.href,'_self');</script>";

}else{


$article_heading = $input->post('article_heading');

class SanitizeUrl {

    public static function slug($string, $space="-") {
        $string = utf8_encode($string);
        if (function_exists('iconv')) {
            $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        }

        $string = preg_replace("/[^a-zA-Z0-9 \-]/", "", $string);
        $string = trim(preg_replace("/\\s+/", " ", $string));
        $string = strtolower($string);
        $string = str_replace(" ", $space, $string);

        return $string;
    }
}	

function removeJava($html){
  
$attrs = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
  
$dom = new DOMDocument;

@$dom->loadHTML($html);

$nodes = $dom->getElementsByTagName('*');//just get all nodes, 

foreach($nodes as $node){

  foreach ($attrs as $attr) { 

    if($node->hasAttribute($attr)){  $node->removeAttribute($attr);  } 

  }

}

return strip_tags($dom->saveHTML(),"<div><br><a><b><i><u><span><img><h1><h2><h3><h4><h5><h6><p><ul><ol><li>");

}

$article_url = SanitizeUrl::slug($article_heading);

$cat_id = $input->post('cat_id');

$article_status = $input->post('article_status');

$article_body = removeJava($_POST['article_body']);


$right_image = $_FILES['right_image']['name'];

$right_image_tmp = $_FILES['right_image']['tmp_name'];


$top_image = $_FILES['top_image']['name'];

$top_image_tmp = $_FILES['top_image']['tmp_name'];


$bottom_image = $_FILES['bottom_image']['name'];

$bottom_image_tmp = $_FILES['bottom_image']['tmp_name'];


$right_extension = pathinfo($right_image, PATHINFO_EXTENSION);

$top_extension = pathinfo($top_image, PATHINFO_EXTENSION);

$bottom_extension = pathinfo($bottom_image, PATHINFO_EXTENSION);


$allowed = array('jpeg','jpg','gif','png','tif','ico','webp');

if(!in_array($right_extension,$allowed) & !empty($right_image) or !in_array($top_extension,$allowed) & !empty($top_image) or !in_array($bottom_extension,$allowed) & !empty($bottom_image)){

echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
  
}else{


move_uploaded_file($right_image_tmp, "../article/article_images/$right_image");

move_uploaded_file($top_image_tmp, "../article/article_images/$top_image");

move_uploaded_file($bottom_image_tmp, "../article/article_images/$bottom_image");


if(empty($right_image)){
  
$right_image = $r_image;
  
}

if(empty($top_image)){
	
$top_image = $t_image;
	
}

if(empty($bottom_image)){
	
$bottom_image = $b_image;
	
}

$update_article = $db->update("knowledge_bank",array("cat_id"=>$cat_id,"article_heading"=>$article_heading,"article_body"=>$article_body,"right_image"=>$right_image,"top_image"=>$top_image,"bottom_image"=>$bottom_image,"article_status"=>$article_status),array("article_id"=>$edit_id));

if($update_article){

$insert_log = $db->insert_log($admin_id,"article",$edit_id,"updated");

echo "<script>alert('Article Updated successfully.');</script>";

echo "<script>window.open('index?view_articles','_self');</script>";

}

}


}

}

?>

<?php } ?>
