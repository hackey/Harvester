<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "������ ���������";
	exit;
}
?>
<?php
$table_global="monitors";
$mas1["���"]=array("name"=>"���:","field"=>"monitor_name");
$mas1["�������������"]=array("name"=>"���������:","field"=>"MonitorManufacturer");
$mas1["������ ����������"]=array("name"=>"������ ����������:","field"=>"ScreenHeight_monitors");
$mas1["������ ����������"]=array("name"=>"������ ����������:","field"=>"ScreenWidth_monitors");

if ($_GET["wmi"]) { 
$wmi_k=0;
foreach ($obj->instancesof ( 'Win32_DesktopMonitor' ) as $mp ) {
	$mas_wmi[]=$mp->Name;
	$mas_wmi[]=$mp->MonitorManufacturer;
	$mas_wmi[]=$mp->ScreenHeight;
	$mas_wmi[]=$mp->ScreenWidth;
	$wmi_k++;
}
}
save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("�������",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);

$table_global="videoadapters";
$mas1["���"]=array("name"=>"���:","field"=>"videoadapter_name");
$mas1["���������"]=array("name"=>"���������:","field"=>"AdapterCompatibility");
$mas1["��������������"]=array("name"=>"��������������:","field"=>"VideoProcessor");
$mas1["��� DAC"]=array("name"=>"��� DAC:","field"=>"AdapterDACType");
$mas1["������������� ������"]=array("name"=>"������������� ������:","field"=>"AdapterRAM");
$mas1["������� ����������"]=array("name"=>"������� ����������:","field"=>"VideoModeDescription");
$mas1["�������"]=array("name"=>"�������:","field"=>"InstalledDisplayDrivers");
$mas1["������ ��������"]=array("name"=>"������ ��������:","field"=>"DriverVersion_videoadapters");
$mas1["����. ������� ����������"]=array("name"=>"����. ������� ����������:","field"=>"MaxRefreshRate_videoadapters");
$mas1["���. ������� ����������"]=array("name"=>"���. ������� ����������:","field"=>"MinRefreshRate_videoadapters");

if ($_GET["wmi"]) { 
$wmi_k=0;
foreach ($obj->instancesof ( 'Win32_VideoController' ) as $mp ) {
	$mas_wmi[]=$mp->Name;
	$mas_wmi[]=$mp->AdapterCompatibility;
	$mas_wmi[]=$mp->VideoProcessor;
	$mas_wmi[]=$mp->AdapterDACType;
	$mas_wmi[]=ceil($mp->AdapterRAM/1024/1024). " ��";
	$mas_wmi[]=$mp->VideoModeDescription;
	$mas_wmi[]=$mp->InstalledDisplayDrivers;
	$mas_wmi[]=$mp->DriverVersion;
	$mas_wmi[]=$mp->MaxRefreshRate;
	$mas_wmi[]=$mp->MinRefreshRate;
	$wmi_k++;
}
}
save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("������������",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);


?>