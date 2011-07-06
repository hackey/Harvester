<?php 
if ((($_GET['Reboot']==1) OR ($_GET['Shutdown']==1))  && $_GET['ip']<>"") {
	if (!preg_match ("/^[0-9]*[.][0-9]*[.][0-9]*[.][0-9]*$/",$_GET['ip'])) {
		echo "Не правильный формат ip адреса.";
		exit; 
	}	
	if (!fsockopen($_GET["ip"],135, $errno, $errstr,2)) {exit;}
	define ( 'IP_COMP', $_GET["ip"]);
	$obj = new COM('winmgmts:{impersonationLevel=impersonate,(Shutdown)}//'. IP_COMP .'/root/cimv2'); 
		foreach($obj->instancesof('Win32_OperatingSystem') as $mp)  {
		if ($_GET['Reboot']==1) {
			$ctemp=($mp->Reboot);
			echo "Перезагрузка компьютера произведена успешно.";
			exit; 		
		}
		
		if ($_GET['Shutdown']==1) {
			$ctemp=($mp->Shutdown);
			echo "Выключение компьютера произведено успешно.";
			exit; 					
		}
	}	
}
elseif (($_GET['Reboot']==1) OR ($_GET['Shutdown']==1)) {echo "IP Адрес не указан";}
?>