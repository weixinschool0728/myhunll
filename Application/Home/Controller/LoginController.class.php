<?php
namespace Home\Controller;
use  Home\Controller;
class LoginController extends FontEndController {
    public function index(){
        if(isset($_SESSION['huiyuan'])){
            $index_url=U('index/index');
            header ( "Location: {$index_url}" ); 
            exit();
        }
        $time=gettime();
        $_SESSION['login']=$time;
        $this->assign("title", "用户登录");
        $this->assign("time", $time);
        $this->display('index');
    }

    public function quit(){
        unset($_SESSION['huiyuan']);
        $index_url=U('index/index');
        header ( "Location: {$index_url}" );  
        exit();
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
        $leixing=$_POST['leixing'];
        if(empty($_POST['hidden'])||empty($_SESSION[$leixing])){
            $this->error('不是从登录页面进入，将转到主页',U('index/index'),3);
        }
        if($_POST['hidden']==$_SESSION[$leixing]){
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
                $row=array(
                    'last_login'=>mktime(),
                    'last_ip'=>$_SERVER['REMOTE_ADDR']
                );
                $usersmodel->where("mobile_phone='{$dlm}'")->save($row);
                $id=$usersmodel->where("mobile_phone='{$dlm}'")->getField('user_id');
                $hym=$usersmodel->where("mobile_phone='{$dlm}'")->getField('user_name');
                $smid=$usersmodel->where("mobile_phone='{$dlm}'")->getField('shopman_id');
                $_SESSION['huiyuan']=array(
                    'user_id'=>$id,
                    'user_name'=>$hym,
                    'shopman_id'=>$smid
                     );
                unset($_SESSION[$leixing]);
                if(isset($_SESSION['ref'])){
                    header("location:". U($_SESSION['ref']));
                    exit();
                }else{
                    header("location:". U('index/index'));
                    exit();
                }
            }else{
                    $this->error('非法进入，将转到主页',U('index/index'),3);
                }
    }
    
    public function is_login(){
        if(isset($_SESSION['huiyuan'])){
            $data=$_SESSION['huiyuan']['user_name'];
        }  else {
            $data=0;
        }
        $this->ajaxReturn($data);
        exit();
    }
}


