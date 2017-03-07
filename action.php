<?php

	const PATH = __DIR__;
	// echo PATH;
	include PATH.'/MySQL.class.php';

	$db = MySQL::getMySQLObj('user');

	// var_dump($db);
	$list = $db->select();

	// var_dump($list);

	$username = $_POST['username'];

	$pwd = $_POST['pwd'];

	foreach ($list as $value) {
			
			$dsn = "mysql:host=localhost;dbname=test;charset=utf8";

			$pdo = new PDO($dsn, 'root', '');

		if($pwd == $value['pwd'] && $username == $value['username']) {

		
			//如果时间戳相等说明半小时过去，给他解封并且登录次数等于0;
				$time = time();

			if ($time > $value['time']) {

				$sql = "update user set status = 1,login = 1 where username='$username'";

				$row = $pdo->exec($sql);

			}

			if ($value['status'] == 2) {

			echo '<script>alert("账号暂时无法登陆")</script>';

			}else{

			echo '<script>alert("登录成功")</script>';

			}
			
		} else {

			echo '<script>alert("登录失败")</script>';

			$sql = "update user set login = login+1 where username = '$username'";

			$row = $pdo->exec($sql);
			//如果登录失败三次 记录下次解封时间并且状态等于2
			$time = time()+50;

			$sql = "update user set status =2,time=$time where login=3";
			// echo $sql;
			$row = $pdo->exec($sql);


			
		}
	}	

