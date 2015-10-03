<?php

namespace Home\Controller;

use Home\Controller;

class ZhuceController extends FontEndController {

    var $pernum = 30;

    //public function  __construct() {
        //parent::__construct();
        //$this->assign("title", "注册");
    //}

    public function index() {
        $time=mktime();
        $_SESSION['zhuce1']=$time;
        $this->assign("title", "新用户注册：设置用户名");
        $this->assign("time", $time);
        $this->display();
    }

    public function zhuce2() {
        if(!empty($_POST['hidden'])&&!empty($_SESSION['zhuce1'])){
            $hidden=$_POST['hidden'];
            if($hidden==$_SESSION['zhuce1']){
                $this->assign("title", "新用户注册：填写账户信息");
                $this->assign("dlm", $_POST['shoujihao']);
                $this->display();
                unset($_SESSION['zhuce1']);
            }else{
                $this->error('您中途打开了另一个注册页面，请重新填写信息',U('zhuce/index'),5);
            }
        }else{
            $this->error('非法操作，请从注册页面进入',U('index/index'),5);

        }
        
    }

    public function zhuce3() {
        $this->assign("title", "新用户注册：注册完成");
        $this->display();
    }

    public function zhuce4() {
        $this->assign("title", "完善婚礼人资料");
        $this->display();
    }
    public function getCode(){
        $config =    array(   
            'expire'      =>    30,    //验证码有效期
            'fontSize'    =>    16,    // 验证码字体大小   
            'length'      =>    4,     // 验证码位数   
            'imageW'    =>    160, // 验证码宽度 设置为0为自动计算
            'imageH'    =>    34, // 验证码高度 设置为0为自动计算
        );
       $Verify = new \Think\Verify($config);
       $Verify->entry();
    }
    
    public function check_yanzhengma(){
        if($_POST['check']=='yanzhengma'){
            $code=$_POST['yanzhengma'];
            $data =check_verify($code);
            $this->ajaxReturn($data);
            exit();
       }else{
           exit();
       }
       
    }


    public function login() {
        var_dump( $_SESSION['ref']);
    }

}
