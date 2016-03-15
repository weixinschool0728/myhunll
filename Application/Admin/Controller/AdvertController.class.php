<?php
namespace Admin\Controller;
use Admin\Controller;
class AdvertController extends FontEndController {
   
    public function advert(){
        $advertmodel=D('Admin_advert');
        if($_GET['id']==='1'){
            $data=$advertmodel->where("position='轮播上'")->select();
        }else if($_GET['id']==='2'){
            $data=$advertmodel->where("position='轮播下'")->select();
        }else if($_GET['id']==='3'){
            $data=$advertmodel->where("position='首页右'")->select();
            $a='下';
        }
        $this->assign('data',$data);
        $this->assign('a',$a);
        $this->display();
    }
    


    
    
    public function file_jia(){

        $file_info=$this->upload('image/temp/');//获取上传文件信息
        //获取图片URL
        $data=array(
            'file_1'=>UPLOAD.$file_info['file_1']['savepath'].$file_info['file_1']['savename'],
            'file_2'=>UPLOAD.$file_info['file_2']['savepath'].$file_info['file_2']['savename'],
            'file_3'=>UPLOAD.$file_info['file_3']['savepath'].$file_info['file_3']['savename'],
            'file_11'=>UPLOAD.$file_info['file_11']['savepath'].$file_info['file_11']['savename'],
            'file_12'=>UPLOAD.$file_info['file_12']['savepath'].$file_info['file_12']['savename'],
            'file_13'=>UPLOAD.$file_info['file_13']['savepath'].$file_info['file_13']['savename'],
            'file_14'=>UPLOAD.$file_info['file_14']['savepath'].$file_info['file_14']['savename'],
            'file_15'=>UPLOAD.$file_info['file_15']['savepath'].$file_info['file_15']['savename'],
            'file_21'=>UPLOAD.$file_info['file_21']['savepath'].$file_info['file_21']['savename'],
            'file_22'=>UPLOAD.$file_info['file_22']['savepath'].$file_info['file_22']['savename'],
            'file_23'=>UPLOAD.$file_info['file_23']['savepath'].$file_info['file_23']['savename'],
            'file_24'=>UPLOAD.$file_info['file_24']['savepath'].$file_info['file_24']['savename'],
            'file_25'=>UPLOAD.$file_info['file_25']['savepath'].$file_info['file_25']['savename'],
            'file_61'=>UPLOAD.$file_info['file_61']['savepath'].$file_info['file_61']['savename'],
            'file_62'=>UPLOAD.$file_info['file_62']['savepath'].$file_info['file_62']['savename'],
            'file_63'=>UPLOAD.$file_info['file_63']['savepath'].$file_info['file_63']['savename']
        );
        $this->ajaxReturn($data,'JSON');
    }
    
    
    public function sc(){
        $arr=array(
            0=>'11',
            1=>'12',
            2=>'13',
            3=>'14',
            4=>'15',
            5=>'21',
            6=>'22',
            7=>'23',
            8=>'24',
            9=>'25',
            10=>'1',
            11=>'2',
            12=>'3',
            13=>'61',
            14=>'62',
            15=>'63'
        );
        //移动文件 并且改变url
        foreach ($arr as $value){
            if(!$_POST['text_file_'.$value]==''){
                $today=substr($_POST['text_file_'.$value],26,8);//获取到文件夹名  如20150101
                creat_file(UPLOAD.'image/admin/'.$today);//创建文件夹（如果存在不会创建）
                rename($_POST['text_file_'.$value], str_replace('Public/Uploads/image/temp', UPLOAD.'image/admin',$_POST['text_file_'.$value]));//移动文件
                $img_url='/'.str_replace('Public/Uploads/image/temp', UPLOAD.'image/admin',$_POST['text_file_'.$value]);
                $xuhao=$value;
            };
        };
       
        $advertmodel=D('Admin_advert');
        $row=array(
            'img_url'=>$img_url,
            'add_user'=>$_SESSION['admin_huiyuan']['user_id'],
            'add_user_name'=>$_SESSION['admin_huiyuan']['user_name'],
            'add_time'=>mktime()
        );
        $advertmodel->where("xuhao=$xuhao")->save($row);
        $position=$advertmodel->where("xuhao=$xuhao")->getField('position');
        if($result!==false){
            if($position==='轮播上'){
                $url = "/admin/advert/advert?id=1"; 
            }elseif($position==='轮播下'){
                $url = "/admin/advert/advert?id=2"; 
            }
            elseif($position==='首页右'){
                $url = "/admin/advert/advert?id=3"; 
            }
            header("location:$url");
            exit();
        }else{
            $this->error('更新数据库失败');
            exit();
        }
        
    }
    
    
    public function xqbj(){
        $xuhao=$_GET['xuhao'];
        $this->assign('xuhao',$xuhao);
        $advertmodel=D('Admin_advert');
        $data=$advertmodel->where("xuhao='$xuhao'")->field('advert_desc,position')->find();
        $this->assign('data',$data);
        $this->display();
    }
    
    public function xqbj_check(){
        $xuhao=$_POST['xuhao'];
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
        $result1=$advertmodel->where("xuhao='{$xuhao}'")->save($row);
        $position=$advertmodel->where("xuhao=$xuhao")->getField('position');
        if($result1!==false){
            if($position==='轮播上'){
                $url = "/admin/advert/advert?id=1";
            }elseif($position==='轮播下'){
                $url = "/admin/advert/advert?id=2"; 
            }elseif($position==='首页右'){
                $url = "/admin/advert/advert?id=3"; 
            }
            header("location:$url");
            exit();
        }else{
            $this->error('更新数据库失败');
            exit();
        }
    }

    public function lanrenhunli(){
        $combomodel=D('Admin_combo');
        $data=$combomodel->field('combo_id')->select();
        $this->assign('data',$data);
        //获取服务类型表单提交值
        if(!empty($_GET['combo_id'])){
            $combo_id=$_GET['combo_id'];
        }else{
            $combo_id=$data[0]['combo_id'];
        }
        $this->assign('combo_id',$combo_id);
        $combo_name=$combomodel->where("combo_id=$combo_id")->getField('combo_name');
        $this->assign('combo_name',$combo_name);
        $this->display('lanrenhunli');
    }
    
    public function lanrenhunli_edit(){
        var_dump($_GET);
    }

}