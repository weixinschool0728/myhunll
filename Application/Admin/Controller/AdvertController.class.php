<?php
namespace Admin\Controller;
use Admin\Controller;
class AdvertController extends FontEndController {
   
    public function lunbo_up(){
        $advertmodel=D('Admin_advert');
        $data=$advertmodel->where("position='轮播上'")->select();
        $this->assign('data',$data);
        $this->display();
    }
    
    
    public function file_jia(){

        $file_info=$this->upload('image/temp/');//获取上传文件信息
        //获取图片URL
        $data=array(
            'file_1'=>UPLOAD.$file_info['file_1']['savepath'].$file_info['file_1']['savename'],
            'file_2'=>UPLOAD.$file_info['file_2']['savepath'].$file_info['file_2']['savename'],
            'file_3'=>UPLOAD.$file_info['file_3']['savepath'].$file_info['file_3']['savename']
        );
        $this->ajaxReturn($data,'JSON');
    }
    
    
    public function shangchuang(){
        //移动文件 并且改变url
        if(!$_POST['text_file_1']==''){
            $today=substr($_POST['text_file_1'],26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/admin/'.$today);//创建文件夹（如果存在不会创建）
            rename($_POST['text_file_1'], str_replace('Public/Uploads/image/temp', UPLOAD.'image/admin',$_POST['text_file_1']));//移动文件
            $img_url='/'.str_replace('Public/Uploads/image/temp', UPLOAD.'image/admin',$_POST['text_file_1']);
            $id=1;
        };
        
        if(!$_POST['text_file_2']==''){
            $today=substr($_POST['text_file_2'],26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/admin/'.$today);//创建文件夹（如果存在不会创建）
            rename($_POST['text_file_2'], str_replace('Public/Uploads/image/temp', UPLOAD.'image/admin',$_POST['text_file_2']));//移动文件
            $img_url='/'.str_replace('Public/Uploads/image/temp', UPLOAD.'image/admin',$_POST['text_file_2']);
            $id=2;
        };
        
        if(!$_POST['text_file_3']==''){
            $today=substr($_POST['text_file_3'],26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/admin/'.$today);//创建文件夹（如果存在不会创建）
            rename($_POST['text_file_3'], str_replace('Public/Uploads/image/temp', UPLOAD.'image/admin',$_POST['text_file_3']));//移动文件
            $img_url='/'.str_replace('Public/Uploads/image/temp', UPLOAD.'image/admin',$_POST['text_file_3']);
            $id=3;
        };
        $advertmodel=D('Admin_advert');
        $row=array(
            'img_url'=>$img_url,
            'add_user'=>$_SESSION['admin_huiyuan']['user_id'],
            'add_user_name'=>$_SESSION['admin_huiyuan']['user_name'],
            'add_time'=>mktime()
        );
        $result=$advertmodel->where("id='{$id}'")->save($row);
        if($result!==false){
            header("location:". U("Advert/lunbo_up"));
            exit();
        }else{
            $this->error('更新数据库失败');
            exit();
        }
        
    }
    
    
    public function xqbj(){
        $index=$_GET['id'];
        $this->assign('index',$index);
        $advertmodel=D('Admin_advert');
        $data=$advertmodel->where("id='$index'")->field('advert_desc')->find();
        $this->assign('data',$data);
        $this->display();
    }
    
    public function xqbj_check(){
        $index=$_POST['index'];
        $content=$_POST['content'];
        $result=get_file($content);//得到编辑框里面的图片文件
         //遍历图片文件，并把图片文件从临时文件夹保存进正式文件夹,并把文件名存储到$file_name数组中
        foreach ($result[1] as $value){
            $today=substr($value,26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/admin/'.$today);//创建文件夹（如果存在不会创建）
            rename($value, str_replace('Public/Uploads/image/temp', UPLOAD.'image/admin', $value));//移动文件
        }
        $advert_desc=str_replace('Public/Uploads/image/temp', UPLOAD.'image/admin', $content);
        $advertmodel=D('Admin_advert');
        $row=array(
            'advert_desc'=>$advert_desc,
            'add_user'=>$_SESSION['admin_huiyuan']['user_id'],
            'add_user_name'=>$_SESSION['admin_huiyuan']['user_name'],
            'add_time'=>mktime()
        );
        $result1=$advertmodel->where("id='{$index}'")->save($row);
        if($result1!==false){
            $url = "/admin/advert/lunbo_up";  
            echo "<script type='text/javascript'>";  
            echo "self.location='$url'";  
            echo "</script>"; 
            exit();
        }else{
            $this->error('更新数据库失败');
            exit();
        }
    }



}