<?php
	session_start();
	$id = $_SESSION['user_id'];
	if ($_SERVER['REQUEST_URI'] !== "/msgSystem/" || $_SESSION['user_id'] < 0)
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
    $query = "SELECT * FROM `users` WHERE `id` = $id";
    $arr = mysql_query($query);
	while($row = mysql_fetch_array($arr, MYSQL_ASSOC))
    {
        $surname =  $row['Surname'];
        $name =  $row['Name'];
        $middleName =  $row['middleName'];
        $department =  $row['department'];
        $position =  $row['position'];
        $email =  $row['email'];
        $phone =  $row['phone'];
        $avatar =  $row['avatar'] === "" ? "images/icons_user/avatar.png" : $row['avatar'];
		$admin = $row['status'];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Тестовая страница</title>
        <link media="screen" href="css/styles.css" type="text/css" rel="stylesheet" />
		<link media="screen" href="css/fromProfile.css" type="text/css" rel="stylesheet" />
		<link media="screen" href="css/list.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
		<!-- Списки  **********************************************************-->
		<div class="newMsgList dialogs" id="newMsgList"></div>
		</div>
		<?php
			if ($admin == "0")
			{
		?>
		<button class="readProfileFormOpen"
		onclick="document.getElementById('readProfileFormAll').style.display = document.getElementById('readProfileFormAll').style.display === 'block' ? 'none' : 'block'";
		>Открыть редактирование</button>
		<div id="readProfileFormAll" class="readProfileFormAll">
		<?php
				$query = "SELECT * FROM `users` WHERE NOT `id` = $id";
				$arr = mysql_query($query);
				while($row = mysql_fetch_array($arr, MYSQL_ASSOC))
				{
		?>
						<form name="uId_<?php echo $row['id']; ?>">
							<table>
								<tr><td>Фамилия : </td>
									<td><input type="text" name="surname" value="<?php echo $row['Surname']; ?>" /></td>
								</tr>
								<tr><td>Имя : </td>
									<td><input type="text" name="name" value="<?php echo $row['Name']; ?>" /></td>				
								</tr>
								<tr><td>Отчество : </td>
									<td><input type="text" name="middleName" value="<?php echo $row['middleName']; ?>" /></td>
								</tr>
								<tr><td>Отдел : </td>
									<td><input type="text" name="department" value="<?php echo $row['department']; ?>" /></td>
								</tr>
								<tr><td>Должность : </td>
									<td><input type="text" name="position" value="<?php echo $row['position']; ?>" /></td>
								</tr>
								<tr><td>mail : </td>
									<td><input type="text" name="email" value="<?php echo $row['email']; ?>" /></td>
								</tr>
								<tr><td>Пароль : </td>
									<td><input type="password" name="pass" value="" /></td>
								</tr>
								<tr><td>телефон : </td>
									<td><input type="text" name="phone" value="<?php echo $row['phone']; ?>" /></td>
								</tr><td>статус :</td>
									<td colspan="">
										<input type="text" name="status" value="<?php echo $row['status']; ?>" />
									</td>
								<tr>
									<td colspan="2">
										<button onclick="readUser(event, 'uId_<?php echo $row['id']; ?>');return false;">Принять</button>
										<button onclick="del(event, 'uId_<?php echo $row['id']; ?>');return false;">Удалить</button>
									</td>
								</tr>
							</table>
						</form>			
		<?php
				}
		?>
						<form name="newUserCreate">
							<div style="text-align: center; font-size: 16pt;">Добавить</div>
							<table>
								<tr><td>Фамилия : </td>
									<td><input type="text" name="surname" value="" /></td>
								</tr>
								<tr><td>Имя : </td>
									<td><input type="text" name="name" value="" /></td>				
								</tr>
								<tr><td>Отчество : </td>
									<td><input type="text" name="middleName" value="" /></td>
								</tr>
								<tr><td>Отдел : </td>
									<td><input type="text" name="department" value="" /></td>
								</tr>
								<tr><td>Должность : </td>
									<td><input type="text" name="position" value="" /></td>
								</tr>
								<tr><td>mail : </td>
									<td><input type="text" name="email" value="" /></td>
								</tr>
								<tr><td>Пароль : </td>
									<td><input type="password" name="pass" value="" /></td>
								</tr>
								<tr><td>телефон : </td>
									<td><input type="text" name="phone" value="" /></td>
								</tr><td>статус :</td>
									<td colspan="">
										<input type="text" name="status" value="" />
									</td>
								<tr>
									<td colspan="2">
										<button onclick="readUser(event, 'newUserCreate');return false;">Принять</button>
									</td>
								</tr>
							</table>
						</form>		
		<?php
			}else{
				if ($admin == 2)
				{exit("ВЫ заблорикованны");}
			}
		?>
		</div>
		<!-- затенение -->
		<div id="shadow"></div>
		<div id="wrapper">                   
            <div id="sidebar"> 
                <div class="panel-side">
					<div id="FIO" class="user-bg">
						<span><?php echo $surname . " " . $name . " " . $middleName?></span>
					</div>
					<div id="Udep" class="user-bg">
						<span>Отдел : <?php echo $department?></span>
					</div>
					<div id="Upos" class="user-bg">
						<span>Должность : <?php echo $position?></span>
					</div>
					<div id="Umail" class="user-bg">
						<span>mail : <?php echo $email?></span>
					</div>
					<div id="Uphon" class="user-bg">
						<span>телефон : <?php echo $phone?></span>
					</div>
					<div class="avatar">
						<img id="Ulink" src="<?php echo $avatar?>">
					</div>
					<ul class="check-user">
						<li onclick="selectNewMsg();readMsg();">Обновить список сообщений</li>
						<li id="newMsgOpen">Написать сообщение</li>
						<li id="readProfileOpen">Редактировать профиль</li>
						<li id="exit">Выход</li>
					</ul>
                </div>                    
            </div>  
		</div>
		<div class="content" id="content">
		    <div class="footer" id="save_footer">                   
				<div class="status-bar">
					<span>
						
					</span>
					<span id="counter">
						НОВЫЕ 0
					</span>
					<span id="gifLoad_id">
						<img class="loads" src="images/load.gif">
					</span>
					
				</div>
			</div>
			<div  id="msgList"></div>
		</div>

		<!-- ФОРМЫ  **********************************************************-->
		<div id="readProfileForm" class="readProfileForm">
			<form name="uProfile">
				<table>
					<tr><td>Фамилия : </td>
						<td><input type="text" name="surname" value="<?php echo $surname ?>" /></td>
					</tr>
					<tr><td>Имя : </td>
						<td><input type="text" name="name" value="<?php echo $name ?>" /></td>				
					</tr>
					<tr><td>Отчество : </td>
						<td><input type="text" name="middleName" value="<?php echo $middleName ?>" /></td>
					</tr>
					<tr><td>Отдел : </td>
						<td><input type="text" name="department" value="<?php echo $department ?>" /></td>
					</tr>
					<tr><td>Должность : </td>
						<td><input type="text" name="position" value="<?php echo $position ?>" /></td>
					</tr>
					<tr><td>mail : </td>
						<td><input type="text" name="email" value="<?php echo $email ?>" /></td>
					</tr>
					<tr><td>Пароль : </td>
						<td><input type="password" name="pass" value="" /></td>
					</tr>
					<tr><td>телефон : </td>
						<td><input type="text" name="phone" value="<?php echo $phone ?>" /></td>
					</tr>
						<td colspan="2">
							<input type="file" name="avatar" value="avatar" />
						</td>
					<tr>
						<td colspan="2">
							<button id="accept">Принять</button>
							<button id="cancel">Отмена</button>
						</td>
					</tr>
				</table>
			</form>
		</div>

		<div id="newMsgForm" class="newMsgForm">
			<form name="uMsg">
				<table>
					<tr>
						<td>Кому : </td>
						<td>
							<select name="target">
								<option value="null" selected disabled>Выберите пользователя</option>
								<?php
									$query = "SELECT * FROM `users` WHERE NOT `id` = $id AND NOT `status` = 2";
									$arr = mysql_query($query);
									while($row = mysql_fetch_array($arr, MYSQL_ASSOC))
									{
										$id = $row['id'];
										$Surname = $row['Surname'];
										echo "<option value='$id'>";
										echo $Surname . " " . $row['Name'];
										echo trim($row['middleName']);
										echo "</option>";
									}
								?>
							</select>
						</td>
						<td>
							<input type="datetime-local" name="date" disabled="disabled"/>
						</td>				
					</tr>
					<tr>
						<td colspan="3">
							<textarea name="msg"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<button id="sendMsg">Отправить</button>
							<button id="cancelMsg">Отмена</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
    </body>
	<script src="js/globalVar.js"></script>
	<script src="js/userControl.js"></script>
	<script src="js/dialogControl.js"></script>
</html>
<?php mysql_close($connect_db); ?>