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

    $query = "";
    $query .= "SELECT ";
    $query .= "u.Surname, u.Name, u.middleName, u.id, u.avatar, ";
    $query .= "m.status, m.from_whom, m.whom, m.date_time, m.msg, m.id as ids ";
    $query .= "FROM users u ";
    $query .= "INNER JOIN msg m ON (m.from_whom = u.id OR m.whom = u.id) AND NOT u.id = $id ";
    $query .= "WHERE m.whom = $id AND m.status = 0 ";
    $query .= "ORDER BY m.date_time DESC";
    
    $arr = mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($arr, MYSQL_ASSOC))
    {
        echo "###dialogId" . $row["id"] . "@@@" . $row['msg'] . "@@@" . $row['date_time'] . "###";
?>
        <div id="helpVar_<?php echo $row['ids'] ?>" class='noShowMsg'>
			<div class='msgOne out' >
				<img src='<?php echo $row['avatar'] == "" ? "images/icons_user/avatar.png" : $row['avatar']; ?>' />
				<span><?php echo $row["Surname"] . " " . $row["Name"] . " " . $row["middleName"]; ?></span>
				<span><?php echo $row['date_time']; ?></span>
				<p><?php echo $row['msg']; ?></p>
			</div>
		</div>     
<?php
    }
?>
