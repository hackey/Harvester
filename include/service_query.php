<?php
if ($_GET['service_do']==1){
	if ($_GET['ip']<>"") {
		if($_GET['service']<>"") {
			if (!preg_match ("/^[0-9]*[.][0-9]*[.][0-9]*[.][0-9]*$/",$_GET['ip'])) {
				echo "Неправильный формат IP";
				exit; 
			}
			if (!fsockopen($_GET["ip"],135, $errno, $errstr,2)) {
				exit;
			}
			foreach($_GET as $key => $value) {
			$_GET[$key] = iconv('UTF-8', 'windows-1251', $value);
			}			
			$obj = new COM('winmgmts:{impersonationLevel=impersonate,(Shutdown)}//'. $_GET["ip"] .'/root/cimv2');
			$process = $obj->execquery("SELECT * FROM Win32_Service Where Name='". $_GET["service"] ."' ");
			if ( $process->count > 0 ) {
				if ($_GET['service_start']==1) {
					foreach ($process AS $row) {
					$row->StartService();
					echo "Служба стартовала!";
					}
				}
				if ($_GET['service_stop']==1) {
					foreach ($process AS $row) {
					$row->StopService ();
					echo"Служба остановлена!";
					}
				}
			} else {echo htmlspecialchars($_GET["service"])."- такой службы не обнаружено";}
		}
		else {echo "Имя службы не указано";exit;}
	}
	else {echo "IP не указан";exit;}
}
?>