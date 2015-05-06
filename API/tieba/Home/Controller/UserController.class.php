<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    public function index(){
        
    }
	public function getUserInfo(){
		$userId = I('userId');
		$user = M('User');
		$condition['userId'] = $userId;
		$data = $user->where($condition)->select();
		$arr['errCode'] = 200;
		$arr['msg'] = '查询成功';
		$arr['data'] = $data[0];
		echo json_encode($arr);
	}
}