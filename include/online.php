<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
?>

<?php
if ($_GET['online']==off) {
	require_once("connect.php");
	$comp=mysql_query("SELECT `computer_name`,`Last_Updated` FROM `computers` ORDER BY `computer_name` ASC");
	echo "<h2>Всего в базе данных - ".mysql_num_rows($comp)."</h2>";
	while ($comp_bd=mysql_fetch_array($comp)) {
	echo "<div class=\"online\"><a href=# onclick=\"show_computer_button('".$comp_bd['computer_name']."','".$comp_bd['Last_Updated']."')\">".$comp_bd['computer_name']."</a></div>";
	}
	echo "<div class=\"clear\"></div>";
}

if ($_GET['online']==on) {
	exec ('..\comp.BAT');
	$domain_array = file('domain.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$bd=0;
	$count_online=0;
	require_once("connect.php");
	foreach ($domain_array as $val) { ?>
		<div class="clear"></div>
		<h2>
		<?php echo $val ?>
		</h2>
		<?php 
		$my_array=file($val.'.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		foreach ($my_array as $value) {
			$comp=mysql_query("SELECT `computer_name` FROM `computers` WHERE `computer_name`='".$value."'");
			if (mysql_num_rows($comp)==1) {
				echo "<div class=\"online\"><a id=\"'".$value."'\" href=# class=\"bd_on\" onclick=\"show_computer_button('".$value."')\">".$value."</a></div>";
				$bd++;			
			} else 	{
				echo "<div class=\"online\"><a id=\"'".$value."'\" class=\"bd_off\" href=# onclick=\"scan_comp_wmi('".$value."')\">".$value."</a></div>";
				$mas_sort[]=$value;
			}		
		}
		$count_online+=count($my_array);
	}
	echo "<div class=\"clear\"></div>";
	echo "<h2>Онлайн <a class=\"bd_off\"> ".$count_online." </a>, из них в базе данных <a class=\"bd_on\">".$bd."</a></br>Для сбора информации выберите необходимый компьютер или используйте <a href=# onclick=\"scan_group_show();\">сканер</a></h2>";	 ?>
	<div id="online_scan" class="online_scan">
	<h2> <div class="inputSubmit scan_b" onclick=scan_group_wmi('<?php echo json_encode($mas_sort); ?>')> запустить сканирование </div></h2>
	<?php 
	$id=1;
	$head_id=(int)(count($mas_sort)/2+1);
	foreach ($mas_sort as $value) {
			if ($id==$head_id or $id==1) {
				if ($id<>1) { ?> 
					</div> <?php
				} ?>
				<div class="main_getdata">
				<div class="num_getdata head_getdata">№</div>
				<div class="name_getdata head_getdata">Имя комьютера</div>
				<div class="Status_getdata head_getdata">Состояние</div>
				<div class="clear"></div>
			<?php
			}
			?>
			<div class="num_getdata"><?php echo $id;$id++; ?></div>
			<div class="name_getdata"><?php echo $value; ?></div>
			<div id="<?php echo $value; ?>" class="Status_getdata <?php echo $value; ?>"></div>
			<div class="clear"></div> 			
	<?php	
	}
	?>
	</div>
	</div>	
<?php
}
?>
