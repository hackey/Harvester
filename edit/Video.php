<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
?>
<?php
$table_global="monitors";
$mas1["Имя"]=array("name"=>"Имя:","field"=>"monitor_name");
$mas1["Производитель"]=array("name"=>"Семейство:","field"=>"MonitorManufacturer");
$mas1["высота разрешение"]=array("name"=>"Высота разрешение:","field"=>"ScreenHeight_monitors");
$mas1["ширина разрешение"]=array("name"=>"Ширина разрешение:","field"=>"ScreenWidth_monitors");

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
if (!$_GET['save_changes']) {show_table_hard ("Монитор",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);

$table_global="videoadapters";
$mas1["Имя"]=array("name"=>"Имя:","field"=>"videoadapter_name");
$mas1["Семейство"]=array("name"=>"Семейство:","field"=>"AdapterCompatibility");
$mas1["Видеопроцессор"]=array("name"=>"Видеопроцессор:","field"=>"VideoProcessor");
$mas1["Тип DAC"]=array("name"=>"Тип DAC:","field"=>"AdapterDACType");
$mas1["Установленная память"]=array("name"=>"Установленная память:","field"=>"AdapterRAM");
$mas1["Текущий видеорежим"]=array("name"=>"Текущий видеорежим:","field"=>"VideoModeDescription");
$mas1["Драйвер"]=array("name"=>"Драйвер:","field"=>"InstalledDisplayDrivers");
$mas1["Версия драйвера"]=array("name"=>"Версия драйвера:","field"=>"DriverVersion_videoadapters");
$mas1["Макс. частота обновления"]=array("name"=>"Макс. частота обновления:","field"=>"MaxRefreshRate_videoadapters");
$mas1["Мин. частота обновления"]=array("name"=>"Мин. частота обновления:","field"=>"MinRefreshRate_videoadapters");

if ($_GET["wmi"]) { 
$wmi_k=0;
foreach ($obj->instancesof ( 'Win32_VideoController' ) as $mp ) {
	$mas_wmi[]=$mp->Name;
	$mas_wmi[]=$mp->AdapterCompatibility;
	$mas_wmi[]=$mp->VideoProcessor;
	$mas_wmi[]=$mp->AdapterDACType;
	$mas_wmi[]=ceil($mp->AdapterRAM/1024/1024). " Мб";
	$mas_wmi[]=$mp->VideoModeDescription;
	$mas_wmi[]=$mp->InstalledDisplayDrivers;
	$mas_wmi[]=$mp->DriverVersion;
	$mas_wmi[]=$mp->MaxRefreshRate;
	$mas_wmi[]=$mp->MinRefreshRate;
	$wmi_k++;
}
}
save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Видеоадаптер",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);


?>