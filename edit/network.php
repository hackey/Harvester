<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "������ ���������";
	exit;
}
?>
<?php
$table_global="network_adapters";
$mas1["���"]=array("name"=>"������������ ��������:","field"=>"adapter_name");
$mas1["������"]=array("name"=>"MAC �����:","field"=>"MACAddress_adapters");
$mas1["��� ��������"]=array("name"=>"��� ��������:","field"=>"AdapterType");


if ($_GET["wmi"]) { 
	$wmi_k=0;
	foreach ($obj->instancesof ( 'Win32_NetworkAdapter' ) as $mp ) {
		if ($mp->NetConnectionStatus<>"") {
		$mas_wmi[]=$mp->Description;
		$mas_wmi[]=$mp->MACAddress;
		$mas_wmi[]=$mp->AdapterType;
		$wmi_k++;
		}
	}
}

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("������� ��������",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);
?>
