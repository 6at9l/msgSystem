<?php
	session_start();
	$id = $_SESSION['user_id'];
	if (isset($_POST['arrId']) &&($_SESSION['user_id'] < 0))
	{
		exit();
	}
    $arr = explode("|", $_POST['arrId']);
	$query = "UPDATE `msg` SET `status` = 1 WHERE ";
	for ($i = 0; $i < count($arr); $i++)
	{
		$query .= "`id` = '" . $arr[$i] . "' OR ";
	}
	$query = substr($query, 0, strlen($query) - 3);
	echo $query;
	$db_name = "ij226533_msgsys";
    $host = "ij226533.mysql.ukraine.com.ua";
    $user = "ij226533_msgsys";
    $passDB = "bebpytse";
    $connect_db = mysql_connect($host, $user, $passDB) or die(mysql_error());
    mysql_select_db($db_name) or die (mysql_error());
    mysql_set_charset('utf8', $connect_db);
	$qMeData = mysql_query($query) or die(mysql_error());
?>