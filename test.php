<?php

$update_seller = $db->query("update sellers set seller_offers=seller_offers-1 where seller_id='$login_seller_id'");


?>