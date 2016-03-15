<?php
namespace Admin\Controller;
use Admin\Controller;
class WithdrawController extends FontEndController {
   
    public function index(){
        $withdrawModel=D('Withdraw');
        $count=$withdrawModel->count();
        $page=$this->get_page($count, 10);
        $page_foot=$page->show();//显示页脚信息
        $withdraw=$withdrawModel->table('m_withdraw t1,m_users t2')->where("t1.user_id=t2.user_id")->field('t2.user_name,t1.account_style,t1.account_number,t1.withdraw_money,t1.time')->select();
        $this->assign('withdraw',$withdraw);
        $this->assign('page_foot',$page_foot);
        $this->display('index');
    }

    
    
    


}