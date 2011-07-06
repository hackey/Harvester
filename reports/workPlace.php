<?php
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
?>
<?php 
require_once("include/connect.php");
require_once("include/select.php");

if (isset($_GET["list_comp"]))
	{ ?>
	<div class="wk_selection">
		<fieldset class="wk_fieldset">
		<legend class="wk_legend"> Инвентаризация рабочего места </legend>
				<?php	function foo() 	{
					$numargs = func_num_args();
					$arg_value = func_get_args();
					?>
					<div class="wk_head_text">
					<?php echo $arg_value[0] ?>
					</div>
					
					<div class="wk_box">
						<div class="wk_value_text">
						<?php 	echo $arg_value[1] ?>
						</div>
						<div class="wk_value">
						<?php 	echo $arg_value[2] ?>
						</div>
					</div>
					
					<?php 
					$box_numarg = ($numargs-1)/2;
					if ($box_numarg > 1) {
						for ($i = 2; $i <= $box_numarg;  $i++) {
						?>		
						<div class="wk_box">
							<div class="wk_value_text">
							<?php 	echo $arg_value[$i*2-1]?>
							</div>
							<div class="wk_value">
							<?php echo $arg_value[$i*2]?>
							</div>
						</div>
						<?php	
						}	
					}?>
					<div class="border clear">
					</div>
				<?php	
				}
				?>
				
			<?php	
			$result=mysql_query("SELECT DISTINCT `fio_current_user`, `mouse`, `keyboard` FROM `computers` WHERE `computer_name`='".$_GET[list_comp]."' ;");
			$row = mysql_fetch_array($result);
			echo foo("Рабочее место","$_GET[list_otdel] &nbsp;" ,"Подразделение","$row[fio_current_user] &nbsp;","Фамилия Имя Отчество");
			echo foo("Мышка","$row[mouse] &nbsp;","Описание");
			echo foo("Клавиатура","$row[keyboard] &nbsp;","Описание");
			
			$result=mysql_query("SELECT `monitor_name`, `ScreenHeight_monitors`, `ScreenWidth_monitors` FROM monitors WHERE computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
			echo foo("Монитор","$row[monitor_name] &nbsp;","Марка","$row[ScreenWidth_monitors] x $row[ScreenHeight_monitors]&nbsp;","Текущее разрешение экрана");
			};
			
			$result=mysql_query("SELECT `printer_name`, `PortName_printers`, `PrintProcessor`, `HorizontalResolution_printers`, `VerticalResolution_printers`, `date_cartridge` FROM printers WHERE computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
		   echo foo("Принтер $i","$row[printer_name] &nbsp;","Марка","$row[PortName_printers] $row[PrintProcessor] $row[HorizontalResolution_printers] $row[VerticalResolution_printers] &nbsp;", "Описание","$row[date_cartridge] &nbsp;","Дата установки картриджа");
			};
			
			echo foo("Системный блок","&nbsp;","Серийный номер");
			?>
	</fieldset>	
	
	<fieldset class="wk_fieldset">
	<legend class="wk_legend"> Паспорт </legend>
			<?php	
			$result=mysql_query("SELECT DISTINCT board_name,BIOS_name FROM motherboards WHERE  computer_name='".$_GET[list_comp]."' ;");
			$row = mysql_fetch_array($result);
			echo foo("Материнская плата","$row[board_name] &nbsp; ","Марка","&nbsp;","Описание","&nbsp;","Тип разъёма, описание","&nbsp;", "Чипсет", "$row[BIOS_name] &nbsp;", "Версия BIOS");
						
			$result=mysql_query("SELECT DISTINCT processor_name,processor_speed,processor_socket_designation FROM processors WHERE 	computer_name='".$_GET[list_comp]."' ;");
			$row = mysql_fetch_array($result);
			echo foo("Процессор","$row[processor_name] &nbsp;","Марка","Слот: ".$row['processor_socket_designation']." &nbsp; Частота: ".$row['processor_speed']."","Описание");
			
			$result=mysql_query("SELECT model_Memory, size_Memory FROM Memory WHERE 	computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
			echo foo("Память $i","$row[model_Memory] &nbsp;","Марка","Размер: ".$row['size_Memory']."","Описание");
			}
			
			$result=mysql_query("SELECT videoadapter_name, AdapterRAM FROM videoadapters WHERE computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
			echo foo("Видео","$row[videoadapter_name] &nbsp;","Марка","$row[AdapterRAM] &nbsp;","Память");
			}
			
			$result=mysql_query("SELECT name_SoundDevice,Manufacturer_SoundDevice FROM SoundDevice WHERE computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
			echo foo("Звук","$row[name_SoundDevice] &nbsp;","Марка","$row[Manufacturer_SoundDevice] &nbsp;","Описание");
			}
						
			$result=mysql_query("SELECT model_physical_drives,InterfaceType_physical_drives,Size_physical_drives FROM physical_drives WHERE computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
			echo foo("Жёсткий диск $i","$row[model_physical_drives] &nbsp;","Марка","Объём:".$row['Size_physical_drives']."Шина: ".$row['InterfaceType_physical_drives']."","Описание");
			}
			
			
			echo foo("Блок питания","&nbsp;","Марка","&nbsp;","Описание");
			
			$result=mysql_query("SELECT DISTINCT cd_drive_name, cd_drives_label FROM cd_drives WHERE 	computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
			echo foo("Привод $i","$row[cd_drive_name]&nbsp;","Марка","$row[cd_drives_label] &nbsp;","Описание");};
			
			echo foo("Floppy","&nbsp;","Марка","&nbsp;","Описание");
			
			$result=mysql_query("SELECT os_name,os_product_key FROM os WHERE computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
			echo foo("Операционная система","$row[os_name] &nbsp;","Версия","$row[os_product_key] &nbsp;","Регистрация");
			}
			
			?>
		<?php	
	}?>
	</fieldset>	
	
		
	</div>
</body>
</html>
