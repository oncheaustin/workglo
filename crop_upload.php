<?php

if(isset($_POST["image"])){
	
	$data = $_POST["image"];

	$name = $_POST["name"];

	$image_array_1 = explode(";", $data);
	
	$image_array_2 = explode(",", $image_array_1[1]);

	$data = base64_decode($image_array_2[1]);

	$imageName = pathinfo($name, PATHINFO_FILENAME) . "_" . time() . '.png';

	$allowed = array('jpeg','jpg','gif','tiff','png','webp');
		
	$file_extension = pathinfo($name, PATHINFO_EXTENSION);

	if(!in_array($file_extension,$allowed)){

	echo "";
		
	}else{

	file_put_contents("user_images/" . $imageName, $data);
    
    echo $imageName;

	}

}

?>