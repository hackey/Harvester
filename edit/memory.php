<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "������ ���������";
	exit;
}
?>
<?php
$table_global="Memory";
$mas1["������"]=array("name"=>"������:","field"=>"model_Memory");
$mas1["�������������"]=array("name"=>"�������������:","field"=>"Manufacturer_Memory");
$mas1["�����"]=array("name"=>"�����:","field"=>"size_Memory");
$mas1["����-������"]=array("name"=>"����-������:","field"=>"FormFactor_Memory");
$mas1["����� �����"]=array("name"=>"����� �����:","field"=>"BankLabel_Memory");
$mas1["���"]=array("name"=>"���:","field"=>"MemoryType_Memory");
$mas1["�������"]=array("name"=>"�������:","field"=>"Speed_Memory");

if ($_GET["wmi"]) { 
$wmi_k=0;
foreach ($obj->instancesof ( 'Win32_PhysicalMemory' ) as $mp ) {
	$mas_wmi[]=$mp->Name;
	$mas_wmi[]=$mp->Manufacturer;
	$mas_wmi[]=$mp->Capacity/1024/1024 . " ��";
	$mas_wmi[]=$mp->FormFactor;
	$mas_wmi[]=$mp->BankLabel;
	$mas_wmi[]=$mp->MemoryType;
	$mas_wmi[]=$mp->Speed;	
	$wmi_k++;
}
}

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("���������� ������",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);
?>