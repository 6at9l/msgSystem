<?php
	session_start();
	$id = $_SESSION['user_id'];
	if (isset($_POST['arrId']) &&($_SESSION['user_id'] < 0))
	{
		exit();
	}
    $target = intval($_POST["target"]);
    $date = str_replace("T", " ", $_POST["date"]) . ":00";
    $msg = $_POST["msg"];
    
    $db_name = "ij226533_msgsys";
    $host = "ij226533.mysql.ukraine.com.ua";
    $user = "ij226533_msgsys";
    $passDB = "bebpytse";
    $connect_db = mysql_connect($host, $user, $passDB) or die(mysql_error());
    mysql_select_db($db_name) or die (mysql_error());
    mysql_set_charset('utf8', $connect_db);
    $query = "INSERT INTO `users` (`Surname`, `Name`, `middleName`, `department`, `position` , `email`, `phone`, `avatar`, `status`, `pass`)";
    $query .= " VALUES (";
	if (isset($_POST["surname"]))
    {
        $temp = $_POST["surname"];
        $query .= "'$temp',";
    }
    
    
    if (isset($_POST["name"]))
    {
        $temp = $_POST["name"];
        $query .= "'$temp',";
    }
    
    if (isset($_POST["middleName"]))
    {
        $temp = $_POST["middleName"];
        $query .= "'$temp',";
    }
    
    if (isset($_POST["department"]))
    {
        $temp = $_POST["department"];
        $query .= "'$temp',";
    }
    
    if (isset($_POST["position"]))
    {
        $temp = $_POST["position"];
        $query .= "'$temp',";
    }
    
    if (isset($_POST["email"]))
    {
        $temp = $_POST["email"];
        $query .= "'$temp',";
    }
    
    if (isset($_POST["phone"]))
    {
        $temp = $_POST["phone"];
        $query .= "'$temp',";
    }
        $query .= "'',";
    
    if (isset($_POST['status']))
    {
        $temp = $_POST["status"];
        $query .= "'$temp',";
	}

    if (isset($_POST["pass"]))
    {
        $query .= "'$temp',";
    }

	$query = substr($query, 0, strlen($query) - 1) . ")";

	echo mysql_query($query) or die(mysql_error());
?>