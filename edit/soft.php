<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
?>
<?php
$table_global="antivirus_software";
$mas1["Антивирус"]=array("name"=>"Антивирус:","field"=>"antivirus_name");

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Антивирус",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);

$table_global="software";
$mas1["Программа 1"]=array("name"=>"Программа 1:","field"=>"software_name1");
$mas1["Программа 2"]=array("name"=>"Программа 2:","field"=>"software_name2");
$mas1["Программа 3"]=array("name"=>"Программа 3:","field"=>"software_name3");

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("Программы",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);
?>
