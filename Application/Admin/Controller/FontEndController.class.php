<?php

namespace Admin\Controller;

use Think\Controller;

class FontEndController extends Controller {

    function __construct() {
        parent::__construct();
        //权限判断 数组内必须首字母大写
        $nologin = array('Index', "Zhuce",'Login');
        if (!in_array(CONTROLLER_NAME, $nologin)) {
            if (!isset($_SESSION['huiyuan']) || $_SESSION['huiyuan'] == '') {
                $_SESSION['ref']=CONTROLLER_NAME.'/'.ACTION_NAME;
                header("location:". U("Login/index"));
            }
        }
        //判断是否登录
         if (isset($_SESSION['huiyuan']) && $_SESSION['huiyuan'] !== '') {
             $huiyuanming=$_SESSION['huiyuan']['user_name'];
             $tuichu_url=U('Login/quit');
             $yonghu_url=U('Userinfo/index');
              $yonghuxinxi=<<<HTML
                     <a  href="#" class="green huiyuanming" >$huiyuanming</a><a href="$tuichu_url">退出</a>
HTML;
             $this->assign("yonghuxinxi", $yonghuxinxi);
         }else{
             $zhuce_url=U('Zhuce/index');
             $login_url=U('Login/index');
             $yonghuxinxi=<<<HTML
                     <a  href="$login_url" class="red">登录</a><a href="$zhuce_url">注册</a>
HTML;
             $this->assign("yonghuxinxi", $yonghuxinxi);
                     }
         
        $this->assign("date",date(Y));//给日期赋值 
        $this->assign("copy","1234567");//给备案号赋值
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
        'maxSize'=> 2097152,
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

}