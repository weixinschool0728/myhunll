<?php
namespace Home\Controller;
use  Home\Controller;
class LoginController extends FontEndController {
    public function index(){
        $time=gettime();
        $_SESSION['login']=$time;
        $this->assign("title", "用户登录");
        $this->assign("time", $time);
        if($_GET['url_to']==='hunliren'){
            $this->assign("url_to", U('Login/chenggong',array('url_to'=>'hunliren')));
        }else if($_GET['url_to']==='Member'){
             $this->assign("url_to", U('Login/chenggong',array('url_to'=>'Member')));
        }else{
             $this->assign("url_to", U('Login/chenggong'));
        }
        $this->display('index');
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
         if(!empty($_POST['hidden'])&&!empty($_SESSION['login'])){
             if($_POST['hidden']==$_SESSION['login']){
                 if(is_feifa($dlm)||is_feifa($mima)){
                     exit();
                 }
                $dlm=$_POST['shoujihao'];
                $usersmodel=D('Users');
                $id=$usersmodel->where("mobile_phone='{$dlm}'")->getField('user_id');
                $hym=$usersmodel->where("mobile_phone='{$dlm}'")->getField('user_name');
                $smid=$usersmodel->where("mobile_phone='{$dlm}'")->getField('shopman_id');
                $_SESSION['huiyuan']=array(
                    'user_id'=>$id,
                    'user_name'=>$hym,
                    'shopman_id'=>$smid
                     );
                
                
                
                header("location:". U($_SESSION['ref']));
                
                unset($_SESSION['login']);
                exit();
                }else{
                    $this->error('非法进入1，将转到主页',U('index/index'),3);
                    exit();
                }
         }else{
             echo $_POST;
             //echo  $_SESSION['huiyuan'];
            //$this->error('非法进入2，将转到主页',U('index/index'),3);
            exit();
         }
    }
}


