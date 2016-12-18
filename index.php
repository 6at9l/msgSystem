<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    if (!($_SESSION['user_id'] > -1))
	{
		include_once("template/aut.php");
		exit();
	}
    else
    {
        include_once("template/pp.php");
    }
   
?>