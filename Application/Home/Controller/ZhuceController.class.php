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
                $time2=mktime();
                $this->assign("time2", $time2);
                $this->display();
                unset($_SESSION['zhuce1']);
                $_SESSION['zhuce2']=$time2;
                $_SESSION['dlm']=$_POST['shoujihao'];
            }else{
                $this->error('您中途打开了另一个注册页面，请重新填写信息',U('zhuce/index'),3);
            }
        }else{
            $this->error('非法操作，请从注册页面进入',U('index/index'),3);

        }
    }

    public function zhuce3() {
         if(!empty($_POST['hidden'])&&!empty($_SESSION['zhuce2'])){
             $usemodel=D('Users');
            $hidden=$_POST['hidden'];
            $dlm=$_SESSION['dlm'];
            $hym=$_POST['huiyuanming'];
            $password=$_POST['shezhimima'];
            if($hidden==$_SESSION['zhuce2']){
                $count=$usemodel->where("mobile_phone={$dlm}")->count();
                if(!is_shoujihao($dlm)||$dount!=0) {
                     $this->error('手机号错误或者已被注册，请重新注册',U('zhuce/index'),3);
                     exit();
                }
                $count=$usemodel->where("user_name={$hym}")->count();
                if(!is_hefa($hym)||$dount!=0){
                    $this->error('会员名含有非法字符或者已被注册，请重新注册',U('zhuce/index'),3);
                    exit();
                }
                $row=array(
                    'mobile_phone'=>$dlm,
                    'user_name'=>$hym,
                    'password'=>$password,
                    'last_login'=>mktime()
                   // 'last_ip'=>$_SERVER['REMOTE_ADDR']
                );
                if($_SERVER['REMOTE_ADDR']){
                    $row['last_ip']=$_SERVER['REMOTE_ADDR'];
                }
                $result=$usemodel->add($row);
                if($result){
                    $this->assign("title", "新用户注册：注册完成");
                    $this->assign("dlm", $dlm);
                    $this->assign("hym",$hym);
                    $this->display();
                    unset($_SESSION['zhuce2']);
                }else{
                    $this->error('注册失败，请重新注册',U('zhuce/index'),3);
                }
            }else{
               $this->error('您中途打开了另一个注册页面，请重新填写信息',U('zhuce/index'),3);
            }
        }else{
            $this->error('非法操作，请从注册页面进入',U('index/index'),3);

        }
        
    }

    public function zhuce4() {
        //$this->assign("title", "完善婚礼人资料");
        //$this->display();
            $usemodel=D('Users');
            $data=$usemodel->where('mobile_phone="13574506835"')->count();
        var_dump($data);
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
    
    public function check(){
        if($_POST['check']=='yanzhengma'){
            $code=$_POST['yanzhengma'];
            $data =check_verify($code);
            $this->ajaxReturn($data);
            //exit();
       }elseif($_POST['check']=='shoujihao'){
            $shoujihao=$_POST['shoujihao'];
            $usesmodel=D('Users');
            $data=$usesmodel->where("mobile_phone={$shoujihao}")->count();
            //$data =check_verify($code);
            $this->ajaxReturn($data);
            //exit();
       }else{
           exit();
       }
    }


    public function login() {
        var_dump( $_SESSION['ref']);
    }

}
