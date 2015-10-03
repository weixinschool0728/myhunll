<?php

namespace Home\Controller;

use Think\Controller;

class FontEndController extends Controller {

    function __construct() {
        parent::__construct();
        //权限判断 数组内必须首字母大写
//        $nologin = array('Index', "Zhuce");
//        if (!in_array(CONTROLLER_NAME, $nologin)) {
//            if (!isset($_SESSION['username']) || $_SESSION['username'] == '') {
//                $_SESSION['ref']=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//                header("location:". U("Zhuce/login"));
//            }
//        }
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

}
