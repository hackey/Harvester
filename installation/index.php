<h1>Добро пожаловать в программу Harvester</h1>
<fieldset  id="step1" class="menu_fieldset" <?php $Headers = @get_headers("HTTP://".$_SERVER["HTTP_HOST"]."/configuration.php"); if(strpos($Headers[0], '200')) { echo "style=\"display:none;\"";} ?> >
	<legend><h2> Первый шаг: Настройки Mysql базы </h2></legend>
		<form id="installbd">
		<p>Сервер</p>
		<input type="text" name="host">
		<p>Имя базы данных</p>
		<input type="text" name="name_bd">
		<p>Пользователь</p>
		<input type="text" name="user_bd">
		<p>Пароль</p>
		<input type="password" name="password_bd">
		<div type="submit" class="inputSubmit" onclick="install_bd()" style="width: 50px; margin-top: 4px;">ОК</div>
	</form>
</fieldset>


<fieldset   id="step2" class="menu_fieldset" <?php if(strpos($Headers[0], '200')) {echo "style=\"display:block;\"";} else {echo "style=\"display:none;\"";} ?>>
	<legend><h2> Второй шаг: Создание администратора сайта </h2></legend>
	<form id="installuser">		
		<p>Имя </p>
		<input type="text" name="name_admin">
		<p>Пароль</p>
		<input type="password" name="password1_admin">
		<p>Ещё раз пароль</p>
		<input type="password" name="password2_admin">		
		<div type="submit" class="inputSubmit" onclick="install_user()" style="width: 50px; margin-top: 4px;">ОК</div>
	</form>
</fieldset>

<script>
function install_bd() {
	var form_data=$('#installbd').serialize();
	$("#loading").show();
	$.ajax({
		type: "POST",
		data: "install=1&"+form_data,
		url: "installation/install_bd.php",
		datatype: "html",
		success: function(msg) {
			$("#loading").hide();
			if (msg=="OK") {
			$('#step2').show();
			$('#step1').hide();
			message_window("База данных успешно создана");		
			} else  message_window(msg);			
		}		
	});
}

function install_user() {
	var form_data=$('#installuser').serialize();
	$("#loading").show();
	$.ajax({
		type: "POST",
		data: "create_admin=1&"+form_data,
		url: "installation/create_admin.php",
		datatype: "html",
		success: function(msg) {
			$("#loading").hide();
			if (msg=="OK") {
			$('#step2').hide();
			$('#step1').hide();
			message_window("Вы успешно зарегистрированы.");
			} else  message_window(msg);		
		}		
	});
}
</script>

