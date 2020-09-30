<?php 

include("../db.php");

$seller_id = $input->post('seller_id');

$select_inbox_messages = $db->select("inbox_messages",array("message_receiver"=>$seller_id,"bell"=>"active"));

while($row_inbox_messages = $select_inbox_messages->fetch()){

$message_id = $row_inbox_messages->message_id;

$update = $db->update("inbox_messages",array("bell"=>'over'),array("message_receiver"=>$seller_id,"bell"=>"active"));

echo "1";

}

?>