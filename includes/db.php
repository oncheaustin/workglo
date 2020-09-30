<?php

@session_start();
require_once("config.php");

if(empty(DB_HOST) and empty(DB_USER) and empty(DB_NAME)){
	echo "<script>window.open('install','_self'); </script>";
	exit();
}else{

$dir = str_replace(array("includes"), '',__DIR__);

require_once "$dir/libs/database.php";
require_once "$dir/libs/input.php";
require_once "$dir/libs/validator.php";
require_once "$dir/libs/flash.php";
$db->query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'");

if(!isset($_SESSION['siteLanguage'])){
	$_SESSION['siteLanguage'] = $db->select("languages",["default_lang" =>1])->fetch()->id;
}

$siteLanguage = $_SESSION['siteLanguage'];
$get_general_settings = $db->select("general_settings");   
$row_general_settings = $get_general_settings->fetch();
$site_url = $row_general_settings->site_url;
$site_name = $row_general_settings->site_name;
$site_desc = $row_general_settings->site_desc;
$site_keywords = $row_general_settings->site_keywords;
$site_author = $row_general_settings->site_author;
$site_favicon = $row_general_settings->site_favicon;
$site_logo_type = $row_general_settings->site_logo_type;
$site_logo_text = $row_general_settings->site_logo_text;
$site_logo_image = $row_general_settings->site_logo_image;
$site_timezone = $row_general_settings->site_timezone;
$tinymce_api_key = $row_general_settings->tinymce_api_key;
$enable_social_login = $row_general_settings->enable_social_login;
$fb_app_id = $row_general_settings->fb_app_id;
$fb_app_secret = $row_general_settings->fb_app_secret;
$g_client_id = $row_general_settings->g_client_id;
$g_client_secret = $row_general_settings->g_client_secret;
$site_currency = $row_general_settings->site_currency;
$enable_maintenance_mode = $row_general_settings->enable_maintenance_mode;
$enable_referrals = $row_general_settings->enable_referrals;

$get_currencies = $db->select("currencies",array( "id" => $site_currency));
$row_currencies = $get_currencies->fetch();
$s_currency = $row_currencies->symbol;

$get_smtp_settings = $db->select("smtp_settings");
$row_smtp_settings = $get_smtp_settings->fetch();
$enable_smtp = $row_smtp_settings->enable_smtp;
$s_host = $row_smtp_settings->host;
$s_port = $row_smtp_settings->port;
$s_secure = $row_smtp_settings->secure;
$s_username = $row_smtp_settings->username;
$s_password = $row_smtp_settings->password;

date_default_timezone_set($site_timezone);

$row_language = $db->select("languages",array("id"=>$siteLanguage))->fetch();
$lang_dir = $row_language->direction;
require($dir."languages/".strtolower($row_language->title).".php");

require_once "$dir/screens/detect.php";
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
if($deviceType == "phone"){
	$proposals_stylesheet = '<link href="styles/mobile_proposals.css" rel="stylesheet">'; 
}else{
	$proposals_stylesheet = '<link href="styles/desktop_proposals.css" rel="stylesheet">'; 
}

if(isset($_SESSION['seller_user_name'])){
	$login_seller_user_name = $_SESSION['seller_user_name'];
	$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
	$count_seller_login = $select_login_seller->rowCount();
	if($count_seller_login == 0){
	echo "<script>window.open('$site_url/logout','_self');</script>";
	}else{
	$row_login_seller = $select_login_seller->fetch();
	$login_seller_id = $row_login_seller->seller_id;
	}
	}

	if(!isset($_SESSION['admin_email'])){
	if($enable_maintenance_mode == "yes"){ echo "<script>window.open('$site_url/maintenance','_self');</script>"; }
	}
}