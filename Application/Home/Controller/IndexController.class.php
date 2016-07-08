<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;

class IndexController extends CommonController {
    public function index(){
        $rankNews = $this->getRank();
        //获取首页大图数据
        $topPicNews = D("PositionContent")->getPosition(array('status'=>1,'position_id'=>2),1);
        //首页3张小图推荐
        $topSmailNews = D("PositionContent")->getPosition(array('status'=>1,'position_id'=>3),1,3);

        $advNews = D("PositionContent")->getPosition(array('status'=>1,'position_id'=>5),1,2);

        $listNews = D("News")->getNews(array("status"=>1,'thumb'=>array('neq','')),1,30);

        $this->assign("result",array(
            'topPicNews' => $topPicNews,
            'topSmailNews' => $topSmailNews,
            'listNews' => $listNews,
            'advNews' => $advNews,
            'rankNews' => $rankNews,
            'catId' => 0
        ));
//        生成页面静态化
        if($type == 'buildHtml'){
            $this->buildHtml('index',HTML_PATH,'Index/index');
        }else{
            $this->display();
        }
    }

    public function build_html(){
        $this->index('buildHtml');
        return show(1,"首页缓存生成成功");
    }

    public function getCount(){
        if(!$_POST){
            return show(0,"没有任何数据");
        }

        $newsIds = array_unique($_POST);

        try{
            $list = D("News")->getNewsByNewsIdIn($newsIds);
        }catch (Exception $e){
            return show(0,$e->getMessage());
        }
        if(!$list){
            return show(0,'notdata');
        }
        $data = array();
        foreach($list as $k=>$v){
            $data[$v['news_id']] = $v['count'];
        }
        return show(1,"success",$data);
    }
}