<?php
session_start();
if($_SESSION["user"]<>"asu5") {
	echo "Доступ ограничен";
	exit;
}
$asd=exec ('..\1.BAT');
echo $asd;
?>