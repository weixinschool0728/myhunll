<?php
namespace Admin\Controller;
use Admin\Controller;
class UsersmanageController extends FontEndController {
   
    public function index(){
        $usersmodel=D('Users');
        $count=$usersmodel->count();
        $page=$this->get_page($count, 10);
        $page_foot=$page->show();//显示页脚信息
        $list=$usersmodel->field('user_id,email,user_name,reg_time,mobile_phone,shopman_id,server_content')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page_foot',$page_foot);
        $this->display('index');
    }
    

    
    
    


}