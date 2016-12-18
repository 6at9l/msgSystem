<?php
    session_start();
	$id = $_SESSION['user_id'];
    if ($id < 0)
    {
        exit();
    }
    $db_name = "ij226533_msgsys";
    $host = "ij226533.mysql.ukraine.com.ua";
    $user = "ij226533_msgsys";
    $passDB = "bebpytse";
    $connect_db = mysql_connect($host, $user, $passDB) or die(mysql_error());
    mysql_select_db($db_name) or die (mysql_error());
    mysql_set_charset('utf8', $connect_db);
    $query = "UPDATE `users` SET ";
    //$arr = mysql_query($query);
    if (isset($_POST["surname"]))
    {
        $temp = $_POST["surname"];
        $query .= "`Surname` = '$temp',";
    }
    
    
    if (isset($_POST["name"]))
    {
        $temp = $_POST["name"];
        $query .= "`Name` = '$temp',";
    }
    
    if (isset($_POST["middleName"]))
    {
        $temp = $_POST["middleName"];
        $query .= "`middleName` = '$temp',";
    }
    
    if (isset($_POST["department"]))
    {
        $temp = $_POST["department"];
        $query .= "`department` = '$temp',";
    }
    
    if (isset($_POST["position"]))
    {
        $temp = $_POST["position"];
        $query .= "`position` = '$temp',";
    }
    
    if (isset($_POST["email"]))
    {
        $temp = $_POST["email"];
        $query .= "`email` = '$temp',";
    }
    
    if (isset($_POST["phone"]))
    {
        $temp = $_POST["phone"];
        $query .= "`phone` = '$temp',";
    }
    
    if (isset($_POST['status']))
    {
        $temp = $_POST["status"];
        $query .= "`status` = '$temp',";
	}

    if (isset($_POST["pass"]))
    {
        $temp = $_POST["pass"];
        if ($temp != "")
        {
             $query .= "`pass` = '$temp',";
        }
    }
    $query = substr($query, 0, strlen($query) - 1);
    $query .= " WHERE `id` = '" . $_POST['id'] . "'";
    echo $query;
    $arr = mysql_query($query);
    //echo $arr;
?>