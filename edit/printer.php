<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "������ ���������";
	exit;
}
?>
<?php
$table_global="printers";
$mas1["���"]=array("name"=>"���:","field"=>"printer_name");
$mas1["����"]=array("name"=>"����:","field"=>"PortName_printers");
$mas1["���������"]=array("name"=>"���������:","field"=>"PrintProcessor");
$mas1["�������������� ����������"]=array("name"=>"�������������� ����������:","field"=>"HorizontalResolution_printers");
$mas1["������������ ����������"]=array("name"=>"������������ ����������:","field"=>"VerticalResolution_printers");
// $mas1["��������"]=array("name"=>"��������:","field"=>"type_printers");
// $mas1["��������"]=array("name"=>"��������:","field"=>"date_kartridje_printer");

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
if (!$_GET['save_changes']) {show_table_hard ("������������ ����������",$table_global,$mas1,$mas_wmi,$wmi_k); }

unset($mas_wmi);
unset($mas1);
?>