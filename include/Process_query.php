<?php 
if ($_GET['process_do']==1){
	if ($_GET['ip']<>"") {
		if (!preg_match ("/^[0-9]*[.][0-9]*[.][0-9]*[.][0-9]*$/",$_GET['ip'])) {
			echo "������������ ������ IP";
			exit; 
		}
		if (!fsockopen($_GET["ip"],135, $errno, $errstr,2)) {
			exit;
		}
		if($_GET['name_process']<>"") {
			foreach($_GET as $key => $value) {
				$_GET[$key] = iconv('UTF-8', 'windows-1251', $value);
			}			
			if ($_GET['process_start']==1) {
				$obj_win32_process=new COM('winmgmts:{impersonationLevel=impersonate}//'.$_GET["ip"].'/root/cimv2:Win32_Process');
				$obj_win32_process->Create($_GET['name_process'],Null,Null,lngProcessID2);
				echo "������� �������, ���� �� �������������� ��������� �������!";
				exit;
			}				
		}
		if ($_GET['process_stop']==1) {
			$obj = new COM('winmgmts:{impersonationLevel=impersonate}//'. $_GET["ip"] .'/root/cimv2');
			$process = $obj->execquery("SELECT * FROM Win32_Process Where Handle='". $_GET["process_processid"] ."' ");
			foreach ($process AS $row){
				$row->Terminate();
				echo "������� ��������!";
				exit;
			}
		}		
		else {echo "��� �������� �� �������";exit;}
	}
	else {echo "IP �� ������";exit;}
}
?>