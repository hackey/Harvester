<?php
header('Content-type: text/html; charset="windows-1251"',true);
setlocale(LC_ALL, 'ru_RU');
session_start();
require_once("connect.php"); 
$tables=array(
	 "antivirus_software",
	 "cd_drives",
	 "computers",
	 "ip_addresses",
	 "local_users",
	 "Memory",
	 "monitors",
	 "motherboards",
	 "network_adapters",
	 "os",
	 "physical_drives",
	 "printers",
	 "processors",
	 "software",
	 "SoundDevice",
	 "videoadapters");

if ($_POST['Create']) {	 
	if (($_POST['comp_name']<>"")) {
		if ($_POST['ip_adr']) {
			if (!preg_match ("/^[0-9]*[.][0-9]*[.][0-9]*[.][0-9]*$/",$_POST['ip_adr'])) {
				echo "Не правильный формат ip адреса.";
				exit; 
			}
		}
		if (!preg_match("/^[-a-zA-Z0-9_]*$/",$_POST['comp_name'])) {
			echo "Не правильный формат имени.";
			exit; 
		}
		if ($_POST['otdel']) {
			if (preg_match("/^[\>\<\+\"\']*$/",$_POST['otdel'])) {
				echo "Не допустимый формат поля отдел.";
				exit; 
			}
		}
		$chk_ip=mysql_query("SELECT `ip_address`, `computer_name` FROM `ip_addresses`");
		while ($row=mysql_fetch_array($chk_ip)) {
			if ($row["ip_address"]==$_POST['ip_adr']) {
				echo "Комьютер $row[computer_name]  с таким IP уже присутствует в базе данных .";
				exit; 
			}
		}
		foreach($_POST as $key => $value) {
			$_POST[$key] = iconv('UTF-8', 'windows-1251', $value);
		}		
		$id_count=mysql_query("SELECT MAX(id) FROM computers");
		$max_id=mysql_fetch_array($id_count,MYSQL_NUM);
		++$max_id[0];
		foreach ($tables as $val) {
		if ($val=="computers") {
			if ($_POST["otdel"]=="") {
				$_POST["otdel"]="Не определён";
			} 
			$query = "INSERT INTO $val SET id=$max_id[0], computer_name='".mysql_real_escape_string($_POST["comp_name"])."', otdel='".mysql_real_escape_string($_POST["otdel"])."'";
		} 	elseif ($val=="ip_addresses") {
				$id_count=mysql_query("SELECT MAX(id) FROM ip_addresses");
				$max_id=mysql_fetch_array($id_count,MYSQL_NUM);
				++$max_id[0];
				$query = "INSERT INTO $val SET  id=$max_id[0], computer_name='".mysql_real_escape_string($_POST["comp_name"])."', ip_address='".mysql_real_escape_string($_POST["ip_adr"])."'";
			} 	else {
							$query = mysql_query("SELECT MAX(id) FROM $val");
							$max_id=mysql_fetch_array($query,MYSQL_NUM);
							$max_id[0]++;
							$query = "INSERT INTO $val SET computer_name='".mysql_real_escape_string($_POST["comp_name"])."', id=$max_id[0] ";								
						}						
		mysql_query($query) or die(mysql_error());
		}
		echo "Учётная запись создана.";
		exit; 
	}
	else {
		?><script type="text/javascript">
		i=2;
		</script><?php
		echo "Не все поля заполнены.";		
		exit;
	}
}

if ($_GET["Refresh"]==1) {
	$result =  mysql_query("SELECT DISTINCT otdel From computers;");
	while ($row = mysql_fetch_array($result)) {
	$arr[]=$row["otdel"];
	}
	foreach($arr as $key => $value) {
			$arr[$key] = iconv('windows-1251','UTF-8',  $value);
		}		
	echo json_encode($arr);	
	exit;
}

if ($_GET["Refresh"]==2) {
	$result =  mysql_query("SELECT `computer_name` From `computers` WHERE `otdel`='".mysql_real_escape_string($_GET["otdel"])."' ");
	while ($row = mysql_fetch_array($result)) {
	$arr[]=$row["computer_name"];
	}
	foreach($arr as $key => $value) {
			$arr[$key] = iconv('windows-1251','UTF-8',  $value);
		}		
	echo json_encode($arr);	
	exit;
}

if ($_GET["Delete"]==1) {
	$result =  mysql_query("SELECT `computer_name` From `computers` WHERE `computer_name`='".mysql_real_escape_string($_GET["list_comp"])."' LIMIT 1");
	$num=mysql_num_rows($result);
	if ($num<>1) {
	echo "Учётная запись не удалена. Такого компьютера не существует";
	exit;
	}
	foreach ($tables as $val) {
	$query = "delete from $val where (computer_name='".mysql_real_escape_string($_GET[list_comp])."')";
	mysql_query($query) or die(mysql_error());
	}
	echo "Учётная запись удалена";
	exit;
}

if(preg_match("/^[a-zA-Z0-9_-]*$/",$_POST["invait"]) && $_POST["create_key"]) {
	$invait_key=md5($_POST["invait"]);
	$query = "INSERT INTO key_user_register(key_invait) VALUES ('".$invait_key."')";
	mysql_query($query) or die(mysql_error());
	$_SESSION["message"]="Ключ доступа успешно создан";
	$_SESSION["error"]="off";
	header("Location: http://".$_POST['URL']);
	exit;
} elseif ($_POST["create_key"]) {
	$_SESSION["message"]="Ключ доступа не создан. Не верный формат поля!";
	$_SESSION["error"]="on";
	header("Location: http://".$_POST['URL']);
	exit;
	}

if($_POST["create_user"]) {
	if(!preg_match("/^[-a-zA-Z0-9_]*$/",$_POST["user"])) {
	$_SESSION["message"]="Не правильный формат имени";
	$_SESSION["error"]="on";
	$_SESSION['user_reg']=htmlspecialchars($_POST["user"]);
	header("Location: http://".$_POST['URL']);
	exit;
	}
	if(!preg_match("/^[-a-zA-Z0-9_]*$/",$_POST["key_invait"])) {
	$_SESSION["message"]="Не правильный формат ключа доступа";
	$_SESSION["error"]="on";
	$_SESSION['user_reg']=htmlspecialchars($_POST["user"]);
	header("Location: http://".$_POST['URL']);
	exit;
	}
	if(!preg_match("/^[-a-zA-Z0-9_]*$/",$_POST["pass1"])) {
	$_SESSION["message"]="Не правильный формат пароля";
	$_SESSION["error"]="on";
	$_SESSION['user_reg']=htmlspecialchars($_POST["user"]);
	header("Location: http://".$_POST['URL']);
	exit;
	}
	if ($_POST["key_invait"]<>"" && $_POST["user"]<>"" && $_POST["pass1"]<>"" && $_POST["pass2"]<>"") {
		$result= mysql_query("SELECT `key_invait` FROM `key_user_register` WHERE `key_invait`='".md5($_POST["key_invait"])."' LIMIT 1");
		$row_result = mysql_num_rows($result);
		if ($row_result<>1) {
			$_SESSION["message"]="Код доступа не верный";
			$_SESSION['user_reg']=htmlspecialchars($_POST["user"]);
			$_SESSION["error"]="on";
			} elseif (!preg_match("/^[a-zA-Z0-9_]*$/",$_POST["user"]) OR !preg_match("/^[a-zA-Z0-9_]*$/",$_POST["pass2"]) OR !preg_match("/^[a-zA-Z0-9_]*$/",$_POST["pass1"])) {
				$_SESSION['user_reg']=htmlspecialchars($_POST["user"]);
				$_SESSION["message"]="Неправильный формат полей";
				$_SESSION["error"]="on";
				}
				elseif ($_POST["pass1"]<>$_POST["pass2"]) {
					$_SESSION['user_reg']=htmlspecialchars($_POST["user"]);
					$_SESSION["message"]="Пароли не совподают";
					$_SESSION["error"]="on";
				} 	else {
					$user_chk = mysql_query("SELECT name_admin FROM users_vts_admin");
					while ($i=mysql_fetch_array($user_chk)) {
						if ($i["name_admin"]==$_POST["user"]) {
						$_SESSION["message"]="Такой пользователь уже существует";
						$_SESSION["error"]="on";
						header("Location: http://".$_POST['URL']);
						exit;
						}
					}
					$id = mysql_query("SELECT id FROM users_vts_admin");
					$id = mysql_num_rows($id);
					++$id;
					mysql_query("INSERT INTO users_vts_admin (`id`,`name_admin`,`_password_admin`, `ip`, `secret_key`) VALUES ('".$id."', '".$_POST["user"]."', '".md5($_POST["pass1"])."', '".$_SERVER["REMOTE_ADDR"]."', '".md5($_POST["key_invait"]+$_SERVER["REMOTE_ADDR"])."')") or die(mysql_error());
					mysql_query("DELETE FROM key_user_register WHERE key_invait='".md5($_POST["key_invait"])."' ");
					$_SESSION["message"]="Регистрация прошла успешно";
					$_SESSION["error"]="off";
					
				}			
		} 	else {
		$_SESSION['user_reg']=htmlspecialchars($_POST["user"]);
		$_SESSION["message"]="Не все поля заполнены";
		$_SESSION["error"]="on";
		} 		
	header("Location: http://".$_POST['URL']);
	exit;
}

if($_POST["change_pass"]) {
	if ($_POST["pass_old"]<>"" && $_POST["pass_new1"]<>"" && $_POST["pass_new2"]<>"") {
		$result= mysql_query("SELECT * FROM users_vts_admin WHERE name_admin='".$_SESSION["user"]."' ");
		$row_result = mysql_num_rows($result);
		if ($row_result<>1) {
			$id_result = mysql_fetch_array($result);
			if ($_POST["pass_new1"]<>$_POST["pass_new2"]) {
						$_SESSION["message"]="Поля с новым паролем не одинаковы.";
						$_SESSION["error"]="on";				
			} elseif ($id_result['_password_admin']<>md5($_POST["pass_old"])){
							$_SESSION["message"]="Старый пароль указан не верно.";
							$_SESSION["error"]="on";
				}elseif (preg_match("/^[a-zA-Z0-9_]*$/",$_POST["pass_new1"])){
						$_SESSION["message"]="Неверный формат пароля.";
						$_SESSION["error"]="on";		
						} else {
						while ($id_result = mysql_fetch_array($result)) {
							if ($id_result['_password_admin']=md5($_POST["pass_old"])) {
								mysql_query("UPDATE users_vts_admin SET _password_admin= '".$_POST["pass_new1"]."' ");
								$_SESSION["message"]="Пароль изменён.";
								$_SESSION["error"]="off";						
							}
						}
					}	
		} else {
					$id_result = mysql_fetch_array($result);
					if ($_POST["pass_new1"]<>$_POST["pass_new2"]) {
						$_SESSION["message"]="Поля с новым паролем не одинаковы.";
						$_SESSION["error"]="on";				
					} elseif ($id_result['_password_admin']<>md5($_POST["pass_old"])){
							$_SESSION["message"]="Старый пароль указан не верно.";
							$_SESSION["error"]="on";
							}elseif (!preg_match("/^[a-zA-Z0-9_]*$/",$_POST["pass_new1"])){
								$_SESSION["message"]="Неверный формат пароля.";
								$_SESSION["error"]="on";		
								} else {
									mysql_query("UPDATE users_vts_admin SET _password_admin= '". md5($_POST["pass_new1"])."' WHERE name_admin='".$_SESSION["user"]."'  ");
									$_SESSION["message"]="Пароль изменён.";
									$_SESSION["error"]="off";
									}					
				}
	} else {
					$_SESSION["message"]="Не все поля заполнены.";
					$_SESSION["error"]="on";
	}	
	header("Location: http://".$_POST['URL']);
	exit;
}
?>
