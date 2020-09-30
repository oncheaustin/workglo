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
    <h1><i class="menu-icon fa fa-phone-square"></i> Support Settings</h1>
</div>
</div>
</div>
<div class="col-sm-8">
<div class="page-header float-right">
<div class="page-title">
    <ol class="breadcrumb text-right">
        <li class="active">View All Request</li>
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

 View Support Requests

</h4>

</div>
<!--- card-header Ends --->

<div class="card-body">
<!--- card-body Starts --->

<span class="text-muted mr-2">

<?php 

$count_support_tickets = $db->count("support_tickets",array("status" => "open"));

?>

All (<?php echo $count_support_tickets; ?>)

</span>

<?php

$get_enquiry_types = $db->select("enquiry_types");

while($row_enquiry_types = $get_enquiry_types->fetch()){

$enquiry_id = $row_enquiry_types->enquiry_id;

$enquiry_title = $row_enquiry_types->enquiry_title;


$count_enquiry_support_tickets = $db->count("support_tickets",array("enquiry_id" => $enquiry_id,"status" => "open"));

?>

    <span class="mr-2">|</span>

    <span class="mr-2">

    <?php echo $enquiry_title; ?> (<?php echo $count_enquiry_support_tickets; ?>)

    </span>

    <?php } ?>

    <div class="table-responsive mt-4"><!--- table-responsive mt-4 Starts --->

        <table class="table table-bordered links-table"><!--- table table-bordered table-hover links-table Starts --->

            <thead><!--- thead Starts --->

                <tr>

                    <th>Enquiry Type:</th>

                    <th>Sender Username:</th>

                    <th>Sender Email:</th>

                    <th>Subject:</th>

                    <th>Status:</th>

                </tr>

            </thead><!--- thead Ends --->

            <tbody><!--- tbody Starts --->

            <?php

                    $per_page = 7;

                    if(isset($_GET['view_support_requests'])){
                        
                    $page = $input->get('view_support_requests');

                    if($page == 0){ $page = 1; }
                        
                    }else{
                        
                    $page = 1;
                        
                    }

                    /// Page will start from 0 and multiply by per page

                    $start_from = ($page-1) * $per_page;

                    $get_support_tickets = $db->query("select * from support_tickets where status='open' order by 1 DESC LIMIT :limit OFFSET :offset","",array("limit"=>$per_page,"offset"=>$start_from));

                    while($row_support_tickets = $get_support_tickets->fetch()){

                    $ticket_id = $row_support_tickets->ticket_id;

                    $sender_id = $row_support_tickets->sender_id;

                    $subject = $row_support_tickets->subject;

                    $status = $row_support_tickets->status;

                    $enquiry_id = $row_support_tickets->enquiry_id;


                    $select_sender = $db->select("sellers",array("seller_id" => $sender_id));

                    $row_sender = $select_sender->fetch();

                    $sender_user_name = $row_sender->seller_user_name;

                    $sender_email = $row_sender->seller_email;


                    $get_enquiry_types = $db->select("enquiry_types",array("enquiry_id" => $enquiry_id));

                    $row_enquiry_types = $get_enquiry_types->fetch();

                    $enquiry_title = $row_enquiry_types->enquiry_title;

                ?>

                   <tr onclick="location.href='index?single_request=<?php echo $ticket_id; ?>'">

                        <td>
                            <?php echo $enquiry_title; ?>
                        </td>

                        <td>
                            <?php echo $sender_user_name; ?>
                        </td>

                        <td>
                            <?php echo $sender_email; ?>
                        </td>

                        <td>
                            <?php echo $subject; ?>
                        </td>

                        <td>

                        <button class="btn btn-success"><?php echo ucwords($status); ?></button>

                        </td>

                    </tr>

                    <?php } ?>

            </tbody>
            <!--- tbody Ends --->

        </table>
        <!--- table table-bordered table-hover links-table Ends --->

    </div>
    <!--- table-responsive mt-4 Ends --->


    <div class="d-flex justify-content-center"><!--- d-flex justify-content-center Starts --->

        <ul class="pagination"><!--- pagination Starts --->

        <?php 

        /// Now Select All From Data From Table

        $query = $db->select("support_tickets",array("status"=>'open'));
        
        /// Count The Total Records 

        $total_records = $query->rowCount();

        /// Using ceil function to divide the total records on per page

        $total_pages = ceil($total_records / $per_page);

        echo "<li class='page-item'><a href='index?view_support_requests=1' class='page-link'>First Page</a></li>";

        echo "<li class='page-item ".(1 == $page ? "active" : "")."'><a class='page-link' href='index?view_support_requests=1'>1</a></li>";
        
        $i = max(2, $page - 5);
        
        if ($i > 2)
        
            echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";
        
        for (; $i < min($page + 6, $total_pages); $i++) {
                    
            echo "<li class='page-item"; if($i == $page){ echo " active "; } echo "'><a href='index?view_support_requests=".$i."' class='page-link'>".$i."</a></li>";

        }
        
        if ($i != $total_pages and $total_pages > 1){echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";}

        if($total_pages > 1){echo "<li class='page-item ".($total_pages == $page ? "active" : "")."'><a class='page-link' href='index?view_support_requests=$total_pages'>$total_pages</a></li>";}

        echo "<li class='page-item'><a href='index?view_support_requests=$total_pages' class='page-link'>Last Page </a></li>";
        ?>

        </ul>
        <!--- pagination Ends --->

    </div>
    <!--- d-flex justify-content-center Ends --->


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