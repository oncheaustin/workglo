<?php

include("../includes/db.php");

$line = $input->post('value');

// $words = "payoneer|pay|mobile|contact|email|skype|number|.com|direct";
// perform a case-Insensitive search for the word "Vi"

$get_words = $db->select("spam_words");
while($row_words = $get_words->fetch()){
	$name = $row_words->word;
	if(preg_match("/\b($name)\b/i", $line)){ 
		echo "match";
		break;
	}
}