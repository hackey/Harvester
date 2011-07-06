<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
?>
<?php
$table_global="physical_drives";
$mas1["ID продукта"]=array("name"=>"ID продукта:","field"=>"model_physical_drives");
$mas1["Тип интерфейса"]=array("name"=>"Тип интерфейса:","field"=>"InterfaceType_physical_drives");
$mas1["Производитель"]=array("name"=>"Производитель:","field"=>"Manufacturer_physical_drives");
$mas1["Тип носителя"]=array("name"=>"Тип носителя:","field"=>"MediaType_physical_drives");
$mas1["Разделы"]=array("name"=>"Разделы:","field"=>"Partitions_physical_drives");
$mas1["Размер"]=array("name"=>"Размер:","field"=>"Size_physical_drives");


if ($_GET["wmi"]) { 
$wmi_k=0;
foreach ($obj->instancesof ( 'Win32_DiskDrive' ) as $mp ) {
	$mas_wmi[]=$mp->model;
	$mas_wmi[]=$mp->InterfaceType;
	$mas_wmi[]=$mp->Manufacturer;
	$mas_wmi[]=$mp->MediaType;
	$mas_wmi[]=$mp->Partitions;
	$mas_wmi[]=ceil($mp->Size/1024/1024/1024) . " Гб";
	$wmi_k++;
}
}
save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Жёсткий диск",$table_global,$mas1,$mas_wmi,$wmi_k);}

unset($mas_wmi);
unset($mas1);

$table_global="cd_drives";
$mas1["ID продукта"]=array("name"=>"ID продукта:","field"=>"cd_drive_name");
$mas1["Метка"]=array("name"=>"Метка:","field"=>"cd_drives_label");
$mas1["Производитель"]=array("name"=>"Производитель:","field"=>"Manufacturer_cd_drives");
$mas1["Описание"]=array("name"=>"Описание:","field"=>"Description_cd_drives");

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
if (!$_GET['save_changes']) {show_table_hard ("Привод",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);

?>