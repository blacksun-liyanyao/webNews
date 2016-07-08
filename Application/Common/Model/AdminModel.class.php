<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/24
 * Time: 15:45
 */
namespace Common\Model;
use Think\Model;

class AdminModel extends Model{

    private $_db = '';

    public function __construct(){
        $this->_db = M('admin');
    }

    public function getAdminByUserName($username){
        $ret = $this->_db->where('username="'.$username.'"')->find();
        return $ret;
    }

    public function getAdmins(){
        $res = $this->_db->select();
        return $res;
    }

    public function updateStatusById($id,$status){
        if(!$id || !is_numeric($id)){
            return show(0,"信息不存在");
        }
        $data['status'] = $status;
        return $this->_db->where("admin_id=".$id)->save($data);
    }

    public function insert($data){
        $res = $this->_db->add($data);
        return $data;
    }

    public function updateByAdminInId($id,$data){
        $res = $this->_db->where("admin_id=".$id)->save($data);
        return $res;
    }

    public function getLastLoginUsers(){
        $time = mktime(0,0,0,date("m"),date("d"),date("y"));
        $data = array("status" => 1,
                      "lastlogintime" => array('gt',$time)
            );

        $res = $this->_db->where($data)->count();
        return $res;
    }
}