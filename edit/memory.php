<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
?>
<?php
$table_global="Memory";
$mas1["Модель"]=array("name"=>"Модель:","field"=>"model_Memory");
$mas1["Производитель"]=array("name"=>"Производитель:","field"=>"Manufacturer_Memory");
$mas1["Объём"]=array("name"=>"Объём:","field"=>"size_Memory");
$mas1["Форм-фактор"]=array("name"=>"Форм-фактор:","field"=>"FormFactor_Memory");
$mas1["Метка банка"]=array("name"=>"Метка банка:","field"=>"BankLabel_Memory");
$mas1["Тип"]=array("name"=>"Тип:","field"=>"MemoryType_Memory");
$mas1["Частота"]=array("name"=>"Частота:","field"=>"Speed_Memory");

if ($_GET["wmi"]) { 
$wmi_k=0;
foreach ($obj->instancesof ( 'Win32_PhysicalMemory' ) as $mp ) {
	$mas_wmi[]=$mp->Name;
	$mas_wmi[]=$mp->Manufacturer;
	$mas_wmi[]=$mp->Capacity/1024/1024 . " Мб";
	$mas_wmi[]=$mp->FormFactor;
	$mas_wmi[]=$mp->BankLabel;
	$mas_wmi[]=$mp->MemoryType;
	$mas_wmi[]=$mp->Speed;	
	$wmi_k++;
}
}

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Устройство памяти",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);
?>