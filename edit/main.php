<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
?>
<?php
$table_global="computers";
$mas1["Имя"]=array("name"=>"Имя компьютера:","field"=>"computer_name");
$mas1["Отдел"]=array("name"=>"Отдел:","field"=>"otdel");
$mas1["ФИО"]=array("name"=>"ФИО пользователя:","field"=>"fio_current_user");
$mas1["Мышь"]=array("name"=>"Мышь:","field"=>"mouse");
$mas1["Клавиатура"]=array("name"=>"Клавиатура:","field"=>"keyboard");

if ($_GET["wmi"]) { 
	$wmi_k=0;
	foreach ($obj->instancesof ( 'Win32_ComputerSystem' ) as $mp ) {
		$mas_wmi[]=$mp->Name;
		$_GET["list_comp"]=$mp->Name;
		$wmi_k++;
		break;
	}
	foreach ($obj->instancesof ( 'Win32_PointingDevice' ) as $mp ) {
		$mas_wmi[3]=$mp->Name;	
		break;
	}
	foreach ($obj->instancesof ( 'Win32_Keyboard' ) as $mp ) {
		$mas_wmi[4]=$mp->Name;	
		break;
	}
	
}

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Информация о компьютере",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);

$table_global="ip_addresses";
$mas1["ip"]=array("name"=>"IP адрес:","field"=>"ip_address");
$mas1["домен"]=array("name"=>"Рабочая группа / домен:","field"=>"Domen");

if ($_GET["wmi"]) { 
	$wmi_k=0;
	foreach ($obj->instancesof ( 'Win32_NetworkAdapterConfiguration' ) as $mp ) {
		if ($mp->IPEnabled) {			
				// $mas_wmi[]=implode(",", $mp->IPEnabled);
				$mas_wmi[]=$mp->IPAddress[0]; 		
				$mas_wmi[]=$mp->DNSDomain; 		
				$wmi_k++;				
		}	
		
	}	
	if ($wmi_k==0) {$wmi_k=1;}
}
save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Информация о сети",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);

$table_global="os";
$mas1["os_name"]=array("name"=>"Операционная система:","field"=>"os_name");
$mas1["Серийный"]=array("name"=>"Серийный номер:","field"=>"os_product_key");
$mas1["Дата установки"]=array("name"=>"Дата установки:","field"=>"date_install");
$mas1["Путь установки"]=array("name"=>"Путь установки:","field"=>"Path");

if ($_GET["wmi"]) { 
	$wmi_k=0;
	foreach ($obj->instancesof ( 'Win32_OperatingSystem' ) as $mp ) {
		$mas_wmi[]=$mp->Caption ;
		$mas_wmi[]=$mp->SerialNumber ;
		$mas_wmi[]=$mp->InstallDate ;
		$mas_wmi[]=$mp->WindowsDirectory ;
		$wmi_k++;		
	}
}
save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Операционная система",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);

if($_SESSION["group"]=="Администратор") {
$table_global="local_users";
$mas1["Имя пользователя"]=array("name"=>"Имя пользователя:","field"=>"user_name");
$mas1["Пароль пользователя"]=array("name"=>"Пароль:","field"=>"user_pass");
$mas1["Имя пользователя2"]=array("name"=>"Имя пользователя:","field"=>"user_name2");
$mas1["Пароль пользователя2"]=array("name"=>"Пароль:","field"=>"user_pass2");

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Информация о пользователях",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);
}
?>
