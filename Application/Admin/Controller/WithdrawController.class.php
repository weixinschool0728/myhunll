<?php
namespace Admin\Controller;
use Admin\Controller;
class WithdrawController extends FontEndController {
   
    public function index(){
        $withdrawModel=D('Withdraw');
        $withdraw=$withdrawModel->table('m_withdraw t1,m_users t2')->where("t1.user_id=t2.user_id")->field('t2.user_name,t1.account_style,t1.account_number,t1.withdraw_money,t1.time')->select();
        $this->assign('withdraw',$withdraw);
        $this->display('index');
    }

    
    
    


}