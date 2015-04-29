<?php
	
		
	
	//引入配置文件
	require 'config.php';
	//连接数据库
	$con = mysql_connect(DB_HOST,DB_USER,DB_PWD) or die('Could not connect: ' . mysql_error());
	mysql_select_db(DB_NAME,$con);
	//执行方法
	switch ($_GET['method']) {
		//上传文件
		case 'upload':
			if(count($_FILES) > 0){
				$f = $_FILES['file'];
				$filename = md5(uniqid(rand())) . '_' . $f['name'];
				$filePath = 'Uploads/' . $filename;
				move_uploaded_file($f['tmp_name'], $filePath);
				$arr = array(
					errCode => 200,
					msg => '上传成功',
					filename=>$filename
				);
			}else{
				$arr = array(
					errCode => 150,
					msg => '上传失败'
				);
			}
			break;
		//发表帖子
		case 'add':
			if($_COOKIE['userId']){
				if(!empty($_POST['title'])&&!empty($_POST['content'])){
						$title = htmlspecialchars(trim($_POST['title']));
						$content = htmlspecialchars(trim($_POST['content']));
						$pubtime = time();
						$userId = $_COOKIE['userId'];
						isset($_POST['pic'])?$pic=$_POST['pic']:$pic=null;
						$result = mysql_query("select * from user where userId='$userId'");
						while ($row = mysql_fetch_assoc($result)){
							$author = $row['nickname'];
						};
					$query = "insert into post (title,content,pubtime,author,pic) values('$title','$content','$pubtime','$author','$pic')";
					$result = mysql_query($query);
					if($result){
						//如果发表成功，积分加2
						$query = "update user set score=score+2 where userId='$userId'";
						$result = mysql_query($query);
						if($result){
							$arr = array(
								errCode => 200,
								msg => '发表成功'
							);
						}
						
					}else{
						$arr = array(
							errCode => 112,
							msg => '发表失败'
						);
					}
					
				}else{
					$arr = array(
						errCode => 113,
						msg => '标题和内容不能为空'
					);
				}
			}else{
				$arr = array(
					errCode => 105,
					msg => '用户未登录'
				);
			}
			break;
		//展示文章列表
		case 'showList':
			$result = mysql_query("select * from post order by id desc");//倒序查询
			//把数据循环插入数组
			while ($row = mysql_fetch_assoc($result)) {
				$arr1[] = array(
					'id'=>$row['id'],
					'title'=>$row['title'],
					'replytime'=>date('Y-m-d H:i:s',$row['replytime']),
					'author'=>$row['author'],
					'replynum'=>$row['replynum']
				);
			}
			$arr = array(
				'errCode' => 200,
				'msg'=>'查询成功', 
				'data' => $arr1
			);
			break;
		//显示主贴内容
		case 'showPost':
			if(!empty($_POST['id'])){
				$id = $_POST['id'];
				$result = mysql_query("select * from post where id='$id'");
				$row = mysql_fetch_assoc($result);
				$row['pubtime']=date('Y-m-d H:i:s',$row['pubtime']);
				$row['replytime']=date('Y-m-d H:i:s',$row['replytime']);
				$arr = array(
					'errCode' => 200,
					'msg'=>'查询成功', 
					'data' => $row
				);
			}
		break;
		//显示回帖内容
		case 'showReply':
			if(!empty($_POST['id'])){
				$id = $_POST['id'];
				$result = mysql_query("select * from reply where postid='$id'");
				while ($row = mysql_fetch_assoc($result)){
					$arr1[] = array(
						'id'=>$row['id'],
						'postid'=>$row['postid'],
						'content'=>$row['content'],
						'pubtime'=>date('Y-m-d H:i:s',$row['pubtime']),
						'author'=>$row['author'],
						'postid'=>$row['postid'],
						
					);
				};
				$arr = array(
					'errCode' => 200,
					'msg'=>'查询成功', 
					'data' => $arr1
				);
			}
			break;
		//回复帖子
		case 'reply':
			if($_COOKIE['userId']){
				if(!empty($_POST['id']) && !empty($_POST['content'])){
					$postid = trim($_POST['id']);
					$content = htmlspecialchars(trim($_POST['content']));
					$pubtime = time();
					$userId = $_COOKIE['userId'];
					$result = mysql_query("select * from user where userId='$userId'");
					while ($row = mysql_fetch_assoc($result)){
						$author = $row['nickname'];
					};
					$query = "insert into reply (content,pubtime,author,postid) values('$content','$pubtime','$author','$postid')";
					$result = mysql_query($query);
					if($result){
						//如果回复成功，积分加1
						mysql_query("update user set score=score+1 where  userId='$userId'");
						//主贴更新回复人
						mysql_query("update post set replyer='$author' where id='$postid'");
						//主贴更新回复时间
						mysql_query("update post set replytime='$pubtime' where id='$postid'");
						//主贴更新回帖数
						mysql_query("update post set replynum=replynum+1 where id='$postid'");
						
						$arr = array(
							errCode => 200,
							msg => '回复成功'
						);
						
					}else{
						$arr = array(
							errCode => 112,
							msg => '回复失败'
						);
					}
					
				}else{
					$arr = array(
						errCode => 113,
						msg => '标题和内容不能为空'
					);
				}
			}else{
				$arr = array(
					errCode => 105,
					msg => '用户未登录'
				);
			}
			break;
			//删除主题
			case 'delPost':
				$postid = trim($_POST['id']);
				if($postid){
					$result = mysql_query("delete from post where id='$postid'");
					if($result){
						$arr = array(
							errCode => 200,
							msg => '删除成功'
						);
					}else{
						$arr = array(
							errCode => 135,
							msg => '删除失败'
						);
					}
				}else{
					$arr = array(
						errCode => 136,
						msg => '参数错误'
					);
				}
			break;
			//删除回帖
			case 'delReply'	:
				$replyid = trim($_POST['id']);
				if($replyid){
					$result = mysql_query("delete from reply where id='$replyid'");
					if($result){
						$arr = array(
							errCode => 200,
							msg => '删除成功'
						);
					}else{
						$arr = array(
							errCode => 135,
							msg => '删除失败'
						);
					}
				}else{
					$arr = array(
						errCode => 136,
						msg => '参数错误'
					);
				}
			break;
	}
	
		
		//关闭连接数据库
		mysql_close($con);
	
	
	//输出json值
	echo json_encode($arr);