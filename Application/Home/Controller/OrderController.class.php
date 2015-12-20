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
        $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
        if($order_user_id!=$_SESSION['huiyuan']['user_id']){//登录用户无该订单权限
            $this->error('您没有该订单权限');
        }
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
        $ordermodel=D('Order');
        $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
        if($order_user_id!=$_SESSION['huiyuan']['user_id']){//登录用户无该订单权限
            $this->error('您没有该订单权限');
        }
        $usersmodel=D('Users');
        $salt=$usersmodel->where("user_id='{$user_id}'")->getField('salt');
        $mima_md5=md5($zhifu_mima.$salt);
        $data=$usersmodel->where("user_id='{$user_id}' and zhifu_password='{$mima_md5}'")->count();
        if($data==='1'){
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
        $this->assign('order_id',$order_id);
        $ordermodel=D('Order');
        $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
        if($order_user_id!=$_SESSION['huiyuan']['user_id']){//登录用户无该订单权限
            $this->error('您没有该订单权限');
        }
        $order=$ordermodel->table('m_order t1,m_users t2,m_goods t3')->where("t1.order_id={$order_id} and t1.shop_id=t2.user_id and t1.goods_id=t3.goods_id")->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.created,t1.updated,t2.true_name,t2.location,t2.mobile_phone,t3.goods_img,t3.price')->find();
        $this->assign('order',$order);
        $this->display('appraise');
    }
    public function appraise_success(){
        $this->assign('title','评价成功');
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $user_id=$_SESSION['huiyuan']['user_id'];
        $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
        if($order_user_id!=$user_id){//登录用户无该订单权限
            $this->error('您没有该订单权限');
        }
        $content=$_POST;//获取提交的内容
        $pinglun=$content['pingjia_text'];
        if($_FILES['file_img']['name']!=''||$_FILES['file_img1']['name']!=''||$_FILES['file_img2']['name']!=''){
            $file_info=$this->upload('image/appraise/');//获取上传文件信息
            //把url 保存到数组中
            foreach ($file_info as $value){
                $arr_img[]='/'.UPLOAD.$value['savepath'].$value['savename'];
            }
            $str_img=serialize($arr_img);//序列化数组
        }
        if(is_feifa($pinglun)){
            $this->error('评论含有非法字符');
            exit();
        }
        if($pinglun==''){
            $pinglun='服务很好，特别专业，我很满意';//如果没有留下评论，自动评论为这句话
        }
        unset($content['pingjia_text']);//从数组中删除评论
        foreach($content as $value){
            if($value==''||  is_feifa($value)){
                $this->error('评分为空或者含有非法字符');
                exit();
            }
            $pingfen[]=$value;
            $score=$score+$value;
        }
        $score=$score/3;
        $score=number_format($score, 1);
        $pingfen=serialize($pingfen);//序列化数组      
        
        //更新order表里面的数据，存入数据库
        $order_status=$ordermodel->where("order_id=$order_id")->getField('status');//订单是否是已确认状态
        if($order_status!='2'){
            $this->error('订单状态不是已确认状态');
            exit();
        }
        $row=array(
            'status'=>3,//支付状态为已评价
            'appraise'=>$pinglun,
            'score'=>$score,
            'pingfen'=>$pingfen,
            'appraise_img'=>$str_img,
            'updated'=> mktime()
                );
        $ordermodel->where("order_id=$order_id")->save($row);
        
        //更新商品表里面的分数和评价人数，存入
        $goods_id=$ordermodel->where("order_id=$order_id")->getField('goods_id');//得到商品id
        $array_score=$ordermodel->where("goods_id=$goods_id and status=3")->getField('score',true);
        $goods_score=0;
        foreach ($array_score as $score_value){
            $goods_score+=$score_value;
        }
        $score_count=count($array_score);
        $goods_score=$goods_score/$score_count;
        $row1=array(
            'score'=>$goods_score,
            'comment_number'=>$score_count
        );
        $goodsmodel=D('Goods');
        $goodsmodel->where("goods_id=$goods_id")->save($row1);
        
        $this->redirect('Order/appraise_manage',array('order_id'=>$order_id),0);

    }
    
    public function appraise_manage(){
        $this->assign('title','我已评价');
        $ordermodel=D('Order');
        $user_id=$_SESSION['huiyuan']['user_id'];
        $count=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=3")->count();
        $page=$this->get_page($count, 10);
        $page_foot=$page->show();//显示页脚信息
        $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.user_id={$user_id} and t1.pay_status=1 and t1.status=3 and t1.goods_id=t2.goods_id")->order('t1.updated desc')->field('t1.order_id,t1.order_no,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.updated,t1.pingfen,t1.appraise,t2.goods_img')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page_foot',$page_foot);
         
        $this->display('appraise_manage');
    }
}