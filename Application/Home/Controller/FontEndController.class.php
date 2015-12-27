<?php

namespace Home\Controller;

use Think\Controller;

class FontEndController extends Controller {

    function __construct() {
        parent::__construct();
        
        header("content-type:text/html;charset=utf-8"); 
     
        //判断是否需要记录当前url 数组内必须首字母大写
        $noref=array('Goods/page','Index/menu','Order/yanzheng_zfmm','Order/queren_success','Goods/zhifu','Member/cart_del','Member/goods_del');
        $noref_contorller=array('Zhuce','Login');
        if(!in_array(CONTROLLER_NAME.'/'.ACTION_NAME, $noref)&&!in_array(CONTROLLER_NAME, $noref_contorller)){
            $_SESSION['ref']=  str_replace('.html', '',$_SERVER['REQUEST_URI']);
        }
        
        //需要登录的控制器或者方法
        $login_contorller = array('Member','Order');//需要登录的控制器
        $login=array('Goods/buy','Goods/zhifu','Goods/gmcg');//需要登录的方法
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
             $yonghu_url=U('Userinfo/index');
              $yonghuxinxi=<<<HTML
                     <a  href="#" class="green huiyuanming" >$huiyuanming</a><a href="$tuichu_url" id='a_2'>退出</a>
HTML;
             $this->assign("yonghuxinxi", $yonghuxinxi);
         }else{
             $zhuce_url=U('Zhuce/index');
             $login_url=U('Login/index');
             $yonghuxinxi=<<<HTML
                     <a  href="$login_url" class="red">登录</a><a href="$zhuce_url" id='a_2'>注册</a>
HTML;
             $this->assign("yonghuxinxi", $yonghuxinxi);
                     }
         
        $this->assign("date",date('Y'));//给日期赋值 
        $this->assign("copy","1234567");//给备案号赋值
        $this->assign("title","一起网");//给标题赋值
        $this->assign("keywords","婚啦啦 长沙婚庆");//给关键字赋值
        $this->assign("description","婚啦啦 长沙婚庆");//给描述赋值
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
