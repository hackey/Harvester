<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
?>
<?php
$table_global="printers";
$mas1["Имя"]=array("name"=>"Имя:","field"=>"printer_name");
$mas1["Порт"]=array("name"=>"Порт:","field"=>"PortName_printers");
$mas1["Процессор"]=array("name"=>"Процессор:","field"=>"PrintProcessor");
$mas1["Горизонтальное разрешение"]=array("name"=>"Горизонтальное разрешение:","field"=>"HorizontalResolution_printers");
$mas1["Вертикальное разрешение"]=array("name"=>"Вертикальное разрешение:","field"=>"VerticalResolution_printers");
// $mas1["Описание"]=array("name"=>"Описание:","field"=>"type_printers");
// $mas1["Картридж"]=array("name"=>"Картридж:","field"=>"date_kartridje_printer");

if ($_GET["wmi"]) { 
$wmi_k=0;
foreach ($obj->instancesof ( 'Win32_Printer' ) as $mp ) {
	$mas_wmi[]=$mp->Name;
	$mas_wmi[]=$mp->PortName;
	$mas_wmi[]=$mp->PrintProcessor;
	$mas_wmi[]=$mp->HorizontalResolution ." dpi";
	$mas_wmi[]=$mp->VerticalResolution ." dpi";
	$wmi_k++;
}
}

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Переферийное устрйоство",$table_global,$mas1,$mas_wmi,$wmi_k); }

unset($mas_wmi);
unset($mas1);
?>