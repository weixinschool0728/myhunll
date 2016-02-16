<?php
namespace Home\Controller;
use Home\Controller;
class AdvertController extends FontEndController {
    public function lunbo_up(){
        $id=$_GET['id'];
        $advertmodel=D('admin_advert');
        $lunbo_shang=$advertmodel->where("id='$id'")->field('index,advert_desc')->find();
        $this->assign('lunbo_shang',$lunbo_shang);
        $this->display();
    }
    



}