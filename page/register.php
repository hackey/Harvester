<h2> ����������� </h2>
<div class="register">
<p>��� ���� ����������� � ����������. </br> ��� ������� ����� �������� � ����������� ���.</p>
<form action="include/checks.php" method="POST">
<p>��� �������:</p>
<input class="reg_inp" name="key_invait" type="text"></br>
<p>��� ������������:</p>
<input class="reg_inp" name="user" type="text" value="<?php echo $_SESSION['user_reg']; unset($_SESSION['user_reg']);?>" ></br>
<p>������:</p>
<input class="reg_inp" name="pass1" type="password"></br>
<p>������ ��� ���:</p>
<input class="reg_inp" name="pass2" type="password"></br>
<p><input name="create_user" type="submit" class="inputSubmit register_button" value="������������������"></p>
<?php echo '<input type="hidden" name="URL" value="'.$_SERVER["HTTP_HOST"].''.$_SERVER['REQUEST_URI'].'" />' ?>
</form>
</div>