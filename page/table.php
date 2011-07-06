<?php
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
?>
<?php 
require_once("include/table_cl.php");

if ( $_GET['option']=="admin" && ($_SESSION["group"]=="Администратор") ) {
$table1 = new table; 
$table1->th_table("Отдел","Имя","Домен","IP адрес","ФИО","User 1"," Password 1","User2"," Password 2");
$query=mysql_query("Select * From computers, ip_addresses,  local_users WHERE computers.computer_name = ip_addresses.computer_name AND computers.computer_name = local_users.computer_name ;");
$table1->table_sql=$query;
$table1->tb_table("otdel","computer_name","Domen","ip_address","fio_current_user","user_name","user_pass","user_name2","user_pass2");
$table1->tf_table("Отдел","Имя","Домен","IP адрес","ФИО","User 1"," Password 1","User2"," Password 2");
}

if ( $_GET['option']=="soft" ) {
$table1 = new table; 
$table1->th_table("Отдел","Имя","OS","Антивирус"," Программа1","Программа2","Программа3");
$query=mysql_query("Select * From computers, antivirus_software, software,os
									WHERE 
									computers.computer_name = antivirus_software.computer_name AND 
									computers.computer_name = os.computer_name AND 
									computers.computer_name = software.computer_name 															
									;");
$table1->table_sql=$query;
$table1->tb_table("otdel","computer_name","os_name","antivirus_name","software_name1","software_name2","software_name3");
$table1->tf_table("Отдел","Имя","OS","Антивирус"," Программа1","Программа2","Программа3");
}
?>

