<?php
if (file_exists("../configuration.php")) {
require_once("../configuration.php");
} else require_once("configuration.php");

mysql_connect($host,$user,$password) or die(mysql_error);
mysql_select_db($db) or die(mysql_error);
?>