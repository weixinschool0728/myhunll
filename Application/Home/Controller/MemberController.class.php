<?php
namespace Home\Controller;
use Home\Controller;
class MemberController extends FontEndController {
    public function index(){
        $this->assign("title","我的婚啦啦");
        $user_id=$_SESSION['huiyuan']['user_id'];//获取会员id号
        $user_id=$_SESSION['huiyuan']['user_id'];//获取会员id号
        $usersmodel=D('Users');
        if(!empty($user_id)||$user_id===0){
        $data=$usersmodel->where("user_id={$user_id}")->find();
        }
        $this->assign("touxiang_url",$data['head_url']);
        if(date("H" ,$data['reg_time'])<12){
            $day_time='上午好';
        }else if(date("H" ,$data['reg_time'])>=12&&date("H" ,$data['reg_time'])<20){
            $day_time='下午好';
        }else{
            $day_time='晚上好';
        }
        $this->assign("day_time",$day_time);
        $this->assign("userdata",$data);
        $this->display('index');
    }
    
    public function  hunlirenshangjiaxinxi(){
        if($_SESSION['huiyuan']['shopman_id']==='0'){
            $_SESSION['ref']=CONTROLLER_NAME.'/'.ACTION_NAME;
            $this->error('您不是婚礼人，将转到注册婚礼人页面',U("Zhuce/zhuce4"),3);
            //header("location:". U("Zhuce/zhuce4"));
            exit();
        }
        $this->assign("title","我是婚礼人");
        $user_id=$_SESSION['huiyuan']['user_id'];//获取会员id号
        $usersmodel=D('Users');
        if(!empty($user_id)||$user_id===0){
        $data=$usersmodel->where("user_id={$user_id}")->find();
        }
        $this->assign("touxiang_url",$data['head_url']);
        if(date("H" ,$data['reg_time'])<12){
            $day_time='上午好';
        }else if(date("H" ,$data['reg_time'])>=12&&date("H" ,$data['reg_time'])<20){
            $day_time='下午好';
        }else{
            $day_time='晚上好';
        }
        $this->assign("day_time",$day_time);
        $this->assign("userdata",$data);
        $this->display('hunlirenshangjiaxinxi');
        
    }
    public function release_goods(){
        if($_SESSION['huiyuan']['shopman_id']==='0'){
            $this->error('您不是婚礼人，将转到注册婚礼人页面',U("Zhuce/zhuce4"),3);
            //header("location:". U("Zhuce/zhuce4"));
            exit();
        } 
        $this->assign("title","婚礼人发布商品");
        //获取该会员基本信息
        $user_id=$_SESSION['huiyuan']['user_id'];//获取会员id号
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
        }
        //获取服务类型表单提交值
        if(!empty($_POST['sc_hidden'])&&$_POST['sc_hidden']==="server_content"){
            $server_content=$_POST['server_content'];
            $this->assign($server_content,'selected="selected"');
            $this->assign('server_content',$server_content);
        }else{
            $server_content=$arr_sc[0];
            $this->assign('server_content',$server_content);
        }
        $categorymodel=D('category');
        $data_cat=$categorymodel->where("cat_name='$server_content'")->getField('shuxing');
        $arr_shuxing=unserialize($data_cat);//得到反序列化属性数组
        $this->assign("arr_shuxing",$arr_shuxing);//给模板里面的$arr_shuxing赋值
        //var_dump($arr_shuxing);
        $this->display('release_goods');
    }
    
    
    public function release_check(){
        $content=$_POST;//获取提交的内容
        $file_info=$this->upload('image/goods/');//获取上传文件信息
        if(count($file_info)<1){
            $this->error('未选择商品头像图片');
            exit();
        }
        //获取图片URL
        $goods_img=UPLOAD.$file_info['file_img']['savepath'].$file_info['file_img']['savename'];
       //先建立一个去掉第一张图片了的info
       $file_info_new=$file_info;
       unset($file_info_new['file_img']);
       //获取其它图片url 放到数组中
       foreach ($file_info_new as $value){
           $arr_goods_img[]='/'.UPLOAD.$value['savepath'].$value['savename'];
       }
       $str_goods_img=serialize($arr_goods_img);
       
       
        if($content['title']===''||is_feifa($content['title'])){
            $this->error('商品标题为空或者含有非法字符');
            exit();
        }
        if(!is_shuzi($content['price'])||is_feifa($content['price'])){
            $this->error('价格为空或者含有非法字符');
            exit();
        }
        if(!is_shuzi($content['yuan_price'])||is_feifa($content['yuan_price'])){
            $this->error('原价为空或者含有非法字符');
            exit();
        }
        $usersmodel=D('Users');
        $user_id=$_SESSION['huiyuan']['user_id'];
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
        $goodsmodel=D('Goods');
        $row=array(
            'cat_id'=>$content['cat_id'],//分类ID
            'area'=>$content['area'],     //地区
            'user_id'=>intval($user_id),//所属店铺
            'goods_name'=>$content['title'],//商品名称
            'yuan_price'=>$content['yuan_price'],//原价
            'price'=>$content['price'],//售价
            'shuxing'=>$str_shuxing,//属性
            'goods_img'=>'/'.$goods_img,//商品图片
            'goods_img_qita'=>$str_goods_img,//被序列化的其它图片
            'goods_desc'=>$goods_desc,//商品描述
            'add_time'=>time(),             //添加时间
            'last_update'=>time()            //更新时间初始等于添加时间
        );
        $result_add=$goodsmodel->add($row);
        if($result_add){
            $this->success('恭喜您，商品发布成功了',U('Member/goods_list'),3);
        }
    }
    

    
    public function editor_check(){
        $file_info=$this->upload('image/temp/');
        //当有文件没有上传时，提示并返回
        if(count($file_info)<1){
            $this->error('请选择文件');
            exit();
        }
        
        $file_url=UPLOAD.$file_info['imgFile']['savepath'].$file_info['imgFile']['savename'];
        $data_1=array(
            'error' => 0,
            'url' => '/'.$file_url
        );
        echo json_encode($data_1);
        exit();
    }
    
    public function goods_list(){
        if($_SESSION['huiyuan']['shopman_id']==='0'){
            $this->error('您还不是婚礼人，请先注册成为婚礼人',U("Zhuce/zhuce4"),3);
            //header("location:". U("Zhuce/zhuce4"));
            exit();
        }
        $this->assign('title','商品列表');
        $goodsmodel=D('Goods');
        $user_id=$_SESSION['huiyuan']['user_id'];
        $count=$goodsmodel->where("user_id={$user_id}")->count();
        $page=$this->get_page($count, 5);
        $page_foot=$page->show();//显示页脚信息
        $list=$goodsmodel->where("user_id={$user_id}")->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page_foot',$page_foot);
        
        $this->display('goods_list');
    }
    
    public function order(){
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
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.user_id={$user_id} and t1.goods_id=t2.goods_id")->field('t1.order_id,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t2.price')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='no_pay'){
             $selected['no_pay']="selected='selected'";//选中下拉菜单的未付款
             $this->assign(selected,$selected);
             $selected['all']='selected';
             $count=$ordermodel->where("user_id={$user_id} and pay_status=0")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.user_id={$user_id} and t1.pay_status=0 and t1.goods_id=t2.goods_id")->field('t1.order_id,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t2.price')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='daiqueren'){
             $selected['daiqueren']="selected='selected'";//选中下拉菜单的待确认
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=1")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.user_id={$user_id} and t1.pay_status=1 and t1.status=1 and t1.goods_id=t2.goods_id")->field('t1.order_id,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t2.price')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }else if($status==='daipingjia'){
             $selected['daipingjia']="selected='selected'";//选中下拉菜单的待评价
             $this->assign(selected,$selected);
             $count=$ordermodel->where("user_id={$user_id} and pay_status=1 and status=2")->count();
             $page=$this->get_page($count, 10);
             $page_foot=$page->show();//显示页脚信息
             $list=$ordermodel->table('m_order t1,m_goods t2')->where("t1.user_id={$user_id} and t1.pay_status=1 and t1.status=2 and t1.goods_id=t2.goods_id")->field('t1.order_id,t1.goods_id,t1.goods_name,t1.server_day,t1.shop_name,t1.status,t1.pay_status,t1.updated,t2.goods_img,t2.price')->limit($page->firstRow.','.$page->listRows)->select();
             $this->assign('list',$list);
             $this->assign('page_foot',$page_foot);
         }
         
         
         
         $this->display('order');
    }
}