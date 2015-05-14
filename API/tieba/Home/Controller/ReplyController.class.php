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
	//添加回复
	public function add(){
		$reply = M('Reply');
		$user = M('User');	
		$post = M('Post');	
		$data1['userId'] = $_COOKIE['userId'];
		$data2['replyTime'] = time();
		$id = I('id');
		$data['author'] = $user->where($data1)->getField('nickname');
		$data['content'] = I('content');
		$data['postId'] = $id;
		$data['pubTime'] = time();
		
		
		$result = $reply->add($data);//数据写入post表
		$result1 = $user->where($data1)->setInc('score',1);//用户积分加1
		$result2 = $post->where('id='.$id)->save($data2);//插入主题最近回复时间
		$result3 = $post->where('id='.$id)->setInc('replyNum',1);//回帖个数加1
		
		
//		echo $result;
		if($result && $result1 && $result2 &&$result3 ){
			$arr['errCode'] = 200;
			$arr['msg'] = '回复成功';
		}else{
			$arr['errCode'] = 108;
			$arr['msg'] = '回复失败';
		}
		echo json_encode($arr);
	}
	public function del(){
		$reply = M('Reply');
		$post = M('Post');
		$user = M('User');
		$id = I('id');
		$postId = I('postId');
		$author = I('author');
		$result = $reply->where('id='.$id)->delete();//删除回帖
		$result1 = $post->where('id='.$postId)->setDec('replyNum',1);//主题回帖数减1
//		$result2 = $user->where('nickname='.$author)->setDec('score',1);//回帖者积分减1
		if($result &&$result1 ){
			$arr['errCode'] = 200;
			$arr['msg'] = '删除成功';
		}else{
			$arr['errCode'] = 112;
			$arr['msg'] = '删除失败';
		}
		echo json_encode($arr);
	}
}