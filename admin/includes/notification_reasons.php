<?php

if($reason == "message_spam"){

  $message = "has used some <span class='text-danger'>spam words</span> in conversation.";

  $url = "index.php?single_inbox_message=$content_id";

}elseif($reason == "order_spam"){
	
  $message = "has used some <span class='text-danger'>spam words</span> in order conversation.";
	
  $url = "index.php?single_order=$content_id";

}