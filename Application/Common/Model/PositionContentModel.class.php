<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/27
 * Time: 10:08
 */
namespace Common\Model;
use Think\Model;

class PositionContentModel extends Model{
    private $_db = '';

    public function __construct(){
        $this->_db = M('Position_content');
    }

    public function insert($data){
        if(!$data || !is_array($data))
        {
            return show(0,'插入数据不存在');
        }
        return $this->_db->add($data);
    }

    public function getPosition($data,$page,$pageSize=10){
        if($_GET['title']){
            $data['title'] = array('like','%'.$data['title'].'%');
        }
        $offset = ($page - 1) * $pageSize;
        $list = $this->_db->where($data)->order('listorder desc,id desc')->limit($offset,$pageSize)->select();
        return $list;
    }

    public function getPositionCount($data){
        if($_GET['title']){
            $data['title'] = array('like','%'.$data['title'].'%');
        }
        return $this->_db->where($data)->count();
    }

    public function find($id){
        return $this->_db->where("id=".$id)->find();
    }

    public function updateById($id,$data){
        if(!$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        if(!$data || !is_array($data)){
            throw_exception("数据不合法");
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

    public function updateListorderById($id,$listorder){
        if(!$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        $data = array("listorder" => intval($listorder));
        return $this->_db->where("id=".$id)->save($data);
    }
}