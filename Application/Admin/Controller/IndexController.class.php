<?php
/**
 * 后台Index相关
 */
namespace Admin\Controller;
use Home\Controller\CommonController;
use Think\Controller;
class IndexController extends CommonController {
    
    public function index(){
        $news = D("News")->countMax();
        $newsCount = D("News")->getNewsCount(array('status'=>1));
        $positionCount = D("Position")->getPositionCount(array('status'=>1));
        $adminCount = D("Admin")->getLastLoginUsers();
        $this->assign('result',array(
            'news' => $news,
            'newsCount' => $newsCount,
            'positionCount' => $positionCount,
            'adminCount' => $adminCount
        ));
    	$this->display();
    }

    public function main() {
    	$this->display();
    }
}