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
        }
        $companymodel=D('Admin_company');
        $data=$companymodel->where("name='$name'")->find();
        $this->assign('data',$data);
        $this->display(index);
    }
    
    
    
    
    
    
}


