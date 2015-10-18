<?php
namespace Home\Controller;
use Home\Controller;
class IndexController extends FontEndController {
    public function index(){
        header("content-type:text/html;charset=utf-8");
        header ( " Expires: Mon, 26 Jul 1970 05:00:00 GMT " );
        header ( " Last-Modified:" . gmdate ( " D, d M Y H:i:s " ). "GMT " );
        $this->assign("title","婚啦啦");
        unset($_SESSION['ref']);
        
        //获取策划类最新的八个商品信息
        $goodsmodel=D('Goods');
        $categorymodel=D('Category');
        $list=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=1 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name')->select();
        $this->assign('list',$list);
        $this->assign('a','|');
        $this->display('index');
 
    }


}