<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
?>
<?php
$table_global="motherboards";
$wmi_k=1;
$mas1["Имя продукта"]=array("name"=>"Модель:","field"=>"board_name");
$mas1["Производитель"]=array("name"=>"Производитель:","field"=>"Manufacturer_motherboards");
$mas1["Серийный номер"]=array("name"=>"Серийный номер:","field"=>"SerialNumber_motherboards");
$mas1["Версия"]=array("name"=>"Версия:","field"=>"Version_motherboards");

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
if (!$_GET['save_changes']) {show_table_hard ("Материская плата",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);

if ($_GET["wmi"]) { 
	foreach ($obj->instancesof ( 'Win32_ComputerSystem' ) as $mp ) {
		$mas_wmi[]=$mp->Model;
		$mas_wmi[]=$mp->Manufacturer;
		break;			
	}
}
$mas1["Модель"]=array("name"=>"Модель:","field"=>"ComputerSystem_model");
$mas1["Производитель"]=array("name"=>"Производитель:","field"=>"ComputerSystem_Manufacturer	");
save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Компьютерная система",$table_global,$mas1,$mas_wmi,$wmi_k);}
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
$mas1["Имя"]=array("name"=>"Имя:","field"=>"BIOS_name");
$mas1["Производитель"]=array("name"=>"Производитель:","field"=>"Manufacturer_BIOS");
$mas1["Дата выпуска"]=array("name"=>"Дата выпуска: ","field"=>"ReleaseDate_BIOS");
$mas1["Версия SMBIOSBIOS "]=array("name"=>"Версия SMBIOSBIOS: ","field"=>"SMBIOSBIOSVersion");
$mas1["Серийный номер: "]=array("name"=>"Серийный номер: ","field"=>"SerialNumber_BIOS");

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Информация о BIOS",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);
?>