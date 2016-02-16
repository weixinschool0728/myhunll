<?php
namespace Admin\Controller;
use Admin\Controller;
class WebinforController extends FontEndController {
   
    public function index(){
        $informodel=D('Admin_infor');
        $date=$informodel->where("id=1")->find();
        $this->assign('date',$date);
        $this->display();
    }
    public function xiugai(){
        $row=$_POST;
        $informodel=D('Admin_infor');
        $informodel->where("id=1")->save($row);
        $url=U('Webinfor/index');
        header ( "Location: {$url}" ); 
    }



}