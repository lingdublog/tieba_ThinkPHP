<?php
namespace Home\Controller;
use Think\Controller;
class PostController extends Controller {
    public function index(){
        
    }
	public function showList(){
		$post = M('Post');
		$data = $post->order('id desc')->select();
		$arr['errCode'] = 200;
		$arr['msg'] = '查询成功';
		$arr['data'] = $data;
		echo json_encode($arr);
	}
}