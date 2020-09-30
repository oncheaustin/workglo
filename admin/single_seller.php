<?php


@session_start();

if(!isset($_SESSION['admin_email'])){
	
echo "<script>window.open('login','_self');</script>";
	
}else{
    
	
if(isset($_GET['single_seller'])){
	
$seller_id = $input->get('single_seller');


$get_seller = $db->select("sellers",array("seller_id" => $seller_id)); 
	
$row_seller = $get_seller->fetch();
	
$seller_name = $row_seller->seller_name;

$seller_user_name = $row_seller->seller_user_name;

$seller_level = $row_seller->seller_level;

$seller_email = $row_seller->seller_email;

$seller_image = $row_seller->seller_image;

$seller_about = $row_seller->seller_about;

$seller_verification = $row_seller->seller_verification;

$seller_headline = $row_seller->seller_headline;

$seller_country = $row_seller->seller_country;

$seller_ip = $row_seller->seller_ip;

$seller_register_date = $row_seller->seller_register_date;

$seller_language = $row_seller->seller_language;


$select_seller_accounts = $db->select("seller_accounts",array("seller_id" => $seller_id));
        
$row_seller_accounts = $select_seller_accounts->fetch();
    
$withdrawn = $row_seller_accounts->withdrawn;

$used_purchases = $row_seller_accounts->used_purchases;

$pending_clearance = $row_seller_accounts->pending_clearance;

$current_balance = $row_seller_accounts->current_balance;
    
    
$get_seller_languages = $db->select("seller_languages",array("language_id" => $seller_language));

$row_seller_languages = $get_seller_languages->fetch();

@$language_title = $row_seller_languages->language_title;



$level_title = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$adminLanguage))->fetch()->title;

}

?>

<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1><i class="menu-icon fa fa-user"></i> User on <?php echo ucfirst($site_name) ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Single Seller Details</li>
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

			<div class="card"><!--- card Starts --->

<div class="card-header">
    <!--- card-header Starts --->

    <h4 class="h4">

        <i class="fa fa-info-circle text-success"></i>
        <?php echo ucfirst($seller_user_name); ?>'s Info

    </h4>

</div>
<!--- card-header Ends --->

<div class="card-body row">
    <!--- card-body row Starts --->

    <div class="col-md-4">
        <!--- col-md-4 Starts --->

        <div class="seller-info mb-3">
            <!--- seller-info mb-3 Starts --->

            <?php if(!empty($seller_image)){ ?>

            <img src="../user_images/<?php echo $seller_image; ?>" class="rounded img-fluid">

            <?php }else{ ?>

            <img src="../user_images/empty-image.png" class="rounded img-fluid">

            <?php } ?>

            <div class="seller-info-title">
                <!--- seller-info-title Starts --->

                <span class="seller-info-inner"> <?php echo $seller_user_name; ?> </span>

                <span class="seller-info-type"> <?php echo $seller_country; ?> </span>


            </div>
            <!--- seller-info-title Ends --->

        </div>
        <!--- seller-info mb-3 Ends --->

        <div class="mb-3">
            <!--- mb-3 Starts --->

            <div class="widget-content-expanded">
                <!--- widget-content-expanded Starts --->

                <p class="lead">

                    <span class="font-weight-bold"> Full Name : </span>
                    <?php echo $seller_name; ?>

                </p>


                <p class="lead">

                    <span class="font-weight-bold"> Username : </span>
                    <?php echo $seller_user_name; ?>

                </p>


                <p class="lead">

                    <span class="font-weight-bold"> Email : </span>
                    <?php echo $seller_email; ?>

                </p>


                <p class="lead">

                    <span class="font-weight-bold"> Level : </span>
                    <?php echo $level_title; ?>

                </p>


                <p class="lead">

                    <span class="font-weight-bold"> Main Conversational Language : </span>

                    <?php echo $language_title; ?>

                </p>


                <p class="lead">

                    <span class="font-weight-bold"> Email Verification : </span>

                    <?php

                        if($seller_verification == "ok"){

                        echo ucfirst($seller_verification);

                        }else{

                        echo "No";

                        }

                    ?>

                </p>


                <p class="lead">

                    <span class="font-weight-bold"> Ip Address : </span>
                    <?php echo $seller_ip; ?>

                </p>


                <p class="lead">

                    <span class="font-weight-bold"> Country : </span>
                    <?php echo $seller_country; ?>

                </p>


                <p class="lead">

                    <span class="font-weight-bold"> Register Date : </span>
                    <?php echo $seller_register_date; ?>

                </p>

            </div>
            <!--- widget-content-expanded Ends --->

            <hr class="dotted short">

            <h5 class="text-muted font-weight-bold"> Headline </h5>

            <p>
                <?php echo $seller_headline; ?>
            </p>

        </div>
        <!--- mb-3 Ends --->

        <div class="mb-3">
            <!--- mb-3 Starts --->

            <hr class="dotted">

            <h5 class="text-muted font-weight-bold">About</h5>

            <p>

                <?php echo $seller_about; ?>

            </p>

        </div>
        <!--- mb-3 Ends --->

    </div>
    <!--- col-md-4 Ends --->

    <div class="col-md-8">
        <!--- col-md-8 Starts --->

        <h3 class="pb-1">
            <?php echo ucfirst($seller_user_name); ?>'s Orders </h3>

        <div class="row box">
            <!--- row box Starts --->

            <div class="text-center border-box col-md-3">
                <!--- text-center border-box col-md-3 Starts --->

                <p> Cancelled Orders </p>

                <?php

                $count_orders = $db->count("orders",["seller_id"=>$seller_id,"order_status"=>'cancelled']);

                ?>

                    <h2>
                        <?php echo $count_orders; ?>
                    </h2>

            </div>
            <!--- text-center border-box col-md-3 Ends --->


            <div class="text-center border-box col-md-3">
                <!--- text-center border-box col-md-3 Starts --->

                <p> Delivered Orders </p>

                <?php

                    $count_orders = $db->count("orders",["seller_id"=>$seller_id,"order_status"=>'delivered']);

                ?>

                    <h2>
                        <?php echo $count_orders; ?>
                    </h2>

            </div>
            <!--- text-center border-box col-md-3 Ends --->


            <div class="text-center border-box col-md-3">
                <!--- text-center border-box col-md-3 Starts --->

                <p> Completed Orders </p>

                <?php

                    $count_orders = $db->count("orders",["seller_id"=>$seller_id,"order_status"=>'completed']);

                ?>

                    <h2>
                        <?php echo $count_orders; ?>
                    </h2>

            </div>
            <!--- text-center border-box col-md-3 Ends --->



            <div class="text-center border-box col-md-3">
                <!--- text-center border-box col-md-3 Starts --->

                <p>Current Active Orders </p>

                <?php

                    $count_orders = $db->count("orders",["seller_id"=>$seller_id,"order_active"=>'yes']);


                ?>

                    <h2>
                        <?php echo $count_orders; ?>
                    </h2>

            </div>
            <!--- text-center border-box col-md-3 Ends --->


        </div>
        <!--- row box Ends --->


        <h3 class="pb-1">
            <?php echo  ucfirst($seller_user_name); ?>'s Earnings </h3>

        <div class="row box">
            <!--- row box Starts --->


            <div class="text-center border-box col-md-3">
                <!--- text-center border-box col-md-3 Starts --->

                <p> Withdrawals </p>

                <h2>
                    <?php echo $withdrawn; ?>
                </h2>

            </div>
            <!--- text-center border-box col-md-3 Ends --->


            <div class="text-center border-box col-md-3">
                <!--- text-center border-box col-md-3 Starts --->

                <p> Used on Proposals</p>

                <h2>
                    <?php echo $used_purchases; ?>
                </h2>

            </div>
            <!--- text-center border-box col-md-3 Ends --->


            <div class="text-center border-box col-md-3">
                <!--- text-center border-box col-md-3 Starts --->

                <p> Pending </p>

                <h2>
                    <?php echo $pending_clearance; ?>
                </h2>

            </div>
            <!--- text-center border-box col-md-3 Ends --->


            <div class="text-center border-box col-md-3">
                <!--- text-center border-box col-md-3 Starts --->

                <p> Availble Income </p>

                <h2>
                    <?php echo $current_balance; ?>
                </h2>

            </div>
            <!--- text-center border-box col-md-3 Ends --->


        </div>
        <!--- row box Ends --->


        <h2>
            <?php echo  ucfirst($seller_user_name); ?>'s Proposals/Services</h2>


        <div class="table-responsive pt-1">
            <!--- table-responsive mt-4 Starts --->

            <table class="table table-bordered">
                <!--- table table-bordered table-hover Starts --->

                <thead>
                    <!--- thead Starts --->

                    <tr>

                        <th>Proposal's Title</th>

                        <th>Proposal's Image</th>

                        <th>Proposal's Price</th>

                        <th>Proposal's Status</th>

                    </tr>

                </thead>
                <!--- thead Ends --->

                <tbody>
                    <!--- tbody Starts --->

                    <?php

                        $get_proposals = $db->select("proposals",array("proposal_seller_id" => $seller_id));

                        $count_proposals = $get_proposals->rowCount();

                        if($count_proposals == 0){

                        echo "

                        <tr>

                        <td colspan='4'>

                        <h3 class='text-center pt-1 pb-1'> This seller has no proposals/services. </h3>

                        </td>

                        </tr>

                        ";

                        }

                        while($row_proposals = $get_proposals->fetch()){

                        $proposal_title = $row_proposals->proposal_title;

                        $proposal_img1 = $row_proposals->proposal_img1;

                        $proposal_price = $row_proposals->proposal_price;

                        $proposal_status = $row_proposals->proposal_status;

                    ?>

                        <tr>

                            <td>
                                <?php echo $proposal_title; ?>
                            </td>

                            <td>

                                <img src="../proposals/proposal_files/<?php echo $proposal_img1; ?>" width="60" height="60">

                            </td>

                            <td>
                                <?php echo $proposal_price; ?>
                            </td>

                            <td>
                                <?php echo $proposal_status; ?>
                            </td>


                        </tr>

                        <?php } ?>

                </tbody>
                <!--- tbody Ends --->

            </table>
            <!--- table table-bordered table-hover Ends --->

        </div>
        <!--- table-responsive mt-4 Ends --->


    </div>
    <!--- col-md-8 Ends --->

</div>
<!--- card-body row Ends --->

</div>
<!--- card Ends --->


</div>
<!--- col-lg-12 Ends --->

</div>
<!--- 2 row Ends --->

</div>
<?php } ?>