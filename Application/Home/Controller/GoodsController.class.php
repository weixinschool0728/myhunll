<?php
namespace Home\Controller;
use Home\Controller;
class GoodsController extends FontEndController {
    public function index(){
        header("content-type:text/html;charset=utf-8");
        $goods_id=$_GET['goods_id'];
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->table('m_goods t1,m_users t2,m_category t3')->where("t1.user_id=t2.user_id and t1.goods_id=$goods_id and t1.cat_id=t3.cat_id")->field('t1.goods_id,t1.area,t1.goods_name,t1.price,t1.yuan_price,t1.goods_img,t1.goods_img_qita,t1.goods_sex,t1.goods_desc,t1.comment_number,t1.shuxing,t3.cat_name,t2.user_name,t1.user_id,t2.weixin,t2.qq,t2.mobile_phone,t2.email')->find();
        $this->assign('goods',$goods);
        $img_qita=unserialize($goods['goods_img_qita']);//获取其它展示图数组
        $this->assign('img_qita',$img_qita);
        $user_id=$goods['user_id'];
        $count=$goodsmodel->where("user_id=$user_id")->count();
        $page=$this->get_page($count, 5);
        $page_foot=$page->show();//显示页脚信息
        $goods_qita=$goodsmodel->table('m_goods t1,m_category t2')->where("t1.cat_id=t2.cat_id and t1.user_id=$user_id")->limit($page->firstRow.','.$page->listRows)->order('t1.last_update desc')->field('t2.cat_name,t1.goods_name,t1.price,t1.yuan_price,t1.goods_id')->select();
        $this->assign('goods_qita',$goods_qita);
        $this->assign('page_foot',$page_foot);
        
        $shuxing=unserialize($goods['shuxing']);//获取商品属性数组
        $this->assign('shuxing',$shuxing);
        $this->display('index');
 
    }


}