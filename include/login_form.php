<?php
$login_form = '
<form action="include/session.php" method="POST">
<p>Имя:</p> <input type="text" name="user">
<p>Пароль:</p>  <input type="password" name="userpassword" />
<input type="hidden" name="URL" value="'.$_SERVER["HTTP_HOST"].''.$_SERVER['REQUEST_URI'].'" />
<p><input type="submit" class="inputSubmit" name="login_form" value="Войти" /></p>
</form>
'; 

if(isset($_SESSION["user"])){
	$login_form = '
	Вы действительно хотите выйти?
	<form action="include/session.php" method="post">
	<input type="hidden" name="URL" value="'.$_SERVER["HTTP_HOST"].''.$_SERVER['REQUEST_URI'].'" />
	<input type="submit" name="exit" value="ВЫХОД С САЙТА">
	</form>
	';
}
echo $login_form ;
?>

