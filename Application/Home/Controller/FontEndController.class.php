<?php

namespace Home\Controller;

use Think\Controller;

class FontEndController extends Controller {

    function __construct() {
        parent::__construct();
        
        header("content-type:text/html;charset=utf-8"); 
     
        //判断是否需要记录当前url 数组内必须首字母大写
        $noref=array('Goods/page','Index/menu','Order/yanzheng_zfmm','Order/queren_success','Goods/zhifu','Goods/pinglun','Member/cart_del','Member/goods_del','Goods/jiance_pay','Goods/getUniqueOrderNo','Goods/notifyweixin','Goods/notify','Goods/gmcg_wx','Goods/sellection_join','Buy/getQRPHP','Member/xiugai_zhifumima','Member/xiugai_zhifumima_check','Member/xiugai_zhifumima_success','Member/xiugai_mima','Member/xiugai_mima_check','Member/xiugai_mima_success','Member/getCode');
        $noref_contorller=array('Zhuce','Login');
        if(!in_array(CONTROLLER_NAME.'/'.ACTION_NAME, $noref)&&!in_array(CONTROLLER_NAME, $noref_contorller)){
            $_SESSION['ref']=  str_replace('.html', '',$_SERVER['REQUEST_URI']);
        }
        
        //需要登录的控制器或者方法
        $login_contorller = array('Member','Order');//需要登录的控制器
        $login=array('Goods/buy','Goods/zhifu','Goods/gmcg','Goods/alipay','Goods/gmcg_wx','Goods/sellection_join');//需要登录的方法
        if (in_array(CONTROLLER_NAME, $login_contorller)||in_array(CONTROLLER_NAME.'/'.ACTION_NAME, $login)) {
            if (!isset($_SESSION['huiyuan']) || $_SESSION['huiyuan'] == '') {
               // $_SESSION['ref']=CONTROLLER_NAME.'/'.ACTION_NAME;
                header("location:". U("Login/index"));
                exit();
            }
        }
        //判断是否登录
         if (isset($_SESSION['huiyuan']) && $_SESSION['huiyuan'] !== '') {
             $huiyuanming=$_SESSION['huiyuan']['user_name'];
             $tuichu_url=U('Login/quit');
             $yonghu_url=U('Member/index');
              $yonghuxinxi=<<<HTML
                     <a  href=" $yonghu_url" class="green" id="a_1" >$huiyuanming</a><a href="$tuichu_url" id='a_2'>退出</a>
HTML;
             $this->assign("yonghuxinxi", $yonghuxinxi);
         }else{
             $zhuce_url=U('Zhuce/index');
             $login_url=U('Login/index');
             $yonghuxinxi=<<<HTML
                     <a  href="$login_url" class="red" id="a_1">登录</a><a href="$zhuce_url" id='a_2'>注册</a>
HTML;
             $this->assign("yonghuxinxi", $yonghuxinxi);
                     }
         
        $this->assign("date",date('Y'));//给日期赋值 
        $informodel=D('Admin_infor');
        $webinfor=$informodel->where("id=1")->find();
        $this->assign("copy",$webinfor['copy']);//给备案号赋值
        $this->assign("title",$webinfor['web_name']);//给标题赋值
        $this->assign("keywords",$webinfor['key_word']);//给关键字赋值
        $this->assign("description",$webinfor['description']);//给描述赋值
        
        //给menu页面中的最近浏览赋值
        $arr_goodsid=  array_reverse(cookie('distory_goods_id'));
        if(!empty($arr_goodsid)){
            $goodsmodel=D('Goods');
            foreach ($arr_goodsid as $v){
                if(is_shuzi($v)){
                    $distory_goods[]=$goodsmodel->where("goods_id=$v")->field('goods_id,goods_name,yuan_price,price,goods_img')->find();
                }else{
                    echo '发生错误，商品id为：'.$v;
                    cookie('distory_goods_id',null);
                }
            }
            $this->assign('distory_goods',$distory_goods);
        }
        
        
        $ismobile = ismobile();//检查客户端是否是手机
        if ($ismobile) {
            C("DEFAULT_THEME", "Mobile");
            C("TMPL_CACHE_PREFIX", "mb");
        }
        $this->assign("ismobile", $ismobile);
    }
    
    public function upload($path){
    $config=array(
        'maxSize'=> 5242880,//上传文件最大值5M
        'rootPath'=>UPLOAD,
        'savePath'=> $path,
        'saveName'=>'getname',
        'exts'=> array('jpg', 'gif', 'png', 'jpeg','bmp','swf'),
        'autoSub'=> true,
        'subName'=>array('date','Ymd')
    );
    $upload = new \Think\Upload($config);// 实例化上传类
    $info   =   $upload->upload();
    if(!$info) {
        $this->error($upload->getError());
        exit();
    }else{// 上传成功,返回文件信息
        return $info;
        }
    }
    
    public function get_page($count,$page_size){
        $page=new \Think\Page($count,$page_size);//创建一个page类  参数1是数据总条数，参数2是一页显示的条数
        $page->setConfig('header','<span class="rows">共 %TOTAL_PAGE% 页</span>');
        $page->setConfig('prev','<上一页');
        $page->setConfig('next','下一页>');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        return $page;
    }
    





}
