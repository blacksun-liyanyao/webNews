<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/27
 * Time: 10:16
 */
namespace Admin\Controller;
use Think\Controller;
//use Think\Exception;

class PositionController extends CommonController{
    public function index(){
        $page = $_REQUEST['p']?$_REQUEST['p']:1;
        $pageSize = $_REQUEST['pageSize']?$_REQUEST['pageSize']:3;
        $position = D("Position")->getPosition($page,$pageSize);
        $positionCount = D("Position")->getPositionCount();
        $res = new \Think\Page($positionCount,$pageSize);
        $pageRes = $res->show();
        $this->assign('pageRes',$pageRes);
        $this->assign('positions',$position);
        $this->display();
    }
    public function add(){
        if($_POST) {
            if (!$_POST['name']) {
                return show(0, "名称不能为空");
            }
            if (!$_POST['description']) {
                return show(0, "描述不能为空");
            }
            if ($_POST["id"]) {
                return $this->save($_POST);
            }
            $data = $_POST;
            $data['create_time'] = time();
            $res = D("Position")->add($data);
            if ($res) {
                return show(1, "添加成功");
            }
            return show(0,"添加失败");
        }
        else{
            $this->display();
        }

    }
    public function edit(){
        $positionId = $_GET['id'];
        $position = D("Position")->find($positionId);
        $this->assign('vo',$position);
        $this->display();
    }

    public function save($data){
        $id= $data['id'];
        unset($data["id"]);
        try{
            $Pid = D("Position")->updatePositionById($id,$data);
            if($Pid === false){
                return show(0,"更新失败");
            }
            return show(1,"更新成功");
        }catch(Exception $e) {
            return show(0,$e->getMessage());
        }
    }

    public function setStatus(){
        $data = array(
            'id' => intval($_POST['id']),
            'status' => $_POST['status']
        );
        return parent::setStatus($data,"Position");
    }
}