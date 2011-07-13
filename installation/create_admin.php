<?php
if ($_POST["create_admin"]==1) {
	if (!preg_match("/^[-a-zA-Z0-9_]*$/",$_POST['name_admin'])) {
				echo "Не допустимый формат имени.";
				exit; 
			}
	if ($_POST['password1_admin']<>$_POST['password2_admin']) {
			echo "Пароли не совпадают";
			exit; 
	}
	if (!preg_match("/^[-a-zA-Z0-9_]*$/",$_POST['password1_admin'])) {
				echo "Не допустимый формат пароля.";
				exit; 
			}
	require_once("../configuration.php");		
	require_once("../include/connect.php");
	mysql_query("INSERT INTO users_vts_admin (`id`,`name_admin`,`_password_admin`, `ip`, `secret_key`, `group`) VALUES ('1', '".mysql_real_escape_string($_POST["name_admin"])."', '".md5(mysql_real_escape_string($_POST["password1_admin"]))."', '".$_SERVER["REMOTE_ADDR"]."', '".md5($_SERVER["REMOTE_ADDR"])."', 'Администратор')") or die(mysql_error());
	echo "OK";
}
?>