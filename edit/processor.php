<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "������ ���������";
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
	$mas_wmi[]=$mp->CurrentClockSpeed ." ���";
	$mas_wmi[]=$mp->MaxClockSpeed ." ���";
	$mas_wmi[]=$mp->ExtClock ." ���";
	$mas_wmi[]=$mp->Level ;
	$mas_wmi[]=$mp->Description; 
	$mas_wmi[]=$mp->Manufacturer;
	$mas_wmi[]=$mp->Status;
	$mas_wmi[]=$mp->L2CacheSize ." ��";
	$mas_wmi[]=$mp->L2CacheSpeed ." ���";
	$mas_wmi[]=$mp->CurrentVoltage/10 ." �����";
	$mas_wmi[]=$mp->SocketDesignation;
	$mas_wmi[]=$np;
	break;			
}
}
$mas1["������������"]=array("name"=>"������������:","table"=>"processors","field"=>"processor_name");
$mas1["������� �������"]=array("name"=>"������� �������:","table"=>"processors","field"=>"processor_speed");
$mas1["������������ �������"]=array("name"=>"������������ �������: ","table"=>"processors","field"=>"MaxClockSpeed_processors");
$mas1["������� ���� (����/�������): "]=array("name"=>"������� ���� (����/�������): ","table"=>"processors","field"=>"ExtClock_processors");
$mas1["���������: "]=array("name"=>"���������: ","table"=>"processors","field"=>"Level_processors");
$mas1["��������: "]=array("name"=>"��������: ","table"=>"processors","field"=>"Description_processors");
$mas1["�������������: "]=array("name"=>"�������������: ","table"=>"processors","field"=>"Manufacturer_processors");
$mas1["������ ����������: "]=array("name"=>"������ ����������: ","table"=>"processors","field"=>"Status_processors");
$mas1["������ ���� 2 ������:  "]=array("name"=>"������ ���� 2 ������: ","table"=>"processors","field"=>"L2CacheSize_processors");
$mas1["������� ���� 2 ������: "]=array("name"=>"������� ���� 2 ������: ","table"=>"processors","field"=>"L2CacheSpeed_processors");
$mas1["���������� ����:  "]=array("name"=>"���������� ����: ","table"=>"processors","field"=>"CurrentVoltage_processors");
$mas1["������: "]=array("name"=>"������:","table"=>"processors","field"=>"processor_socket_designation");
$mas1["���������� ����: "]=array("name"=>"���������� ����: ","table"=>"processors","field"=>"num_proc");

save_table_hard ($table_global,$mas1);
if (!$_GET['save_changes']) {show_table_hard ("���������� � �����������",$table_global,$mas1,$mas_wmi,$wmi_k);}
unset($mas_wmi);
unset($mas1);
?>
