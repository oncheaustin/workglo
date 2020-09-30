<?php
	@session_start();
	
	include "includes/db.php";
	include "Facebook/autoload.php";

	$FB = new \Facebook\Facebook([
		'app_id' => $fb_app_id,
		'app_secret' => $fb_app_secret,
  		'default_graph_version' => 'v2.10',
	]);

	$helper = $FB->getRedirectLoginHelper();