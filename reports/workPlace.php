<?php
if(!isset($_SESSION["user"])) {
	echo "������ ���������";
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
		<legend class="wk_legend"> �������������� �������� ����� </legend>
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
			echo foo("������� �����","$_GET[list_otdel] &nbsp;" ,"�������������","$row[fio_current_user] &nbsp;","������� ��� ��������");
			echo foo("�����","$row[mouse] &nbsp;","��������");
			echo foo("����������","$row[keyboard] &nbsp;","��������");
			
			$result=mysql_query("SELECT `monitor_name`, `ScreenHeight_monitors`, `ScreenWidth_monitors` FROM monitors WHERE computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
			echo foo("�������","$row[monitor_name] &nbsp;","�����","$row[ScreenWidth_monitors] x $row[ScreenHeight_monitors]&nbsp;","������� ���������� ������");
			};
			
			$result=mysql_query("SELECT `printer_name`, `PortName_printers`, `PrintProcessor`, `HorizontalResolution_printers`, `VerticalResolution_printers`, `date_cartridge` FROM printers WHERE computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
		   echo foo("������� $i","$row[printer_name] &nbsp;","�����","$row[PortName_printers] $row[PrintProcessor] $row[HorizontalResolution_printers] $row[VerticalResolution_printers] &nbsp;", "��������","$row[date_cartridge] &nbsp;","���� ��������� ���������");
			};
			
			echo foo("��������� ����","&nbsp;","�������� �����");
			?>
	</fieldset>	
	
	<fieldset class="wk_fieldset">
	<legend class="wk_legend"> ������� </legend>
			<?php	
			$result=mysql_query("SELECT DISTINCT board_name,BIOS_name FROM motherboards WHERE  computer_name='".$_GET[list_comp]."' ;");
			$row = mysql_fetch_array($result);
			echo foo("����������� �����","$row[board_name] &nbsp; ","�����","&nbsp;","��������","&nbsp;","��� �������, ��������","&nbsp;", "������", "$row[BIOS_name] &nbsp;", "������ BIOS");
						
			$result=mysql_query("SELECT DISTINCT processor_name,processor_speed,processor_socket_designation FROM processors WHERE 	computer_name='".$_GET[list_comp]."' ;");
			$row = mysql_fetch_array($result);
			echo foo("���������","$row[processor_name] &nbsp;","�����","����: ".$row['processor_socket_designation']." &nbsp; �������: ".$row['processor_speed']."","��������");
			
			$result=mysql_query("SELECT model_Memory, size_Memory FROM Memory WHERE 	computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
			echo foo("������ $i","$row[model_Memory] &nbsp;","�����","������: ".$row['size_Memory']."","��������");
			}
			
			$result=mysql_query("SELECT videoadapter_name, AdapterRAM FROM videoadapters WHERE computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
			echo foo("�����","$row[videoadapter_name] &nbsp;","�����","$row[AdapterRAM] &nbsp;","������");
			}
			
			$result=mysql_query("SELECT name_SoundDevice,Manufacturer_SoundDevice FROM SoundDevice WHERE computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
			echo foo("����","$row[name_SoundDevice] &nbsp;","�����","$row[Manufacturer_SoundDevice] &nbsp;","��������");
			}
						
			$result=mysql_query("SELECT model_physical_drives,InterfaceType_physical_drives,Size_physical_drives FROM physical_drives WHERE computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
			echo foo("Ƹ����� ���� $i","$row[model_physical_drives] &nbsp;","�����","�����:".$row['Size_physical_drives']."����: ".$row['InterfaceType_physical_drives']."","��������");
			}
			
			
			echo foo("���� �������","&nbsp;","�����","&nbsp;","��������");
			
			$result=mysql_query("SELECT DISTINCT cd_drive_name, cd_drives_label FROM cd_drives WHERE 	computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
			echo foo("������ $i","$row[cd_drive_name]&nbsp;","�����","$row[cd_drives_label] &nbsp;","��������");};
			
			echo foo("Floppy","&nbsp;","�����","&nbsp;","��������");
			
			$result=mysql_query("SELECT os_name,os_product_key FROM os WHERE computer_name='".$_GET[list_comp]."' ;");
			$i=0;
			while($row = mysql_fetch_array($result))
			{$i++;
			echo foo("������������ �������","$row[os_name] &nbsp;","������","$row[os_product_key] &nbsp;","�����������");
			}
			
			?>
		<?php	
	}?>
	</fieldset>	
	
		
	</div>
</body>
</html>
