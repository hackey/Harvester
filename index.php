<?php 
session_start();
header("Content-type: text/html; charset=windows-1251");

?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once("include/meta.php"); ?>
</head>
<body>
<?php require_once("include/header.php"); ?>
<div id="content_main" class="main_center">
<noscript>
<div class="error">
<h2 style="color: red;">Пожалуйста, включите JavaScript! <a href="http://www.google.ru/support/bin/answer.py?answer=23852">Как?</a></h2>
</div>
</noscript>	
<?php 
$Headers = @get_headers("HTTP://".$_SERVER["HTTP_HOST"]."/configuration.php");
$Headers1 = @get_headers("HTTP://".$_SERVER["SERVER_ADDR"]."/".$_SERVER["HTTP_HOST"]."/configuration.php");
if (strpos($Headers[0], '200') or strpos($Headers1[0], '200')) {
	switch ($_GET["content"]) {
		case 'menu';require_once 'page/menu.php';break;
		case 'view';require_once 'page/table.php';break;
		case 'new';require_once 'page/new.php';break;
		case 'hard';require_once 'page/edit.php';break;
		case 'Service';require_once 'page/Service.php';break;
		case 'Process';require_once 'page/Process.php';break;
		case 'share';require_once 'page/share.php';break;
		case 'test';require_once 'include/test.php';break;
		case 'spy';require_once 'spy.php';break;
		case 'panel_admin';require_once 'page/panel_admin.php';break;
		case 'register';require_once 'page/register.php';break;
		case 'workPlace';require_once 'reports/workPlace.php';break;
		default: require_once 'page/main.php';break;
	}	
} else {	
require_once 'installation/index.php';	
}
?>
</body>
</html>