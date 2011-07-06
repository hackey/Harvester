<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
?>
<?php
if ($_POST["name_comp"]<>"") {
fsockopen($_POST['name_comp'], 135, $errno, $errstr, 2);
echo "Connect";
unset($_POST["name_comp"]);
exit;
}
?>