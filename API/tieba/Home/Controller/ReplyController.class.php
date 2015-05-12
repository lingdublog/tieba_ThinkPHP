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
		$reply = M('Reply');
		$user = M('User');	
		$data1['userId'] = $_COOKIE['userId'];
		
		$data['author'] = $user->where($data1)->getField('nickname');
		$data['content'] = I('content');
		$data['postId'] = I('id');
		$data['pubTime'] = time();
		
		
		$result = $reply->add($data);//数据写入post表
		$result1 = $user->where($data1)->setInc('score',1);//用户积分加1
		
		
//		echo $result;
		if($result && $result1){
			$arr['errCode'] = 200;
			$arr['msg'] = '回复成功';
		}else{
			$arr['errCode'] = 108;
			$arr['msg'] = '回复失败';
		}
		echo json_encode($arr);
	}
	public function del(){
		
	}
}