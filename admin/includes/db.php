<?php

include("../includes/config.php");

if(empty(DB_HOST) and empty(DB_USER) and empty(DB_NAME)){
	
echo "<script>window.open('../install.php','_self'); </script>";

exit();

}else{

include '../libs/database.php';

include '../libs/input.php';

include '../libs/validator.php';

include '../libs/flash.php';

$db->query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'");

$get_general_settings = $db->select("general_settings");   

$row_general_settings = $get_general_settings->fetch();

$site_favicon = $row_general_settings->site_favicon;

$site_url = $row_general_settings->site_url;

$tinymce_api_key = $row_general_settings->tinymce_api_key;
    
$site_name = $row_general_settings->site_name;

$site_keywords = $row_general_settings->site_keywords;

$site_author = $row_general_settings->site_author;

$site_desc = $row_general_settings->site_desc;
    
$site_logo_image = $row_general_settings->site_logo_image;

$site_currency = $row_general_settings->site_currency;


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


}

?>