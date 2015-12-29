<?php
namespace Home\Controller;
use Home\Controller;
class GoodsController extends FontEndController {
    public function index(){
        $time=gettime();
        $_SESSION['mini_login']=$time;
        $this->assign("time", $time);
        //判断是否登录
        if(isset($_SESSION['huiyuan'])){
            $is_login=1;
        }else{
            $is_login=0;
        }
        $this->assign('is_login',$is_login);
        $goods_id=$_GET['goods_id'];
        $this->assign('goods_id',$goods_id);
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->table('m_goods t1,m_users t2,m_category t3')->where("t1.user_id=t2.user_id and t1.goods_id=$goods_id and t1.cat_id=t3.cat_id")->field('t1.goods_id,t1.area,t1.goods_name,t1.price,t1.yuan_price,t1.goods_img,t1.goods_img_qita,t1.goods_sex,t1.goods_desc,t1.comment_number,t1.shuxing,t1.score,t3.cat_name,t2.user_name,t1.user_id,t2.weixin,t2.qq,t2.mobile_phone,t2.email,t1.comment_number,t2.shop_introduce')->find();
        $goods['shop_introduce']=str_replace("\r", "", $goods['shop_introduce']);
        $goods['shop_introduce']=str_replace("\n", "", $goods['shop_introduce']);
        $this->assign('goods',$goods);
        $shop_introduce=strlen($goods['shop_introduce']);
        $this->assign('shop_introduce',$shop_introduce);
        
        $img_qita=unserialize($goods['goods_img_qita']);//获取其它展示图数组
        $this->assign('img_qita',$img_qita);
        $shuxing=unserialize($goods['shuxing']);//获取商品属性数组
        $this->assign('shuxing',$shuxing);
        //获取具体分项目评分
        $ordermodel=D ('Order');
        $pingfen=$ordermodel->where("goods_id={$goods_id}")->getField('pingfen',true);
        foreach ($pingfen as $value){
            $value=unserialize($value);
            $pingfen0+=$value[0];
            $pingfen1+=$value[1];
            $pingfen2+=$value[2];
        }
        $pingfen_fl[]=number_format($pingfen0/count($pingfen),1);
        $pingfen_fl[]=number_format($pingfen1/count($pingfen),1);
        $pingfen_fl[]=number_format($pingfen2/count($pingfen),1);
        $this->assign('pingfen_fl',$pingfen_fl);
        //评论分页
        $count_pinglun=$ordermodel->where("goods_id={$goods_id} and status=3")->count();
        $page_pinglun=$this->get_page($count_pinglun, 4);
        $page_foot_pinglun=$page_pinglun->show();//显示页脚信息
        $list_pinglun=$ordermodel->table('m_order t1,m_users t2')->where("t1.goods_id={$goods_id} and t1.user_id=t2.user_id and t1.status=3")->limit($page_pinglun->firstRow.','.$page_pinglun->listRows)->field('t1.updated,t1.score,t1.appraise_img,t1.appraise,t1.appraise_img,t2.user_name,t2.head_url')->order('t1.updated desc')->select();
        //遍历数组，把img字段反序列化
        foreach ($list_pinglun as &$value){
            $value['appraise_img']=unserialize($value['appraise_img']);
        }
        $this->assign('list_pinglun',$list_pinglun);
        $this->assign('page_foot_pinglun',$page_foot_pinglun);
        
        
        $this->assign("title","一起网—".$goods['user_name'].'—'.$goods['goods_name']);//给标题赋值
        $this->display('index');
 
    }
    public function pinglun(){
        $goods_id=$_GET['goods_id'];
        $ordermodel=D ('Order');
        $count_pinglun=$ordermodel->where("goods_id={$goods_id} and status=3")->count();
        $page_pinglun=$this->get_page($count_pinglun, 4);
        $page_foot_pinglun=$page_pinglun->show();//显示页脚信息
        $list_pinglun=$ordermodel->table('m_order t1,m_users t2')->where("t1.goods_id={$goods_id} and t1.user_id=t2.user_id and t1.status=3")->limit($page_pinglun->firstRow.','.$page_pinglun->listRows)->field('t1.updated,t1.score,t1.appraise_img,t1.appraise,t1.appraise_img,t2.user_name,t2.head_url')->order('t1.updated desc')->select();
        //遍历数组，把img字段反序列化
        foreach ($list_pinglun as &$value){
            $value['appraise_img']=unserialize($value['appraise_img']);
        }
        //$this->assign('list_pinglun',$list_pinglun);
        //$this->assign('page_foot_pinglun',$page_foot_pinglun);
        $data['li']=$list_pinglun;
        $data['page_foot']=$page_foot_pinglun;
        $this->ajaxReturn($data);
    }
    public function page(){
        $goods_id=$_GET['goods_id'];
        $goodsmodel=D('Goods');
        //$goods=$goodsmodel->table('m_goods t1,m_users t2,m_category t3')->where("t1.user_id=t2.user_id and t1.goods_id=$goods_id and t1.cat_id=t3.cat_id")->field('t1.goods_id,t1.area,t1.goods_name,t1.price,t1.yuan_price,t1.goods_img,t1.goods_img_qita,t1.goods_sex,t1.goods_desc,t1.comment_number,t1.shuxing,t3.cat_name,t2.user_name,t1.user_id,t2.weixin,t2.qq,t2.mobile_phone,t2.email')->find();
        $goods=$goodsmodel->where("goods_id=$goods_id")->field('user_id')->find();
        $user_id=$goods['user_id'];
        $count=$goodsmodel->where("user_id=$user_id")->count();
        $page=$this->get_page($count, 5);
        $page_foot=$page->show();//显示页脚信息
        $goods_qita=$goodsmodel->table('m_goods t1,m_category t2')->where("t1.cat_id=t2.cat_id and t1.user_id=$user_id")->limit($page->firstRow.','.$page->listRows)->order('t1.last_update desc')->field('t2.cat_name,t1.goods_name,t1.price,t1.yuan_price,t1.goods_id')->select();
        $data['li']=$goods_qita;
        $data['page_foot']=$page_foot;
        $this->ajaxReturn($data);
    }

    public function buy(){
        $server_day=$_GET['server_day'];
        $y=(int)substr($server_day, 0,4);
        $m=(int)substr($server_day, 4,2);
        $d=(int)substr($server_day, 6,2);
        $a=mktime(24, 59, 59, $m, $d, $y);
        $now=time();
        $goods_id=$_GET['goods_id'];
        if($a<$now){
             $this->error('该日期已经过去，请选择今天以后的日期',U('Goods/index',"goods_id=$goods_id"),3);
        }
        $this->assign('goods_id',$goods_id);
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->table('m_goods t1,m_users t2,m_category t3')->where("t1.user_id=t2.user_id and t1.goods_id=$goods_id and t1.cat_id=t3.cat_id")->field('t1.area,t1.goods_name,t1.price,t3.cat_name,t2.user_name,t1.user_id')->find();
        $this->assign('goods',$goods);
        $this->assign('server_day',$server_day);
        $ordermodel=D('Order');
        //$shop_id=$goods['user_id'];
        //如果该条订单已被别人付款，提示已经被购买，返回首页
        $order_qita=$ordermodel->where("goods_id=$goods_id and server_day=$server_day")->find();
        if(!empty($order_qita)){
            if($order_qita['pay_status']==1){
                $this->error('该日期的商品已被购买，请选择其它商品',U('Goods/index',"goods_id=$goods_id"),3);
            }
        }
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->table('m_goods t1,m_users t2,m_category t3')->where("t1.user_id=t2.user_id and t1.goods_id=$goods_id and t1.cat_id=t3.cat_id")->field('t1.area,t1.goods_name,t1.price,t3.cat_name,t2.user_name,t1.user_id')->find();
        $this->assign('goods',$goods);
        $this->assign('server_day',$server_day);
        $this->display('buy');
    }
    
    public function zhifu(){
        $user_id=$_SESSION['huiyuan']['user_id'];
        $server_day=$_GET['server_day'];
        $y=(int)substr($server_day, 0,4);
        $m=(int)substr($server_day, 4,2);
        $d=(int)substr($server_day, 6,2);
        $a=mktime(24, 59, 59, $m, $d, $y);
        $now=time();
        if($a<$now){
             $this->error('该日期已经过去，请选择今天以后的日期',U($_SESSION['ref']),3);
        }
        $goods_id=$_GET['goods_id'];
        $this->assign('goods_id',$goods_id);
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->table('m_goods t1,m_users t2,m_category t3')->where("t1.user_id=t2.user_id and t1.goods_id=$goods_id and t1.cat_id=t3.cat_id")->field('t1.area,t1.goods_name,t1.price,t3.cat_name,t2.user_name,t1.user_id')->find();
        $this->assign('goods',$goods);
        $this->assign('server_day',$server_day);
        $ordermodel=D('Order');
        //如果该条订单已被别人付款，提示已经被购买，返回
        $order_qita=$ordermodel->where("goods_id=$goods_id and server_day=$server_day")->find();
        if(!empty($order_qita)){
            if($order_qita['pay_status']==1){
                $this->error('该日期的商品已被购买，请选择其它商品',U($_SESSION['ref']),3);
            }
        }
        //如果用户自己已经有了该条订单，未付款，转到付款页面，已付款，提示不能重复购买
        $order_self=$ordermodel->where("user_id=$user_id and goods_id=$goods_id and server_day=$server_day")->find();
        if(!empty($order_self)){
            $this->assign('order_id',$order_self['order_id']);
            $this->display('zhifu');
            exit();
        }

        $row=array(
            'user_id'=>$user_id,
            "order_no"=>getname(),
            'goods_id'=>$goods_id,
            'shop_id'=>$goods['user_id'],
            'shop_name'=>$goods['user_name'],
            'goods_name'=>$goods['goods_name'],
            'server_day'=>$server_day,
            'status'=>1,//生成订单
            'pay_status'=>0,//支付状态为未支付
            'created'=> mktime(),
            'updated'=> mktime(),
            'price'=>$goods['price']
                );
        $result=$ordermodel->add($row);//订单信息写入数据库order表
        if($result){
            $this->assign('order_id',$result);
            $this->display('zhifu');
        }else{
            $this->error('订单提交失败，请重新提交',$_SERVER['HTTP_REFERER'],3);
        }
    }
    
    public function gmcg(){
        $order_id=$_GET['order_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id")->field('goods_id,server_day,goods_name,shop_name')->find();
        $this->assign('order',$order);
        $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
        if($order_user_id!=$_SESSION['huiyuan']['user_id']){//登录用户无该订单权限
            $this->error('您没有该订单权限');
        }
        //如果该条订单已被别人付款，提示已经被购买，返回首页
        $goods_id=$order['goods_id'];
        $server_day=$order['server_day'];
        $tianjian['order_id']=array('neq',$order_id);
        $order_qita=$ordermodel->where($tiaojian)->where("goods_id=$goods_id and server_day=$server_day")->find();
        if(!empty($order_qita)){
            if($order_qita['pay_status']==1){
                $this->error('该日期的商品已被购买，请选择其它商品',U('index/index'),3);
            }
        }
        
        $row=array(
            'pay_status'=>1,//支付状态为支付
            'updated'=> mktime()
                );
        $ordermodel->where("order_id=$order_id")->save($row);
        
        //商品表里面购买数量加1
        $row_goods=array(
            'buy_number'=>$goods['buy_number']+1
        );
        $goodsmodel=D('Goods');
        $goodsmodel->where("goods_id=$goods_id")->save($row);
        $this->display('gmcg');

    }
    
    public function cart_join(){
        if($_POST['check']!=='cart_join'){
            exit();
        }
        $user_id=$_SESSION['huiyuan']['user_id'];
        $server_day=$_POST['server_day'];
        $goods_id=$_POST['goods_id'];
        $cartmodel=D('Cart');
        $count=$cartmodel->where("user_id=$user_id and goods_id=$goods_id and server_day=$server_day")->count();
        if($count!='0'){
            $data='9';
            $this->ajaxReturn($data);
            exit();
        }
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->table('m_goods t1,m_users t2,m_category t3')->where("t1.user_id=t2.user_id and t1.goods_id=$goods_id and t1.cat_id=t3.cat_id")->field('t1.goods_id,t1.goods_name,t1.user_id,t1.price,t1.yuan_price,t1.goods_img,t3.cat_name,t2.user_name')->find();
        $row=array(
            'user_id'=>$user_id,
            'goods_id'=>$goods_id,
            'goods_name'=>$goods['goods_name'],
            'goods_price'=>$goods['price'],
            'yuan_price'=>$goods['price'],
            'shop_name'=>$goods['user_name'],
            'shop_id'=>$goods['user_id'],
            'server_day'=>$server_day,
            'cat_name'=>$goods['cat_name'],
            'goods_img'=>$goods['goods_img'],
            'join_time'=>mktime()
        );
        $result=$cartmodel->add($row);//信息写入数据库
        if($result){
            $data='1';
        }else{
            $data='-1';
        }
        $this->ajaxReturn($data);
        exit();
    }

}