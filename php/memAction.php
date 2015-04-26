<?php
	//引入配置文件
	require 'config.php';
	//连接数据库
	$con = mysql_connect(DB_HOST,DB_USER,DB_PWD) or die('Could not connect: ' . mysql_error());
	mysql_select_db(DB_NAME,$con);
	//执行方法
	switch ($_GET['method']) {
		//注册
		case 'add':
			if(!empty($_POST['username'])&&!empty($_POST['password'])&&!empty($_POST['nickname'])){
				if(!empty($_POST['username'])){
					$username = trim($_POST['username']);
					$userId = md5($username);
				};
				if(!empty($_POST['password'])){
					$password = md5(trim($_POST['password']));
				};
				if(!empty($_POST['nickname'])){
					$nickname = trim($_POST['nickname']);
				};
				$regtime = time();
				$query = "insert into user values('','$username','$password','$nickname','$regtime','$userId')";
				$result = mysql_query($query);
				if($result){
					$arr = array(
						errCode => 200,
						msg => '提交成功'
					);
				}else{
					$arr = array(
						errCode => 103,
						msg => '提交失败'
					);
				}
				
			}else{
				$arr = array(
					errCode => 104,
					msg => '用户名，密码，昵称不能为空'
				);
			}
			
			
			
			break;
		//展示会员列表
		case 'show':
			$result = mysql_query("select * from user");
			while ($row = mysql_fetch_assoc($result)) {
				$row['username']?$username=$row['username']:$username=null;
				$row['nickname']?$nickname=$row['nickname']:$nickname=null;
				$row['regtime']?$regtime=date('Y-m-d H:i:s',$row['regtime']):$regtime=null;
				$arr1[] = array(
					'id'=>$row['id'],
					'username'=>$username,
					'nickname'=>$nickname,
					'regtime'=>$regtime
				);
			}
			$arr = array(
				'errCode' => 200, 
				'data' => $arr1
			);
			break;
		//登录
		case 'login':
			if(isset($_POST['username'])){
				$username = trim($_POST['username']);
			};
			if(isset($_POST['password'])){
				$password = trim($_POST['password']);
			};
			$query = "select * from user where username='$username'";
			$result = mysql_query($query);
			$row = mysql_num_rows($result);
			//	如果数据库里有数据
			if($row != 0){
				while ($row = mysql_fetch_assoc($result)){
					$password1 = $row['password'];
					$userId = $row['userId'];
					$nickname = $row['nickname'];
				};
				//如果密码匹配
				if(md5($password)==$password1){
					$arr1 = array(
						nickname => $nickname,
						userId => $userId
					);
					$arr = array(
						errCode => 200,
						msg => '登录成功',
						data => $arr1
					);
				}else{
					$arr = array(
						errCode => 101,
						msg => '用户名或密码错误'
					);
				}
			}else{
				$arr = array(
					errCode => 102,
					msg => '该用户未注册'
				);
			}
			
			break;
			//显示用户信息
		case 'userInfo':
			$userId = $_COOKIE['userId'];
			if($userId){
				$query = "select * from user where userId='$userId'";
				$result = mysql_query($query);
				$row = mysql_fetch_assoc($result);
				$arr = array(
					errCode => 200,
					msg => '查询成功',
					data=>$row
				);
			}else{
				$arr = array(
					errCode => 105,
					msg => '用户未登录'
				);
			}
			break;
	}
	
	
	//关闭连接数据库
	mysql_close($con);
	
	//输出json值
	echo json_encode($arr);
	