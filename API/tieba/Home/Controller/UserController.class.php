<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    public function index(){
        
    }
	//获取用户信息
	public function getUserInfo(){
		$userId = $_COOKIE['userId'];
		if($userId){
			$user = M('User');
			$condition['userId'] = $userId;
			$data = $user->field('id,username,nickname,score')->where($condition)->select();
			$arr['errCode'] = 200;
			$arr['msg'] = '查询成功';
			$arr['data'] = $data[0];
		}else{
			$arr['errCode'] = 108;
			$arr['msg'] = '用户未登录';
		}
		
		echo json_encode($arr);
	}
	//登录
	public function login(){
		$username = I('username');
		$password = I('password');
		$user = M('User');
		$condition['username'] = $username;
		$condition['password'] = md5($password);
		$data = $user->field('id,userId,nickname')->where($condition)->select();
//		print_r($data);
		if($data){
			$arr['errCode'] = 200;
			$arr['msg'] = '登录成功';
			$arr['data'] = $data[0];
		}else{
			$arr['errCode'] = 105;
			$arr['msg'] = '用户名或密码错误';
		}
		echo json_encode($arr);
	}
	//注册
	public function register(){
		$username = I('username');
		$password = I('password');
		$nickname = I('nickname');
		$regtime = time();
		$userId = md5($username.'tb');
		$user = M('User');
		$data['username'] = $username;
		$data['password'] = md5($password);
		$data['nickname'] = $nickname;
		$data['regTime'] = $regtime;
		$data['userId'] = $userId;
		$result = $user->add($data);
//		echo json_encode($result);
		if($result>0){
			$arr = array(
				'errCode'=>200,
				'msg'=>'注册成功'
			);
		}else{
			$arr = array(
				'errCode'=>101,
				'msg'=>'注册失败'
			);
		}
		echo json_encode($arr);
	}
}