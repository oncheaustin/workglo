<?php

require_once("$dir/social-config.php");

if(isset($_SESSION['seller_user_name'])){
	
$login_seller_user_name = $_SESSION['seller_user_name'];

$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));

$row_login_seller = $select_login_seller->fetch();

$login_seller_id = $row_login_seller->seller_id;
	
}


// Accounting (Sales)
function getAdminCommission($amount){
	global $db;
	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$percentage = $row_payment_settings->comission_percentage;

	$calculate_percentage = ($percentage / 100 ) * $amount ;
	return $calculate_percentage;
}

function insertSale($data){
	global $db;
	$data["date"] = date("Y-m-d");
	$sale = $db->insert("sales",$data);
	if($sale){return true;}
}

// Processing Fee
function get_percentage_amount($amount, $percentage){
	$calculate_percentage = ($percentage / 100 ) * $amount;
	return $calculate_percentage;
}

function processing_fee($amount){
	global $db;
	$get_payment_settings = $db->select("payment_settings");
	$row_payment_settings = $get_payment_settings->fetch();
	$processing_feeType = $row_payment_settings->processing_feeType;
	$processing_fee = $row_payment_settings->processing_fee;
	if($processing_feeType=="fixed") {
		return $processing_fee;
	}elseif($processing_feeType=="percentage"){
		return get_percentage_amount($amount,$processing_fee);
	}
}


/// Time Ago Function Starts ///

function time_ago($timestamp){  

    $time_ago = strtotime($timestamp);  
    $current_time = time();  
    $time_difference = $current_time - $time_ago;  
    $seconds = $time_difference;  
    $minutes      = round($seconds / 60 );           // value 60 is seconds  
    $hours           = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec  
    $days          = round($seconds / 86400);          //86400 = 24 * 60 * 60;  
    $weeks          = round($seconds / 604800);          // 7*24*60*60;  
    $months          = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60  
    $years          = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60  
    if($seconds <= 60)  
    {  
   return "Just Now";  
 }  
    else if($minutes <=60)  
    {  
   if($minutes==1)  
         {  
     return "one minute ago";  
   }  
   else  
         {  
     return "$minutes minutes ago";  
   }  
 }  
    else if($hours <=24)  
    {  
   if($hours==1)  
         {  
     return "an hour ago";  
   }  
         else  
         {  
     return "$hours hrs ago";  
   }  
 }  
    else if($days <= 7)  
    {  
   if($days==1)  
         {  
     return "yesterday";  
   }  
         else  
         {  
     return "$days days ago";  
   }  
 }  
    else if($weeks <= 4.3) //4.3 == 52/12  
    {  
   if($weeks==1)  
         {  
     return "a week ago";  
   }  
         else  
         {  
     return "$weeks weeks ago";  
   }  
 }  
     else if($months <=12)  
    {  
   if($months==1)  
         {  
     return "a month ago";  
   }  
         else  
         {  
     return "$months months ago";  
   }  
 } else{  
   if($years==1)  
         {  
     return "one year ago";  
   }  
         else  
         {  
     return "$years years ago";  
   }  
 }
}
/// Time Ago Function Ends ///

/// get_search_proposals Function Starts ///

function get_search_proposals(){

global $input;

global $siteLanguage;

global $db;

global $enable_referrals;

global $lang;

global $dir;

global $s_currency;

global $login_seller_id;

global $site_url;

$search_query = $_SESSION['search_query'];

$online_sellers = array();

$s_value = "%$search_query%";

$get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_title like :proposal_title AND proposal_status='active'",array(":proposal_title"=>$s_value));

while($row_proposals = $get_proposals->fetch()){
	
	$proposal_seller_id = $row_proposals->proposal_seller_id;
	
	$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

	$seller_status = $select_seller->fetch()->seller_status;
	
	if($seller_status == "online"){
		
	array_push($online_sellers,$proposal_seller_id);
		
	}


}

$where_online = array();

$where_cat = array();

$where_delivery_times = array();

$where_level = array();

$where_language = array();

$values = array();

if(isset($_REQUEST['online_sellers'])){
	$i = 0;
	foreach($_REQUEST['online_sellers'] as $value){

		if($value != 0){
			
			foreach($online_sellers as $seller_id){
		
				$i++;

				$where_online[] = "proposal_seller_id=:proposal_seller_id_$i";

				$values["proposal_seller_id_$i"] = $seller_id;
				
			}
			
		}
		
	}
	
}

if(isset($_REQUEST['cat_id'])){
	$i = 0;
	foreach($_REQUEST['cat_id'] as $value){
		
		$i++;

		if($value != 0){
			
			$where_cat[] = "proposal_cat_id=:proposal_cat_id_$i";

			$values["proposal_cat_id_$i"] = $value;
			
		}
	}
	
}

if(isset($_REQUEST['delivery_time'])){
		
	$i = 0;

	foreach($_REQUEST['delivery_time'] as $value){
		$i++;
		if($value != 0){
			
			$where_delivery_times[] = "delivery_id=:delivery_id_$i";

			$values["delivery_id_$i"] = $value;
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_level'])){
	
	$i = 0;

	foreach($_REQUEST['seller_level'] as $value){
		$i++;
		if($value != 0){
			
			$where_level[] = "level_id=:level_id_$i";

			$values["level_id_$i"] = $value;
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_language'])){
	$i=0;
	foreach($_REQUEST['seller_language'] as $value){
		$i++;
		if($value != 0){
			
			$where_language[] = "language_id=:language_id_$i";

			$values["language_id_$i"] = $value;
			
		}
		
	}
	
}

$values['proposal_title'] = $s_value;

$query_where = "where proposal_title like :proposal_title AND proposal_status='active' ";

if(count($where_online)>0){
	
	$query_where .= " and (" . implode(" or ",$where_online) . ")";
	
}

if(count($where_cat)>0){
	
	$query_where .= " and (" . implode(" or ",$where_cat) . ")";
	
}

if(count($where_delivery_times)>0){
	
	$query_where .= " and (" . implode(" or ",$where_delivery_times) . ")";
	
}

if(count($where_level)>0){
	
	$query_where .= " and (" . implode(" or ",$where_level) . ")";
	
}

if(count($where_language)>0){
	
	$query_where .= " and (" . implode(" or ",$where_language) . ")";
	
}

$per_page = 12;

if(isset($_GET['page'])){
	
	$page = $input->get('page');
	
}else{
	
	$page = 1;
	
}

$start_from = ($page-1) * $per_page;

$where_limit = " order by proposal_featured='yes' DESC LIMIT :limit OFFSET :offset";

$get_proposals = $db->query("select * from proposals " . $query_where . $where_limit,$values,array("limit"=>$per_page,"offset"=>$start_from));

$count_proposals = $get_proposals->rowCount();

if($count_proposals == 0){
	
echo"

<div class='col-md-12'>

<h1 class='text-center mt-4'><i class='fa fa-meh-o'></i> We haven't found any proposals/services matching that search </h1>

</div>

";
	
}

while($row_proposals = $get_proposals->fetch()){

$proposal_id = $row_proposals->proposal_id;

$proposal_title = $row_proposals->proposal_title;

$proposal_price = $row_proposals->proposal_price;

if($proposal_price == 0){

$get_p_1 = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));

$proposal_price = $get_p_1->fetch()->price;

}

$proposal_img1 = $row_proposals->proposal_img1;

$proposal_video = $row_proposals->proposal_video;

$proposal_seller_id = $row_proposals->proposal_seller_id;

$proposal_rating = $row_proposals->proposal_rating;

$proposal_url = $row_proposals->proposal_url;

$proposal_featured = $row_proposals->proposal_featured;

$proposal_enable_referrals = $row_proposals->proposal_enable_referrals;

$proposal_referral_money = $row_proposals->proposal_referral_money;


if(empty($proposal_video)){
	
	$video_class = "";
	
}else{
	
	$video_class = "video-img";
	
}


$get_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

$row_seller = $get_seller->fetch();

$seller_user_name = $row_seller->seller_user_name;

$seller_image = $row_seller->seller_image;

$seller_level = $row_seller->seller_level;

$seller_status = $row_seller->seller_status;

if(empty($seller_image)){

$seller_image = "empty-image.png";

}


// Select Proposal Seller Level

@$seller_level = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;


$proposal_reviews = array();

$select_buyer_reviews = $db->select("buyer_reviews",array("proposal_id" => $proposal_id));

$count_reviews = $select_buyer_reviews->rowCount();

while($row_buyer_reviews = $select_buyer_reviews->fetch()){
	
	$proposal_buyer_rating = $row_buyer_reviews->buyer_rating;
	
	array_push($proposal_reviews,$proposal_buyer_rating);
	
}

$total = array_sum($proposal_reviews);

@$average_rating = $total/count($proposal_reviews);



$count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));

if($count_favorites == 0){

$show_favorite_class = "proposal-favorite dil1";

}else{

$show_favorite_class = "proposal-unfavorite dil";

}

?>

<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">

<?php require("includes/proposals.php"); ?>

</div>

<?php	
	
}

}

/// get_search_proposals Function Ends ///


/// get_search_pagination Function Starts ///

function get_search_pagination(){
	
global $db;

global $input;

global $lang;

global $s_currency;

$search_query = $_SESSION['search_query'];

$s_value = "%$search_query%";

$online_sellers = array();

$get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_title like :proposal_title AND proposal_status='active'",array(":proposal_title"=>$s_value));

while($row_proposals = $get_proposals->fetch()){
	
	$proposal_seller_id = $row_proposals->proposal_seller_id;

	
	$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

	$seller_status = $select_seller->fetch()->seller_status;
	
	if($seller_status == "online"){
		
	array_push($online_sellers,$proposal_seller_id);
		
	}
	
}

$where_online = array();

$where_cat = array();

$where_delivery_times = array();

$where_level = array();

$where_language = array();

$values = array();

$where_path = "";

if(isset($_REQUEST['online_sellers'])){
	
	$i = 0;

	foreach($_REQUEST['online_sellers'] as $value){
		
		if($value != 0){
			
			foreach($online_sellers as $seller_id){
				$i++;
				$where_online[] = "proposal_seller_id=:proposal_seller_id_$i";

				$values["proposal_seller_id_$i"] = $seller_id;
				
			}
			
			$where_path .= "online_sellers[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['cat_id'])){
	
	$i = 0;

	foreach($_REQUEST['cat_id'] as $value){
		$i++;
		if($value != 0){
			
			$where_cat[] = "proposal_cat_id=:proposal_cat_id_$i";

			$values["proposal_cat_id_$i"] = $value;
			
			$where_path .= "cat_id[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['delivery_time'])){
	$i = 0;
	foreach($_REQUEST['delivery_time'] as $value){
		$i++;
		if($value != 0){
			
			$where_delivery_times[] = "delivery_id=:delivery_id_$i";

			$values["delivery_id_$i"] = $value;
			
			$where_path .= "delivery_time[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_level'])){
	$i = 0;
	foreach($_REQUEST['seller_level'] as $value){
		$i++;
		if($value != 0){
			
			$where_level[] = "level_id=:level_id_$i";

			$values["level_id_$i"] = $value;
			
			$where_path .= "seller_level[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_language'])){
	$i = 0;
	foreach($_REQUEST['seller_language'] as $value){
		$i++;
		if($value != 0){
			
			$where_language[] = "language_id=:language_id_$i";

			$values["language_id_$i"] = $value;
			
			$where_path .= "seller_language[]=" . $value . "&";
			
		}
		
	}
	
}


$values['proposal_title'] = $s_value;

$query_where = "where proposal_title like :proposal_title AND proposal_status='active' ";

if(count($where_online)>0){
	
	$query_where .= " and (" . implode(" or ",$where_online) . ")";
	
}

if(count($where_cat)>0){
	
	$query_where .= " and (" . implode(" or ",$where_cat) . ")";
	
}

if(count($where_delivery_times)>0){
	
	$query_where .= " and (" . implode(" or ",$where_delivery_times) . ")";
	
}

if(count($where_level)>0){
	
	$query_where .= " and (" . implode(" or ",$where_level) . ")";
	
}

if(count($where_language)>0){
	
	$query_where .= " and (" . implode(" or ",$where_language) . ")";
	
}

$per_page = 12;

$get_proposals = $db->query("select * from proposals " . $query_where,$values);

$count_proposals = $get_proposals->rowCount();

if($count_proposals > 0){
	
	$total_pages = ceil($count_proposals / $per_page);

    if(isset($_GET['page'])){ 

    $page = $input->get('page'); if($page == 0){ $page = 1; }
        
    }else{
        
    $page = 1;
        
    }

	echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='search?page=1&$where_path'>{$lang['pagination']['first_page']}</a>
	
	</li>";

    echo "<li class='page-item ".(1 == $page ? "active" : "")."'><a class='page-link' href='search?page=1&$where_path'>1</a></li>";
    
    $i = max(2, $page - 5);
    
    if ($i > 2)
    
        echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";
    
    for (; $i < min($page + 6, $total_pages); $i++) {
            	
    	echo "<li class='page-item"; if($i == $page){ echo " active "; } echo "'><a href='search?page=$i&$where_path' class='page-link'>".$i."</a></li>";

    }
    if ($i != $total_pages and $total_pages > 1){echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";}

    if($total_pages > 1){echo "<li class='page-item ".($total_pages == $page ? "active" : "")."'><a class='page-link' href='search?page=$total_pages&$where_path'>$total_pages</a></li>";}

	echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='search?page=$total_pages&$where_path'>{$lang['pagination']['last_page']}</a>
	
	</li>";

}
	
	
}


/// get_search_pagination Function Ends ///



/// get_category_proposals Function Starts ///

function get_category_proposals(){
	
global $input;

global $siteLanguage;

global $dir;

global $db;

global $enable_referrals;

global $lang;

global $s_currency;

global $login_seller_id;

global $site_url;

global $dir;


$online_sellers = array();

if(isset($_SESSION['cat_id'])){
	
$session_cat_id = $_SESSION['cat_id'];

$get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_cat_id=:cat_id AND proposal_status='active'",array("cat_id"=>$session_cat_id));

}elseif(isset($_SESSION['cat_child_id'])){
	
$session_cat_child_id = $_SESSION['cat_child_id'];

$get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_child_id=:child_id AND proposal_status='active'",array("child_id"=>$session_cat_child_id));
	
}

while($row_proposals = $get_proposals->fetch()){
	
	$proposal_seller_id = $row_proposals->proposal_seller_id;
	
	$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

	$seller_status = $select_seller->fetch()->seller_status;
	
	if($seller_status == "online"){
		
	array_push($online_sellers,$proposal_seller_id);
		
	}

}


$where_online = array();

$where_delivery_times = array();

$where_level = array();

$where_language = array();


if(isset($_REQUEST['online_sellers'])){
	$i = 0;
	foreach($_REQUEST['online_sellers'] as $value){

		if($value != 0){
			
			foreach($online_sellers as $seller_id){
		
				$i++;

				$where_online[] = "proposal_seller_id=:proposal_seller_id_$i";

				$values["proposal_seller_id_$i"] = $seller_id;
				
			}
			
		}
		
	}
	
}


if(isset($_REQUEST['delivery_time'])){
		$i = 0;
	foreach($_REQUEST['delivery_time'] as $value){
		$i++;
		if($value != 0){
			
			$where_delivery_times[] = "delivery_id=:delivery_id_$i";

			$values["delivery_id_$i"] = $value;
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_level'])){
	$i = 0;
	foreach($_REQUEST['seller_level'] as $value){
		$i++;
		if($value != 0){
			
			$where_level[] = "level_id=:level_id_$i";

			$values["level_id_$i"] = $value;
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_language'])){
	$i = 0;
	foreach($_REQUEST['seller_language'] as $value){
		$i++;
		if($value != 0){
			
			$where_language[] = "language_id=:language_id_$i";

			$values["language_id_$i"] = $value;
			
		}
		
	}
	
}

if(isset($_SESSION['cat_id'])){

$query_where = "where proposal_cat_id=:cat_id AND proposal_status='active' ";

}elseif(isset($_SESSION['cat_child_id'])){

$query_where = "where proposal_child_id=:child_id AND proposal_status='active' ";
	
}

if(isset($_SESSION['cat_id'])){

$values['cat_id'] = $session_cat_id;

}elseif(isset($_SESSION['cat_child_id'])){

$values['child_id'] = $session_cat_child_id;

}

if(count($where_online)>0){
	
	$query_where .= " and (" . implode(" or ",$where_online) . ")";
	
}

if(count($where_delivery_times)>0){
	
	$query_where .= " and (" . implode(" or ",$where_delivery_times) . ")";
	
}

if(count($where_level)>0){
	
	$query_where .= " and (" . implode(" or ",$where_level) . ")";
	
}

if(count($where_language)>0){
	
	$query_where .= " and (" . implode(" or ",$where_language) . ")";
	
}

$per_page = 12;

if(isset($_GET['page'])){
	
	$page = $input->get('page');
	
}else{
	
	$page = 1;
	
}

$start_from = ($page-1) * $per_page;

$where_limit = " order by proposal_featured='yes' DESC LIMIT :limit OFFSET :offset";

$get_proposals = $db->query("select * from proposals " . $query_where . $where_limit,$values,array("limit"=>$per_page,"offset"=>$start_from));

$count_proposals = $get_proposals->rowCount();

if($count_proposals == 0){
	
	if(isset($_SESSION['cat_id'])){
	
	echo "
	
	<div class='col-md-12'>
	
	<h1 class='text-center mt-4'><i class='fa fa-meh-o'></i> No proposals/services to Show in this Category Yet. </h1>
	
	</div>";
	
	}elseif(isset($_SESSION['cat_child_id'])){
		
	echo "
	
	<div class='col-md-12'>
	
	<h1 class='text-center mt-4'> <i class='fa fa-meh-o'></i> No proposals/services to Show in this Sub-Category Yet. </h1>
	
	</div>";
		
	}
	
	
}

while($row_proposals = $get_proposals->fetch()){

$proposal_id = $row_proposals->proposal_id;

$proposal_title = $row_proposals->proposal_title;

$proposal_price = $row_proposals->proposal_price;

if($proposal_price == 0){

$get_p_1 = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));

$proposal_price = $get_p_1->fetch()->price;

}


$proposal_img1 = $row_proposals->proposal_img1;

$proposal_video = $row_proposals->proposal_video;

$proposal_seller_id = $row_proposals->proposal_seller_id;

$proposal_rating = $row_proposals->proposal_rating;

$proposal_url = $row_proposals->proposal_url;

$proposal_featured = $row_proposals->proposal_featured;


$proposal_enable_referrals = $row_proposals->proposal_enable_referrals;

$proposal_referral_money = $row_proposals->proposal_referral_money;

if(empty($proposal_video)){
	
	$video_class = "";
	
}else{
	
	$video_class = "video-img";
	
}


$get_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

$row_seller = $get_seller->fetch();

$seller_user_name = $row_seller->seller_user_name;

$seller_image = $row_seller->seller_image;

$seller_level = $row_seller->seller_level;

$seller_status = $row_seller->seller_status;

if(empty($seller_image)){

$seller_image = "empty-image.png";

}


// Select Proposal Seller Level

@$seller_level = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;


$proposal_reviews = array();

$select_buyer_reviews = $db->select("buyer_reviews",array("proposal_id" => $proposal_id));

$count_reviews = $select_buyer_reviews->rowCount();

while($row_buyer_reviews = $select_buyer_reviews->fetch()){
	
	$proposal_buyer_rating = $row_buyer_reviews->buyer_rating;
	
	array_push($proposal_reviews,$proposal_buyer_rating);
	
}

$total = array_sum($proposal_reviews);

@$average_rating = $total/count($proposal_reviews);



$count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));

if($count_favorites == 0){

$show_favorite_class = "proposal-favorite dil1";

}else{

$show_favorite_class = "proposal-unfavorite dil";

}

	
?>

<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">

<?php require("$dir/includes/proposals.php"); ?>

</div>

<?php	
	
}
	
	
}

/// get_category_proposals Function Ends ///


/// get_category_pagination Function Starts ///

function get_category_pagination(){
	
global $db;

global $site_url;

global $input;

global $lang;

global $s_currency;

$online_sellers = array();

if(isset($_SESSION['cat_id'])){
	
$session_cat_id = $_SESSION['cat_id'];

$get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_cat_id=:cat_id AND proposal_status='active'",array("cat_id"=>$session_cat_id));

}elseif(isset($_SESSION['cat_child_id'])){
	
$session_cat_child_id = $_SESSION['cat_child_id'];

$get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_child_id=:child_id AND proposal_status='active'",array("child_id"=>$session_cat_child_id));
	
}

while($row_proposals = $get_proposals->fetch()){
	
	$proposal_seller_id = $row_proposals->proposal_seller_id;

	$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

	$seller_status = $select_seller->fetch()->seller_status;
	
	if($seller_status == "online"){
		
	array_push($online_sellers,$proposal_seller_id);
		
	}
	
}


$where_online = array();

$where_delivery_times = array();

$where_level = array();

$where_language = array();

$values = array();

$where_path = "";

if(isset($_REQUEST['online_sellers'])){
	$i = 0;
	foreach($_REQUEST['online_sellers'] as $value){
		
		if($value != 0){
			
			foreach($online_sellers as $seller_id){
				$i++;
				$where_online[] = "proposal_seller_id=:proposal_seller_id_$i";

				$values["proposal_seller_id_$i"] = $seller_id;
				
			}
			
			$where_path .= "online_sellers[]=" . $value . "&";
			
		}
		
	}
	
}



if(isset($_REQUEST['delivery_time'])){
	$i = 0;
	foreach($_REQUEST['delivery_time'] as $value){
		$i++;
		if($value != 0){
			
			$where_delivery_times[] = "delivery_id=:delivery_id_$i";

			$values["delivery_id_$i"] = $value;
			
			$where_path .= "delivery_time[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_level'])){
	$i = 0;
	foreach($_REQUEST['seller_level'] as $value){
		$i++;
		if($value != 0){
			
			$where_level[] = "level_id=:level_id_$i";

			$values["level_id_$i"] = $value;
			
			$where_path .= "seller_level[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_language'])){
	$i = 0;
	foreach($_REQUEST['seller_language'] as $value){
		$i++;
		if($value != 0){
			
			$where_language[] = "language_id=:language_id_$i";

			$values["language_id_$i"] = $value;
			
			$where_path .= "seller_language[]=" . $value . "&";
			
		}
		
	}
	
}


if(isset($_SESSION['cat_id'])){

$query_where = "where proposal_cat_id=:cat_id AND proposal_status='active' ";

}elseif(isset($_SESSION['cat_child_id'])){

$query_where = "where proposal_child_id=:child_id AND proposal_status='active' ";
	
}


if(isset($_SESSION['cat_id'])){

$values['cat_id'] = $session_cat_id;

}elseif(isset($_SESSION['cat_child_id'])){

$values['child_id'] = $session_cat_child_id;

}


if(count($where_online)>0){
	
	$query_where .= " and (" . implode(" or ",$where_online) . ")";
	
}

if(count($where_delivery_times)>0){
	
	$query_where .= " and (" . implode(" or ",$where_delivery_times) . ")";
	
}

if(count($where_level)>0){
	
	$query_where .= " and (" . implode(" or ",$where_level) . ")";
	
}

if(count($where_language)>0){
	
	$query_where .= " and (" . implode(" or ",$where_language) . ")";
	
}

$per_page = 12;


if(isset($_REQUEST['cat_child_url'])){

$child_url = "/" . $_REQUEST['cat_child_url'];

}else{

$child_url = "";
	
}


$get_proposals = $db->query("select * from proposals " . $query_where,$values);

$count_proposals = $get_proposals->rowCount();

if($count_proposals > 0){
	
	$total_pages = ceil($count_proposals / $per_page);
	

	if(isset($_GET['page'])){ 

    $page = $input->get('page'); if($page == 0){ $page = 1; }
        
    }else{
        
    $page = 1;
        
    }

	echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='$site_url/categories/{$_REQUEST['cat_url']}$child_url?page=1&$where_path'>
	
	{$lang['pagination']['first_page']}
	
	</a>
	
	</li>";

    echo "<li class='page-item ".(1 == $page ? "active" : "")."'><a class='page-link' href='$site_url/categories/{$_REQUEST['cat_url']}$child_url?page=1&$where_path'>1</a></li>";
    
    $i = max(2, $page - 5);
    
    if ($i > 2)
    
        echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";
    
    for (; $i < min($page + 6, $total_pages); $i++) {
            	
    	echo "<li class='page-item"; if($i == $page){ echo " active "; } echo "'><a href='$site_url/categories/{$_REQUEST['cat_url']}$child_url?page=$i&$where_path' class='page-link'>".$i."</a></li>";

    }

    if ($i != $total_pages and $total_pages > 1){echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";}

    if($total_pages > 1){echo "<li class='page-item ".($total_pages == $page ? "active" : "")."'><a class='page-link' href='$site_url/categories/{$_REQUEST['cat_url']}$child_url?page=$total_pages&$where_path'>$total_pages</a></li>";}

	echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='$site_url/categories/{$_REQUEST['cat_url']}$child_url?page=$total_pages&$where_path'>{$lang['pagination']['last_page']}</a>
	
	</li>";


	
}
	
}

/// get_category_pagination Function Ends ///






/// get_featured_proposals Function Starts ///

function get_featured_proposals(){

global $input;

global $siteLanguage;

global $db;

global $enable_referrals;

global $lang;

global $s_currency;

global $login_seller_id;

global $site_url;

global $dir;


$online_sellers = array();

$get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_featured='yes' AND proposal_status='active'");

while($row_proposals = $get_proposals->fetch()){
	
	$proposal_seller_id = $row_proposals->proposal_seller_id;
	
	$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

	$seller_status = $select_seller->fetch()->seller_status;
	
	if($seller_status == "online"){
		
	array_push($online_sellers,$proposal_seller_id);
		
	}

}

$where_online = array();

$where_cat = array();

$where_delivery_times = array();

$where_level = array();

$where_language = array();

$values = array();

if(isset($_REQUEST['online_sellers'])){
	$i = 0;
	foreach($_REQUEST['online_sellers'] as $value){

		if($value != 0){
			
			foreach($online_sellers as $seller_id){
		
				$i++;

				$where_online[] = "proposal_seller_id=:proposal_seller_id_$i";

				$values["proposal_seller_id_$i"] = $seller_id;
				
			}
			
		}
		
	}
	
}

if(isset($_REQUEST['cat_id'])){
	$i = 0;
	foreach($_REQUEST['cat_id'] as $value){
		
		$i++;

		if($value != 0){
			
			$where_cat[] = "proposal_cat_id=:proposal_cat_id_$i";

			$values["proposal_cat_id_$i"] = $value;
			
		}
	}
	
}

if(isset($_REQUEST['delivery_time'])){
		$i = 0;
	foreach($_REQUEST['delivery_time'] as $value){
		$i++;
		if($value != 0){
			
			$where_delivery_times[] = "delivery_id=:delivery_id_$i";

			$values["delivery_id_$i"] = $value;
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_level'])){
	$i = 0;
	foreach($_REQUEST['seller_level'] as $value){
		$i++;
		if($value != 0){
			
			$where_level[] = "level_id=:level_id_$i";

			$values["level_id_$i"] = $value;
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_language'])){
	$i++;
	foreach($_REQUEST['seller_language'] as $value){
		$i++;
		if($value != 0){
			
			$where_language[] = "language_id=:language_id_$i";

			$values["language_id_$i"] = $value;
			
		}
		
	}
	
}

$query_where = "where proposal_featured='yes' AND proposal_status='active' ";

if(count($where_online)>0){
	
	$query_where .= " and (" . implode(" or ",$where_online) . ")";
	
}

if(count($where_cat)>0){
	
	$query_where .= " and (" . implode(" or ",$where_cat) . ")";
	
}

if(count($where_delivery_times)>0){
	
	$query_where .= " and (" . implode(" or ",$where_delivery_times) . ")";
	
}

if(count($where_level)>0){
	
	$query_where .= " and (" . implode(" or ",$where_level) . ")";
	
}

if(count($where_language)>0){
	
	$query_where .= " and (" . implode(" or ",$where_language) . ")";
	
}

$per_page = 12;

if(isset($_GET['page'])){
	
	$page = $input->get('page');
	
}else{
	
	$page = 1;
	
}

$start_from = ($page-1) * $per_page;

$where_limit = " order by proposal_featured='yes' DESC LIMIT :limit OFFSET :offset";

$get_proposals = $db->query("select * from proposals " . $query_where . $where_limit,$values,array("limit"=>$per_page,"offset"=>$start_from));

$count_proposals = $get_proposals->rowCount();

if($count_proposals == 0){
	
echo "

<div class='col-md-12'>

<h1 class='text-center mt-4'><i class='fa fa-meh-o'></i> Sorry, We haven't found any proposals/services matching that search. </h1>

</div>

";

	
}

while($row_proposals = $get_proposals->fetch()){

$proposal_id = $row_proposals->proposal_id;

$proposal_title = $row_proposals->proposal_title;

$proposal_price = $row_proposals->proposal_price;

if($proposal_price == 0){

$get_p_1 = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));

$proposal_price = $get_p_1->fetch()->price;

}


$proposal_img1 = $row_proposals->proposal_img1;

$proposal_video = $row_proposals->proposal_video;

$proposal_seller_id = $row_proposals->proposal_seller_id;

$proposal_rating = $row_proposals->proposal_rating;

$proposal_url = $row_proposals->proposal_url;

$proposal_featured = $row_proposals->proposal_featured;


$proposal_enable_referrals = $row_proposals->proposal_enable_referrals;

$proposal_referral_money = $row_proposals->proposal_referral_money;


if(empty($proposal_video)){
	
	$video_class = "";
	
}else{
	
	$video_class = "video-img";
	
}


$get_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

$row_seller = $get_seller->fetch();

$seller_user_name = $row_seller->seller_user_name;

$seller_image = $row_seller->seller_image;

$seller_level = $row_seller->seller_level;

$seller_status = $row_seller->seller_status;

if(empty($seller_image)){

$seller_image = "empty-image.png";

}


// Select Proposal Seller Level

@$seller_level = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;


$proposal_reviews = array();

$select_buyer_reviews = $db->select("buyer_reviews",array("proposal_id" => $proposal_id));

$count_reviews = $select_buyer_reviews->rowCount();

while($row_buyer_reviews = $select_buyer_reviews->fetch()){
	
	$proposal_buyer_rating = $row_buyer_reviews->buyer_rating;
	
	array_push($proposal_reviews,$proposal_buyer_rating);
	
}

$total = array_sum($proposal_reviews);

@$average_rating = $total/count($proposal_reviews);



$count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));

if($count_favorites == 0){

$show_favorite_class = "proposal-favorite dil1";

}else{

$show_favorite_class = "proposal-unfavorite dil";

}	


?>

<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">

<?php require("includes/proposals.php"); ?>

</div>

<?php	
	
}
	
}

/// get_featured_proposals Function Ends ///


/// get_featured_pagination Function Starts ///

function get_featured_pagination(){
	

global $db;

global $input;

global $lang;

global $s_currency;


$online_sellers = array();

$get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_featured='yes' AND proposal_status='active'");

while($row_proposals = $get_proposals->fetch()){
	
	$proposal_seller_id = $row_proposals->proposal_seller_id;

	
	$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

	$seller_status = $select_seller->fetch()->seller_status;
	
	if($seller_status == "online"){
	
	array_push($online_sellers,$proposal_seller_id);
	
	}

}


$where_online = array();

$where_cat = array();

$where_delivery_times = array();

$where_level = array();

$where_language = array();

$values = array();

$where_path = "";

if(isset($_REQUEST['online_sellers'])){
	$i = 0;
	foreach($_REQUEST['online_sellers'] as $value){
		
		if($value != 0){
			
			foreach($online_sellers as $seller_id){
				$i++;
				$where_online[] = "proposal_seller_id=:proposal_seller_id_$i";

				$values["proposal_seller_id_$i"] = $seller_id;
				
			}
			
			$where_path .= "online_sellers[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['cat_id'])){
	$i = 0;
	foreach($_REQUEST['cat_id'] as $value){
		$i++;
		if($value != 0){
			
			$where_cat[] = "proposal_cat_id=:proposal_cat_id_$i";

			$values["proposal_cat_id_$i"] = $value;
			
			$where_path .= "cat_id[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['delivery_time'])){
	$i = 0;
	foreach($_REQUEST['delivery_time'] as $value){
		$i++;
		if($value != 0){
			
			$where_delivery_times[] = "delivery_id=:delivery_id_$i";

			$values["delivery_id_$i"] = $value;
			
			$where_path .= "delivery_time[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_level'])){
	$i = 0;
	foreach($_REQUEST['seller_level'] as $value){
		$i++;
		if($value != 0){
			
			$where_level[] = "level_id=:level_id_$i";

			$values["level_id_$i"] = $value;
			
			$where_path .= "seller_level[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_language'])){
	$i = 0;
	foreach($_REQUEST['seller_language'] as $value){
		$i++;
		if($value != 0){
			
			$where_language[] = "language_id=:language_id_$i";

			$values["language_id_$i"] = $value;
			
			$where_path .= "seller_language[]=" . $value . "&";
			
		}
		
	}
	
}


$query_where = "where proposal_featured='yes' AND proposal_status='active' ";

if(count($where_online)>0){
	
	$query_where .= " and (" . implode(" or ",$where_online) . ")";
	
}

if(count($where_cat)>0){
	
	$query_where .= " and (" . implode(" or ",$where_cat) . ")";
	
}

if(count($where_delivery_times)>0){
	
	$query_where .= " and (" . implode(" or ",$where_delivery_times) . ")";
	
}

if(count($where_level)>0){
	
	$query_where .= " and (" . implode(" or ",$where_level) . ")";
	
}

if(count($where_language)>0){
	
	$query_where .= " and (" . implode(" or ",$where_language) . ")";
	
}

$per_page = 12;

$get_proposals = $db->query("select * from proposals " . $query_where,$values);

$count_proposals = $get_proposals->rowCount();

if($count_proposals > 0){
	
	$total_pages = ceil($count_proposals / $per_page);
	

	if(isset($_GET['page'])){ 

    $page = $input->get('page'); if($page == 0){ $page = 1; }
        
    }else{
        
    $page = 1;
        
    }

	echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='featured_proposals?page=1&$where_path'>{$lang['pagination']['first_page']}</a>
	
	</li>";

    echo "<li class='page-item ".(1 == $page ? "active" : "")."'><a class='page-link' href='featured_proposals?page=1&$where_path'>1</a></li>";
    
    $i = max(2, $page - 5);
    
    if ($i > 2)
    
        echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";
    
    for (; $i < min($page + 6, $total_pages); $i++) {
            	
    	echo "<li class='page-item"; if($i == $page){ echo " active "; } echo "'><a href='featured_proposals?page=$i&$where_path' class='page-link'>".$i."</a></li>";

    }
    if ($i != $total_pages and $total_pages > 1){echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";}

    if($total_pages > 1){echo "<li class='page-item ".($total_pages == $page ? "active" : "")."'><a class='page-link' href='featured_proposals?page=$total_pages&$where_path'>$total_pages</a></li>";}

	echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='featured_proposals?page=$total_pages&$where_path'>{$lang['pagination']['last_page']}</a>
	
	</li>";

	
}
	
	
}


/// get_featured_pagination Function Ends ///






/// get_top_proposals Function Starts ///

function get_top_proposals(){

global $input;

global $siteLanguage;

global $db;

global $enable_referrals;

global $lang;

global $s_currency;

global $login_seller_id;

global $site_url;

global $dir;

$online_sellers = array();

$get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where level_id='4' and proposal_status='active'");

while($row_proposals = $get_proposals->fetch()){
	
	$proposal_seller_id = $row_proposals->proposal_seller_id;
	
	$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

	$seller_status = $select_seller->fetch()->seller_status;
	
	if($seller_status == "online"){
		
	array_push($online_sellers,$proposal_seller_id);
		
	}

}


$where_online = array();

$where_cat = array();

$where_delivery_times = array();

$where_level = array();

$where_language = array();

$values = array();

if(isset($_REQUEST['online_sellers'])){
	$i = 0;
	foreach($_REQUEST['online_sellers'] as $value){

		if($value != 0){
			
			foreach($online_sellers as $seller_id){
		
				$i++;

				$where_online[] = "proposal_seller_id=:proposal_seller_id_$i";

				$values["proposal_seller_id_$i"] = $seller_id;
				
			}
			
		}
		
	}
	
}

if(isset($_REQUEST['cat_id'])){
	$i = 0;
	foreach($_REQUEST['cat_id'] as $value){
		
		$i++;

		if($value != 0){
			
			$where_cat[] = "proposal_cat_id=:proposal_cat_id_$i";

			$values["proposal_cat_id_$i"] = $value;
			
		}
	}
	
}

if(isset($_REQUEST['delivery_time'])){
		$i = 0;
	foreach($_REQUEST['delivery_time'] as $value){
		$i++;
		if($value != 0){
			
			$where_delivery_times[] = "delivery_id=:delivery_id_$i";

			$values["delivery_id_$i"] = $value;
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_level'])){
	$i = 0;
	foreach($_REQUEST['seller_level'] as $value){
		$i++;
		if($value != 0){
			
			$where_level[] = "level_id=:level_id_$i";

			$values["level_id_$i"] = $value;
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_language'])){
	$i = 0;
	foreach($_REQUEST['seller_language'] as $value){
		$i++;
		if($value != 0){
			
			$where_language[] = "language_id=:language_id_$i";

			$values["language_id_$i"] = $value;
			
		}
		
	}
	
}

$topProposals = array();
$select = $db->query("select * from top_proposals");
while($row = $select->fetch()){
  array_push($topProposals,  $row->proposal_id);
}

if(empty($topProposals)){
$query_where = "where level_id='4' and proposal_status='active' ";
}else{
$topProposals = implode(",", $topProposals);
$topRatedWhere = "level_id='4' and proposal_status='active'";
$query_where = "where proposal_id in ($topProposals) or ($topRatedWhere) ";
}

if(count($where_online)>0){
	
	$query_where .= " and (" . implode(" or ",$where_online) . ")";
	
}

if(count($where_cat)>0){
	
	$query_where .= " and (" . implode(" or ",$where_cat) . ")";
	
}

if(count($where_delivery_times)>0){
	
	$query_where .= " and (" . implode(" or ",$where_delivery_times) . ")";
	
}

if(count($where_level)>0){
	
	$query_where .= " and (" . implode(" or ",$where_level) . ")";
	
}

if(count($where_language)>0){
	
	$query_where .= " and (" . implode(" or ",$where_language) . ")";
	
}

$per_page = 12;

if(isset($_GET['page'])){
	
	$page = $input->get('page');
	
}else{
	
	$page = 1;
	
}

$start_from = ($page-1) * $per_page;

$where_limit = " order by proposal_featured='yes' DESC LIMIT :limit OFFSET :offset";

$get_proposals = $db->query("select * from proposals " . $query_where . $where_limit,$values,array("limit"=>$per_page,"offset"=>$start_from));

$count_proposals = $get_proposals->rowCount();

if($count_proposals == 0){
	
	echo "
	
	<div class='col-md-12'>
	
	<h1 class='text-center mt-4'><i class='fa fa-meh-o'></i> Sorry, We haven't found any proposals/services matching that search </h1>
	
	</div>
	
	
	";
	
	
}

while($row_proposals = $get_proposals->fetch()){
	
$proposal_id = $row_proposals->proposal_id;

$proposal_title = $row_proposals->proposal_title;

$proposal_price = $row_proposals->proposal_price;

if($proposal_price == 0){

$get_p_1 = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));

$proposal_price = $get_p_1->fetch()->price;

}


$proposal_img1 = $row_proposals->proposal_img1;

$proposal_video = $row_proposals->proposal_video;

$proposal_seller_id = $row_proposals->proposal_seller_id;

$proposal_rating = $row_proposals->proposal_rating;

$proposal_url = $row_proposals->proposal_url;

$proposal_featured = $row_proposals->proposal_featured;


$proposal_enable_referrals = $row_proposals->proposal_enable_referrals;

$proposal_referral_money = $row_proposals->proposal_referral_money;


if(empty($proposal_video)){
	
	$video_class = "";
	
}else{
	
	$video_class = "video-img";
	
}


$get_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

$row_seller = $get_seller->fetch();

$seller_user_name = $row_seller->seller_user_name;

$seller_image = $row_seller->seller_image;

$seller_level = $row_seller->seller_level;

$seller_status = $row_seller->seller_status;

if(empty($seller_image)){

$seller_image = "empty-image.png";

}


// Select Proposal Seller Level

@$seller_level = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;


$proposal_reviews = array();

$select_buyer_reviews = $db->select("buyer_reviews",array("proposal_id" => $proposal_id));

$count_reviews = $select_buyer_reviews->rowCount();

while($row_buyer_reviews = $select_buyer_reviews->fetch()){
	
	$proposal_buyer_rating = $row_buyer_reviews->buyer_rating;
	
	array_push($proposal_reviews,$proposal_buyer_rating);
	
}

$total = array_sum($proposal_reviews);

@$average_rating = $total/count($proposal_reviews);



$count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));

if($count_favorites == 0){

$show_favorite_class = "proposal-favorite dil1";

}else{

$show_favorite_class = "proposal-unfavorite dil";

}

?>

<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">

<?php require("includes/proposals.php"); ?>

</div>

<?php	
	
}
	
}

/// get_top_proposals Function Ends ///


/// get_top_pagination Function Starts ///

function get_top_pagination(){
	
global $db;

global $input;

global $lang;

global $s_currency;

$online_sellers = array();

$get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where level_id='4' and proposal_status='active'");

while($row_proposals = $get_proposals->fetch()){
	
	$proposal_seller_id = $row_proposals->proposal_seller_id;

	
	$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

	$seller_status = $select_seller->fetch()->seller_status;
	
	if($seller_status == "online"){
		
	array_push($online_sellers,$proposal_seller_id);
		
	}

}

$where_online = array();

$where_cat = array();

$where_delivery_times = array();

$where_level = array();

$where_language = array();

$values = array();

$where_path = "";

if(isset($_REQUEST['online_sellers'])){
	$i = 0;
	foreach($_REQUEST['online_sellers'] as $value){
		
		if($value != 0){
			
			foreach($online_sellers as $seller_id){
				$i++;
				$where_online[] = "proposal_seller_id=:proposal_seller_id_$i";

				$values["proposal_seller_id_$i"] = $seller_id;
				
			}
			
			$where_path .= "online_sellers[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['cat_id'])){
	$i = 0;
	foreach($_REQUEST['cat_id'] as $value){
		$i++;
		if($value != 0){
			
			$where_cat[] = "proposal_cat_id=:proposal_cat_id_$i";

			$values["proposal_cat_id_$i"] = $value;
			
			$where_path .= "cat_id[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['delivery_time'])){
	$i = 0;
	foreach($_REQUEST['delivery_time'] as $value){
		$i++;
		if($value != 0){
			
			$where_delivery_times[] = "delivery_id=:delivery_id_$i";

			$values["delivery_id_$i"] = $value;
			
			$where_path .= "delivery_time[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_level'])){
	$i = 0;
	foreach($_REQUEST['seller_level'] as $value){
		$i++;
		if($value != 0){
			
			$where_level[] = "level_id=:level_id_$i";

			$values["level_id_$i"] = $value;
			
			$where_path .= "seller_level[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_language'])){
	$i = 0;
	foreach($_REQUEST['seller_language'] as $value){
		$i++;
		if($value != 0){
			
			$where_language[] = "language_id=:language_id_$i";

			$values["language_id_$i"] = $value;
			
			$where_path .= "seller_language[]=" . $value . "&";
			
		}
		
	}
	
}
$query_where = "where level_id='4' and proposal_status='active' ";

if(count($where_online)>0){
	
	$query_where .= " and (" . implode(" or ",$where_online) . ")";
	
}

if(count($where_cat)>0){
	
	$query_where .= " and (" . implode(" or ",$where_cat) . ")";
	
}

if(count($where_delivery_times)>0){
	
	$query_where .= " and (" . implode(" or ",$where_delivery_times) . ")";
	
}

if(count($where_level)>0){
	
	$query_where .= " and (" . implode(" or ",$where_level) . ")";
	
}

if(count($where_language)>0){
	
	$query_where .= " and (" . implode(" or ",$where_language) . ")";
	
}

$per_page = 12;

$get_proposals = $db->query("select * from proposals " . $query_where,$values);

$count_proposals = $get_proposals->rowCount();

if($count_proposals > 0){
	
	$total_pages = ceil($count_proposals / $per_page);
	

	if(isset($_GET['page'])){ 

    $page = $input->get('page'); if($page == 0){ $page = 1; }
        
    }else{
        
    $page = 1;
        
    }

	echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='top_proposals?page=1&$where_path'>{$lang['pagination']['first_page']}</a>
	
	</li>";

    echo "<li class='page-item ".(1 == $page ? "active" : "")."'><a class='page-link' href='top_proposals?page=1&$where_path'>1</a></li>";
    
    $i = max(2, $page - 5);
    
    if ($i > 2)
    
        echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";
    
    for (; $i < min($page + 6, $total_pages); $i++) {
            	
    	echo "<li class='page-item"; if($i == $page){ echo " active "; } echo "'><a href='top_proposals?page=$i&$where_path' class='page-link'>".$i."</a></li>";

    }
    if ($i != $total_pages and $total_pages > 1){echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";}

    if($total_pages > 1){echo "<li class='page-item ".($total_pages == $page ? "active" : "")."'><a class='page-link' href='top_proposals?page=$total_pages&$where_path'>$total_pages</a></li>";}

	echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='top_proposals?page=$total_pages&$where_path'>{$lang['pagination']['last_page']}</a>
	
	</li>";




	}

	}

/// get_top_pagination Function Ends ///







/// get_random_proposals Function Starts ///

function get_random_proposals(){

global $input;

global $siteLanguage;

global $db;

global $enable_referrals;

global $dir;

global $lang;

global $s_currency;

global $login_seller_id;

global $site_url;

$online_sellers = array();

$get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_status='active' order by rand()");

while($row_proposals = $get_proposals->fetch()){
	
	$proposal_seller_id = $row_proposals->proposal_seller_id;
	
	$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

	$seller_status = $select_seller->fetch()->seller_status;
	
	if($seller_status == "online"){
		
	array_push($online_sellers,$proposal_seller_id);
		
	}

}


$where_online = array();

$where_cat = array();

$where_delivery_times = array();

$where_level = array();

$where_language = array();

$values = array();

if(isset($_REQUEST['online_sellers'])){
	$i = 0;
	foreach($_REQUEST['online_sellers'] as $value){

		if($value != 0){
			
			foreach($online_sellers as $seller_id){
		
				$i++;

				$where_online[] = "proposal_seller_id=:proposal_seller_id_$i";

				$values["proposal_seller_id_$i"] = $seller_id;
				
			}
			
		}
		
	}
	
}


if(isset($_REQUEST['cat_id'])){
	$i = 0;
	foreach($_REQUEST['cat_id'] as $value){
		
		$i++;

		if($value != 0){
			
			$where_cat[] = "proposal_cat_id=:proposal_cat_id_$i";

			$values["proposal_cat_id_$i"] = $value;
			
		}
	}
	
}

if(isset($_REQUEST['delivery_time'])){
		$i = 0;
	foreach($_REQUEST['delivery_time'] as $value){
		$i++;
		if($value != 0){
			
			$where_delivery_times[] = "delivery_id=:delivery_id_$i";

			$values["delivery_id_$i"] = $value;
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_level'])){
	$i = 0;
	foreach($_REQUEST['seller_level'] as $value){
		$i++;
		if($value != 0){
			
			$where_level[] = "level_id=:level_id_$i";

			$values["level_id_$i"] = $value;
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_language'])){
	$i = 0;
	foreach($_REQUEST['seller_language'] as $value){
		$i++;
		if($value != 0){
			
			$where_language[] = "language_id=:language_id_$i";

			$values["language_id_$i"] = $value;
			
		}
		
	}
	
}


$query_where = "where proposal_status='active' ";

if(count($where_online)>0){
	
	$query_where .= " and (" . implode(" or ",$where_online) . ")";
	
}

if(count($where_cat)>0){
	
	$query_where .= " and (" . implode(" or ",$where_cat) . ")";
	
}

if(count($where_delivery_times)>0){
	
	$query_where .= " and (" . implode(" or ",$where_delivery_times) . ")";
	
}

if(count($where_level)>0){
	
	$query_where .= " and (" . implode(" or ",$where_level) . ")";
	
}

if(count($where_language)>0){
	
	$query_where .= " and (" . implode(" or ",$where_language) . ")";
	
}

$per_page = 12;

if(isset($_GET['page'])){
	
	$page = $input->get('page');
	
}else{
	
	$page = 1;
	
}

$start_from = ($page-1) * $per_page;

$where_limit = " order by rand() DESC LIMIT :limit OFFSET :offset";

$get_proposals = $db->query("select * from proposals " . $query_where . $where_limit,$values,array("limit"=>$per_page,"offset"=>$start_from));

$count_proposals = $get_proposals->rowCount();

if($count_proposals == 0){
	
	echo "
	
	<div class='col-md-12'>
	
	<h1 class='text-center mt-4'>

	<i class='fa fa-meh-o'></i> We haven't found any proposals/services matching that search. 

	</h1>
	
	</div>";
	
}

while($row_proposals = $get_proposals->fetch()){
	
$proposal_id = $row_proposals->proposal_id;

$proposal_title = $row_proposals->proposal_title;

$proposal_price = $row_proposals->proposal_price;

if($proposal_price == 0){

$get_p_1 = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));

$proposal_price = $get_p_1->fetch()->price;

}


$proposal_img1 = $row_proposals->proposal_img1;

$proposal_video = $row_proposals->proposal_video;

$proposal_seller_id = $row_proposals->proposal_seller_id;

$proposal_rating = $row_proposals->proposal_rating;

$proposal_url = $row_proposals->proposal_url;

$proposal_featured = $row_proposals->proposal_featured;


$proposal_enable_referrals = $row_proposals->proposal_enable_referrals;

$proposal_referral_money = $row_proposals->proposal_referral_money;

if(empty($proposal_video)){
	
	$video_class = "";
	
}else{
	
	$video_class = "video-img";
	
}


$get_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

$row_seller = $get_seller->fetch();

$seller_user_name = $row_seller->seller_user_name;

$seller_image = $row_seller->seller_image;

$seller_level = $row_seller->seller_level;

$seller_status = $row_seller->seller_status;

if(empty($seller_image)){

$seller_image = "empty-image.png";

}


// Select Proposal Seller Level

@$seller_level = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;

$proposal_reviews = array();

$select_buyer_reviews = $db->select("buyer_reviews",array("proposal_id" => $proposal_id));

$count_reviews = $select_buyer_reviews->rowCount();

while($row_buyer_reviews = $select_buyer_reviews->fetch()){
	
	$proposal_buyer_rating = $row_buyer_reviews->buyer_rating;
	
	array_push($proposal_reviews,$proposal_buyer_rating);
	
}

$total = array_sum($proposal_reviews);

@$average_rating = $total/count($proposal_reviews);


$count_favorites = $db->count("favorites",array("proposal_id"=>$proposal_id,"seller_id"=>$login_seller_id));

if($count_favorites == 0){

$show_favorite_class = "proposal-favorite dil1";

}else{

$show_favorite_class = "proposal-unfavorite dil";

}

?>

<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">

<?php require("includes/proposals.php"); ?>

</div>

<?php	
	
}
	
}

/// get_top_proposals Function Ends ///


/// get_top_pagination Function Starts ///

function get_random_pagination(){
	
global $db;

global $input;

global $lang;

global $s_currency;


$online_sellers = array();

$get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_status='active' order by rand()");

while($row_proposals = $get_proposals->fetch()){
	
	$proposal_seller_id = $row_proposals->proposal_seller_id;
	
	$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

	$seller_status = $select_seller->fetch()->seller_status;
	
	if($seller_status == "online"){
		
	array_push($online_sellers,$proposal_seller_id);
		
	}

}

$where_online = array();

$where_cat = array();

$where_delivery_times = array();

$where_level = array();

$where_language = array();

$values = array();

$where_path = "";

if(isset($_REQUEST['online_sellers'])){
	$i = 0;
	foreach($_REQUEST['online_sellers'] as $value){
		
		if($value != 0){
			
			foreach($online_sellers as $seller_id){
				$i++;
				$where_online[] = "proposal_seller_id=:proposal_seller_id_$i";

				$values["proposal_seller_id_$i"] = $seller_id;
				
			}
			
			$where_path .= "online_sellers[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['cat_id'])){
	$i = 0;
	foreach($_REQUEST['cat_id'] as $value){
		$i++;
		if($value != 0){
			
			$where_cat[] = "proposal_cat_id=:proposal_cat_id_$i";

			$values["proposal_cat_id_$i"] = $value;
			
			$where_path .= "cat_id[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['delivery_time'])){
	$i = 0;
	foreach($_REQUEST['delivery_time'] as $value){
		$i++;
		if($value != 0){
			
			$where_delivery_times[] = "delivery_id=:delivery_id_$i";

			$values["delivery_id_$i"] = $value;
			
			$where_path .= "delivery_time[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_level'])){
	$i = 0;
	foreach($_REQUEST['seller_level'] as $value){
		$i++;
		if($value != 0){
			
			$where_level[] = "level_id=:level_id_$i";

			$values["level_id_$i"] = $value;
			
			$where_path .= "seller_level[]=" . $value . "&";
			
		}
		
	}
	
}

if(isset($_REQUEST['seller_language'])){
	$i = 0;
	foreach($_REQUEST['seller_language'] as $value){
		$i++;
		if($value != 0){
			
			$where_language[] = "language_id=:language_id_$i";

			$values["language_id_$i"] = $value;
			
			$where_path .= "seller_language[]=" . $value . "&";
			
		}
		
	}
	
}

$query_where = "where proposal_status='active' ";

if(count($where_online)>0){

	$query_where .= " and (" . implode(" or ",$where_online) . ")";

}

if(count($where_cat)>0){

	$query_where .= " and (" . implode(" or ",$where_cat) . ")";

}

if(count($where_delivery_times)>0){

	$query_where .= " and (" . implode(" or ",$where_delivery_times) . ")";

}

if(count($where_level)>0){

	$query_where .= " and (" . implode(" or ",$where_level) . ")";

}

if(count($where_language)>0){

	$query_where .= " and (" . implode(" or ",$where_language) . ")";

}

$per_page = 12;

$get_proposals = $db->query("select * from proposals " . $query_where . "order by rand()",$values);

$count_proposals = $get_proposals->rowCount();

if($count_proposals > 0){
	
	$total_pages = ceil($count_proposals / $per_page);

	if(isset($_GET['page'])){ 

    $page = $input->get('page'); if($page == 0){ $page = 1; }
        
    }else{
        
    $page = 1;
        
    }

	echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='random_proposals?page=1&$where_path'>{$lang['pagination']['first_page']}</a>
	
	</li>";

    echo "<li class='page-item ".(1 == $page ? "active" : "")."'><a class='page-link' href='random_proposals?page=1&$where_path'>1</a></li>";
    
    $i = max(2, $page - 5);
    
    if ($i > 2)
    
        echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";
    
    for (; $i < min($page + 6, $total_pages); $i++) {
            	
    	echo "<li class='page-item"; if($i == $page){ echo " active "; } echo "'><a href='random_proposals?page=$i&$where_path' class='page-link'>".$i."</a></li>";

    }
    if ($i != $total_pages and $total_pages > 1){echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";}

    if($total_pages > 1){echo "<li class='page-item ".($total_pages == $page ? "active" : "")."'><a class='page-link' href='random_proposals?page=$total_pages&$where_path'>$total_pages</a></li>";}

	echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='random_proposals?page=$total_pages&$where_path'>{$lang['pagination']['last_page']}</a>
	
	</li>";
	
}
	
	
}

/// get_random_pagination Function Ends ///




	/// get_tag_proposals Function Starts ///

	function get_tag_proposals(){
		
	global $lang;

	global $input;

	global $siteLanguage;

	global $db;

	global $enable_referrals;

	global $dir;

	global $s_currency;

	global $login_seller_id;

	global $site_url;

	$online_sellers = array();

	if(isset($_SESSION['tag'])){
		
	$tag = $_SESSION['tag'];

	$get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_tags LIKE :tag AND proposal_status='active'",array("tag"=>"%$tag%"));

	}

	while($row_proposals = $get_proposals->fetch()){
		
		$proposal_seller_id = $row_proposals->proposal_seller_id;
		
		$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

		$seller_status = $select_seller->fetch()->seller_status;
		
		if($seller_status == "online"){
			
		array_push($online_sellers,$proposal_seller_id);
			
		}

	}


	$where_online = array();

	$where_cat = array();

	$where_delivery_times = array();

	$where_level = array();

	$where_language = array();

	$values = array();

	$where_path = "";

	if(isset($_REQUEST['online_sellers'])){
		$i = 0;
		foreach($_REQUEST['online_sellers'] as $value){
			
			if($value != 0){
				
				foreach($online_sellers as $seller_id){
					$i++;
					$where_online[] = "proposal_seller_id=:proposal_seller_id_$i";

					$values["proposal_seller_id_$i"] = $seller_id;
					
				}
				
				$where_path .= "online_sellers[]=" . $value . "&";
				
			}
			
		}
		
	}

	if(isset($_REQUEST['cat_id'])){
		$i = 0;
		foreach($_REQUEST['cat_id'] as $value){
			$i++;
			if($value != 0){
				
				$where_cat[] = "proposal_cat_id=:proposal_cat_id_$i";

				$values["proposal_cat_id_$i"] = $value;
				
				$where_path .= "cat_id[]=" . $value . "&";
				
			}
			
		}
		
	}

	if(isset($_REQUEST['delivery_time'])){
		$i = 0;
		foreach($_REQUEST['delivery_time'] as $value){
			$i++;
			if($value != 0){
				
				$where_delivery_times[] = "delivery_id=:delivery_id_$i";

				$values["delivery_id_$i"] = $value;
				
				$where_path .= "delivery_time[]=" . $value . "&";
				
			}
			
		}
		
	}

	if(isset($_REQUEST['seller_level'])){
		$i = 0;
		foreach($_REQUEST['seller_level'] as $value){
			$i++;
			if($value != 0){
				
				$where_level[] = "level_id=:level_id_$i";

				$values["level_id_$i"] = $value;
				
				$where_path .= "seller_level[]=" . $value . "&";
				
			}
			
		}
		
	}

	if(isset($_REQUEST['seller_language'])){
		$i = 0;
		foreach($_REQUEST['seller_language'] as $value){
			$i++;
			if($value != 0){
				
				$where_language[] = "language_id=:language_id_$i";

				$values["language_id_$i"] = $value;
				
				$where_path .= "seller_language[]=" . $value . "&";
				
			}
			
		}
		
	}


	$query_where = "where proposal_tags LIKE :tag AND proposal_status='active'";

	if(count($where_online)>0){
		
		$query_where .= " and (" . implode(" or ",$where_online) . ")";
		
	}

	if(count($where_cat)>0){
		
		$query_where .= " and (" . implode(" or ",$where_cat) . ")";
		
	}

	if(count($where_delivery_times)>0){
		
		$query_where .= " and (" . implode(" or ",$where_delivery_times) . ")";
		
	}

	if(count($where_level)>0){
		
		$query_where .= " and (" . implode(" or ",$where_level) . ")";
		
	}

	if(count($where_language)>0){
		
		$query_where .= " and (" . implode(" or ",$where_language) . ")";
		
	}

	$values['tag'] = "%$tag%";

	$per_page = 12;

	if(isset($_GET['page'])){
		
		$page = $_GET['page'];
		
	}else{
		
		$page = 1;
		
	}

	$start_from = ($page-1) * $per_page;

	$where_limit = " order by proposal_featured='yes' DESC LIMIT :limit OFFSET :offset";

	$get_proposals = $db->query("select * from proposals ".$query_where.$where_limit,$values,array("limit"=>$per_page,"offset"=>$start_from));

	$count_proposals = $get_proposals->rowCount();

	if($count_proposals == 0){
		
		if(isset($_SESSION['tag'])){
		
		echo "
		
		<div class='col-md-12'>
		
		<h1 class='text-center mt-4'><i class='fa fa-meh-o'></i> No Proposals to Show in this Tag Yet. </h1>
		
		</div>";
		
		}
		
	}

	while($row_proposals = $get_proposals->fetch()){	

	$proposal_id = $row_proposals->proposal_id;

	$proposal_title = $row_proposals->proposal_title;

	$proposal_price = $row_proposals->proposal_price;

	if($proposal_price == 0){

	$get_p_1 = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));

	$proposal_price = $get_p_1->fetch()->price;

	}

	$proposal_img1 = $row_proposals->proposal_img1;

	$proposal_video = $row_proposals->proposal_video;

	$proposal_seller_id = $row_proposals->proposal_seller_id;

	$proposal_rating = $row_proposals->proposal_rating;

	$proposal_url = $row_proposals->proposal_url;

	$proposal_featured = $row_proposals->proposal_featured;

	$proposal_enable_referrals = $row_proposals->proposal_enable_referrals;

	$proposal_referral_money = $row_proposals->proposal_referral_money;


	if(empty($proposal_video)){
		
		$video_class = "";
		
	}else{
		
		$video_class = "video-img";
		
	}

	$get_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

	$row_seller = $get_seller->fetch();

	$seller_user_name = $row_seller->seller_user_name;

	$seller_image = $row_seller->seller_image;

	$seller_level = $row_seller->seller_level;

	$seller_status = $row_seller->seller_status;

	if(empty($seller_image)){

	$seller_image = "empty-image.png";

	}

	// Select Proposal Seller Level

	@$seller_level = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;


	$proposal_reviews = array();

	$select_buyer_reviews = $db->select("buyer_reviews",array("proposal_id" => $proposal_id));

	$count_reviews = $select_buyer_reviews->rowCount();

	while($row_buyer_reviews = $select_buyer_reviews->fetch()){
		
		$proposal_buyer_rating = $row_buyer_reviews->buyer_rating;
		
		array_push($proposal_reviews,$proposal_buyer_rating);
		
	}

	$total = array_sum($proposal_reviews);

	@$average_rating = $total/count($proposal_reviews);



	$count_favorites = $db->count("favorites",array("proposal_id" => $proposal_id,"seller_id" => $login_seller_id));

	if($count_favorites == 0){

	$show_favorite_class = "proposal-favorite dil1";

	}else{

	$show_favorite_class = "proposal-unfavorite dil";

	}

	?>

	<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">

	<?php require("$dir/includes/proposals.php"); ?>

	</div>

	<?php	
		
	}
		
	}

	/// get_tag_proposals Function Ends ///


	/// get_tag_pagination Function Starts ///

	function get_tag_pagination(){
	
	global $db;

	global $input;

	global $lang;

	global $s_currency;


	$online_sellers = array();

	if(isset($_SESSION['tag'])){
		
	$tag = $_SESSION['tag'];

	$get_proposals = $db->query("select DISTINCT proposal_seller_id from proposals where proposal_tags LIKE :tag AND proposal_status='active'",array("tag"=>"%$tag%"));

	}

	while($row_proposals = $get_proposals->fetch()){
		
		$proposal_seller_id = $row_proposals->proposal_seller_id;

		
		$select_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));

		$seller_status = $select_seller->fetch()->seller_status;
		
		if($seller_status == "online"){
		
		array_push($online_sellers,$proposal_seller_id);
		
		}

	}


	$where_online = array();

	$where_cat = array();

	$where_delivery_times = array();

	$where_level = array();

	$where_language = array();

	$values = array();

	$where_path = "";

	if(isset($_REQUEST['online_sellers'])){
		$i = 0;
		foreach($_REQUEST['online_sellers'] as $value){
			
			if($value != 0){
				
				foreach($online_sellers as $seller_id){
					$i++;
					$where_online[] = "proposal_seller_id=:proposal_seller_id_$i";

					$values["proposal_seller_id_$i"] = $seller_id;
					
				}
				
				$where_path .= "online_sellers[]=" . $value . "&";
				
			}
			
		}
		
	}

	if(isset($_REQUEST['cat_id'])){
		$i = 0;
		foreach($_REQUEST['cat_id'] as $value){
			$i++;
			if($value != 0){
				
				$where_cat[] = "proposal_cat_id=:proposal_cat_id_$i";

				$values["proposal_cat_id_$i"] = $value;
				
				$where_path .= "cat_id[]=" . $value . "&";
				
			}
			
		}
		
	}

	if(isset($_REQUEST['delivery_time'])){
		$i = 0;
		foreach($_REQUEST['delivery_time'] as $value){
			$i++;
			if($value != 0){
				
				$where_delivery_times[] = "delivery_id=:delivery_id_$i";

				$values["delivery_id_$i"] = $value;
				
				$where_path .= "delivery_time[]=" . $value . "&";
				
			}
			
		}
		
	}

	if(isset($_REQUEST['seller_level'])){
		$i = 0;
		foreach($_REQUEST['seller_level'] as $value){
			$i++;
			if($value != 0){
				
				$where_level[] = "level_id=:level_id_$i";

				$values["level_id_$i"] = $value;
				
				$where_path .= "seller_level[]=" . $value . "&";
				
			}
			
		}
		
	}

	if(isset($_REQUEST['seller_language'])){
		$i = 0;
		foreach($_REQUEST['seller_language'] as $value){
			$i++;
			if($value != 0){
				
				$where_language[] = "language_id=:language_id_$i";

				$values["language_id_$i"] = $value;
				
				$where_path .= "seller_language[]=" . $value . "&";
				
			}
			
		}
		
	}


	$query_where = "where proposal_tags Like :tag AND proposal_status='active' ";

	if(count($where_online)>0){
		
		$query_where .= " and (" . implode(" or ",$where_online) . ")";
		
	}

	if(count($where_cat)>0){
		
		$query_where .= " and (" . implode(" or ",$where_cat) . ")";
		
	}

	if(count($where_delivery_times)>0){
		
		$query_where .= " and (" . implode(" or ",$where_delivery_times) . ")";
		
	}

	if(count($where_level)>0){
		
		$query_where .= " and (" . implode(" or ",$where_level) . ")";
		
	}

	if(count($where_language)>0){
		
		$query_where .= " and (" . implode(" or ",$where_language) . ")";
		
	}

	$values['tag'] = "%$tag%";

	$per_page = 12;

	$get_proposals = $db->query("select * from proposals " . $query_where,$values);

	$count_proposals = $get_proposals->rowCount();

	if($count_proposals > 0){
	
	$total_pages = ceil($count_proposals / $per_page);

	if(isset($_GET['page'])){ 
    $page = $input->get('page'); if($page == 0){ $page = 1; }
    }else{
    $page = 1;
    }

	echo "
	
	<li class='page-item'>
	
	<a class='page-link' href='?page=1&$where_path'>{$lang['pagination']['first_page']}</a>
	
	</li>";

    echo "<li class='page-item ".(1 == $page ? "active" : "")."'><a class='page-link' href='?page=1&$where_path'>1</a></li>";
    
    $i = max(2, $page - 5);
    
    if ($i > 2)
    
        echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";
    
    for (; $i < min($page + 6, $total_pages); $i++) {
            	
    	echo "<li class='page-item"; if($i == $page){ echo " active "; } echo "'><a href='?page=$i&$where_path' class='page-link'>".$i."</a></li>";

    }
    if ($i != $total_pages and $total_pages > 1){echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";}

    if($total_pages > 1){echo "<li class='page-item ".($total_pages == $page ? "active" : "")."'><a class='page-link' href='?page=$total_pages&$where_path'>$total_pages</a></li>";}

	echo "	
	<li class='page-item'>
	<a class='page-link' href='?page=$total_pages&$where_path'>{$lang['pagination']['last_page']}</a>
	</li>";

	}

	
	}

/// get_tag_pagination Function Ends ///

function addAnd($query){
	if(strlen($query) == 5){
		return "";
	}else{
		return " and";
	}
}

/// freelancers page Functions Starts ///
function get_freelancers(){
	global $db;
	global $input;
	global $lang;
	global $siteLanguage;
	global $s_currency;

	$online_sellers = array();
	$sellers = $db->query("select * from sellers where seller_status='online'");
	while($seller = $sellers->fetch()){
		array_push($online_sellers,$seller->seller_id);
	}

	$where_online = array();
	$where_country = array();
	$where_level = array();
	$where_language = array();
	$values = array();
	$where_path = "";

	if(isset($_REQUEST['online_sellers'])){
		$i = 0;
		foreach($_REQUEST['online_sellers'] as $value){
			if($value != 0){
				foreach($online_sellers as $seller_id){
					$i++;
					$where_online[] = "seller_id=:seller_id_$i";
					$values["seller_id_$i"] = $seller_id;
				}
				$where_path .= "online_sellers[]=" . $value . "&";
			}
		}
	}

	if(isset($_REQUEST['seller_country'])){
		$i = 0;
		foreach($_REQUEST['seller_country'] as $value){
			$i++;
			if($value != "undefined"){
				$where_country[] = "seller_country=:seller_country_$i";
				$values["seller_country_$i"] = $value;
				$where_path .= "seller_country[]=" . $value . "&";
			}
		}
	}

	if(isset($_REQUEST['seller_level'])){
		$i = 0;
		foreach($_REQUEST['seller_level'] as $value){
			$i++;
			if($value != 0){
				$where_level[] = "seller_level=:seller_level_$i";
				$values["seller_level_$i"] = $value;
				$where_path .= "seller_level[]=" . $value . "&";
			}
		}
	}

	if(isset($_REQUEST['seller_language'])){
		$i = 0;
		foreach($_REQUEST['seller_language'] as $value){
			$i++;
			if($value != 0){
				$where_language[] = "seller_language=:seller_language_$i";
				$values["seller_language_$i"] = $value;
				$where_path .= "seller_language[]=" . $value . "&";
			}
		}
	}

	$query_where = "where";
	if(count($where_online)>0){
		$query_where .= addAnd($query_where)." (" . implode(" or ",$where_online) . ")";
	}
	if(count($where_country)>0){
		$query_where .= addAnd($query_where)." (" . implode(" or ",$where_country) . ")";
	}
	if(count($where_level)>0){
		$query_where .= addAnd($query_where)." (" . implode(" or ",$where_level) . ")";
	}
	if(count($where_language)>0){
		$query_where .= addAnd($query_where)." (" . implode(" or ",$where_language) . ")";
	}

	$per_page = 12;

	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}else{
		$page = 1;
	}

	$start_from = ($page-1) * $per_page;
	$where_limit = " order by seller_level DESC LIMIT $per_page OFFSET $start_from";

	if(!empty($where_path)){
		$sellers = $db->query("select * from sellers $query_where$where_limit",$values);
	}else{
		$sellers = $db->query("select * from sellers $where_limit");
	}

	$sellersCount = 0;

	while($seller = $sellers->fetch()){
		$seller_id = $seller->seller_id;
		$seller_user_name = $seller->seller_user_name;
		$seller_name = $seller->seller_name;
		$seller_headline = $seller->seller_headline;
		$seller_about = $seller->seller_about;
		$seller_image = $seller->seller_image;
		$seller_email = $seller->seller_email;
		$seller_level = $seller->seller_level;
		$seller_register_date = $seller->seller_register_date;
		$seller_recent_delivery = $seller->seller_recent_delivery;
		$seller_country = $seller->seller_country;
		$seller_status = $seller->seller_status;
		$level_title = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;

		$select_buyer_reviews = $db->select("buyer_reviews",array("review_seller_id"=>$seller_id)); 
		$count_reviews = $select_buyer_reviews->rowCount();
		if(!$count_reviews == 0){
		  $rattings = array();
		  while($row_buyer_reviews = $select_buyer_reviews->fetch()){
		    $buyer_rating = $row_buyer_reviews->buyer_rating;
		    array_push($rattings,$buyer_rating);
		  }
		  $total = array_sum($rattings);
		  @$average = $total/count($rattings);
		  $average_rating = substr($average ,0,1);
		}else{
		 $average = "0";  
		 $average_rating = "0";
		}
		$count_active_proposals = $db->count("proposals",array("proposal_seller_id"=>$seller_id,"proposal_status"=>'active'));
		if($count_active_proposals > 0){
			$sellersCount++;
			require("includes/freelancer.php");
		}
	}
	if($sellersCount == 0){
	echo"
	<div class='col-md-12'>
	<h1 class='text-center mt-4'><i class='fa fa-meh-o'></i> We haven't found any freelancers matching that search </h1>
	</div>
	";
	}
}

function get_freelancer_pagination(){
	global $db;
	global $input;
	global $lang;
	global $s_currency;

	$online_sellers = array();
	$sellers = $db->query("select * from sellers where seller_status='online'");
	while($seller = $sellers->fetch()){
		array_push($online_sellers,$seller->seller_id);
	}

	$where_online = array();
	$where_country = array();
	$where_level = array();
	$where_language = array();
	$values = array();
	$where_path = "";

	if(isset($_REQUEST['online_sellers'])){
		$i = 0;
		foreach($_REQUEST['online_sellers'] as $value){
			if($value != 0){
				foreach($online_sellers as $seller_id){
					$i++;
					$where_online[] = "seller_id=:seller_id_$i";
					$values["seller_id_$i"] = $seller_id;
				}
				$where_path .= "online_sellers[]=" . $value . "&";
			}
		}
	}

	if(isset($_REQUEST['seller_country'])){
		$i = 0;
		foreach($_REQUEST['seller_country'] as $value){
			$i++;
			if($value != "undefined"){
				$where_country[] = "seller_country=:seller_country_$i";
				$values["seller_country_$i"] = $value;
				$where_path .= "seller_country[]=" . $value . "&";
			}
		}
	}

	if(isset($_REQUEST['seller_level'])){
		$i = 0;
		foreach($_REQUEST['seller_level'] as $value){
			$i++;
			if($value != 0){
				$where_level[] = "seller_level=:seller_level_$i";
				$values["seller_level_$i"] = $value;
				$where_path .= "seller_level[]=" . $value . "&";
			}
		}
	}

	if(isset($_REQUEST['seller_language'])){
		$i = 0;
		foreach($_REQUEST['seller_language'] as $value){
			$i++;
			if($value != 0){
				$where_language[] = "seller_language=:seller_language_$i";
				$values["seller_language_$i"] = $value;
				$where_path .= "seller_language[]=" . $value . "&";
			}
		}
	}

	$query_where = "where";
	if(count($where_online)>0){
		$query_where .= addAnd($query_where)." (" . implode(" or ",$where_online) . ")";
	}
	if(count($where_country)>0){
		$query_where .= addAnd($query_where)." (" . implode(" or ",$where_country) . ")";
	}
	if(count($where_level)>0){
		$query_where .= addAnd($query_where)." (" . implode(" or ",$where_level) . ")";
	}
	if(count($where_language)>0){
		$query_where .= addAnd($query_where)." (" . implode(" or ",$where_language) . ")";
	}

	$per_page = 10;

	if(!empty($where_path)) {
		$sellers = $db->query("select * from sellers " . $query_where,$values);
	}else{
		$sellers = $db->query("select * from sellers");
	}

	$sellersCount = 0;
	while($seller = $sellers->fetch()){
		$count_active_proposals = $db->count("proposals",array("proposal_seller_id"=>$seller->seller_id,"proposal_status"=>'active'));
		if($count_active_proposals > 0){
			$sellersCount++;
		}
	}

	if($sellersCount > 0){
	
		$total_pages = ceil($sellersCount / $per_page);
		if(isset($_GET['page'])){ 
	  	$page = $input->get('page'); if($page == 0){ $page = 1; }
	  }else{
	  	$page = 1;
	  }

		echo "
		<li class='page-item'>
		<a class='page-link' href='?page=1&$where_path'>{$lang['pagination']['first_page']}</a>
		</li>";

	  echo "<li class='page-item ".(1 == $page ? "active" : "")."'><a class='page-link' href='?page=1&$where_path'>1</a></li>";
	  
	  $i = max(2, $page - 5);
	  
	  if ($i > 2){
	    echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";
	  }
	  
	  for (; $i < min($page + 6, $total_pages); $i++) {
	  	echo "<li class='page-item"; if($i == $page){ echo " active "; } echo "'><a href='?page=$i&$where_path' class='page-link'>".$i."</a></li>";
	  }

	  if ($i != $total_pages and $total_pages > 1){
	  	echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";
	  }

	  if($total_pages > 1){echo "<li class='page-item ".(
	  	$total_pages == $page ? "active" : "")."'><a class='page-link' href='?page=$total_pages&$where_path'>$total_pages</a></li>";
		}

		echo "	
		<li class='page-item'>
		<a class='page-link' href='?page=$total_pages&$where_path'>{$lang['pagination']['last_page']}</a>
		</li>";

	}
}
/// freelancers page Functions Ends ///



?>