<?php
namespace Home\Controller;
use Think\Controller;
class ReplyController extends Controller {
    public function index(){
        
    }
	//展示回帖列表
	public function showList(){
		$postId = I('id');
		$pageIndex = I('pageIndex');
		$pageNum = I('pageNum');
		$Reply = M('Reply');
		$data = $Reply->page($pageIndex,$pageNum)->where('postId='.$postId)->select();
		$replyCount = $Reply->where('postId='.$postId)->count();
//		print_r($data);
		if($data){
			foreach($data as $k=>$v){
				$data[$k]['pubTime'] = date('Y-m-d H:i:s',$data[$k]['pubTime']);
	//			print_r($v['pubTime']) ;
			}
	//		print_r($data);
			$arr['errCode'] = 200;
			$arr['msg'] = '查询成功';
			$arr['replyCount'] = $replyCount;
			$arr['data'] = $data;
		}else{
			$arr['errCode'] = 108;
			$arr['msg'] = '查询失败';
		}
		
		echo json_encode($arr);
	}
	//添加主题
	public function add(){
		$user = M('User');
		$post = M('Post');
		
		$data1['userId'] = $_COOKIE['userId'];
		
		$data['author'] = $user->where($data1)->getField('nickname');
		$data['title'] = I('title');
		$data['content'] = I('content');
		$data['pic'] = I('pic');
		$data['pubTime'] = time();
		$data['replyTime'] = time();
		
		
		$result = $post->add($data);//数据写入post表
		$result1 = $user->where($data1)->setInc('score',2);//用户积分加3
		
		
//		echo $result;
		if($result && $result1){
			$arr['errCode'] = 200;
			$arr['msg'] = '发表成功';
		}else{
			$arr['errCode'] = 108;
			$arr['msg'] = '发表失败';
		}
		echo json_encode($arr);
	}
	public function del(){
		
	}
}