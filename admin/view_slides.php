
                        <?php


@session_start();

if(!isset($_SESSION['admin_email'])){
	
echo "<script>window.open('login','_self');</script>";
	
}else{
    
	
?>

<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1><i class="menu-icon fa fa-picture-o"></i> Slides</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                             <li class="active"><a href="index?insert_slide" class="btn btn-success">

                                            <i class="fa fa-plus-circle text-white"></i> <span class="text-white">Add New Slide</span>

                                        </a></li>
                        </ol>
                    </div>
                </div>
            </div>
    
    </div>


<div class="container">

    <div class="row">
        <!--- 2 row Starts --->

        <div class="col-lg-12">
            <!--- col-lg-12 Starts --->

            <div class="card">
                <!--- card Starts --->

                <div class="card-header">
                    <!--- card-header Starts --->

                    <h4 class="h4">
                        <!--- h4 Starts --->

                         View Slides <br>
                        
                        <small>These slides will show up in logged in homepage</small>

                    </h4>
                    <!--- h4 Ends --->

                </div>
                <!--- card-header Ends --->

                <div class="card-body">
                    <!--- card-body Starts --->

                    <div class="row">
                        <!--- row Starts --->

                        <?php

                        $get_slides = $db->select("slider",array("language_id" => $adminLanguage));

                        while($row_slides = $get_slides->fetch()){

                        $slide_id = $row_slides->slide_id;

                        $slide_name = $row_slides->slide_name;

                        $slide_image = $row_slides->slide_image;


                        ?>

                            <div class="col-lg-4 col-md-6 mb-lg-3 mb-3">
                                <!--- col-lg-3 col-md-6 mb-lg-0 mb-3 Starts --->

                                <div class="card">
                                    <!--- card Starts --->

                                    <div class="card-header">

                                        <h5 class="h5 text-center">
                                            <?php echo $slide_name; ?> </h5>

                                    </div>

                                    <div class="card-body">
                                        <!--- card-body Starts --->

                                        <img src="../slides_images/<?php echo $slide_image; ?>" class="img-fluid">

                                    </div>
                                    <!--- card-body Ends --->

                                    <div class="card-footer">
                                        <!--- card-footer Starts --->

                                        <a href="index?delete_slide=<?php echo $slide_id; ?>" class="float-left btn btn-danger" title="Delete">

                                            <i class="fa fa-trash text-white"></i> 

                                        </a>

                                        <a href="index?edit_slide=<?php echo $slide_id; ?>" class="float-right btn btn-success" title="edit">

                                            <i class="fa fa-pencil text-white"></i> 

                                        </a>

                                        <div class="clearfix"></div>

                                    </div>
                                    <!--- card-footer Ends --->

                                </div>
                                <!--- card Ends --->

                            </div>
                            <!--- col-lg-3 col-md-6 mb-lg-0 mb-3 Ends --->

                            <?php } ?>

                    </div>
                    <!--- row Ends --->

                </div>
                <!--- card-body Ends --->

            </div>
            <!--- card Ends --->

        </div>
        <!--- col-lg-12 Ends --->

    </div>
    <!--- 2 row Ends --->

</div>



<?php } ?>