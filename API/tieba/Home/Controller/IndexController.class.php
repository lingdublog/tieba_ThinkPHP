<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $a ='2222';
		$b = array(
			'aa'=>'111',
			'bb'=>'333'
		);
		$this->assign('b',$b);
		$this->display();
    }
}