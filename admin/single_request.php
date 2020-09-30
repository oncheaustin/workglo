<?php


@session_start();

if(!isset($_SESSION['admin_email'])){
	
echo "<script>window.open('login','_self');</script>";
	
}else{
    
$single_request = $input->get('single_request');

$get_support_tickets = $db->select("support_tickets",array("ticket_id" => $single_request));

$row_support_tickets = $get_support_tickets->fetch();

$ticket_id = $row_support_tickets->ticket_id;

$sender_id = $row_support_tickets->sender_id;

$subject = $row_support_tickets->subject;

$status = $row_support_tickets->status;

$enquiry_id = $row_support_tickets->enquiry_id;

$message = $row_support_tickets->message;

$attachment = $row_support_tickets->attachment;

$order_number = $row_support_tickets->order_number;

$order_rule = $row_support_tickets->order_rule;

$date = $row_support_tickets->date;


$select_sender = $db->select("sellers",array("seller_id" => $sender_id));

$row_sender = $select_sender->fetch();

$sender_user_name = $row_sender->seller_user_name;

$sender_email = $row_sender->seller_email;


$get_enquiry_types = $db->select("enquiry_types",array("enquiry_id" => $enquiry_id));

$enquiry_title = $get_enquiry_types->fetch()->enquiry_title;

	
?>


<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1><i class="menu-icon fa fa-phone-square"></i> Support Settings</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Single Request</li>
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

                        View Single Request

                    </h4>

                </div><!--- card-header Ends --->

                <div class="card-body"><!--- card-body Starts --->

                    <p>

                        <b> Enquiry Type : </b>
                        <?php echo $enquiry_title; ?>

                    </p>

                    <p>

                        <b> Sender Username : </b>
                        <?php echo $sender_user_name; ?>

                    </p>

                    <p>

                        <b> Sender Email Address : </b>
                        <?php echo $sender_email; ?>

                    </p>

                    <p>

                        <b> Subject : </b>
                        <?php echo $subject; ?>

                    </p>

                    <p>

                        <b> Message : </b>
                        <?php echo $message; ?>

                    </p>

                    <?php if(!empty($order_rule)){ ?>

                    <p>

                        <b> Order Rule : </b>
                        <?php echo $order_rule; ?>

                    </p>

                    <?php } ?>

                    <?php if(!empty($order_number)){ ?>

                    <p>

                        <b> Order Number : </b>
                        <?php echo $order_number; ?>

                    </p>

                    <?php } ?>


                    <?php if(!empty($attachment)){ ?>

                    <p>

                        <b> Attachment : </b>

                        <a href="../ticket_files/<?php echo $attachment; ?>" download>
                            <?php echo $attachment; ?> </a>

                    </p>

                    <?php } ?>

                    <p>

                        <b> Request Created Date : </b>
                        <?php echo $date; ?>

                    </p>


                    <p>

                        <b> Request Status : </b>
                        <?php echo ucwords($status); ?> &nbsp;&nbsp;

                        <a href="#" class="btn btn-success" data-toggle="collapse" data-target="#status">

                            Change Status

                        </a>

                    </p>


                    <form id="status" class="collapse form-inline" method="post">
                        <!--- collapse form-inline Starts --->

                        <p class="text-muted mb-3">

                            <span class="text-danger">Note : </span> If you solve this issue, change the text from "OPEN" to "CLOSE". By doing this, this ticket will dissappear.

                        </p>

                        <div class="form-group">
                            <!--- form-group Starts --->

                            <label class="mb-2 mr-sm-2 mb-sm-0"> Change Status : </label>

                            <input type="text" name="status" class="form-control mb-2 mr-sm-2 mb-sm-0" value="<?php echo $status; ?>">

                            <input type="submit" name="update_status" class="form-control btn btn-success" value="Change Status">

                        </div>
                        <!--- form-group Ends --->

                        <?php

                            if(isset($_POST['update_status'])){

                            $status = $input->post('status');

                            $update_support_ticket = $db->update("support_tickets",array("status" => $status),array("ticket_id" => $single_request));

                            if($update_support_ticket){

                            $insert_log = $db->insert_log($admin_id,"support_request",$ticket_id,$status);

                            echo "<script>alert('Ticket has been changed successfully.');</script>";

                            echo "<script>window.open('index?view_support_requests','_self');</script>"; 

                            }

                            }

                        ?>

                    </form><!--- collapse form-inline Ends --->

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