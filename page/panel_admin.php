<?php
if(!isset($_SESSION["user"])) {
	echo "Доступ ограничен";
	exit;
}
require_once("include/connect.php"); 
if($_POST["save_group"]) {
	$query = "UPDATE `users_vts_admin` SET `group`='".$_POST["list_group"]."' WHERE name_admin='".$_POST["name_user"]."' ";
	mysql_query($query) or die (mysql_error()); 
}
?>
<h2> Административная панель </h2>

<?php if($_SESSION["group"]=="Администратор") {?>
	<div class="panel_admin_left">
	<form method="POST" action="include/checks.php">
	<input type="text" name="invait"></br>
	<input type="submit" class="inputSubmit" value="Создать ключ доступа" name="create_key">
	<?php echo '<input type="hidden" name="URL" value="'.$_SERVER["HTTP_HOST"].''.$_SERVER['REQUEST_URI'].'" />' ?>
	</form> 
	<p>Ключ действует до регистрации пользователя! </p>
	<p>Может содержать только латинские буквы, цифры _ -</p>
	</div>

	<div class="panel_admin_left">
	Зарегистрированные пользователи 
	<?php 

	$result=mysql_query("SELECT `ip` , `name_admin`, `group` FROM `users_vts_admin`");
	while ($row=mysql_fetch_array($result)) { ?>
	<form method="POST">
	<div class="user_group"><?php	echo "<p> <input type=\"hidden\" name=\"name_user\" value='". $row["name_admin"] ."'>$row[name_admin] <span> $row[ip] </span></p>";?></div>
	<select class="user_group" name="list_group">
	<option disabled selected><?php echo $row["group"]; ?></option>
	<option>Администратор</option>
	<option>Пользователь</option>
	</select>

	<input type="submit" value="Сохранить" name="save_group" />
	</form><div class="clear"></div>
	<?php
	}
	?>
	</div>
<?php } ?>

<div class="panel_admin_left">
<form method="POST" action="include/checks.php">
<p>Текущий пароль:</p><input type="password" name="pass_old"></br>
<p>Новый пароль:</p><input type="password" name="pass_new1"></br>
<p>Пароль ещё раз:</p><input type="password" name="pass_new2"></br>
<input type="submit" class="inputSubmit" value="Изменить" name="change_pass">
<?php echo '<input type="hidden" name="URL" value="'.$_SERVER["HTTP_HOST"].''.$_SERVER['REQUEST_URI'].'" />' ?>
</form>
</div>