<?php require_once("connect.php");?>

<?php
class table {

	function th_table() { 
		echo "<table cellpadding=0 cellspacing=0 border=0 class=display id=example><thead><tr>";
		$numargs = func_num_args();
		$arg_value = func_get_args();
		if ( $_GET['option']=="hard") {
			echo "<th title=\"Подробнее\"> ";
			echo "+";
			echo "</th>";
		}
		for ($i=0;$i<$numargs;$i++) {
		echo "<th>$arg_value[$i]</th>";
		}
		echo "</tr></thead>";
	}

	var $table_sql;
	function tb_table() {?>
	<tbody> 	
	<?php while($stroka1=mysql_fetch_array($this->table_sql)) {	?>
	<tr> <?php
	$numargs = func_num_args();
	$arg_value = func_get_args();
	if ( $_GET['option']=="hard") {
		echo "<td title=\"Подробнее\"> ";
		echo "+";
		echo "</td>";
	}
	for ($i=0;$i<$numargs;$i++) {
	$param=$arg_value[$i];
	echo "<td> ";
	if (($stroka1[$param])) {echo $stroka1[$param]; } else { echo "-"; }
	echo "</td>";
	}
	?>
	</tr> 
	<?php
	}	?>
	</tbody> 
	<?php
	}

	function tf_table() { ?>
	<tfoot> 
	<tr> 	
		<?php 	$numargs = func_num_args();
		$arg_value = func_get_args();
		if ( $_GET['option']=="hard") {
			echo "<th title=\"Подробнее\"> ";
			echo "+";
			echo "</th>";
		}
		for ($i=0;$i<$numargs;$i++) {
		
			echo "<th>$arg_value[$i]</th>";
		}?>
	</tr> 
	</tfoot> 
	</table> 
	<?php }
}

?>