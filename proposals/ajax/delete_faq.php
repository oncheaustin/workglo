<?php

session_start();

require_once("../../includes/db.php");

if(!isset($_SESSION['seller_user_name'])){

echo "<script>window.open('../login','_self')</script>";

}

$data = $input->post();

$delete_extra = $db->delete("proposals_faq",$data);