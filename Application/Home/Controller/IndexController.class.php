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
        $cehua=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=1 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name')->select();
        $this->assign('cehua',$cehua);
        $this->assign('a','|');

        
        //获取司仪类最新的八个商品信息
        $siyi=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=2 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name')->select();
        $this->assign('siyi',$siyi);
        $this->assign('a','|');

        
        //获取布置类最新的八个商品信息
        $buzhi=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=7 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name')->select();
        $this->assign('buzhi',$buzhi);
        $this->assign('a','|');

        
        //获取摄像类最新的八个商品信息
        $shexiang=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=3 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name')->select();
        $this->assign('shexiang',$shexiang);
        $this->assign('a','|');

        
        //获取摄影类最新的八个商品信息
        $sheying=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=4 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name')->select();
        $this->assign('sheying',$sheying);
        $this->assign('a','|');

        
        //获取跟妆类最新的八个商品信息
        $genzhuang=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=6 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name')->select();
        $this->assign('genzhuang',$genzhuang);
        $this->assign('a','|');

        
        //获取车队类最新的八个商品信息
        $chedui=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=5 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name')->select();
        $this->assign('chedui',$chedui);
        $this->assign('a','|');

        
        //获取演艺类最新的八个商品信息
        $yanyi=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=8 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name')->select();
        $this->assign('yanyi',$yanyi);
        $this->assign('a','|');

        
        //获取舞美类最新的八个商品信息
        $wumei=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=9 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name')->select();
        $this->assign('wumei',$wumei);
        $this->assign('a','|');

        
        //获取酒店类最新的八个商品信息
        $jiudian=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=10 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name')->select();
        $this->assign('jiudian',$jiudian);
        $this->assign('a','|');
        $this->display('index');
    }


}