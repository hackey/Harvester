<?php
if(!isset($_SESSION["user"])) {
	echo "������ ���������";
	exit;
}
?>
<div class="menu_center">
<div class="menu1">
	<fieldset class="menu_fieldset">
	<legend class="menu_legend">  ���������� </legend>
	<ul>
		<li>	
			<p>
			<?php 
			include ("include/connect.php");
			$comp=mysql_query("SELECT `computer_name`, `ip_address` FROM `ip_addresses` WHERE `ip_address`='".$_SERVER[REMOTE_ADDR]."' LIMIT 1");
			if (mysql_num_rows($comp)<>1) { ?>
				<a href=# onclick="scan_comp_wmi('<?php echo $_SERVER["REMOTE_ADDR"]; ?>')">��� ���������</a>
			<?php 
			}else { 
				$comp=mysql_fetch_array($comp);
				$comp=mysql_query("SELECT `computer_name` FROM `computers` WHERE `computer_name`='".$comp[computer_name]."' LIMIT 1");
				$comp=mysql_fetch_array($comp);
				?>				
				<a href=# onclick="show_computer_button('<?php echo $comp['computer_name']; ?>')">��� ���������</a>
			<?php
			} ?>					
		</li>
		<li><a href=# onclick="online_button('off')"> ���� ������ </a></li>
	</ul>
	</fieldset>
	
	<?php if($_SESSION["group"]=="�������������") {?>
		
		<fieldset class="menu_fieldset">
		<legend class="menu_legend"> �������� ������� ������� </legend>
				<form id="comp_create">��� ���������� * <br/>
				<input type="text" id="comp_name" name="comp_name" value="<?php echo $_SESSION["comp_name"];unset($_SESSION["comp_name"]) ?>"> <br/>
				IP ����� <br/>
				<input type="text" id="ip_adr" name="ip_adr" value="<?php echo $_SESSION["ip_adr"];unset($_SESSION["ip_adr"]) ?>"> 
				<br/>
				�����<br/>
				<input type="text" id="otdel" name="otdel" value="<?php echo $_SESSION["otdel"];unset($_SESSION["otdel"]) ?>"><br/> 
				<div class="inputSubmit but_create" name="Create" onclick="create_comp_button()">�������</div>
				<p class="new_value"> ���� ��������� * ����������� � ���������� </p>
				</form>
				<p class="menu_online"> <a href=# onclick="online_button('on')"> ������� ��������� </a> </p>
</fieldset>
		
		<fieldset class="menu_fieldset">
		<legend class="menu_legend">  �������� ������� ������</legend>
		<?php require_once("include/select.php"); ?>
		</fieldset>
		<?php } ?>
</div>

<?php if($_SESSION["group"]=="�������������") {?>
<fieldset class="menu_fieldset menu2">
	<legend class="menu_legend">�����������������</legend>
	<form id="management_form" class="menu_admin1">
	<p>IP ���������� </p>
	<input type="text" name="ip" id="input_ip">
	<div class="inputSubmit but_reboot" onclick="reboot_comp_button()">�������������</div>
	<div class="inputSubmit but_reboot" onclick="shutdown_comp_button()">����������</div>
	</form>
	<p class="menu_admin2"> <a href=# onclick="service_button()"> ��������� �����</a> </p>
	<p class="menu_admin2"> <a href=# onclick="process_button()"> ��������� ���������</a> </p>
	<p class="menu_admin2"> <a href=# onclick="share_button()"> ����� ������ </a> </p>
</fieldset>
<?php } ?>

<fieldset class="menu_fieldset menu2">
<legend class="menu_legend"> ������� �������</legend>
<?php if($_SESSION["group"]=="�������������") {?><p> <a href='index.php?content=view&option=admin'> �������� �������� </a></p> <?php } ?>
<p> <a href='index.php?content=view&option=soft'> ����������� ����������� </a> </p>
</fieldset>

<fieldset class="menu_fieldset menu3">
<legend class="menu_legend">  ������ </legend>
<p> <a href="index.php?content=workPlace"> ������� ���������� </a> </p>
<?php if($_SESSION["user"]=="asu5") {  ?>
	<p> <a href="index.php?content=test"> testsss </a> </p>
	<p> <a href="index.php?content=spy"> SPY </a> </p>
<?php }  ?>
</fieldset>
</div>