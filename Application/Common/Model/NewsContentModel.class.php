<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/26
 * Time: 10:18
 */
namespace Common\Model;
use Think\Model;

class NewsContentModel extends Model{
    private $_db = '';

    public function __construct(){
        $this->_db = M("news_content");
    }
    public function insert($data){
        if(!is_array($data) || !$data) {
            return 0;
            }
        $data['create_time'] = time();
        if($data['content'] && isset($data['content'])){
            $data['content'] = htmlspecialchars($data['content']);
        }

        return $this->_db->add($data);
    }

    public function find($id){
        $data = $this->_db->where('news_id='.$id)->find();
        return $data;

    }

    public function updateNewsById($id,$data){
        if(!$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        if(!$data || !is_array($data)){
            throw_exception("数据不合法");
        }
        if($data['content'] && isset($data['content'])){
            $data['content'] = htmlspecialchars($data['content']);
        }
        return $this->_db->where("news_id=".$id)->save($data);
    }
}