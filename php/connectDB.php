<?php
    $db_name = "ij226533_msgsys";
    $host = "ij226533.mysql.ukraine.com.ua";
    $user = "ij226533_msgsys";
    $pass = "bebpytse";
    
    $connect_db = mysql_connect($host, $user, $pass) or die(mysql_error());
    mysql_select_db($db_name) or die (mysql_error());
    mysql_set_charset('utf8', $connect_db);
    $query = "SELECT * FROM `users`";
    $arr = mysql_query($query);
    while($row = mysql_fetch_array($arr, MYSQL_ASSOC))
    {
        echo $row['id'] . "<br>";
        echo $row['Surname'] . "<br>";
        echo $row['Name'] . "<br>";
        echo $row['middleName'] . "<br>";
        echo $row['department'] . "<br>";
        echo $row['position'] . "<br>";
        echo $row['email'] . "<br>";
        echo $row['phone'] . "<br>";
        echo $row['avatar'] . "<br>";
        echo $row['status'] . "<br>";
		echo "======<br>";
    }

    
    mysql_close($connect_db);

/*

		$counter = 0;
		while ($row = mysql_fetch_array($arr, MYSQL_ASSOC))
		{
			$counter++;
			$link = $row['link_to_file'];
			$quantity = $row['quantity'];
		}
        */
?>