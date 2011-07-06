<?php
session_start();
if ($_POST['exit']){
	session_destroy();
	header("Location: http://".$_POST['URL']); 
	exit;
}
 
if ($_POST['login_form'] && $_POST['user'] && $_POST['userpassword']) {
	if(!preg_match("/^[-a-zA-Z0-9_]*$/",$_POST["user"])) {
	$_SESSION["message"]="Имя пользователя задано в неправильном формате";
	$_SESSION["error"]="on";
	header("Location: http://".$_POST['URL']);
	exit;
	}	
	require_once("connect.php");
	$check_password = mysql_query("SELECT * FROM users_vts_admin WHERE (name_admin='".$_POST['user']."') LIMIT 1");
	$row_check_password = mysql_num_rows($check_password);
	if ($row_check_password<>1) {
			$_SESSION["message"] = "Такого пользователя не существует";
			$_SESSION["error"]="on";
			header("Location: http://".$_POST['URL']); 
			exit;
	}
	$row_check_password = mysql_fetch_assoc($check_password);  
    $table['id'] = $row_check_password['id'];      
    $table['login'] = $row_check_password['name_admin'];    
	$table['password'] = $row_check_password['_password_admin'];  
	$table['group'] = $row_check_password['group'];  
	$md5_password = md5($_POST['userpassword']);
	if ($md5_password == $table['password'] && $_POST['user'] == $table['login']){ 
			$_SESSION["user"] = $_POST["user"];			
			$_SESSION["group"] = $table["group"];
			$_SESSION["message"] = "Вход успешно осуществлён.";
			$_SESSION["error"]="off";
			$max_id=mysql_query("SELECT MAX(`id`) FROM `Spy`");
			$max_id=mysql_fetch_array($max_id,MYSQL_NUM);
			$max_id[0]++;			
			$query=mysql_query("INSERT INTO `Spy` SET `id`='".$max_id[0]."', `Name_User`='".mysql_real_escape_string($_POST["user"])."', `Date`='".date('Y-m-d [H:i:s]')."', `User_comp`='".$_SERVER["REMOTE_ADDR"]."' ");
			mysql_query($query); 
			header("Location: http://".$_POST['URL']); 
			exit;
	} else {
	$_SESSION["message"] = "Пароль не верный";
	$_SESSION["error"]="on";
	header("Location: http://".$_POST['URL']); 
	exit;
	}
	
	
} elseif ($_POST['login_form']) {
	$_SESSION["message"] = "Вход не осуществлён. Заполните все поля.";
	$_SESSION["error"]="on";
	header("Location: http://".$_POST['URL']); 
	exit;
}
?>