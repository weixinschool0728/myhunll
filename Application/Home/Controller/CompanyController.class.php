<?php
namespace Home\Controller;
use  Home\Controller;
class CompanyController extends FontEndController {
    public function index() {
        $name=$_GET['name'];
        if($name==='about_17each'){
            $name="关于一起网";
        }elseif($name==='promise'){
            $name="一起网承诺";
        }elseif($name==='user_protocol'){
            $name="用户协议";
        }elseif($name==='hunliren_protocol'){
            $name="商家协议";
        }elseif($name==='daijinquan'){
            $name="代金券规则";
        }elseif($name==='fanxian'){
            $name="返现规则";
        }elseif($name==='shuangbeipeifu'){
            $name="双倍赔付规则";
        }elseif($name==='suishitui'){
            $name="随时退规则";
        }elseif($name==='baozhengjin'){
            $name="保证金规则";
        }
        $companymodel=D('Admin_company');
        $data=$companymodel->where("name='$name'")->find();
        $this->assign('data',$data);
        $this->display(index);
    }
    
    
    
    
    
    
}


