<?php

$cookie_name = "close_cookie";

$cookie_value = "Cookie Bar";

setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

?>