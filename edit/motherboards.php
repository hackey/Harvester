<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "������ ���������";
	exit;
}
?>
<?php
$table_global="motherboards";
$wmi_k=1;
$mas1["��� ��������"]=array("name"=>"������:","field"=>"board_name");
$mas1["�������������"]=array("name"=>"�������������:","field"=>"Manufacturer_motherboards");
$mas1["�������� �����"]=array("name"=>"�������� �����:","field"=>"SerialNumber_motherboards");
$mas1["������"]=array("name"=>"������:","field"=>"Version_motherboards");

if ($_GET["wmi"]) { 
	foreach ($obj->instancesof ( 'Win32_BaseBoard' ) as $mp ) {
		$mas_wmi[]=$mp->Product;
		$mas_wmi[]=$mp->Manufacturer;
		$mas_wmi[]=$mp->SerialNumber;
		$mas_wmi[]=$mp->Version;
		break;			
	}
}

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("���������� �����",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);

if ($_GET["wmi"]) { 
	foreach ($obj->instancesof ( 'Win32_ComputerSystem' ) as $mp ) {
		$mas_wmi[]=$mp->Model;
		$mas_wmi[]=$mp->Manufacturer;
		break;			
	}
}
$mas1["������"]=array("name"=>"������:","field"=>"ComputerSystem_model");
$mas1["�������������"]=array("name"=>"�������������:","field"=>"ComputerSystem_Manufacturer	");
save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("������������ �������",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);

if ($_GET["wmi"]) { 
	foreach ($obj->instancesof ( 'Win32_BIOS' ) as $mp ) {
		$mas_wmi[]=$mp->Name;
		$mas_wmi[]=$mp->Manufacturer;
		$mas_wmi[]=$mp->ReleaseDate;
		$mas_wmi[]=$mp->SMBIOSBIOSVersion;
		$mas_wmi[]=$mp->SerialNumber;
		break;			
	}
}
$mas1["���"]=array("name"=>"���:","field"=>"BIOS_name");
$mas1["�������������"]=array("name"=>"�������������:","field"=>"Manufacturer_BIOS");
$mas1["���� �������"]=array("name"=>"���� �������: ","field"=>"ReleaseDate_BIOS");
$mas1["������ SMBIOSBIOS "]=array("name"=>"������ SMBIOSBIOS: ","field"=>"SMBIOSBIOSVersion");
$mas1["�������� �����: "]=array("name"=>"�������� �����: ","field"=>"SerialNumber_BIOS");

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("���������� � BIOS",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);
?>