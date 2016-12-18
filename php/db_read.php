<?php
    session_start();
	$id = $_SESSION['user_id'];
    if($id < 0)
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
	
	$qMe = "SELECT `Surname`, `Name`, `middleName`, `avatar` FROM `users` WHERE `id` = $id";
	$qMeData = mysql_query($qMe) or die(mysql_error());
	$uData["FOI"] = "";
	$uData["ava"] = "";
	
	while($row1 = mysql_fetch_array($qMeData, MYSQL_ASSOC))
	{
		$uData["FOI"] = $row1['Surname'] . " " . $row1['Name'] . " " . $row1['middleName'];
		$uData["ava"] = $row1['avatar'];
		break;
	}
	
    $query = "SELECT u.Surname, u.Name, u.middleName, u.id, u.avatar, m.status, m.from_whom, m.whom, m.date_time, m.msg , m.id AS ids ";
	$query .= "FROM users u ";
	$query .= "INNER JOIN msg m ON  (m.from_whom = u.id OR m.whom = u.id) AND NOT u.id = $id ";
	$query .= "WHERE m.from_whom = $id OR m.whom = $id ";
	$query .= "ORDER BY m.date_time DESC";
    $arr = mysql_query($query) or die(mysql_error());
	
	$dataArr['-100'] = array(array(
		"ava" => "",
		"status" => 0, 
		"whom" => "",
		"time" => "",
		"msg" => "")); 
	
	while($row = mysql_fetch_array($arr, MYSQL_ASSOC))
    {
		$flag = 0;
		foreach ($dataArr as $key => $value)
		{
			if ($key == $row["id"])
			{
				$dataArr[$key][count($dataArr[$key])] = array(
					"idMsg" => $row["ids"],
					"ava" => $row["whom"] == strval($id) ? $row["avatar"] : $uData["ava"],
					"SNM" => $row["Surname"] . " " . $row["Name"] . " " . $row["middleName"],
					"status" => $row["whom"] == strval($id) ? $row["status"] : 1,
					"whom" => $row["whom"] == strval($id) ? $row["Surname"] . " " . $row["Name"] . " " . $row["middleName"] : $uData["FOI"],
					"time" => $row["date_time"],
					"msg" => $row["msg"]);
				$flag = 1;
				break;
			}
		}
		if ($flag == 0)
		{
			$dataArr[$row["id"]] = array(array(
				"idMsg" => $row["ids"],
				"ava" => $row["whom"] == strval($id) ? $row["avatar"] : $uData["ava"],
				"SNM" => $row["Surname"] . " " . $row["Name"] . " " . $row["middleName"], 
				"status" => $row["whom"] == strval($id) ? $row["status"] : 1,
				"whom" => $row["whom"] == strval($id) ? $row["Surname"] . " " . $row["Name"] . " " . $row["middleName"] : $uData["FOI"],
				"time" => $row["date_time"],
				"msg" => $row["msg"]));
		}
		
    }
?>

<?php
	foreach($dataArr as $k => $v)
	{
		if ($k == "-100"){continue;}
?>
		<div id="for_insert_<?php echo $k ?>" class='dialogs'>
			<div class='control'>
				<button class='open'></button>
				<span>Диалог с <?php echo $v[0]['SNM']; ?></span>	
			</div>
<?php
		$count_a = count($v);
		for ($i = 0; $i < $count_a; $i++)
		{
?>
			<div id="helpVar_<?php echo $v[$i]['idMsg'] ?>" class='noShowMsg'>
				<div <?php echo "class='msgOne " . ($v[$i]['status'] == 1 ? "in" : "out") . "'"; ?> >
					<img src='<?php echo $v[$i]['ava'] == "" ? "images/icons_user/avatar.png" : $v[$i]['ava']; ?>' />
					<span><?php echo $v[$i]['whom']; ?></span>
					<span><?php echo $v[$i]['time']; ?></span>
					<p><?php echo $v[$i]['msg']; ?></p>	
				</div>
			</div>
<?php 	}
		echo "</div>";
	}
?>
		