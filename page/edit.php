<?php
session_start();
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
?>
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
<?php 
if (($_GET[list_comp])=="info") {require("../include/select.php");}
require("../include/connect.php");
function save_table_hard ($table_global,$mas1) {
	if ($_POST['save_changes']) {
		$query=mysql_query("SELECT * FROM $table_global WHERE computer_name='".mysql_real_escape_string($_POST[list_comp])."' ");
		$num_query=mysql_num_rows($query);
		$query=mysql_query("SELECT id FROM $table_global WHERE computer_name='".mysql_real_escape_string($_POST[list_comp])."' ");
		if ($num_query>$_POST[$table_global]) {
			$i=1;
			while ($mas_ar=mysql_fetch_array($query,MYSQL_NUM)) {
				if($i>$_POST[$table_global]) {
					$query_save="DELETE FROM $table_global WHERE id='".mysql_real_escape_string($mas_ar[0])."' ";
					mysql_query($query_save) or die (mysql_error()); 
				}
				$i++;
			}
		}
		
		$query=mysql_query("SELECT * FROM $table_global WHERE computer_name='".mysql_real_escape_string($_POST[list_comp])."' ");
		$num_query=mysql_num_rows($query);
		$query=mysql_query("SELECT `id` FROM $table_global WHERE computer_name='".mysql_real_escape_string($_POST[list_comp])."' ");
		$i=1;	
		while ($mas_ar=mysql_fetch_array($query,MYSQL_NUM)) {
					foreach ($mas1 as $v) {
						$post=$_POST[$v["field"].$i];
						$pole=$v["field"];
						$query_save="UPDATE $table_global SET $pole='".mysql_real_escape_string($post)."' WHERE id='".mysql_real_escape_string($mas_ar[0])."' ";
						mysql_query($query_save) or die (mysql_error()); 
					}
					$i++;
		}
		
		if ($num_query<$_POST[$table_global]) {
			$max_id=mysql_query("SELECT MAX(`id`) FROM `$table_global`");
			$max_id=mysql_fetch_array($max_id,MYSQL_NUM);
			$max_id[0]++;
			while ($i<=$_POST[$table_global]) {
				$query_insert="INSERT INTO $table_global SET id=$max_id[0], computer_name='".mysql_real_escape_string($_POST[list_comp])."' ";
				mysql_query($query_insert) or die (mysql_error());
				$max_id[0]++;
				$i++;
			}
			save_table_hard($table_global,$mas1);
		} 
	}
}
if ($_POST['save_changes']) {
foreach($_POST as $key => $value) {
			$_POST[$key] = iconv('UTF-8', 'windows-1251', $value);
}		
require_once("../edit/main.php");
require_once("../edit/soft.php");
require_once("../edit/processor.php");
require_once("../edit/motherboards.php");
require_once("../edit/memory.php");
require_once("../edit/Video.php");
require_once("../edit/storage.php");
require_once("../edit/SoundDevice.php");
require_once("../edit/printer.php");
require_once("../edit/network.php");
mysql_query ("UPDATE `computers` SET `Last_Updated`='".date('Y-m-d')."' WHERE computer_name='".mysql_real_escape_string($_POST['list_comp'])."'");
echo "Сохранено";
}

function show_table_hard ($hard,$table_global,$mas1,$mas_wmi,$wmi_k){
	if (!$_POST['save_changes']) {
		$query=mysql_query("SELECT * FROM $table_global WHERE computer_name='".$_GET[list_comp]."' ");
		$n_query=mysql_num_rows($query);

		if ($_GET["wmi"]) { 
			$i=1;
			$num_query=0;
			$query_array=mysql_fetch_array($query);
			while($i<=$wmi_k) {
				if ($wmi_k==1) {echo "<div class=edit_podlegend>".$hard."</div>";} else {echo "<div class=edit_podlegend>".$hard." ".$i."</div>";}
				$num_even=0;
				foreach ($mas1 as $v) {
					if($num_even % 2 == 1) {
						echo "<div class=\"edit_row_view \">";
					} else {
						echo "<div class=\"edit_row_view _edit_even\">";
					}
					echo "<div class=\"edit_row_name\">".$v["name"]."</div>";
					$field=$v["field"];
					if ($mas_wmi[$num_query]=="") {
						echo "<div class=\"edit_row_value\" id=". $field."text".$i.">". $query_array[$field] ."</div>";
							} else 
								{echo "<div class=\"edit_row_value\" id=". $field."text".$i.">". $mas_wmi[$num_query] ."</div>";}
					if ($mas_wmi[$num_query]=="") {
						echo "<input id=". $field."edit".$i ." style=\"DISPLAY: none\" class=\"inputText edit_row_input\" name=". $field.$i ." value='". $query_array[$field] ."'>";
							} else
								{echo "<input id=". $field."edit".$i ." style=\"DISPLAY: none\" class=\"inputText edit_row_input\" name=". $field.$i ." value='". $mas_wmi[$num_query] ."'>";}
					$num_query++;
					echo "<div id=". $field."b".$i ."  class=edit_tag onclick=\"show('". $field."text".$i ."','". $field."edit".$i ."','". $field."b".$i ."');\";></div>";
					echo "</div>";
					echo "<div class=clear></div>";
					$num_even++;
				}		
				$i++;
			}
			echo "<input type=\"hidden\" name=\"$table_global\" value='". $wmi_k ."'>";		
		} else {	
						$num_query=1;
						while($query_array=mysql_fetch_array($query)) {
						if ($n_query==1) 
							{echo "<div class=edit_podlegend>".$hard."</div>";}
								else {echo "<div class=edit_podlegend>".$hard." ".$num_query."</div>";}
							$num_even=0;
							foreach ($mas1 as $v) {
								if($num_even % 2 == 1) {
									echo "<div class=\"edit_row_view \">";
								} else {
									echo "<div class=\"edit_row_view _edit_even\">";
								}
								echo "<div class=\"edit_row_name\">".$v["name"]."</div>";
								$field=$v["field"];
								echo "<div  class=\"edit_row_value\" id=". $field."text".$num_query .">".$query_array[$field]."</div>";
								echo "<input id=". $field."edit".$num_query ." style=\"DISPLAY: none\" class=\"inputText edit_row_input\" name=". $field.$num_query ." value='". $query_array[$field] ."'>";
								echo "<div id=". $field."b".$num_query ."  class=edit_tag onclick=\"show('". $field."text".$num_query ."','". $field."edit".$num_query ."','". $field."b".$num_query ."');\";></div>";
								echo "</div>";
								echo "<div class=clear></div>";
								$num_even++;							
							}
							$num_query++;
						}
						if ($num_query<>1) {$num_query--;}
						echo "<input type=\"hidden\" name=\"$table_global\" value='". $num_query ."'>";
		}
	}
}
?>
<script type="text/javascript">
<!--//<![CDATA[
function show(text,edit,b) {
var text = document.getElementById(text)
var edit = document.getElementById(edit)
var b = document.getElementById(b)

if (edit.style.display == 'none') {
		edit.style.display = 'block'
		text.style.display = 'none'
		b.style.background = 'url(images/tick.png)'
	} else {
		edit.style.display = 'none'
		text.style.display = 'block'
		b.style.background = 'url(images/tag.png)'
		text.innerHTML = edit.value
	}
}
// ]]>-->
</script> 


<?php if ($_GET['list_comp'] && !$_POST['save_changes']) {
$mas=array("Общие сведения",
					"Програмное обеспечение",
					"Процессор",
					"Материнская плата",
					"Системная память",
					"Видеосистема",
					"Хранение информации",
					"Мультимедиа",
					"Сетевые адаптеры",
					"Переферийные устройства"
					
					); ?>
					
<form id="data_comp">
<div class="edit_menu">
	<ul>	
	<?php 
				$anchor=1;
				foreach ($mas as $v) {
						echo "<li><a href=\"#anchor".$anchor."\">".$v."</a></li>";
						if ($anchor==1 OR $anchor==2 OR $anchor==count($mas)) {echo "<div class=\"edit_menu_li_div\"> </div>";}
						++$anchor;
				} ?>
	</ul>
	<p class="e_b">
	<?php if($_SESSION["group"]=="Администратор") { ?>
	<?php if (!$_GET["wmi"]) { ?>
	<div class="inputSubmit but_reboot" onclick="refresh_wmi_button('<?php echo htmlspecialchars($_GET[list_comp]);?>','<?php echo htmlspecialchars($_GET[id_modal]);?>')">Обновить</div>
	<?php } ?>
	<?php } ?>
	<div class="inputSubmit but_reboot" onclick="save_comp_edit_button('<?php echo htmlspecialchars($_GET[list_comp]);?>')">Сохранить</div>
	</p>
</div>

<div class="edit_view">


<?php
if ($_GET["wmi"]) { 
	if (!fsockopen($result[0],135, $errno, $errstr,2)) {exit;}
	define ( 'CPU_NAME', $_GET[list_comp]);
	$obj = new COM ( 'winmgmts:{impersonationLevel=impersonate}//' . CPU_NAME . '/root/cimv2' );
}
$anchor=1;
foreach ($mas as $v) {
	echo "<a name=\"anchor".$anchor."\"></a>";
	echo "<div class=\"edit_legend\">".$v."</div>";
	
	switch ($v) {
		case 'Общие сведения':
			require_once("../edit/main.php");
			break;
		case 'Програмное обеспечение':
			require_once("../edit/soft.php");
			break;
		case 'Процессор':
			require_once("../edit/processor.php");
			break;
		case 'Материнская плата':
			require_once("../edit/motherboards.php");
			break;			
		case 'Системная память':
			require_once("../edit/memory.php");
			break;
		case 'Видеосистема':
			require_once("../edit/Video.php");
			break;
		case 'Хранение информации':
			require_once("../edit/storage.php");
			break;
		case 'Мультимедиа':
			require_once("../edit/SoundDevice.php");
			break;
		case 'Сетевые адаптеры':
			require_once("../edit/network.php");
			break;
		case 'Переферийные устройства':
			require_once("../edit/printer.php");
			break;
	}
	++$anchor;
}
?>
</form>
</div>
<?php } ?>


