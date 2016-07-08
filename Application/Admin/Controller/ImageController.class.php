<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/25
 * Time: 14:36
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;

class ImageController extends CommonController{
    private $_uploadobj;

    public function __construct(){

    }

    public function ajaxuploadimage(){
        $upload = D("UploadImage");
        $res = $upload->imageUpload();
        if($res===false){
            return show(0,'上传失败');
        }
        else{
            return show(0,'上传成功',$res);
        }
    }

    public function kindupload(){
        $upload = D("UploadImage");
        $res = $upload->upload();
        if($res === false){
            return showKind(1,"上传失败");
        }
        return showKind(0,$res);
    }

}