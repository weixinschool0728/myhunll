<?php
namespace Home\Controller;
use  Home\Controller;
class LoginController extends FontEndController {
    public function index(){
        $time=gettime();
        $_SESSION['login']=$time;
        $this->assign("title", "用户登录");
        $this->assign("time", $time);
        $this->display('index');
    }
    public function mini_login(){
        $time=gettime();
        $_SESSION['login']=$time;
        $this->assign("title", "用户登录");
        $this->assign("time", $time);
        $this->display('mini_login');
    }
    public function quit(){
        unset($_SESSION['huiyuan']);
        $index_url=U('index/index');
        header ( "Location: {$index_url}" );  
    }
    
    public function login(){
        if($_POST['check']=='login'){
            $dlm=$_POST['shoujihao'];
            $mima =$_POST['mima'];
            if(is_feifa($dlm)||is_feifa($mima)){
                exit();
            }
            $usersmodel=D('Users');
            $is_cunzai=$usersmodel->where("mobile_phone='{$dlm}'")->count();
            if($is_cunzai!=='0'){
                $salt=$usersmodel->where("mobile_phone='{$dlm}'")->getField('salt');
                $mima_md5=md5($mima.$salt);
                $data=$usersmodel->where("mobile_phone='{$dlm}' and password='{$mima_md5}'")->count();
            }else{
                $data='-1';
            }
            $this->ajaxReturn($data);
            exit();
        }
    }

    
    public function chenggong() {
        if(empty($_POST['hidden'])||empty($_SESSION['login'])){
            $this->error('非法进入，将转到主页',U('index/index'),3);
        }
        if($_POST['hidden']==$_SESSION['login']){
                $dlm=$_POST['shoujihao'];
                $mima =$_POST['mima'];
                if(is_feifa($dlm)||is_feifa($mima)){
                    exit();
                }
                $usersmodel=D('Users');
                $is_cunzai=$usersmodel->where("mobile_phone='{$dlm}'")->count();
                if($is_cunzai==='0'){
                    $this->error('登录名不存在，请重新登录',U('Login/index'),3);
                }
                $salt=$usersmodel->where("mobile_phone='{$dlm}'")->getField('salt');
                $mima_md5=md5($mima.$salt);
                $data=$usersmodel->where("mobile_phone='{$dlm}' and password='{$mima_md5}'")->count();
                if($data==='0'){
                    $this->error('登录名或密码不正确，请重新登录',U('Login/index'),3);
                }
                $id=$usersmodel->where("mobile_phone='{$dlm}'")->getField('user_id');
                $hym=$usersmodel->where("mobile_phone='{$dlm}'")->getField('user_name');
                $smid=$usersmodel->where("mobile_phone='{$dlm}'")->getField('shopman_id');
                $_SESSION['huiyuan']=array(
                    'user_id'=>$id,
                    'user_name'=>$hym,
                    'shopman_id'=>$smid
                     );
                unset($_SESSION['login']);
                if($_POST['mini_login']==='yse'){
                    echo '登录成功';
                }elseif(isset($_SESSION['ref'])){
                    header("location:". U($_SESSION['ref']));
                }else{
                    header("location:". U('index/index'));
                }
            }else{
                    $this->error('非法进入1，将转到主页',U('index/index'),3);
                }
    }
    
    
}


