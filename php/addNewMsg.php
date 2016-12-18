<?php
    session_start();
    $id = $_SESSION['user_id'];
    if (($id < 0) || (!(isset($_POST["target"]) && isset($_POST["date"]) && isset($_POST["msg"]))))
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
    $query = "INSERT INTO `msg` (`status`, `from_whom`, `whom`, `date_time`, `msg`)";
    $query .= " VALUES ('0', '$id', '$target', '$date', '$msg')";
    echo mysql_query($query) or die(mysql_error());
?>