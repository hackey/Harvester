<?php 
if ((($_GET['Reboot']==1) OR ($_GET['Shutdown']==1))  && $_GET['ip']<>"") {
	if (!preg_match ("/^[0-9]*[.][0-9]*[.][0-9]*[.][0-9]*$/",$_GET['ip'])) {
		echo "�� ���������� ������ ip ������.";
		exit; 
	}	
	if (!fsockopen($_GET["ip"],135, $errno, $errstr,2)) {exit;}
	define ( 'IP_COMP', $_GET["ip"]);
	$obj = new COM('winmgmts:{impersonationLevel=impersonate,(Shutdown)}//'. IP_COMP .'/root/cimv2'); 
		foreach($obj->instancesof('Win32_OperatingSystem') as $mp)  {
		if ($_GET['Reboot']==1) {
			$ctemp=($mp->Reboot);
			echo "������������ ���������� ����������� �������.";
			exit; 		
		}
		
		if ($_GET['Shutdown']==1) {
			$ctemp=($mp->Shutdown);
			echo "���������� ���������� ����������� �������.";
			exit; 					
		}
	}	
}
elseif (($_GET['Reboot']==1) OR ($_GET['Shutdown']==1)) {echo "IP ����� �� ������";}
?>