<?php 
if ($_GET['process']==1){
	if ($_GET['ip']<>"") {
		if (!preg_match ("/^[0-9]*[.][0-9]*[.][0-9]*[.][0-9]*$/",$_GET['ip'])) {
			echo "������������ ������ IP";
			exit; 
		}
		if (!fsockopen($_GET["ip"],135, $errno, $errstr,2)) {
			exit;
		}
		?>
		<form id="process_form">
		<span>
		<p>��� ��������</p>
		<input type="text" name="name_process">
		<input type="hidden" name="ip" <?php echo "value=\"".$_GET['ip']."\"";?>>		
		<div class="inputSubmit but_service" name="process_start" onclick="process_do_button('process_start')">���������</div>		
		</span>
		</form>
		<div class="clear"></div>
		<?php
		define ( 'IP_COMP', $_GET["ip"]);
		$obj = new COM('winmgmts:{impersonationLevel=impersonate,(Shutdown)}//'. IP_COMP .'/root/cimv2');
		$process = $obj->execquery("SELECT * FROM Win32_Process");
		if ( $process->count > 0 ){
			require_once("cl.php");
			$table1 = new table; 
			$table1->th_table("PID","��� ��������","������������ ������","X");
			echo "<tbody>";
			foreach ( $process AS $row )	{
					echo "<tr>";
					echo "<td>" . $row->processid ."</td>";
					echo "<td>" . strtolower( $row->name ) ."</td>";
					echo "<td>" . number_format( $row->workingsetsize )."</td>";
					echo "<td> 
							<div class=\"inputSubmit but_process_stop\" name=\"process_start\" onclick=\"process_do_button('process_stop'," . $row->processid .")\">X</div>							
							</td>";
					echo "</tr>";
			}
			echo "</tbody>";
			$table1->tf_table("PID","��� ��������","������������ ������","X");
		}
	}
	else { 
		echo "IP �� ������";
		exit;
	}
}
?>