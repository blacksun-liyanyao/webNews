<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/30 0030
 * Time: 16:21
 */
namespace Admin\Controller;
use Think\Controller;

class BasicController extends CommonController{

    public function index(){
        $result = D("Basic")->select();
        $this->assign('type',1);
        $this->assign("vo",$result);
        $this->display();
    }

    public function add(){
        if($_POST){
            if(!$_POST['title']){
                show(0,"站点信息不能为空");
            }
            if(!$_POST['keywords']){
                show(0,"站点关键词不能为空");
            }
            if(!$_POST['description']){
                show(0,"站点描述不能为空");
            }
            D("Basic")->save($_POST);
            return show(1,"配置成功");
        }
        else {
            return show(0, "没有数据提交");
        }
    }

    public function cache(){
        $this->assign('type',2);
        $this->display();
    }
}