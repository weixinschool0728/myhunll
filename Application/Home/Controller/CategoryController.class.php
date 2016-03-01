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
            $this->assign("title","一起网 ".$cat_name);
            $url['full']=$_SERVER['REQUEST_URI'];
            $url['full_teshu']=substr($url['full'],0,strpos($url['full'],'?')===FALSE?strlen($url['full']):strpos($url['full'],'?'));
            $url['houmian']=strstr($url['full'],'?');
            $url['url']=str_replace('.html', '',$url['full']);
            $url['teshu']=str_replace('.html', '',$url['full_teshu']);
            $this->assign("url",$url);
            $get=$_GET;
            $this->assign('get',$get);//get赋值给模板
            //order的url
            $get_cs['order_moren']=$get;
            unset($get_cs['order_moren']['order']);
            
            $get_cs['order_xiaoliang']=$get;
            $get_cs['order_xiaoliang']['order']='number_desc';
            
            $get_cs['order_price_desc']=$get;
            $get_cs['order_price_desc']['order']='price_desc';
            $get_cs['order_price_asc']=$get;
            $get_cs['order_price_asc']['order']='price_asc';
            
            $get_cs['order_pinglun']=$get;
            $get_cs['order_pinglun']['order']='pinglun_desc';
            
            $get_cs['order_update']=$get;
            $get_cs['order_update']['order']='update_desc';
            //代金券url
            $get_cs['daijinquan']=$get;
            $get_cs['daijinquan']['daijinquan']='1';
            $get_cs['no_daijinquan']=$get;
            unset($get_cs['no_daijinquan']['daijinquan']);
            
            //返现url
            $get_cs['fanxian']=$get;
            $get_cs['fanxian']['fanxian']='1';
            $get_cs['no_fanxian']=$get;
            unset($get_cs['no_fanxian']['fanxian']);
            
            //性别url
            $get_cs['sex_1']=$get;
            $get_cs['sex_1']['sex']='1';
            $get_cs['sex_0']=$get;
            $get_cs['sex_0']['sex']='0';
            $get_cs['no_sex']=$get;
            unset($get_cs['no_sex']['sex']);
            
            //形式url
            $get_cs['form_1']=$get;
            $get_cs['form_1']['form']='1';
            $get_cs['form_0']=$get;
            $get_cs['form_0']['form']='0';
            $get_cs['no_form']=$get;
            unset($get_cs['no_form']['form']);
            
            
            $this->assign('get_cs',$get_cs);//get_cs赋值给模板
            
           
            if($_GET['sex']!=null and $_GET['form']!=null){//因为性别和形式是一行，所以当两个都空的时候，必须不显示该div
                $sex_and_form=1;
            }
            $this->assign('sex_and_form',$sex_and_form);
            //把shuxing参数给分割成数组
            if($_GET['shuxing']!==null){
                $shuxing=explode('+',$_GET['shuxing']);
                $this->assign('shuxing',$shuxing);
                
                foreach ($shuxing as $key => $value) {
                    $shuxing_value=explode('-',$value);
                    $tiaojian['shuxing'][]=array('LIKE','%'.$shuxing_value[0].'\";s:'.strlen($shuxing_value[1]).':\"'.$shuxing_value[1].'%');
                }
            }
            
            $categorymodel=D('category');
            $data_cat=$categorymodel->where("cat_id=$cat_id")->getField('shuxing');
            $arr_shuxing0=unserialize($data_cat);//得到反序列化属性数组
            $shuxing_count=count($arr_shuxing0);
            $this->assign(shuxing_count,$shuxing_count);
            $arr_shuxing=  array_chunk($arr_shuxing0, 2,true);
            $this->assign("arr_shuxing",$arr_shuxing);//给模板里面的$arr_shuxing赋值
            $goodsmodel=D('Goods');
            if($_GET['sex']!=null){
                $tiaojian['t1.goods_sex']=$_GET['sex'];
            }
            if($_GET['form']!=null){
                $tiaojian['t2.server_form']=$_GET['form'];
            }
            if($_GET['location']!=null){
                $tiaojian['t2.location']=array('LIKE','%'.$_GET['location']);
            }
            if($_GET['price']!=null){
                switch ($_GET['price']){
                    case '400元以下':
                        $tiaojian['t1.price']=array('ELT',400);
                        break;
                    case '400-600元':
                        $tiaojian['t1.price']=array('BETWEEN','400,600');
                        break;
                    case '600-800元':
                        $tiaojian['t1.price']=array('BETWEEN','600,800');
                        break;
                    case '800-1000元':
                        $tiaojian['t1.price']=array('BETWEEN','800,1000');
                        break;
                    case '1000元以上':
                        $tiaojian['t1.price']=array('EGT',1000);
                        break;
                }
            }
            if($_GET['price_s']!=null or $_GET['price_b']!=null){
                $tiaojian['t1.price']=array(array('EGT',$_GET['price_s']),array('ELT',$_GET['price_b']));
            }
            if($_GET['daijinquan']==='1'){
                $tiaojian['t1.daijinquan']='1';
            }
            if($_GET['fanxian']!=null){
                $tiaojian['t1.fanxian']=array('neq',0);
            }
            
            $count=$goodsmodel->table('m_goods t1,m_users t2')->where($tiaojian)->where("t1.cat_id={$cat_id} and t1.user_id=t2.user_id and t1.is_delete=0")->count();
            $page=$this->get_page($count, 48);
            $page_foot=$page->show();//显示页脚信息
            
            
            //排序
            $order=$_GET['order'];
            if(empty($order)){
                $list=$goodsmodel->table('m_goods t1,m_users t2')->where($tiaojian)->where("t1.cat_id={$cat_id} and t1.user_id=t2.user_id and t1.is_delete=0")->limit($page->firstRow.','.$page->listRows)->field('t1.goods_id,t1.area,t1.user_id,t1.goods_name,t1.price,t1.yuan_price,t1.goods_img,t1.comment_number,t2.user_name,t1.goods_id,t1.score,t1.buy_number,t1.daijinquan,t1.fanxian')->order('t1.daijinquan desc,t1.fanxian desc,t1.buy_number desc,t1.score desc,t1.last_update desc')->select();
            }elseif($order==='number_desc'){
                $list=$goodsmodel->table('m_goods t1,m_users t2')->where($tiaojian)->where("t1.cat_id={$cat_id} and t1.user_id=t2.user_id and t1.is_delete=0")->limit($page->firstRow.','.$page->listRows)->field('t1.goods_id,t1.area,t1.user_id,t1.goods_name,t1.price,t1.yuan_price,t1.goods_img,t1.comment_number,t2.user_name,t1.goods_id,t1.score,t1.buy_number,t1.daijinquan,t1.fanxian')->order('t1.buy_number desc,t1.last_update desc')->select();
            }elseif($order==='price_desc'){
                $list=$goodsmodel->table('m_goods t1,m_users t2')->where($tiaojian)->where("t1.cat_id={$cat_id} and t1.user_id=t2.user_id and t1.is_delete=0")->limit($page->firstRow.','.$page->listRows)->field('t1.goods_id,t1.area,t1.user_id,t1.goods_name,t1.price,t1.yuan_price,t1.goods_img,t1.comment_number,t2.user_name,t1.goods_id,t1.score,t1.buy_number,t1.daijinquan,t1.fanxian')->order('t1.price desc,t1.last_update desc')->select();
            }elseif($order==='pinglun_desc'){
                $list=$goodsmodel->table('m_goods t1,m_users t2')->where($tiaojian)->where("t1.cat_id={$cat_id} and t1.user_id=t2.user_id and t1.is_delete=0")->limit($page->firstRow.','.$page->listRows)->field('t1.goods_id,t1.area,t1.user_id,t1.goods_name,t1.price,t1.yuan_price,t1.goods_img,t1.comment_number,t2.user_name,t1.goods_id,t1.score,t1.buy_number,t1.daijinquan,t1.fanxian')->order('t1.score desc,t1.last_update desc')->select();
            }elseif($order==='update_desc'){
                $list=$goodsmodel->table('m_goods t1,m_users t2')->where($tiaojian)->where("t1.cat_id={$cat_id} and t1.user_id=t2.user_id and t1.is_delete=0")->limit($page->firstRow.','.$page->listRows)->field('t1.goods_id,t1.area,t1.user_id,t1.goods_name,t1.price,t1.yuan_price,t1.goods_img,t1.comment_number,t2.user_name,t1.goods_id,t1.score,t1.buy_number,t1.daijinquan,t1.fanxian')->order('t1.last_update desc')->select();
            }elseif($order==='price_asc'){
                $list=$goodsmodel->table('m_goods t1,m_users t2')->where($tiaojian)->where("t1.cat_id={$cat_id} and t1.user_id=t2.user_id and t1.is_delete=0")->limit($page->firstRow.','.$page->listRows)->field('t1.goods_id,t1.area,t1.user_id,t1.goods_name,t1.price,t1.yuan_price,t1.goods_img,t1.comment_number,t2.user_name,t1.goods_id,t1.score,t1.buy_number,t1.daijinquan,t1.fanxian')->order('t1.price,t1.last_update desc')->select();
            }
            
            $this->assign('list',$list);
            $this->assign('page_foot',$page_foot);

            //获取广告商品列表
            $guanggao=$goodsmodel->where("cat_id={$cat_id}")->order('advert_cat_order')->limit(12)->field('goods_id,goods_name,goods_img,price,buy_number')->select();
            $this->assign('guanggao',$guanggao);
            $this->display(index);
        }
    }
    
    
    
    
    
    private function get_catname($cat){
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
                return '婚纱';
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