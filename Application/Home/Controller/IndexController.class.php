<?php
namespace Home\Controller;
use Home\Controller;
class IndexController extends FontEndController {
    public function index(){ 
        $this->assign("title","一起网");
        unset($_SESSION['ref']);
        //获取策划类最新的八个商品信息
        $goodsmodel=D('Goods');
        $cehua=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=1 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name,t2.goods_id,t2.score,t2.buy_number')->select();
        $this->assign('cehua',$cehua);
        $this->assign('a','|');

        
        //获取司仪类最新的八个商品信息
        $siyi=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=2 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name,t2.goods_id,t2.buy_number')->select();
        $this->assign('siyi',$siyi);
        $this->assign('a','|');

        
        //获取布置类最新的八个商品信息
        $buzhi=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=3 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name,t2.goods_id,t2.buy_number')->select();
        $this->assign('buzhi',$buzhi);
        $this->assign('a','|');

        
        //获取摄像类最新的八个商品信息
        $shexiang=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=4 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name,t2.goods_id,t2.buy_number')->select();
        $this->assign('shexiang',$shexiang);
        $this->assign('a','|');

        
        //获取摄影类最新的八个商品信息
        $sheying=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=5 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name,t2.goods_id,t2.buy_number')->select();
        $this->assign('sheying',$sheying);
        $this->assign('a','|');

        
        //获取跟妆类最新的八个商品信息
        $genzhuang=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=6 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name,t2.goods_id,t2.buy_number')->select();
        $this->assign('genzhuang',$genzhuang);
        $this->assign('a','|');

        
        //获取车队类最新的八个商品信息
        $chedui=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=7 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name,t2.goods_id,t2.buy_number')->select();
        $this->assign('chedui',$chedui);
        $this->assign('a','|');

        
        //获取演艺类最新的八个商品信息
        $yanyi=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=8 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name,t2.goods_id,t2.buy_number')->select();
        $this->assign('yanyi',$yanyi);
        $this->assign('a','|');

        
        //获取婚纱租赁类最新的八个商品信息
        $wumei=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=9 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name,t2.goods_id,t2.buy_number')->select();
        $this->assign('wumei',$wumei);
        $this->assign('a','|');

        
        //获取酒店类最新的八个商品信息
        $jiudian=$goodsmodel->table('m_category t1,m_goods t2,m_users t3')->where("t2.cat_id=10 and t2.is_delete=0 and t2.cat_id=t1.cat_id and t2.user_id=t3.user_id")->limit(8)->order('t2.last_update desc')->field('t2.goods_id,t2.area,t2.user_id,t2.goods_name,t2.price,t2.yuan_price,t2.goods_img,t2.comment_number,t1.cat_name,t3.user_name,t2.goods_id,t2.buy_number')->select();
        $this->assign('jiudian',$jiudian);
        $this->assign('a','|');
        
        $this->display('index');
    }
    
    public function menu(){
        if (isset($_SESSION['huiyuan']) && $_SESSION['huiyuan'] !== '') {
            $huiyuanming=$_SESSION['huiyuan']['user_name'];
            $tuichu_url=U('Login/quit');
            $yonghu_url=U('Member/index');
            $this->assign('yonghu_url',$yonghu_url);
            $this->assign('tuichu_url',$tuichu_url);
            $this->assign('huiyuanming',$huiyuanming);
        }
        $zhuce_url=U('Zhuce/index');
        $login_url=U('Login/index');
        $this->assign('zhuce_url',$zhuce_url);
        $this->assign('login_url',$login_url);
        $this->display('menu');
    }
    public function search(){
        $this->assign("title","婚啦啦 ".$sp);
        $url['full']=$_SERVER['REQUEST_URI'];
        $url['full_teshu']=substr($url['full'],0,strpos($url['full'],'?')===FALSE?strlen($url['full']):strpos($url['full'],'?'));
        $url['houmian']=strstr($url['full'],'?');
        $url['url']=str_replace('.html', '',$url['full']);
        $url['teshu']=str_replace('.html', '',$url['full_teshu']);
        $this->assign("url",$url);
        $this->assign('get',$_GET);     
      
        if($_GET['sex']!=null and $_GET['form']!=null){//因为性别和形式是一行，所以当两个都空的时候，必须不显示该div
                $sex_and_form=1;
            }
        $this->assign('sex_and_form',$sex_and_form);
        if($_GET['cid']!=null){
            $tiaojian['t1.cat_id']=$_GET['cid'];
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
            $cat_id=$_GET['cid'];
            $data_cat=$categorymodel->where("cat_id=$cat_id")->getField('shuxing');
            $arr_shuxing0=unserialize($data_cat);//得到反序列化属性数组
            $arr_shuxing=  array_chunk($arr_shuxing0, 2,true);
            $this->assign("arr_shuxing",$arr_shuxing);//给模板里面的$arr_shuxing赋值
            }
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
        
        $sp_1=  str_replace(' ', '%', $_GET['sp']);
        $goodsmodel=D('Goods');
        $search['t1.goods_name']=array('LIKE','%'.$sp_1.'%');
        $count=$goodsmodel->table('m_goods t1,m_users t2')->where($tiaojian)->where("t1.user_id=t2.user_id and t1.is_delete=0")->where($search)->count();
        $page=$this->get_page($count, 48);
        $page_foot=$page->show();//显示页脚信息
        $list=$goodsmodel->table('m_goods t1,m_users t2')->where($tiaojian)->where("t1.user_id=t2.user_id and t1.is_delete=0")->where($search)->limit($page->firstRow.','.$page->listRows)->field('t1.cat_id,t1.goods_id,t1.area,t1.user_id,t1.goods_name,t1.price,t1.yuan_price,t1.goods_img,t1.comment_number,t2.user_name,t1.goods_id,t1.score,t1.buy_number')->order('t1.last_update desc')->select();
        $this->assign('list',$list);
        $this->assign('page_foot',$page_foot);
        
        //获取搜索到的商品里面，所包含的所有分类
        $serch1['goods_name']=array('LIKE','%'.$sp_1.'%');
        $arr_cat_id=$goodsmodel->where($search1)->getField('cat_id',true);
        $arr_cat_id=array_unique($arr_cat_id);
        $this->assign('arr_cat_id',$arr_cat_id);
        
        $this->display(search);
    }

    public function delete_distory(){
        cookie('distory_goods_id',null);
        exit();
    }
    
    

}