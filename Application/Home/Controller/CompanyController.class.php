<?php
namespace Home\Controller;
use  Home\Controller;
class CompanyController extends FontEndController {
    public function information() {
        $name=$_GET['name'];
        if($name==='about_17each'){
            $this->display('about_17each');
        }elseif($name==='promise'){
            $this->display('promise');
        }elseif($name==='user_protocol'){
            $this->display('user_protocol');
        }elseif($name==='hunliren_protocol'){
            $this->display('hunliren_protocol');
        }
    }
}


