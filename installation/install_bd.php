<?php
if ($_POST["install"]==1) {
	function parse_mysql_dump($url,$nowhost,$nowdatabase,$nowuser,$nowpass){
		$link = mysql_connect($nowhost, $nowuser, $nowpass);
		if (!$link) {
		   die('Нет соединения: ' . mysql_error());
		}

		// make foo the current db
		$db_selected = mysql_select_db($nowdatabase, $link);
		if (!$db_selected) {
		   mysql_query("CREATE DATABASE `".mysql_real_escape_string($nowdatabase)."` ") or die ('Can\'t use foo : ' . mysql_error());
		   $db_selected = mysql_select_db($nowdatabase, $link);
		}
		
		$contents = file_get_contents($url);

		$statements = explode(";", $contents);
		$statements = preg_replace("/\s/", ' ', $statements);

		foreach ($statements as $query) {
			if (trim($query) != '') {
				mysql_query($query) or die ('Can\'t use foo : ' . mysql_error());		
			}
		}
		echo mysql_error();    	
		file_put_contents('../configuration.php',"<?php \$host=\"$nowhost\"; \$user=\"$nowuser\"; \$password=\"$nowpass\"; \$db=\"$nowdatabase\" ?>");	
	}
	
	parse_mysql_dump("mysqlfile.sql",htmlspecialchars($_POST["host"]),htmlspecialchars($_POST["name_bd"]),htmlspecialchars($_POST["user_bd"]),htmlspecialchars($_POST["password_bd"]));
	echo "OK";
}
?>