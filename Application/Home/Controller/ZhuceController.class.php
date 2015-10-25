<?php

namespace Home\Controller;

use Home\Controller;

class ZhuceController extends FontEndController {


    public function index() {
        $time=gettime();
        $_SESSION['zhuce1']=$time;
        $this->assign("title", "新用户注册：设置用户名");
        $this->assign("time", $time);
        $this->display('index');
    }

    public function zhuce2() {
        if(!empty($_POST['hidden'])&&!empty($_SESSION['zhuce1'])){
            $hidden=$_POST['hidden'];
            if($hidden==$_SESSION['zhuce1']){
                $this->assign("title", "新用户注册：填写账户信息");
                $this->assign("dlm", $_POST['shoujihao']);
                $time2=gettime();
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
            $usersmodel=D('Users');
            $hidden=$_POST['hidden'];
            $dlm=$_SESSION['dlm'];
            $hym=$_POST['huiyuanming'];
            $password=$_POST['shezhimima'];
            $salt=  create_char(6);
            $password_md5=  md5($password.$salt);
            if($hidden==$_SESSION['zhuce2']){
                $count=$usersmodel->where("mobile_phone='{$dlm}'")->count();
                if(!is_shoujihao($dlm)||$count!=='0') {
                     $this->error('手机号错误或者已被注册，请重新注册',U('zhuce/index'),3);
                     exit();
                }
                $count1=$usersmodel->where("user_name='{$hym}'")->count();
                if(is_feifa($hym)||$count1!=='0'){
                    $this->error('会员名含有非法字符或者已被注册，请重新注册',U('zhuce/index'),3);
                    exit();
                }
                $row=array(
                    'mobile_phone'=>$dlm,
                    'user_name'=>$hym,
                    'password'=>$password_md5,
                    'last_login'=>mktime(),
                    'salt'=>$salt,
                    'reg_time'=>  mktime()
                );
                if($_SERVER['REMOTE_ADDR']){
                    $row['last_ip']=$_SERVER['REMOTE_ADDR'];
                }
                $result=$usersmodel->add($row);//注册信息写入数据库
                if($result){
                    $this->assign("title", "新用户注册：注册完成");
                    $this->assign("dlm", $dlm);
                    $this->assign("hym",$hym);
                    $this->display();
                    $id=$usersmodel->where("user_name='{$hym}'")->getField('user_id');
                    $smid=$usersmodel->where("user_name='{$hym}'")->getField('shopman_id');
                    $_SESSION['huiyuan']=array(
                        'user_id'=>$id,
                        'user_name'=>$hym,
                        'shopman_id'=>$smid
                            );
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
        //判断是否登录
        if (isset($_SESSION['huiyuan']) && $_SESSION['huiyuan'] !== '') {
            //判断是否已经是商家
            if($_SESSION['huiyuan']['shopman_id']==='1'){
                header("location:". U("Member/hunlirenshangjiaxinxi"));
                exit();
            }
            $this->assign("title", "成为婚礼人");
            $this->display(zhuce4);
        }else{
            $this->error('请先登录',U('Login/index'),3);
        }
        
    }
    
    public function zhuce4_check(){
        //如果已经是婚礼人了  直接跳过
        if($_SESSION['huiyuan']['shopman_id']==='1'){
            header("location:". U("Member/hunlirenshangjiaxinxi"));
            exit();
        }
        //获取上传文件信息
        $file_info=$this->upload('image/hunliren/');
        //当有文件没有上传时，提示并返回
        if(count($file_info)<2){
            $this->error('存在未选择的文件');
            exit();
        }
        $serverform=intval($_POST['radio_fuwuxingshi']);//获取服务形式
        //当服务形式为公司，至少必须上传3个图片文件，否则提示并且返回
       //if($serverform===2){
            //if(count($file_info)<3){
                //$this->error('有选现未选择文件');
                //exit();
            //}
        //}
        $sex=  intval($_POST['radio_sex']);//获取性别
        $name=$_POST['name'];//获取真实姓名
        $province=$_POST['address_province'];//获取省份
        //如果没选择省份，提示并退出
        if($province==='请选择省市'||empty($province)){
            $this->error('未选择所在省市');
            exit();
        }else{//获取城市和县城
            $city=$_POST['address_city'];
            $county=$_POST['address_county'];
        }
        $address=$_POST['address_juti'];//获取详细地址
        $qq=$_POST['contact_qq'];//获取QQ号码
        $weixin=$_POST['contact_weixin'];//获取微信号码
        $email=$_POST['contact_email'];//获取邮箱
        $fuwuneirong=$_POST['fuwuneirong'];//获取服务内容
        //服务内容未选择时，提示并退出
        if(empty($fuwuneirong)||empty($email)||empty($fuwuneirong)||empty($weixin)||empty($qq)||empty($address)||empty($name)){
            $this->error('有内容未填写');
            exit();
        }
        $fuwuneirong=  implode('|', $fuwuneirong);//把服务内容数组变成字符串
        //邮箱是否正确
        if(is_youxiang($email)){
            $this->error('邮箱不正确');
            exit();
        }
        //任何文本框如果含有非法字符，提示并退出
        if(is_feifa($weixin)||is_feifa($qq)||is_feifa($address)||is_feifa($name)){
            $this->error('有内容含有非法字符');
            exit();
        }
        //获取上传文件信息
        $head_url=UPLOAD.$file_info['file_touxiang']['savepath'].$file_info['file_touxiang']['savename'];
        $shenfenzheng_url=UPLOAD.$file_info['file_shenfenzheng']['savepath'].$file_info['file_shenfenzheng']['savename'];
        //准备需要写进数据库的数组
        $user_id=intval($_SESSION['huiyuan']['user_id']);//获取会员id号
        $row=array(
            'head_url'=>'/'.$head_url,
            'shenfenzheng_url'=>'/'.$shenfenzheng_url,
            'sex'=>$sex,
            'server_form'=>$serverform,
            'true_name'=>$name,
            'location'=>$province.'|'.$city.'|'.$county,
            'address'=>$address,
            'qq'=>$qq,
            'weixin'=>$weixin,
            'email'=>$email,
            'server_content'=>$fuwuneirong,
            'shopman_id'=>1,
            'shopman_reg_time'=>  mktime()
        );
        //如果上传了营业执照照片，写进数组
        //if(isset($file_info['file_yingyezhizhao'])){
            //$yingyezhizhao_url=UPLOAD.$file_info['file_yingyezhizha']['savepath'].$file_info['file_yingyezhizha']['savename'];
            //$row['yingyezhizhao_url']='/'.$yingyezhizhao_url;
        //}
        //写入数据库
        $usersmodel=D('Users');
        $result=$usersmodel->where("user_id={$user_id}")->save($row);
        if($result!==false){
            $_SESSION['huiyuan']['shopman_id']='1';
            header("location:". U("Member/hunlirenshangjiaxinxi"));
        }else{
            $this->error('更新数据库失败');
            exit();
        }
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
            exit();
       }elseif($_POST['check']=='shoujihao'){
            $shoujihao=$_POST['shoujihao'];
            $usesmodel=D('Users');
            $data=$usesmodel->where("mobile_phone={$shoujihao}")->count();
            $this->ajaxReturn($data);
            exit();
       }elseif($_POST['check']=='huiyuanming'){
            $huiyuanming=$_POST['huiyuanming'];
            $usesmodel=D('Users');
            $data=$usesmodel->where("user_name='{$huiyuanming}'")->count();
            $this->ajaxReturn($data);
            exit();
       }
       else{
           exit();
       }
    }


}
