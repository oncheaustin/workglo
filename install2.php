<?php
session_start();
require_once("includes/config.php");
require_once("libs/database.php");
require_once("libs/input.php");
if(!empty(DB_HOST) and !empty(DB_USER) and !empty(DB_NAME)){
echo "<script>window.open('index','_self'); </script>";
exit();
}
if(!isset($_SESSION["db_host"])){
echo "<script>window.open('install','_self'); </script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title> Install Script - Step Two</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
<link href="styles/bootstrap.css" rel="stylesheet">
<link href="styles/style.css" rel="stylesheet">
<link href="styles/category_nav_style.css" rel="stylesheet">
<link href="styles/sweat_alert.css" rel="stylesheet">
<!--- stylesheet width modifications --->
<link href="styles/custom.css" rel="stylesheet">
<link href="font_awesome/css/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/sweat_alert.js"></script>
<style>
    body {
        background-color: #001f3f;
    }
    .control-label {
        font-size: 16px;
        margin-top: 5px;
    }
    .card {
        box-shadow: 0px 0px 1px 2px #cccc;
    }
</style>
</head>
<body class="is-responsive">
<div class="container">
    <!-- container Starts -->
    <div class="row">
        <!-- row Starts -->
        <div class="col-md-2"></div>
        <div class="text-center col-md-8 mb-2 mt-5">
            <!-- col-md-12 mb-5 mt-5 Starts -->
            <h2 class="text-white"> Step Two </h2>
            <!---<img src="images/logo.png" width="100">-->
        </div>
        <!-- col-md-12 mb-5 mt-5 Ends -->
    </div>
    <div class="row">
        <!-- row Starts -->
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <!-- col-md-12 Starts -->
            <div class="card rounded-0 mb-5">
                <!-- card rounded-0 mb-5 Starts -->
                <div class="card-body">
                    <!-- card-body Starts -->
                    <h3>Site Information</h3>
                        <hr>
                        <p>Yay! you're almost done. Now type in your website information.</p>
                        <br>
                        <form method="post" enctype="multipart/form-data">
                            <!-- form Starts -->
                            <div class="form-group row ">
                                <!-- form-group row Starts -->
                                <div class="col-md-3 control-label h5 mt-2"> Site Title </div>
                                <div class="col-md-8">
                                    <input type="text" name="site_title" class="form-control" required>
                                    <small>E.g. GigToDo - Freelance MarketPlace</small>
                                </div>
                            </div>
                            <!-- form-group row Ends -->
                            <div class="form-group row ">
                                <!-- form-group row Starts -->
                                <div class="col-md-3 control-label h5 mt-2"> Site Url </div>
                                <div class="col-md-8">
                                    <input type="text" name="site_url" class="form-control" required>
                                    <small>E.g https://www.gigtodo.com (include the protocol "http://")</small>
                                </div>
                            </div>
                            <!-- form-group row Ends -->
                            <div class="form-group row ">
                                <!-- form-group row Starts -->
                                <div class="col-md-3 control-label h5 mt-2"> Site Description </div>
                                <div class="col-md-8">
                                    <textarea type="text" name="site_desc" rows="2" style="overflow-x:hidden;" class="form-control"></textarea>
                                </div>
                            </div>
                            <!-- form-group row Ends -->
                            <div class="form-group row ">
                                <!-- form-group row Starts -->
                                <div class="col-md-3 control-label h5 mt-2"> Site Name <span class="text-danger">*</span> </div>
                                <div class="col-md-8">
                                    <input type="text" name="site_name" class="form-control" required>
                                    <small>E.g. GigToDo</small>
                                </div>
                            </div>
                            <!-- form-group row Ends -->
                            <div class="form-group row ">
                                <!-- form-group row Starts -->
                                <div class="col-md-3 control-label h5 mt-2"> JwPlayer Code <small class="text-muted">(Optional)</small> </div>
                                <div class="col-md-8">
                                    <input type="text" name="jwplayer_code" class="form-control">
                                    <small> <a href="http://help.gigtodoscript.com/knowledge/details/3/How-to-get-the-JwPlayer-code-.html" target="_blank" class="text-success">How To?</a></small>
                                </div>
                            </div>
                            <!-- form-group row Ends -->
                            <h3>Admin Panel</h3>
                                <hr>
                                <div class="form-group row ">
                                    <!-- form-group row Starts -->
                                    <div class="col-md-3 control-label h5 mt-2"> Admin Name <span class="text-danger">*</span></div>
                                    <div class="col-md-8">
                                        <input type="text" name="admin_name" class="form-control" required>
                                    </div>
                                </div>
                                <!-- form-group row Ends -->
                                <div class="form-group row ">
                                    <!-- form-group row Starts -->
                                    <div class="col-md-3 control-label h5 mt-2"> Admin Email <span class="text-danger">*</span></div>
                                    <div class="col-md-8">
                                        <input type="email" name="admin_email" class="form-control" required="">
                                    </div>
                                </div>
                                <!-- form-group row Ends -->
                                <div class="form-group row ">
                                    <!-- form-group row Starts -->
                                    <div class="col-md-3 control-label h5 mt-2"> Admin Password <span class="text-danger">*</span> </div>
                                    <div class="col-md-8">
                                        <input type="password" name="admin_pass" class="form-control" required>
                                    </div>
                                </div>
                                <!-- form-group row Ends -->
                                <hr>
                                <div class="form-group row ">
                                    <!-- form-group row Starts -->
                                    <div class="col-md-7 control-label h5 mt-2"> </div>
                                    <div class="col-md-4">
                                        <button type="submit" name="install" class="btn btn-primary form-control">
                                        Install Script <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- form-group row Ends -->
                        </form>
                        <!-- form Ends -->
                </div><!-- card-body Ends -->
            </div><!-- card rounded-0 mb-5 Ends -->
        </div><!-- col-md-12 Ends -->
    </div><!-- row Ends -->
</div><!-- container Ends -->
<?php 
$host = $_SESSION["db_host"];
$uname = $_SESSION["db_username"];
$pass = $_SESSION["db_pass"];
$database = $_SESSION["db_name"]; //Change Your Database Name
if(isset($_POST["install"])){
    $site_title = $input->post('site_title');
    $site_url = $input->post('site_url');
    $site_desc = $input->post('site_desc');
    $site_name = $input->post('site_name');
    $jwplayer_code = $input->post('jwplayer_code');
    $admin_name = $input->post('admin_name');
    $admin_email = $input->post('admin_email');
    $admin_pass = $input->post('admin_pass');
    $encrypt_password = password_hash($admin_pass, PASSWORD_DEFAULT);

    $update_general_settings = $db->update("general_settings",array("site_title"=>$site_title,"site_url"=>$site_url,"site_desc"=>$site_desc,"site_name"=>$site_name,"jwplayer_code"=>$jwplayer_code));
    $update_admin = $db->update("admins",array("admin_name"=>$admin_name,"admin_email"=> $admin_email,"admin_pass"=> $encrypt_password));

    $config_file = "includes/config.php";
    $newData = "<?php
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    @define('DB_HOST', '$host');
    @define('DB_USER', '$uname');
    @define('DB_PASS', '$pass');
    @define('DB_NAME', '$database');"; 
    $handle = fopen($config_file, "w"); 
    fwrite($handle, $newData); 
    fclose($handle);

    session_destroy(); 

    echo "<script>window.open('install3', '_self');</script>";
} 
?>
</body>
</html>