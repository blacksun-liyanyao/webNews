<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/1 0001
 * Time: 14:38
 */
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller{
    public function __construct(){
        header("Content-type: text/html; charset=utf8");
        parent::__construct();
    }

    public function getRank(){
        $conds['status'] = 1;
        $news = D("News")->getRank($conds,10);
        return $news;
    }

    public function error($message){
        $message = $message ? $message : "系统发生错误";
        $this->assign('message',$message);
        $this->display("Index/error");
    }
}