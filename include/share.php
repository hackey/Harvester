<?php 
if ($_GET["share_view"]==1) {
	if (!preg_match ("/^[0-9]*[.][0-9]*[.][0-9]*[.][0-9]*$/",$_GET['ip'])) {
		echo "Неправильный формат IP";
		exit;
	}
	if (!fsockopen($_GET["ip"],135, $errno, $errstr,2)) {
			exit;
	}
	if ($_GET["disable"]==1) {
		if ($_GET["share_name"]<>"") {
			define ( 'IP_COMP', $_GET["ip"]);
			$obj = new COM('winmgmts:{impersonationLevel=impersonate}//'. IP_COMP .'/root/cimv2');
			$share = $obj->execquery("SELECT * FROM Win32_Share WHERE Name='".$_GET["share_name"]. "' ");
			foreach ($share AS $row) {
				$row->Delete();
			}
			echo "Общий доступ к ".htmlspecialchars($_GET["name"])." закрыт";
			exit;
		}
		echo "Путь не указан";
		exit;
	} 
	
	define ( 'IP_COMP', $_GET["ip"]);
	$obj = new COM('winmgmts:{impersonationLevel=impersonate}//'. IP_COMP .'/root/cimv2');
	$process = $obj->execquery("SELECT * FROM Win32_Share");
	foreach ($process AS $row){
	echo "<div class=\"inputSubmit share_do\" onclick=\"share_do_button('". $row->Name. "','". $_GET["ip"] . "' )\">X</div>
	<a title=\"".$_GET['ip'].">>>>>".$row->Path." \" href=\"file://".$_GET['ip']."/". $row->Name."\" >". $row->Name."</a><br/>";		
	}	
}
?>
