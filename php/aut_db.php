<?php
	header('Content-Type: text/html; charset=utf-8');
    $log = "'" . $_POST['mail'] . "'";
    $pass = "'" . $_POST['pass'] . "'";
    
    $db_name = "ij226533_msgsys";
    $host = "ij226533.mysql.ukraine.com.ua";
    $user = "ij226533_msgsys";
    $passDB = "bebpytse";
    $connect_db = mysql_connect($host, $user, $passDB) or die(mysql_error());
    mysql_select_db($db_name) or die (mysql_error());
    mysql_set_charset('utf8', $connect_db);
    $query = "SELECT * FROM `users` WHERE `email` LIKE $log  AND `pass` LIKE $pass";
    $arr = mysql_query($query);
    $counter = 0;
    $user_id = -1;
    while($row = mysql_fetch_array($arr, MYSQL_ASSOC))
    {
        $counter++;
        $user_id = $row['id'];

    }
	mysql_close($connect_db);
    if ($counter === 1)
    {
        session_start();
        $_SESSION['user_id'] = $user_id;
		echo "Вы успешно авторизировались и будуте перенаправленны в личный кабинет через <span id='c'>5</span>";
    }
	else
	{
		echo "Не верный логин или пароль, вы будуте перенаправленны в личный кабинет через <span id='c'>5</span>";
	}
?>
<script>
	setInterval(function()
	{
		var val = +document.getElementById('c').innerHTML;
		if (val === 0){document.location.href = "/msgSystem";}
		else{document.getElementById('c').innerHTML = val - 1;}
	}, 1000);
</script>