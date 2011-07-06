<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
?>
<?php
$table_global="SoundDevice";
$mas1["Имя"]=array("name"=>"Имя:","field"=>"name_SoundDevice");
$mas1["Производитель"]=array("name"=>"Семейство:","field"=>"Manufacturer_SoundDevice");

if ($_GET["wmi"]) { 
	$wmi_k=0;
	foreach ($obj->instancesof ( 'Win32_SoundDevice' ) as $mp ) {
		$mas_wmi[]=$mp->Name;
		$mas_wmi[]=$mp->Manufacturer;
		$wmi_k++;
	}
}

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Звуковое устройство",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);
?>