<?php
namespace Home\Controller;
use Think\Controller;
class PostController extends Controller {
    public function index(){
        
    }
	//展示帖子列表
	public function showList(){
		$pageIndex = I('pageIndex');
		$pageNum = I('pageNum');
		$post = M('Post');
		$data = $post->order('id desc')->page($pageIndex,$pageNum)->select();
//		print_r($data);
		foreach($data as $k=>$v){
			$data[$k]['replyTime'] = date('Y-m-d H:i:s',$data[$k]['replyTime']);
//			print_r($v['pubTime']) ;
		}
//		print_r($data);
		$arr['errCode'] = 200;
		$arr['msg'] = '查询成功';
		$arr['data'] = $data;
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
	//展示主题
	public function show(){
		$post = M('Post');
		$id = I('id');
		$data = $post->field('id,title,content,author,pubTime')->where('id='.$id)->select();
		if($data){
			$data[0]['pubTime'] = date('Y-m-d H:i:s',$data[0]['pubTime']);
			$arr['errCode'] = 200;
			$arr['msg'] = '查询成功';
			$arr['data'] = $data[0];
		}else{
			$arr['errCode'] = 108;
			$arr['msg'] = '查询失败';
		}
		echo json_encode($arr);
	}
	
	//更新主题 
	public function update(){
		$user = M('User');
		$post = M('Post');
		
		$data1['userId'] = $_COOKIE['userId'];
		
		$data['id'] = I('id');
		$data['author'] = $user->where($data1)->getField('nickname');
		$data['title'] = I('title');
		$data['content'] = I('content');
		$data['pic'] = I('pic');
		$data['updateTime'] = time();
		
		
		$result = $post->save($data);//数据写入post表
		
		
		if($result){
			$arr['errCode'] = 200;
			$arr['msg'] = '发表成功';
		}else{
			$arr['errCode'] = 108;
			$arr['msg'] = '发表失败';
		}
		echo json_encode($arr);
	}
	
	//删除主题
	public function del(){
		$reply = M('Reply');
		$post = M('Post');
		$id = I('id');
		$result = $post->where('id='.$id)->delete();
		$result1 = $reply->where('postId='.$id)->delete();
		if($result && $result1){
			$arr['errCode'] = 200;
			$arr['msg'] = '删除成功';
		}else{
			$arr['errCode'] = 112;
			$arr['msg'] = '删除失败';
		}
		echo json_encode($arr);
	}
}