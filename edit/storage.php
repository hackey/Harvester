<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "������ ���������";
	exit;
}
?>
<?php
$table_global="physical_drives";
$mas1["ID ��������"]=array("name"=>"ID ��������:","field"=>"model_physical_drives");
$mas1["��� ����������"]=array("name"=>"��� ����������:","field"=>"InterfaceType_physical_drives");
$mas1["�������������"]=array("name"=>"�������������:","field"=>"Manufacturer_physical_drives");
$mas1["��� ��������"]=array("name"=>"��� ��������:","field"=>"MediaType_physical_drives");
$mas1["�������"]=array("name"=>"�������:","field"=>"Partitions_physical_drives");
$mas1["������"]=array("name"=>"������:","field"=>"Size_physical_drives");


if ($_GET["wmi"]) { 
$wmi_k=0;
foreach ($obj->instancesof ( 'Win32_DiskDrive' ) as $mp ) {
	$mas_wmi[]=$mp->model;
	$mas_wmi[]=$mp->InterfaceType;
	$mas_wmi[]=$mp->Manufacturer;
	$mas_wmi[]=$mp->MediaType;
	$mas_wmi[]=$mp->Partitions;
	$mas_wmi[]=ceil($mp->Size/1024/1024/1024) . " ��";
	$wmi_k++;
}
}
save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Ƹ����� ����",$table_global,$mas1,$mas_wmi,$wmi_k);}

unset($mas_wmi);
unset($mas1);

$table_global="cd_drives";
$mas1["ID ��������"]=array("name"=>"ID ��������:","field"=>"cd_drive_name");
$mas1["�����"]=array("name"=>"�����:","field"=>"cd_drives_label");
$mas1["�������������"]=array("name"=>"�������������:","field"=>"Manufacturer_cd_drives");
$mas1["��������"]=array("name"=>"��������:","field"=>"Description_cd_drives");

if ($_GET["wmi"]) { 
$wmi_k=0;
foreach ($obj->instancesof ( 'Win32_CDROMDrive' ) as $mp ) {
	$mas_wmi[]=$mp->Name;
	$mas_wmi[]=$mp->Drive;
	$mas_wmi[]=$mp->Manufacturer;
	$mas_wmi[]=$mp->Description;
	$wmi_k++;
}
}

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("������",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);

?>