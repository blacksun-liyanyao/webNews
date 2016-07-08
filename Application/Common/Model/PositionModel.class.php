<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/27
 * Time: 9:33
 */
namespace Common\Model;
use Think\Model;

class PositionModel extends Model{
    private $_db = '';

    public function __construct(){
        $this->_db = M('Position');
    }

    public function add($data){
        if(!is_array($data)){
            return show(0,"数据异常");
        }
        return $this->_db->add($data);
    }

    public function getNormalPositions(){
        $data["status"] = array('neq',-1);
        return $this->_db->where($data)->select();
    }

    public function getPosition($page,$pageSize=10){
        $data['status'] = array('neq',-1);
        $offset = ($page - 1) * $pageSize;
        $list = $this->_db->where($data)->order('id desc')->limit($offset,$pageSize)->select();
        return $list;
    }

    public function getPositionCount(){
        $data['status'] = array('neq',-1);
        return $this->_db->where($data)->count();
    }

    public function find($id){
        if(!$id || !is_numeric($id)){
            return show(0,"内容不存在");
        }
        return $this->_db->where("id=".$id)->find();
    }

    public function updatePositionById($id,$data){
        if(!$id || !is_numeric($id)){
            return show(0,"信息不存在");
        }
        if(!is_array($data)){
            return show(0,"修改内容不正确");
        }

        return $this->_db->where("id=".$id)->save($data);
    }
    public function updateStatusById($id,$status){
        if(!$id || !is_numeric($id)){
            return show(0,"信息不存在");
        }
        $data['status'] = $status;
        return $this->_db->where("id=".$id)->save($data);
    }
}