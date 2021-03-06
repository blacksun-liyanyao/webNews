<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/26
 * Time: 10:20
 */
namespace Common\Model;
use Think\Model;

class NewsModel extends Model{
    private $_db = '';

    public function __construct(){
        $this->_db = M("news");
    }

    public function insert($data=array()){
        if(!is_array($data) || !$data){
            return 0;
        }

        $data['create_time'] = time();
        $data['username'] = getLoginUsername();
        return $this->_db->add($data);
    }

    public function getNews($data,$page,$pageSize=5){
        $conditions = $data;
        if(isset($data['title']) && $data['title']){
            $conditions['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['catid']) && $data['catid']){
            $conditions['catid'] = intval($data['catid']);
        }
        $offset = ($page - 1) * $pageSize;
        $list = $this->_db->where($conditions)
            ->order("listorder desc,news_id desc")
            ->limit($offset,$pageSize)
            ->select();

        return $list;

    }

    public function getNewsCount($data = array()){
        $conditions = $data;
        if(isset($data['title']) && $data['title']){
            $conditions['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['catid']) && $data['catid']){
            $conditions['catid'] = intval($data['catid']);
        }
        return $this->_db->where($conditions)->count();
    }

    public function find($id){
        if(!$id || !is_numeric($id)){
            return show(0,"操作错误");exit;
        }
        $data = $this->_db->where('news_id='.$id)->find();
        return $data;

    }

    public function updateById($id,$data){
        if(!$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        if(!$data || !is_array($data)){
           throw_exception("数据不合法");
        }
        return $this->_db->where("news_id=".$id)->save($data);
    }

    public function updateStatusById($id,$status){
        if(!$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        if(!is_numeric($status)){
            throw_exception("status不合法");
        }
        $data['status'] = $status;
        return $this->_db->where("news_id=".$id)->save($data);
    }

    public function updateNewsListorderById($id,$listorder){
        if(!$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        $data = array("listorder" => intval($listorder));
        return $this->_db->where("news_id=".$id)->save($data);
    }

    public function getNewsByNewsIdIn($newsIds){
        if(!is_array($newsIds)){
            throw_exception("参数不合法");
        }
        $data = array(
            "news_id" => array('in',implode(',',$newsIds))
        );
        return $this->_db->where($data)->select();
    }

    public function getRank($data = array(),$limit=100){
        $list = $this->_db->where($data)->order("count desc,news_id desc")->limit($limit)->select();
        return $list;
    }
    public function updateCount($id,$count){
        if(!$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        if(!is_numeric($count)){
            throw_exception("Count不能为非数字");
        }
        $data['count'] = $count;
        return $this->_db->where("news_id=".$id)->save($data);
    }
    public function countMax(){
        $data['status'] = 1;
        return $this->_db->where($data)->order('count desc')->limit(1)->find();

    }
}