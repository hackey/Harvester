<?php 
if ($_GET['service_refresh']==1){
	if ($_GET['ip']<>"") {
		if (!preg_match ("/^[0-9]*[.][0-9]*[.][0-9]*[.][0-9]*$/",$_GET['ip'])) {
			echo "Неправильный формат IP";
			exit; 
		}
		if (!fsockopen($_GET["ip"],135, $errno, $errstr,2)) {
			exit;
		}
		?>
		<form id="service_form">
		<span>
		<p>Имя службы</p>
		<input type="hidden" name="ip" <?php echo "value=\"".$_GET['ip']."\"";?>>
		<input type="text" name="service">
		<div class="inputSubmit but_service" name="service_start" onclick="service_do_button('service_start')">Запустить</div>
		<div class="inputSubmit but_service" name="service_stop" onclick="service_do_button('service_stop')">Остановить</div>
		</span>
		</form>
		<div class="clear"></div>
		<?php
		define ( 'IP_COMP', $_GET["ip"]);
		$obj = new COM('winmgmts:{impersonationLevel=impersonate,(Shutdown)}//'. IP_COMP .'/root/cimv2');
		$process = $obj->execquery("SELECT * FROM Win32_Service");
		require_once("cl.php");
		$table1 = new table; 
		$table1->th_table("Имя процесса","Описание процесса","Путь","Состояние");
		echo "<tbody>";
		foreach ( $process AS $row )	{
				echo "<tr>";
				echo "<td>" . $row->Name ."</td>";
				echo "<td>" . strtolower($row->DisplayName) ."</td>";
				echo "<td>" . strtolower($row->PathName ) ."</td>";
				if (strtolower($row->state )=="running") {echo "<td class=\"service_run\">" . strtolower($row->state ) ."</td>";} 
				else {echo "<td class=\"service_stop\">" . strtolower($row->state ) ."</td>";} 			
				echo "</tr>";
			}
		echo "</tbody>";
		$table1->tf_table("Имя процесса","Описание процесса","Путь","Состояние");
	}
	else { 
		echo "IP не указан";
		exit;
	}
}
?>