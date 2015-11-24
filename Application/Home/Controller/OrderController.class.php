<?php
namespace Home\Controller;
use Home\Controller;
class OrderController extends FontEndController {
    public function index(){
         $status=$_GET['status'];
         $this->assign('title','我的订单');
         $ordermodel=D('Order');
         $user_id=$_SESSION['huiyuan']['user_id'];
         $status_count['all']=$ordermodel->where("user_id={$user_id}")->count();//获取全部订单条数
         $status_count['no_pay']=$ordermodel->where("user_id={$user_id} and pay_status=0")->count();//获取未付款条数
         $status_count['daiqueren']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=1")->count();//获取待确认条数
         $status_count['daipingjia']=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=2")->count();//获取待评价条数
         $this->assign(status_count,$status_count);
         if(empty($status)){
             $selected['all']="selected='selected'";//选中下拉菜单的全部订单
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id}")->count();
             $this->assign(count,$count);
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.user_id={$user_id} and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t2.price')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='no_pay'){
             $selected['no_pay']="selected='selected'";//选中下拉菜单的未付款
             $this->assign(selected,$selected);
             $selected['all']='selected';
             $count=$ordermodel->where("user_id={$user_id} and pay_status=0")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.user_id={$user_id} and t1.pay_status=0 and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t2.price')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='daiqueren'){
             $selected['daiqueren']="selected='selected'";//选中下拉菜单的待确认
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=1")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.user_id={$user_id} and t1.pay_status=1 and t1.status=1 and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t2.price')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='daipingjia'){
             $selected['daipingjia']="selected='selected'";//选中下拉菜单的待评价
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=2")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.user_id={$user_id} and t1.pay_status=1 and t1.status=2 and t1.goods_id=t2.goods_id")->order('t1.created desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t2.price')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }
         
         
         
         $this->display('index');
    }
    
    public function view(){
        $this->assign('title','我的订单');
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->table('m_order t1,m_users t2,m_goods t3')->where("t1.order_id={$order_id} and t1.shop_id=t2.user_id and t1.goods_id=t3.goods_id")->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.created,t1.updated,t2.true_name,t2.location,t2.mobile_phone,t3.goods_img,t3.price')->find();
        $this->assign('order',$order);
        $this->display('view');
    }

    public function queren(){
        $this->assign('title','确认服务完成');
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->table('m_order t1,m_users t2,m_goods t3')->where("t1.order_id={$order_id} and t1.shop_id=t2.user_id and t1.goods_id=t3.goods_id")->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.created,t1.updated,t2.true_name,t2.location,t2.mobile_phone,t3.goods_img,t3.price')->find();
        $this->assign('order',$order);
        
        $this->display('queren');
    }
    
    public function yanzheng_zfmm(){
        if($_POST['check']=='yanzheng'){
            $user_id=$_SESSION['huiyuan']['user_id'];
            $zhifu_mima =$_POST['mima'];
            if(empty($user_id)||is_feifa($zhifu_mima)){
                exit();
            }
            $usersmodel=D('Users');
            $salt=$usersmodel->where("user_id='{$user_id}'")->getField('salt');
            $mima_md5=md5($zhifu_mima.$salt);
            $data=$usersmodel->where("user_id='{$user_id}' and zhifu_password='{$mima_md5}'")->count();
            $this->ajaxReturn($data);
            exit();
        }
    }
    public function queren_success(){
        $user_id=$_SESSION['huiyuan']['user_id'];
        $zhifu_mima =$_POST['zhifu_password'];
        $order_id=$_POST['order_id'];
        $usersmodel=D('Users');
        $salt=$usersmodel->where("user_id='{$user_id}'")->getField('salt');
        $mima_md5=md5($zhifu_mima.$salt);
        $data=$usersmodel->where("user_id='{$user_id}' and zhifu_password='{$mima_md5}'")->count();
        var_dump($order_id);
        if($data==='1'){
            $ordermodel=D('Order');
            $row=array(
            'status'=>2,//支付状态为支付
            'updated'=> mktime()
                );
            $ordermodel->where("order_id=$order_id")->save($row);
            $this->redirect('Order/appraise',array('order_id'=>$order_id),0);
        }else{
            $this->error('非法进入，将转到主页',U('index/index'),3);
        }
        
    }
    
    public function appraise(){
        $this->assign('title','评价');
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->table('m_order t1,m_users t2,m_goods t3')->where("t1.order_id={$order_id} and t1.shop_id=t2.user_id and t1.goods_id=t3.goods_id")->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.created,t1.updated,t2.true_name,t2.location,t2.mobile_phone,t3.goods_img,t3.price')->find();
        $this->assign('order',$order);
        $this->display('appraise');
    }
}