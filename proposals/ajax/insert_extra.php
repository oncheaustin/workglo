<?php

	session_start();

	require_once("../../includes/db.php");

	if(!isset($_SESSION['seller_user_name'])){

	echo "<script>window.open('../login','_self')</script>";

	}

  $rules = array(
  "name" => "required",
  "price" => "required");

  $val = new Validator($_POST,$rules);

  if($val->run() == false){

  echo "error";

  }else{

  $data = $input->post();

  $insert_extra = $db->insert("proposals_extras",$data);

  $data['id'] = $db->lastInsertId();

  echo json_encode($data);

  }