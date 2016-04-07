<?php
namespace Admin\Controller;
use Admin\Controller;
class GoodsmanageController extends FontEndController {
   
    public function index(){
        $categorymodel=D('Category');
        $data=$categorymodel->field('cat_name')->select();
        $this->assign('data',$data);
        //获取服务类型表单提交值
        if(!empty($_POST['server_content'])){
            $server_content=$_POST['server_content'];
        }else{
            $server_content=$data[0]['cat_name'];
        }
        $this->assign($server_content,'selected="selected"');
        $this->assign('server_content',$server_content);
        
        $cat_id=$categorymodel->where("cat_name='$server_content'")->getField('cat_id');
        $goodsmodel=D('Goods');
        $serch_name=$_POST['serch'];
        $this->assign('serch_name',$serch_name);
        if(!empty($serch_name)){
            $where['goods_name']=array('like',"%$serch_name%");
            $count=$goodsmodel->where($where)->where("cat_id={$cat_id} and is_delete=0")->count();
        }else{
            $count=$goodsmodel->where("cat_id={$cat_id} and is_delete=0")->count();
        }
        $page=$this->get_page($count, 10);
        $page_foot=$page->show();//显示页脚信息
        if(!empty($serch_name)){
            $where['t1.goods_name']=array('like',"%$serch_name%");
            $list=$goodsmodel->table('m_goods t1,m_users t2')->where($where)->where("t1.cat_id={$cat_id} and t1.is_delete=0 and t1.user_id=t2.user_id")->limit($page->firstRow.','.$page->listRows)->order('goods_id desc')->select();
        }else{
            $list=$goodsmodel->table('m_goods t1,m_users t2')->where("t1.cat_id={$cat_id} and t1.is_delete=0 and t1.user_id=t2.user_id")->limit($page->firstRow.','.$page->listRows)->order('goods_id desc')->select();
        }
        $this->assign('list',$list);
        $this->assign('page_foot',$page_foot);
        $this->display();
    }
    
    
    //编辑商品
    public function goods_editor(){
         //获取商品信息
        $goods_id=$_GET['goods_id'];
        $this->assign('goods_id',$goods_id);
        //获取商品服务类型
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id")->find();//商品信息列表
        $user_id=$goods['user_id'];
        $goods['goods_img_qita']=unserialize($goods['goods_img_qita']);
        $this->assign('goods',$goods);
        $goods_sc=get_catname($goods['cat_id']);//获取服务类型
        $goods_shuxing=unserialize($goods['shuxing']);//得到商品属性
        //遍历商品属性数组，让$属性值='selected="selected"'
        foreach ($goods_shuxing as $key => $value) {
            if(is_numeric($value)){
                $this->assign($key.$value ,'selected="selected"');
            }else{
                $this->assign($value ,'selected="selected"');
            }
        }
        
        //获取该会员基本信息
        $usersmodel=D('Users');
        if(!empty($user_id)||$user_id===0){
        $data=$usersmodel->where("user_id={$user_id}")->find();
        }
        $sc=$data['server_content'];
        $arr_sc=explode('|',$sc);//获取服务内容
        $this->assign("arr_sc",$arr_sc);
        
        //如果服务形式为个人，隐藏性别单选radio
        if($data['server_form']==='0'){
            $this->assign("css",'display: none;');
        }else{
            $this->assign("css",'');
            //团队发布的商品：获取商品性别
            if($goods['goods_sex']==='0'){
                $this->assign('man','selected="selected"');
            }else{
                $this->assign('woman','selected="selected"');
            }
        }
        //获取服务类型表单提交值
        if(!empty($_POST['sc_hidden'])&&$_POST['sc_hidden']==="server_content"){
            $server_content=$_POST['server_content'];
            $this->assign($server_content,'selected="selected"');
            $this->assign('server_content',$server_content);
        }else{
            $server_content=$goods_sc;
            $this->assign($server_content,'selected="selected"');
            $this->assign('server_content',$server_content);
        }
        $categorymodel=D('category');
        $data_cat=$categorymodel->where("cat_name='$server_content'")->getField('shuxing');
        $arr_shuxing=unserialize($data_cat);//得到反序列化属性数组
        $this->assign("arr_shuxing",$arr_shuxing);//给模板里面的$arr_shuxing赋值

        
        $this->display('goods_editor');
    }
    
    public function bianji_check(){
        $goods_id=$_GET['goods_id'];
        $content=$_POST;//获取提交的内容
        if($content['goods_img']===''){
            $this->error('未选择商品图片');
            exit();
        }
        //获取图片URL,分割成数组
        $arr_goods_img=explode('+img+',$content['goods_img']);
        //移动文件 并且改变url
        foreach ($arr_goods_img as &$value) {
            $today=substr($value,26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/goods/'.$today);//创建文件夹（如果存在不会创建）
            if(substr($value, 21,4)==='temp'){
                rename($value, str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods',$value));//移动文件
                $value=str_replace('Public/Uploads/image/temp', '/'.UPLOAD.'image/goods',$value);
            }
        }

        
        //获取第一张图片URL
        $goods_img=$arr_goods_img[0];
       //建立一个去掉第一张图片了的数组并序列化
       array_splice($arr_goods_img,0,1);
       $str_goods_img=serialize($arr_goods_img);
        
        
        if($content['title']==''||is_feifa($content['title'])){
            $this->error('商品标题为空或者含有非法字符');
            exit();
        }
        if(!is_price($content['price'])){
            $this->error('价格为空或者不规范,请输入如100.00');
            exit();
        }
        if(!is_price($content['yuan_price'])){
            $this->error('原价为空或者不规范,请输入如100.00');
            exit();
        }
        $usersmodel=D('Users');
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id")->find();//商品信息列表
        $user_id=$goods['user_id'];
        //$user_id=$_SESSION['admin_huiyuan']['user_id'];
        //获取所在地区
        $content['area']=$usersmodel->where("user_id={$user_id}")->getField('location');

        //根据服务形式获取性别
        $server_form=$usersmodel->where("user_id={$user_id}")->getField('server_form');
        if($server_form==='0'){
            $content['radio_sex']=$usersmodel->where("user_id={$user_id}")->getField('sex');//得到个人的性别
        }
        
        $result=get_file($content['content']);//得到编辑框里面的图片文件
        //遍历图片文件，并把图片文件从临时文件夹保存进正式文件夹,并把文件名存储到$file_name数组中
        foreach ($result[1] as $value){
            $today=substr($value,26,8);//获取到文件夹名  如20150101
            creat_file(UPLOAD.'image/goods/'.$today);//创建文件夹（如果存在不会创建）
            $a=copy($value, str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods', $value));
        }
        $goods_desc=str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods', $content['content']);
        $goods_desc=  replace_a($goods_desc);
        //得到商品分类id
        $categorymodel=D('Category');
        $server_content=$content['server_content'];
        $data_category=$categorymodel->where("cat_name='{$server_content}'")->find();
        $content['cat_id']=$data_category['cat_id'];//得到商品分类ID
         $data_cat=unserialize($data_category['shuxing']);//得到分类的属性,并反序列化成数组
         $data_cat_keys=array_keys($data_cat);//获取属性键名,保存到数组
         //拼凑出属性数组 并序列化
        foreach ($data_cat_keys as $key=>$value){
             $arr_shuxing["$value"]=$content['shuxing'][$key];
         }
        $str_shuxing=serialize($arr_shuxing);
        //保存商品信息，把商品信息写入数据库
        
        $row=array(
            'cat_id'=>$content['cat_id'],//分类ID
            'area'=>$content['area'],     //地区
            'user_id'=>intval($user_id),//所属店铺
            'goods_name'=>$content['title'],//商品名称
            'goods_img'=>$goods_img,//商品图片
            'goods_img_qita'=>$str_goods_img,//被序列化的其它图片
            'yuan_price'=>$content['yuan_price'],//原价
            'price'=>$content['price'],//
            'goods_form'=>$server_form,//商家服务形式(团队还是个人)
            'goods_sex'=>$content['radio_sex'],//商家性别
            'shuxing'=>$str_shuxing,//属性
            'fanxian'=>$content['select_fanxian'],
            'daijinquan'=>$content['radio_daijinquan'],
            'goods_desc'=>$goods_desc,//商品描述
            //'add_time'=>time(),             //添加时间
            'last_update'=>time()            //更新时间初始等于添加时间
        );
        $result_add=$goodsmodel->where("goods_id=$goods_id")->save($row);
        if($result_add){
            $this->success('商品编辑成功！',U('Goodsmanage/index'),3);
        }
    }
    
    //下架商品
    public function goods_del(){
        $goods_id=$_GET['goods_id'];
        $goodsmodel=D('Goods');
        $user_id=$_SESSION['huiyuan']['user_id'];
        $data['is_delete']=1;
        $goodsmodel->where("goods_id=$goods_id")->save($data);
    }
    
    
    public function file_jia(){
        $file_info=$this->upload('image/temp/');//获取上传文件信息
        //获取图片URL
        $data=array();
        $data['src']=UPLOAD.$file_info['file_img']['savepath'].$file_info['file_img']['savename'];
        $this->ajaxReturn($data);
    }
    


}