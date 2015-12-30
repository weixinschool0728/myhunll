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
       
       
        if($content['title']==''||is_feifa($content['title'])){
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
            $a=rename($value, str_replace('Public/Uploads/image/temp', UPLOAD.'image/goods', $value));
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
            'price'=>$content['price'],//
            'goods_form'=>$server_form,//商家服务形式(团队还是个人)
            'goods_sex'=>$content['radio_sex'],//商家性别
            'shuxing'=>$str_shuxing,//属性
            'goods_img'=>'/'.$goods_img,//商品图片
            'goods_img_qita'=>$str_goods_img,//被序列化的其它图片
            'fanxian'=>$content['select_fanxian'],
            'daijinquan'=>$content['radio_daijinquan'],
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
        $count=$goodsmodel->where("user_id={$user_id} and is_delete=0")->count();
        $page=$this->get_page($count, 5);
        $page_foot=$page->show();//显示页脚信息
        $list=$goodsmodel->where("user_id={$user_id} and is_delete=0")->limit($page->firstRow.','.$page->listRows)->order('last_update desc')->select();
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
    
    public function xiugai_mima(){
        $time=gettime();
        $_SESSION['xiugai_mima']=$time;
        $this->assign("time",$time);
        $this->assign("title","会员_修改密码");
        $this->display('xiugai_mima');
    }
    
    public function xiugai_mima_check(){
        if($_POST['check']=='xiugai_mima'){
            $user_id=$_SESSION['huiyuan']['user_id'];
            $mima =$_POST['mima'];
            if(is_feifa($mima)){
                exit();
            }
            $usersmodel=D('Users');
            $salt=$usersmodel->where("user_id=$user_id")->getField('salt');
            $mima_md5=md5($mima.$salt);
            $data=$usersmodel->where("user_id=$user_id and password='{$mima_md5}'")->count();
            $this->ajaxReturn($data);
            exit();
        }
    }
    
    public function xiugai_mima_success(){
        if(!empty($_POST['hidden'])&&!empty($_SESSION['xiugai_mima'])){
            $hidden=$_POST['hidden'];
            if($hidden==$_SESSION['xiugai_mima']){
                $user_id=$_SESSION['huiyuan']['user_id'];
                $mima =$_POST['yuan_mima'];
                if(is_feifa($mima)){
                    exit();
                }
                $usersmodel=D('Users');
                $salt=$usersmodel->where("user_id='{$user_id}'")->getField('salt');
                $mima_md5=md5($mima.$salt);
                $data=$usersmodel->where("user_id='{$user_id}' and password='{$mima_md5}'")->count();
                if($data=='1'){
                     $new_mima_md5=md5($_POST['new_mima'].$salt);
                     $row=array(
                         'password'=>$new_mima_md5
                     );
                     $usersmodel->where("user_id=$user_id")->save($row);
                     $this->success('修改成功,将返回会员页面',U('Member/index'),3);
                }else{
                    $this->error('原密码错误，修改失败',U('Member/xiugai_mima'),3);
                }
            }else{
                $this->error('您中途打开了另一个修改页面，请重新进入',U('Member/xiugai_mima'),3);
            }
        }else{
            $this->error('非法操作，请从修改密码页面进入',U('index/index'),3);

        }
    }
    
    
    public function updated_head(){
        $this->assign("title","会员_更换头像");
        $this->display('updated_head');
    }
    public function getCode(){
        $config =    array(   
            'expire'      =>    30,    //验证码有效期
            'fontSize'    =>    16,    // 验证码字体大小   
            'length'      =>    4,     // 验证码位数   
            'imageW'    =>    160, // 验证码宽度 设置为0为自动计算
            'imageH'    =>    34, // 验证码高度 设置为0为自动计算
        );
       $Verify = new \Think\Verify($config);
       $Verify->entry();
    }
    
    public function cart(){
        $this->assign("title","一起网_我的购物车");
        $user_id=$_SESSION['huiyuan']['user_id'];
        $cartmodel=D('Cart');
        $count=$cartmodel->where("user_id=$user_id")->count();
        $this->assign('count',$count);
        $mycart=$cartmodel->where("user_id=$user_id")->order('join_time desc')->select();
        $this->assign('mycart',$mycart);
        $this->display('cart');
    }
    public function cart_del(){
        $cart_id=$_GET[cart_id];
        $cartmodel=D('Cart');
        $user_id=$_SESSION['huiyuan']['user_id'];
        $count=$cartmodel->where("cart_id=$cart_id and user_id=$user_id")->count();
        if($count==0){
            $this->error('非法操作',U($_SESSION['ref']),3);
            exit();
        }else{
            $cartmodel->where("cart_id=$cart_id")->delete();
        }
    }
    public function cart_zhifu(){
        $this->assign("title","一起网_选择支付方式");
        $cart_item=$_POST['cart_item'];
        $cartmodel=D('Cart');
        $user_id=$_SESSION['huiyuan']['user_id'];
        foreach ($cart_item as $value){
            $tiaojian['cart_id'][]=array('EQ',$value);
        }
        $tiaojian['cart_id'][]='or';
        $cart_zhifu=$cartmodel->where($tiaojian)->where("user_id=$user_id")->select();
        $ordermodel=D('Order');
        $now=time();
        
        foreach ($cart_zhifu as $value){
            //如果该日期已经过去了，返回
            $server_day=$value['server_day'];
            $y=(int)substr($server_day, 0,4);
            $m=(int)substr($server_day, 4,2);
            $d=(int)substr($server_day, 6,2);
            $a=mktime(24, 59, 59, $m, $d, $y);
            if($a<$now){
                $this->error('存在日期已经过去的商品，请从购物车删除该商品后重新拍今天以后的日期',U('Member/cart'),3);
            }
            //如果该条订单已被别人付款，提示已经被购买，返回
            $goods_id=$value['goods_id'];
            $order_qita=$ordermodel->where("goods_id=$goods_id and server_day=$server_day")->find();
            if(!empty($order_qita)){
                if($order_qita['pay_status']==1){
                    $goods_name=$value['goods_name'];
                    $this->error($goods_name.'的日期'.date_geshi1($server_day).'已被购买，请从购物车删除该商品后重新选择其它商品',U('Member/cart'),3);
                }
            }          
        }
        
        //订单写入数据库
        foreach ($cart_zhifu as $value){
            $server_day=$value['server_day'];
            $goods_id=$value['goods_id'];
            //自己已经有的重复订单不再重复写入
            $order_self=$ordermodel->where("user_id=$user_id and goods_id=$goods_id and server_day=$server_day")->find();
            if(empty($order_self)){
                $row=array(
                'user_id'=>$user_id,
                "order_no"=>getname(),
                'goods_id'=>$value['goods_id'],
                'shop_id'=>$value['shop_id'],
                'shop_name'=>$value['shop_name'],
                'goods_name'=>$value['goods_name'],
                'server_day'=>$server_day,
                'status'=>1,//生成订单
                'pay_status'=>0,//支付状态为未支付
                'created'=> mktime(),
                'updated'=> mktime(),
                'price'=>$value['goods_price']
                );
                $result[]=$ordermodel->add($row);//订单信息写入数据库order表
            }
        }
        //清空购物车
        $cartmodel->where($tiaojian)->where("user_id=$user_id")->delete();
        
        if(!empty($result)){
            $_SESSION['cart_order']=$result;
        }
        $result=$_SESSION['cart_order'];
        $tiaojian1['t1.order_id']=array('in',$result);
        $order=$ordermodel->table("m_order t1,m_goods t2,m_category t3")->where($tiaojian1)->where('t1.goods_id=t2.goods_id and t2.cat_id=t3.cat_id')->field('t1.shop_name,t3.cat_name,t1.goods_name,t2.price,t1.server_day')->select();
        
        $price=0.00;
        foreach ($order as $value){
            $price+=$value['price'];
        }
        $price= sprintf("%.2f",$price);
        $this->assign('price',$price);
        $this->assign('order',$order);
        $this->assign('order_id',$result);
        $this->display('cart_zhifu');
    }
    public function cart_gmcg(){
        $this->assign("title","一起网_购买成功");
        $order_id1=$_POST['order_id'];
        $ordermodel=D('Order');
        $goodsmodel=D('Goods');
        $tiaojian['order_id']=array('in',$order_id1);;
        $order_2=$ordermodel->where($tiaojian)->field('goods_id,server_day,goods_name,shop_name')->select();
        $this->assign('order_2',$order_2);
        foreach ($order_id1 as $order_id){
            $order=$ordermodel->where("order_id=$order_id")->field('goods_id,server_day,goods_name,shop_name')->find();
            $this->assign('order',$order);
            $order_user_id=$ordermodel->where("order_id=$order_id")->getField('user_id');//登录用户无该订单权限
            if($order_user_id!=$_SESSION['huiyuan']['user_id']){//登录用户无该订单权限
                $this->error('您没有该订单权限');
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
            $goodsmodel->where("goods_id=$goods_id")->save($row);
        }
        
        $this->display('cart_gmcg');
    }
    
    //下架商品
    public function goods_del(){
        $goods_id=$_GET[goods_id];
        $goodsmodel=D('Goods');
        $user_id=$_SESSION['huiyuan']['user_id'];
        $count=$goodsmodel->where("goods_id=$goods_id and user_id=$user_id")->count();
        if($count==0){
            $this->error('非法操作',U($_SESSION['ref']),3);
            exit();
        }else{
            $data['is_delete']=1;
            $goodsmodel->where("goods_id=$goods_id")->save($data);
        }
    }
    
    //编辑商品
    public function goods_editor(){
        $this->assign("title","一起网_编辑商品");
        if($_SESSION['huiyuan']['shopman_id']==='0'){
            $this->error('您不是婚礼人，将转到注册婚礼人页面',U("Zhuce/zhuce4"),3);
            exit();
        }

        $user_id=$_SESSION['huiyuan']['user_id'];//获取会员id号
        
        
         //获取商品信息
        $goods_id=$_GET['goods_id'];
        $this->assign('goods_id',$goods_id);
        //获取商品服务类型
        $goodsmodel=D('Goods');
        $goods=$goodsmodel->where("goods_id=$goods_id and user_id=$user_id")->find();//商品信息列表
        $this->assign('goods',$goods);
        if(empty($goods)){
            $this->error('非法操作',U($_SESSION['ref']),3);
            exit();
        }
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
        /*
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
       */
       
        if($content['title']==''||is_feifa($content['title'])){
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
            'price'=>$content['price'],//
            'goods_form'=>$server_form,//商家服务形式(团队还是个人)
            'goods_sex'=>$content['radio_sex'],//商家性别
            'shuxing'=>$str_shuxing,//属性
            //'goods_img'=>'/'.$goods_img,//商品图片
            //'goods_img_qita'=>$str_goods_img,//被序列化的其它图片
            'goods_desc'=>$goods_desc,//商品描述
            //'add_time'=>time(),             //添加时间
            'last_update'=>time()            //更新时间初始等于添加时间
        );
        $result_add=$goodsmodel->where("goods_id=$goods_id")->save($row);
        if($result_add){
            $this->success('商品编辑成功！',U('Member/goods_list'),3);
        }
    }
}


