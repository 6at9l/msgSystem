<?php
	session_start();
	$id = $_SESSION['user_id'];
	if ($_SESSION['user_id'] < 0)
	{
		echo "Страница не доступна";
		exit();
	}
	$db_name = "ij226533_msgsys";
    $host = "ij226533.mysql.ukraine.com.ua";
    $user = "ij226533_msgsys";
    $passDB = "bebpytse";
    $connect_db = mysql_connect($host, $user, $passDB) or die(mysql_error());
    mysql_select_db($db_name) or die (mysql_error());
    mysql_set_charset('utf8', $connect_db);
    $query = "DELETE FROM users WHERE id='" . $_POST["id"] . "'";
    mysql_query($query);
?>