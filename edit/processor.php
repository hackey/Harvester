<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
?>
<?php
$table_global="processors";
$wmi_k=1;
if ($_GET["wmi"]) { 
foreach ( $obj->instancesof ( 'Win32_Processor' ) as $mp ) {
	++$np;
}

foreach ($obj->instancesof ( 'Win32_Processor' ) as $mp ) {
	$mas_wmi[]=$mp->Name;
	$mas_wmi[]=$mp->CurrentClockSpeed ." МГц";
	$mas_wmi[]=$mp->MaxClockSpeed ." МГц";
	$mas_wmi[]=$mp->ExtClock ." МГц";
	$mas_wmi[]=$mp->Level ;
	$mas_wmi[]=$mp->Description; 
	$mas_wmi[]=$mp->Manufacturer;
	$mas_wmi[]=$mp->Status;
	$mas_wmi[]=$mp->L2CacheSize ." Кб";
	$mas_wmi[]=$mp->L2CacheSpeed ." МГц";
	$mas_wmi[]=$mp->CurrentVoltage/10 ." вольт";
	$mas_wmi[]=$mp->SocketDesignation;
	$mas_wmi[]=$np;
	break;			
}
}
$mas1["Наименование"]=array("name"=>"Наименование:","table"=>"processors","field"=>"processor_name");
$mas1["Текущая частота"]=array("name"=>"Текущая частота:","table"=>"processors","field"=>"processor_speed");
$mas1["Максимальная частота"]=array("name"=>"Максимальная частота: ","table"=>"processors","field"=>"MaxClockSpeed_processors");
$mas1["Частота шины (реал/рейтинг): "]=array("name"=>"Частота шины (реал/рейтинг): ","table"=>"processors","field"=>"ExtClock_processors");
$mas1["Множитель: "]=array("name"=>"Множитель: ","table"=>"processors","field"=>"Level_processors");
$mas1["Описание: "]=array("name"=>"Описание: ","table"=>"processors","field"=>"Description_processors");
$mas1["Производитель: "]=array("name"=>"Производитель: ","table"=>"processors","field"=>"Manufacturer_processors");
$mas1["Статус процессора: "]=array("name"=>"Статус процессора: ","table"=>"processors","field"=>"Status_processors");
$mas1["Размер кеша 2 уровня:  "]=array("name"=>"Размер кеша 2 уровня: ","table"=>"processors","field"=>"L2CacheSize_processors");
$mas1["Частота кеша 2 уровня: "]=array("name"=>"Частота кеша 2 уровня: ","table"=>"processors","field"=>"L2CacheSpeed_processors");
$mas1["Напряжение ядра:  "]=array("name"=>"Напряжение ядра: ","table"=>"processors","field"=>"CurrentVoltage_processors");
$mas1["Разъем: "]=array("name"=>"Разъем:","table"=>"processors","field"=>"processor_socket_designation");
$mas1["Количество ядер: "]=array("name"=>"Количество ядер: ","table"=>"processors","field"=>"num_proc");

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Информация о процессорах",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);
?>
