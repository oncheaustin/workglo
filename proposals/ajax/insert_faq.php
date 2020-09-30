<?php

	session_start();

	require_once("../../includes/db.php");

	if(!isset($_SESSION['seller_user_name'])){

	echo "<script>window.open('../login','_self')</script>";

	}

  $rules = array(
  "title" => "required",
  "content" => "required");

  $val = new Validator($_POST,$rules);

  if($val->run() == false){

  echo "error";

  }else{

  $data = $input->post();

  $insert_extra = $db->insert("proposals_faq",$data);

  $data['id'] = $db->lastInsertId();

  }