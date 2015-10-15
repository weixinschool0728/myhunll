<?php
namespace Home\Controller;
use Home\Controller;
class MemberController extends FontEndController {
    public function index(){
        $this->assign("title","我的婚啦啦");
        $this->display('index');
    }
    public function  hunlirenshangjiaxinxi(){
        if($_SESSION['huiyuan']['shopman_id']==='0'){
            header("location:". U("Zhuce/zhuce4"));
            exit();
        }
        $this->assign("title","我是婚礼人");
        $user_id=$_SESSION['huiyuan']['user_id'];//获取会员id号
        $usersmodel=D('Users');
        if(!empty($user_id)||$user_id===0){
        $data=$usersmodel->where("user_id={$user_id}")->find();
        }
        $this->assign("touxiang_url",$data['head_url']);
        if(date("H" ,$data['reg_time'])<12){
            $day_time='上午好';
        }else if(date("H" ,$data['reg_time'])>=12&&date("H" ,$data['reg_time'])<20){
            $day_time='下午好';
        }else{
            $day_time='晚上好';
        }
        $this->assign("day_time",$day_time);
        $this->assign("user_name",$data['user_name']);
        $this->assign("server_content",$data['server_content']);
        $this->assign("reg_time",date("Y年m月d日 H：i" ,$data['reg_time']));
        $this->assign("sex",$data['sex']==0?'男':'女');
        $this->assign("server_form",$data['server_form']);
        $this->assign("location",$data['location']);
        $this->assign("address",$data['address']);
        $this->assign("qq",$data['qq']);
        $this->assign("weixin",$data['weixin']);
        $this->assign("email",$data['email']);
        
        $this->display('hunlirenshangjiaxinxi');
        
    }
    public function release_goods(){
        if($_SESSION['huiyuan']['shopman_id']==='0'){
            header("location:". U("Zhuce/zhuce4"));
            exit();
        } 
        $this->assign("title","婚礼人发布商品");
        
        $user_id=$_SESSION['huiyuan']['user_id'];//获取会员id号
        $usersmodel=D('Users');
        if(!empty($user_id)||$user_id===0){
        $data=$usersmodel->where("user_id={$user_id}")->find();
        }
        $sc=$data['server_content'];
        $arr_sc=explode('|',$sc);
        $this->assign("arr_sc",$arr_sc);
        
        if($data['server_form']==='个人'){
            $this->assign("css",'display: none;');
        }else{
            $this->assign("css",'');
        }
        
        $this->display('release_goods');
    }

}