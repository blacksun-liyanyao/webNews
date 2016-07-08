<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/5
 * Time: 15:44
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class AdminController extends CommonController{
    public function index(){
        $data = D("Admin")->getAdmins();
        $this->assign('data',$data);
        $this->display();
    }

    public function setStatus(){
        $data = array(
            'id' => intval($_POST['id']),
            'status' => $_POST['status']
        );
        return parent::setStatus($data,"Admin");
    }

    public function add(){
        if($_POST){
            if(!isset($_POST['username']) || !$_POST['username']){
                return show(0,"用户名不能为空");
            }
            if(!isset($_POST['password']) || !$_POST['password']){
                return show(0,"密码不能为空");
            }
            $_POST['password'] = getMd5Passord($_POST['password']);
            if(!isset($_POST['realname']) || !$_POST['realname']){
                return show(0,"真实姓名不能为空");
            }
            if(!isset($_POST['email']) || !$_POST['email']){
                return show(0,"电子邮箱不能为空");
            }
            $admin = D("Admin")->getAdminByUserName($_POST['username']);
            if($admin && $admin['status'] != -1){
                return show(0,"该用户名已存在");
            }
            $res = D("Admin")->insert($_POST);
            if($res){
                return show(1,"添加成功");
            }
            else{
                return show(0,"添加失败");
            }
        }
        $this->display();
    }

    public function personal(){
        $data = D("Admin")->getAdminByUserName($_SESSION['adminUser']['username']);
        $this->assign("data",$data);
        $this->display();
    }

    public function save(){
        $user = $this->getLoginUser();
        if(!$user){
            return show(0,"用户不存在");
        }

        $data['realname'] = $_POST['realname'];
        $data['email'] = $_POST['email'];
        try{
            $id = D("Admin")->updateByAdminInId($user['admin_id'],$data);
            if($id === false){
                return show(0,"配置失败");
            }
            else{
                return show(1,"配置成功");
            }
        }catch (Exception $e){
            return show(0,$e->getMessage());
        }
    }
}