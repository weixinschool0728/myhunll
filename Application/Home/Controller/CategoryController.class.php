<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;
use Home\Controller;
class CategoryController extends FontEndController {
    public function index(){
        if(isset($_GET['cid'])){
            $cat_id=$_GET['cid'];
            $cat_name=$this->get_catname($cat_id);
            $this->assign('cat_name',$cat_name);
        
            $categorymodel=D('category');
            $data_cat=$categorymodel->where("cat_id=$cat_id")->getField('shuxing');
            $arr_shuxing0=unserialize($data_cat);//得到反序列化属性数组
            $arr_shuxing=  array_chunk($arr_shuxing0, 2,true);
            $this->assign("arr_shuxing1",$arr_shuxing[0]);//给模板里面的$arr_shuxing赋值
            $this->assign("arr_shuxing2",$arr_shuxing[1]);//给模板里面的$arr_shuxing赋值
            
            $goodsmodel=D('Goods');
            $count=$goodsmodel->where("cat_id={$cat_id}")->count();
            $page=$this->get_page($count, 48);
            $page_foot=$page->show();//显示页脚信息
            $list=$goodsmodel->table('m_goods t1,m_users t2')->where("t1.cat_id={$cat_id} and t1.user_id=t2.user_id and t1.is_delete=0")->limit($page->firstRow.','.$page->listRows)->field('t1.goods_id,t1.area,t1.user_id,t1.goods_name,t1.price,t1.yuan_price,t1.goods_img,t1.comment_number,t2.user_name,t1.goods_id')->order('t1.last_update desc')->select();
            $this->assign('list',$list);
            $this->assign('page_foot',$page_foot);

        
            $this->display(index);
        }
    }
    
    
    
    
    
    public function get_catname($cat){
        switch ($cat){
            case '1':
                return '策划师';
                break;
            case '2':
                return '司仪';
                break;
            case '3':
                return '布置';
                break;
            case '4':
                return '摄像';
                break;
            case '5':
                return '摄影';
                break;
            case '6':
                return '跟妆';
                break;
            case '7':
                return '车队';
                break;
            case '8':
                return '演艺';
                break;
            case '9':
                return '舞美';
                break;
            case '10':
                return '酒店';
                break;
            case '11':
                return '喜铺';
                break;       
        }
    }
}