<?php
$login_form = '
<form action="include/session.php" method="POST">
<p>���:</p> <input type="text" name="user">
<p>������:</p>  <input type="password" name="userpassword" />
<input type="hidden" name="URL" value="'.$_SERVER["HTTP_HOST"].''.$_SERVER['REQUEST_URI'].'" />
<p><input type="submit" class="inputSubmit" name="login_form" value="�����" /></p>
</form>
'; 

if(isset($_SESSION["user"])){
	$login_form = '
	�� ������������� ������ �����?
	<form action="include/session.php" method="post">
	<input type="hidden" name="URL" value="'.$_SERVER["HTTP_HOST"].''.$_SERVER['REQUEST_URI'].'" />
	<input type="submit" name="exit" value="����� � �����">
	</form>
	';
}
echo $login_form ;
?>

