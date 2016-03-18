<?php

namespace Home\Controller;

use Home\Controller;

class GoodsController extends FontEndController {

    public function index() {
        $time = gettime();
        $_SESSION['mini_login'] = $time;
        $this->assign("time", $time);
        //判断是否登录
        if (isset($_SESSION['huiyuan'])) {
            $is_login = 1;
            $user_id = $_SESSION['huiyuan']['user_id'];
            $this->assign('user_id', $user_id);
        } else {
            $is_login = 0;
        }
        $this->assign('is_login', $is_login);
        $goods_id = $_GET['goods_id'];
        $this->assign('goods_id', $goods_id);
        $goodsmodel = D('Goods');
        $goods = $goodsmodel->table('m_goods t1,m_users t2,m_category t3')->where("t1.user_id=t2.user_id and t1.goods_id=$goods_id and t1.cat_id=t3.cat_id")->field('t1.user_id,t1.goods_id,t1.area,t1.goods_name,t1.price,t1.yuan_price,t1.goods_img,t1.goods_img_qita,t1.goods_sex,t1.goods_desc,t1.comment_number,t1.shuxing,t1.score,t3.cat_name,t2.user_name,t1.user_id,t2.weixin,t2.qq,t2.mobile_phone,t2.email,t1.comment_number,t2.shop_introduce,t1.daijinquan,t1.fanxian,t2.weixin_erweima,t1.cat_id,t1.is_delete,t1.buy_number')->find();
        if($goods['is_delete']==='1'){
            $this->error('该商品已被删除！', '/Home/Index/index');
        }
        
        //把商品id赋值给cookie 并且永久保存.
        if (is_shuzi($goods_id)) {
            $arr_goods_id = cookie('distory_goods_id') == '' ? array() : cookie('distory_goods_id');
            $is_in = in_array($goods_id, $arr_goods_id);
            if ($is_in === false) {
                if (count($arr_goods_id) > 4) {
                    array_shift($arr_goods_id);
                }
                array_push($arr_goods_id, $goods_id);
                cookie('distory_goods_id', $arr_goods_id, 2419200); //保存到cookie中一个月
            }
        } else {
            $this->error('发生错误：商品id不正确!', 'Index/index');
        }



        
        $goods['shop_introduce'] = str_replace("\r", "", $goods['shop_introduce']);
        $goods['shop_introduce'] = str_replace("\n", "", $goods['shop_introduce']);
        $goods['url']['url'] = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $goods['url']['goods_name'] = urlencode('一起网-' . $goods['cat_name'] . '-' . $goods['goods_name']);
        $goods['url']['goods_img'] = urlencode('http://www.17each.com' . $goods['goods_img']);
        $goods['url']['summary'] = urlencode('一起网，您的婚庆专家。' . $goods['cat_name'] . '-' . $goods['goods_name']);
        $this->assign('goods', $goods);
        $shop_introduce = strlen($goods['shop_introduce']);
        $this->assign('shop_introduce', $shop_introduce);

        $img_qita = unserialize($goods['goods_img_qita']); //获取其它展示图数组
        $this->assign('img_qita', $img_qita);
        $shuxing = unserialize($goods['shuxing']); //获取商品属性数组
        $this->assign('shuxing', $shuxing);
        //获取具体分项目评分
        $ordermodel = D('Order');
        $pingfen = $ordermodel->where("goods_id={$goods_id}")->getField('pingfen', true);
        foreach ($pingfen as $value) {
            $value = unserialize($value);
            $pingfen0+=$value[0];
            $pingfen1+=$value[1];
            $pingfen2+=$value[2];
        }
        $pingfen_fl[] = number_format($pingfen0 / count($pingfen), 1);
        $pingfen_fl[] = number_format($pingfen1 / count($pingfen), 1);
        $pingfen_fl[] = number_format($pingfen2 / count($pingfen), 1);
        $this->assign('pingfen_fl', $pingfen_fl);
        //评论分页
        $count_pinglun = $ordermodel->where("goods_id={$goods_id} and status=3")->count();
        $page_pinglun = $this->get_page($count_pinglun, 4);
        $page_foot_pinglun = $page_pinglun->show(); //显示页脚信息
        $list_pinglun = $ordermodel->table('m_order t1,m_users t2')->where("t1.goods_id={$goods_id} and t1.user_id=t2.user_id and t1.status=3")->limit($page_pinglun->firstRow . ',' . $page_pinglun->listRows)->field('t1.updated,t1.score,t1.appraise_img,t1.appraise,t1.appraise_img,t2.user_name,t2.head_url')->order('t1.updated desc')->select();
        //遍历数组，把img字段反序列化
        foreach ($list_pinglun as &$value) {
            $value['appraise_img'] = unserialize($value['appraise_img']);
        }
        $this->assign('list_pinglun', $list_pinglun);
        $this->assign('page_foot_pinglun', $page_foot_pinglun);


        //获取广告商品列表
        $guanggao = $goodsmodel->where("cat_id={$goods['cat_id']}")->order('advert_shop_order')->limit(12)->field('goods_id,goods_name,goods_img,price,buy_number')->select();
        $this->assign('guanggao', $guanggao);

        $ordermodel = D('Order');
        //$shop_id=$goods['user_id'];
        //找出该商品的已被下单的日期，js标注背景色，并加事件点击的话提示已经被购买，
        $buy_server_day = $ordermodel->where("goods_id=$goods_id and status<>'4'")->getField('server_day', true);
        $this->assign('buy_server_day', $buy_server_day);

        //找出该商品是否被用户收藏了
        $sellectionmodel = D('Sellection');
        if ($is_login == 1) {
            $user_id = $_SESSION['huiyuan']['user_id'];
            $is_sellect = $sellectionmodel->where("goods_id=$goods_id and user_id=$user_id")->find();
            $sellection_count = $sellectionmodel->where("user_id=$user_id")->count();
            $this->assign('sellection_count', $sellection_count);
        } else {
            $is_sellect = NULL;
        }
        $this->assign('is_sellect', $is_sellect);
        //该商品被收藏了多少次
        $sellection_count = $sellectionmodel->where("goods_id=$goods_id")->count();
        $this->assign('sellection_count', $sellection_count);

        //其它商品
        $goods_qita_user = $goodsmodel->where("goods_id=$goods_id")->field('user_id')->find();
        $qita_user_id = $goods_qita_user['user_id'];
        $goods_qita = $goodsmodel->where("user_id=$qita_user_id and is_delete=0")->order('last_update desc')->field('goods_id,goods_name,goods_img,price,buy_number')->limit(12)->select();
        $this->assign('goods_qita', $goods_qita);

        $this->assign("title", "一起网—" . $goods['user_name'] . '—' . $goods['goods_name']); //给标题赋值
        $this->display('index');
    }

    public function pinglun() {
        $goods_id = $_GET['goods_id'];
        $ordermodel = D('Order');
        $count_pinglun = $ordermodel->where("goods_id={$goods_id} and status=3")->count();
        $page_pinglun = $this->get_page($count_pinglun, 4);
        $page_foot_pinglun = $page_pinglun->show(); //显示页脚信息
        $list_pinglun = $ordermodel->table('m_order t1,m_users t2')->where("t1.goods_id={$goods_id} and t1.user_id=t2.user_id and t1.status=3")->limit($page_pinglun->firstRow . ',' . $page_pinglun->listRows)->field('t1.updated,t1.score,t1.appraise_img,t1.appraise,t1.appraise_img,t2.user_name,t2.head_url')->order('t1.updated desc')->select();
        //遍历数组，把img字段反序列化
        foreach ($list_pinglun as &$value) {
            $value['appraise_img'] = unserialize($value['appraise_img']);
        }
        //$this->assign('list_pinglun',$list_pinglun);
        //$this->assign('page_foot_pinglun',$page_foot_pinglun);
        $data['li'] = $list_pinglun;
        $data['page_foot'] = $page_foot_pinglun;
        $this->ajaxReturn($data);
    }

    public function page() {
        $goods_id = $_GET['goods_id'];
        $goodsmodel = D('Goods');
        //$goods=$goodsmodel->table('m_goods t1,m_users t2,m_category t3')->where("t1.user_id=t2.user_id and t1.goods_id=$goods_id and t1.cat_id=t3.cat_id")->field('t1.goods_id,t1.area,t1.goods_name,t1.price,t1.yuan_price,t1.goods_img,t1.goods_img_qita,t1.goods_sex,t1.goods_desc,t1.comment_number,t1.shuxing,t3.cat_name,t2.user_name,t1.user_id,t2.weixin,t2.qq,t2.mobile_phone,t2.email')->find();
        $goods = $goodsmodel->where("goods_id=$goods_id")->field('user_id')->find();
        $user_id = $goods['user_id'];
        $count = $goodsmodel->where("user_id=$user_id and is_delete=0")->count();
        $page = $this->get_page($count, 5);
        $page_foot = $page->show(); //显示页脚信息
        $goods_qita = $goodsmodel->table('m_goods t1,m_category t2')->where("t1.cat_id=t2.cat_id and t1.user_id=$user_id  and t1.is_delete=0")->limit($page->firstRow . ',' . $page->listRows)->order('t1.last_update desc')->field('t2.cat_name,t1.goods_name,t1.price,t1.yuan_price,t1.goods_id,t1.buy_number')->select();
        $data['li'] = $goods_qita;
        $data['page_foot'] = $page_foot;
        $this->ajaxReturn($data);
    }

    public function buy() {
        $user_id = $_SESSION['huiyuan']['user_id'];
        $server_day = $_GET['server_day'];
        $y = (int) substr($server_day, 0, 4);
        $m = (int) substr($server_day, 4, 2);
        $d = (int) substr($server_day, 6, 2);
        $a = mktime(24, 59, 59, $m, $d, $y);
        $now = time();
        $goods_id = $_GET['goods_id'];
        if ($a < $now) {
            $this->error('该日期已经过去，请选择今天以后的日期', U('Goods/index', "goods_id=$goods_id"), 3);
        }
        $this->assign('goods_id', $goods_id);
        $goodsmodel = D('Goods');
        $goods = $goodsmodel->table('m_goods t1,m_users t2,m_category t3')->where("t1.user_id=t2.user_id and t1.goods_id=$goods_id and t1.cat_id=t3.cat_id")->field('t1.user_id,t1.area,t1.goods_name,t1.price,t3.cat_name,t2.user_name,t1.user_id')->find();
        if ($user_id === $goods['user_id']) {
            $this->error('不能购买自己的商品', U('Goods/index', "goods_id=$goods_id"), 3);
        }
        $this->assign('goods', $goods);
        $this->assign('server_day', $server_day);
        $ordermodel = D('Order');
        //$shop_id=$goods['user_id'];
        //如果该条订单已被别人下单并且没取消，提示已经被购买，返回首页
        $order_qita = $ordermodel->where("goods_id=$goods_id and server_day=$server_day")->find();
        if (!empty($order_qita)) {
            if ($order_qita['status'] !== '4') {
                $this->error('该日期的商品已被购买，请选择其它商品', U('Goods/index', "goods_id=$goods_id"), 3);
            }
        }
        $goodsmodel = D('Goods');
        $goods = $goodsmodel->table('m_goods t1,m_users t2,m_category t3')->where("t1.user_id=t2.user_id and t1.goods_id=$goods_id and t1.cat_id=t3.cat_id")->field('t1.area,t1.goods_name,t1.price,t3.cat_name,t2.user_name,t1.user_id,t1.daijinquan,t1.fanxian')->find();
        $this->assign('goods', $goods);
        //代金券
        if($goods['daijinquan']==='1'){
            $usersmodel=D('Users');
            $daijinjuan=$usersmodel->where("user_id=$user_id")->getField('daijinjuan');
            $ky_daijinjuan=round($daijinjuan>$goods['price']/10?$goods['price']/10:$daijinjuan,2);
        }else{
            $ky_daijinjuan=0.00;
        }
        $dues=round($goods['price']-$ky_daijinjuan,2);
        $this->assign('ky_daijinjuan',$ky_daijinjuan);
        $this->assign('dues',$dues);
        //返现
        $fanxian=round($dues*$goods['fanxian']*0.01,2);
        $this->assign('fanxian',$fanxian);

        $this->assign('server_day', $server_day);
        $this->display('buy');
    }

    public function zhifu() {
        $user_id = $_SESSION['huiyuan']['user_id'];
        $server_day = $_GET['server_day'];
        $y = (int) substr($server_day, 0, 4);
        $m = (int) substr($server_day, 4, 2);
        $d = (int) substr($server_day, 6, 2);
        $a = mktime(24, 59, 59, $m, $d, $y);
        $now = time();
        if ($a < $now) {
            $this->error('该日期已经过去，请选择今天以后的日期', U($_SESSION['ref']), 3);
        }
        $goods_id = $_GET['goods_id'];
        $this->assign('goods_id', $goods_id);
        $this->assign("pay_method", C("PAY_METHOD"));
        $goodsmodel = D('Goods');
        $goods = $goodsmodel->table('m_goods t1,m_users t2,m_category t3')->where("t1.user_id=t2.user_id and t1.goods_id=$goods_id and t1.cat_id=t3.cat_id")->field('t1.area,t1.goods_name,t1.price,t3.cat_name,t2.user_name,t1.user_id,t1.daijinquan,t1.fanxian')->find();
        $this->assign('goods', $goods);
        //代金券
        if($goods['daijinquan']==='1'){
            $usersmodel=D('Users');
            $daijinjuan=$usersmodel->where("user_id=$user_id")->getField('daijinjuan');
            $ky_daijinjuan=round($daijinjuan>$goods['price']/10?$goods['price']/10:$daijinjuan,2);
        }else{
            $ky_daijinjuan=0.00;
        }
        $dues=round($goods['price']-$ky_daijinjuan,2);
        $this->assign('ky_daijinjuan',$ky_daijinjuan);
        $this->assign('dues',$dues);
        //返现
        $fanxian=round($dues*$goods['fanxian']*0.01,2);
        $this->assign('fanxian',$fanxian);
        
        $this->assign('server_day', $server_day);
        $ordermodel = D('Order');
        //如果该条订单已被别人付款，提示已经被购买，返回
        $order_qita = $ordermodel->where("goods_id=$goods_id and server_day=$server_day and user_id<>$user_id")->find();
        if (!empty($order_qita)) {
            if ($order_qita['status'] !== '4') {
                $this->error('该日期的商品已被购买，请选择其它商品', U($_SESSION['ref']), 3);
            }
        }
        //如果用户自己已经有了该条订单，未付款，转到付款页面，已付款，提示不能重复购买
        $order_self = $ordermodel->where("user_id=$user_id and goods_id=$goods_id and server_day=$server_day and status<>'4'")->find();
        if (!empty($order_self)) {
            $this->assign('order_id', $order_self['order_id']);
            $this->display('zhifu');
            exit();
        }

        $row = array(
            'user_id' => $user_id,
            "order_no" => $this->getUniqueOrderNo(),
            'goods_id' => $goods_id,
            'shop_id' => $goods['user_id'],
            'shop_name' => $goods['user_name'],
            'goods_name' => $goods['goods_name'],
            'server_day' => $server_day,
            'status' => 1, //生成订单
            'pay_status' => 0, //支付状态为未支付
            'created' => mktime(),
            'updated' => mktime(),
            'price' => $goods['price'],
            'daijinjuan'=>$ky_daijinjuan,
            'dues'=>$dues,
            'fanxian'=>$fanxian
        );
        $result = $ordermodel->add($row); //订单信息写入数据库order表
        if ($result) {
            $this->assign('order_id', $result);
            $this->display('zhifu');
        } else {
            $this->error('订单提交失败，请重新提交', $_SERVER['HTTP_REFERER'], 3);
        }
    }

    /**
     * 生成唯一的订单号 会查询订单表来保证唯一性
     * 
     */
    public function getUniqueOrderNo() {
        $code = getname();
        $OrderModel = D("Order");
        $res = $OrderModel->where("order_no='{$code}' and deleted=0")->find();
        if ($res) {
            $this->getUniqueOrderNo();
        }
        return $code;
    }

    //生成支付宝订单
    public function alipay() {
        $order_id = $_GET['order_id'];
        $pay_method = $_GET['pay_method'];
        $pay_method = array_key_exists($pay_method, C("PAY_METHOD")) ? $pay_method : 1;
        $ordermodel = D('Order');
        $order = $ordermodel->where("order_id=$order_id and deleted=0 ")->find();
        $goodsmodel=D('Goods');
        $goods_id=$order['goods_id'];
        $cat_id=$goodsmodel->where("goods_id=$goods_id")->getField('cat_id');
        $categorymodel=D('Category');
        $order['cat_name']=$categorymodel->where("cat_id=$cat_id")->getField('cat_name');
        $this->assign('order', $order);
        $order_user_id = $order['user_id']; //登录用户无该订单权限
        if ($order_user_id != $_SESSION['huiyuan']['user_id']) {//登录用户无该订单权限
            $this->error('您没有该订单权限');
        }
        //如果该条订单已被别人付款，提示已经被购买，返回首页
        $goods_id = $order['goods_id'];
        $server_day = $order['server_day'];
        $tianjian['order_id'] = array('neq', $order_id);
        $order_qita = $ordermodel->where($tiaojian)->where("goods_id=$goods_id and server_day=$server_day")->find();
        if (!empty($order_qita)) {
            if ($order_qita['pay_status'] == 1) {
                $this->error('该日期的商品已被购买，请选择其它商品', U('index/index'), 3);
            }
        }
        //发起支付
        if ($pay_method == 1) {
            //支付宝
            $option["show_url"] = PAY_HOST . U("Goods/index", array("goods_id" => $goods_id));
            $option['return_url'] = PAY_HOST . U("Goods/gmcg");
            $option['notify_url'] = PAY_HOST . U("Goods/notify");
            $option['out_trade_no'] = $order['order_no'];
            $option['total_fee'] = floatval($order['dues']);
            $option["subject"] = $order['goods_name'];
            $option['body'] = sprintf("一起网：商铺名：%s 商品名：%s 服务时间：%s", $order['shop_name'], $order['goods_name'], $order['server_day']);
            vendor('create_direct_pay_by_xia.alipayapi'); //引入第三方类库
            $aliPay = new \AlipayOption($option, C("ALIPAY_CONFIG"));
            $button=$aliPay->alipaySubmit();
            $this->assign('button',$button);
            $this->display('zhifu_tiaozhuan');
        } else if ($pay_method == 2) {
            //微信
            vendor('wxp.native'); //引入第三方类库
            $notify = new \NativePay();
            $input = new \WxPayUnifiedOrder();
            $input->SetBody(sprintf("一起网：商铺名：%s 商品名：%s 服务时间：%s", $order['shop_name'], $order['goods_name'], $order['server_day']));
            $input->SetAttach($order['shop_name']);
            $input->SetOut_trade_no($order['order_no']);
            $input->SetTotal_fee($order['dues'] * 100);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            $input->SetGoods_tag($order['shop_name']);
            $input->SetNotify_url(PAY_HOST . U("Goods/notifyweixin"));
            $input->SetTrade_type("NATIVE");
            $input->SetProduct_id($order['goods_id']);
            $result = $notify->GetPayUrl($input);
            $url2 = urlencode($result["code_url"]);
            file_put_contents("url.txt", $url2);
            $this->assign("goods", $order);
            $this->assign('order_id',$order_id);
            $this->assign("payurl", $url2);
            $this->display("zhifuweixin");
        } else {
            
        }
    }

    /**
     * 微信支付的 异步回调
     * 
     */
    public function notifyweixin() {

        vendor('wxp.notify'); //引入第三方类库

        $notify = new \PayNotifyCallBack();
        $notify->Handle(false);
        $returnPay = $notify->getPayReturn();
//        file_put_contents("logs/returnpau_data".time().".txt",  print_r($returnPay,true));
        if (!$returnPay || $returnPay[""]) {
            echo "FAIL";
            die;
        }
        if (array_key_exists("return_code", $returnPay) && array_key_exists("result_code", $returnPay) && $returnPay["return_code"] == "SUCCESS" && $returnPay["result_code"] == "SUCCESS") {
            $ordermodel = D('Order');
            $order = $ordermodel->where("order_no='{$returnPay["out_trade_no"]}' and deleted=0 ")->find();
            //验证交易金额是否为订单的金额;
            if (!empty($returnPay['total_fee'])) {
                if ($returnPay['total_fee'] != $order['dues'] * 100) {
                    echo "fail";
                    die;
                }
            }


            $order_id = $order['order_id'];
            

            $row = array(
                'pay_status' => 1, //支付状态为支付
                'updated' => mktime(),
                "pay_type" => 2,
                "trade_no" => $returnPay['transaction_id'],
                "pay_info" => serialize($returnPay),
            );
            if (!$ordermodel->where("order_id=$order_id")->save($row)) {
                echo "fail";
                die;
            }

            //商品表里面购买数量加1
            $goodsmodel = D('Goods');
            $goodsmodel->where("goods_id=$goods_id")->setInc('buy_number');

            echo "success";
        }
    }

    /*     * *
     * 后台异步处理
     * 支付成功的同步页面采用同步通知即可 
     * 更新数据库状态
     */

    public function notify() {
        error_reporting(0);
        vendor('create_direct_pay_by_xia.lib.alipay_notify'); //引入第三方类库
        //计算得出通知验证结果
        $alipayNotify = new \AlipayNotify(C("ALIPAY_CONFIG"));
        $verify_result = $alipayNotify->verifyNotify();
//        file_put_contents("./notify.txt", print_r($_POST,true),FILE_APPEND);
        $out_trade_no = $_POST['out_trade_no'];
        $trade_no = $_POST['trade_no'];
        if ($verify_result) {//验证成功
            $ordermodel = D('Order');
            $order = $ordermodel->where("order_no='{$out_trade_no}' and deleted=0 ")->find();
            //验证交易金额是否为订单的金额;
            if (!empty($_POST['total_fee'])) {
                if ($_POST['total_fee'] != $order['dues']) {
                    echo "fail";
                    die;
                }
            }
            //验证收款人邮箱
            if (!empty($_POST['seller_email'])) {
                $alipayconfig = C("ALIPAY_CONFIG");
                if ($_POST['seller_email'] != $alipayconfig['seller_email']) {
                    echo "fail";
                    die;
                }
            }

            $order_id = $order['order_id'];
            

            $row = array(
                'pay_status' => 1, //支付状态为支付
                'updated' => mktime(),
                "pay_type" => 1,
                "trade_no" => $trade_no,
                "pay_info" => serialize($_POST),
            );
            if (!$ordermodel->where("order_id=$order_id")->save($row)) {
                echo "fail";
                die;
            }

            //商品表里面购买数量加1
            $goodsmodel = D('Goods');
            $goodsmodel->where("goods_id=$goods_id")->setInc('buy_number');
            //用户代金卷更新
            $order=$ordermodel->where("order_id=$order_id")->field('daijinjuan,user_id')->find();
            if($order['daijinjuan']!=='0.00'){
                $usersmodel=D('Users');
                $user_id=$order['user_id'];
                $user_daijinjuan=$usersmodel->where("user_id=$user_id")->getField('daijinjuan');
                $daijinjuan=$user_daijinjuan-$order['daijinjuan'];
                $users_row=array(
                    'daijinjuan'=>$daijinjuan
                );
                $usersmodel->where("user_id=$user_id")->save($users_row);
            }
            echo "success";
        } else {
            //验证失败
            echo "fail";
        }
    }

    /*     * *
     * 支付成功的同步页面采用同步通知即可 
     * 将结果显示给用户
     */

    public function gmcg() {
        vendor('create_direct_pay_by_xia.lib.alipay_notify'); //引入第三方类库
        //计算得出通知验证结果
        $alipayNotify = new \AlipayNotify(C("ALIPAY_CONFIG"));
        $verify_result = $alipayNotify->verifyReturn();
        if ($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
            //商户订单号
            $out_trade_no = $_GET['out_trade_no'];
            //支付宝交易号
            $trade_no = $_GET['trade_no'];
            //交易状态
            $trade_status = $_GET['trade_status'];

            if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                $ordermodel = D('Order');
                $order = $ordermodel->where("order_no='{$out_trade_no}' and deleted=0 ")->find();
                $this->assign('order', $order);
                if ($_GET['total_fee'] != $order['dues']) {
                    $this->error('订单的金额有问题，可能与提交时的不符', U('Order/index'), 3);
                }
                //验证收款人邮箱
                if (!empty($_GET['seller_email'])) {
                    $alipayconfig = C("ALIPAY_CONFIG");
                    if ($_GET['seller_email'] != $alipayconfig['seller_email']) {
                        $this->error('订单的收款人存在问题', U('Order/index'), 3);
                    }
                }
                $order_user_id = $order['user_id']; //登录用户无该订单权限
                if ($order_user_id != $_SESSION['huiyuan']['user_id']) {//登录用户无该订单权限
                    $this->error('您没有该订单权限');
                }
                $order_id = $order['order_id'];
               

//                $row = array(
//                    'pay_status' => 1, //支付状态为支付
//                    'updated' => mktime(),
//                    "pay_type" => 0,
//                    "trade_no" => $trade_no,
//                    "pay_info" => serialize($_GET),
//                );
//                $ordermodel->where("order_id=$order_id")->save($row);
//
//                //商品表里面购买数量加1
//                $row_goods = array(
//                    'buy_number' => "buy_number" . "+ 1",
//                );
//                $goodsmodel = D('Goods');
//                $goodsmodel->where("goods_id=$goods_id")->save($row_goods);
                $this->display('gmcg');
            } else {
                $message = "支付遇到问题，请稍后重试！" . "trade_status=" . $_GET['trade_status'];
                $this->error($message, U('Order/index'), 3);
            }
        } else {
            //验证失败
            $message = "支付遇到问题，请稍后重试！";
            $this->error($message, U('Order/index'), 3);
        }

    }
    
    
    public function gmcg_wx(){
        $order_id=$_GET['order_id'];
        $user_id=$_SESSION['huiyuan']['user_id'];
        $ordermodel=D('Order');
        $order=$ordermodel->where("order_id=$order_id and deleted=0")->find();
        if($user_id=$order['user_id']){
            if($order['pay_status']==='1'){
                $this->assign('order', $order);
                $this->display('gmcg');
            }else{
                $this->error('未付款成功,将返回付款页面',$_SESSION['ref']);
            }
        }else{
            $this->error('您没有该订单！',U('Order/index'),3);
        }
    }
    
    public function jiance_pay(){
        if($_POST['check']==='wx_zhifu'){
            $order_id=$_POST['order_id'];
            $ordermodel=D('Order');
            $pay_status=$ordermodel->where("order_id=$order_id")->getField('pay_status');
            $this->ajaxReturn($pay_status);
        }
    }

        public function cart_join() {
        if ($_POST['check'] !== 'cart_join') {
            exit();
        }
        $user_id = $_SESSION['huiyuan']['user_id'];
        $server_day = $_POST['server_day'];
        $goods_id = $_POST['goods_id'];
        $cartmodel = D('Cart');
        $count = $cartmodel->where("user_id=$user_id and goods_id=$goods_id and server_day=$server_day")->count();
        if ($count != '0') {
            $data = '9';
            $this->ajaxReturn($data);
            exit();
        }
        $goodsmodel = D('Goods');
        $goods = $goodsmodel->table('m_goods t1,m_users t2,m_category t3')->where("t1.user_id=t2.user_id and t1.goods_id=$goods_id and t1.cat_id=t3.cat_id")->field('t1.goods_id,t1.goods_name,t1.user_id,t1.price,t1.yuan_price,t1.goods_img,t3.cat_name,t2.user_name')->find();
        $row = array(
            'user_id' => $user_id,
            'goods_id' => $goods_id,
            'goods_name' => $goods['goods_name'],
            'goods_price' => $goods['price'],
            'yuan_price' => $goods['price'],
            'shop_name' => $goods['user_name'],
            'shop_id' => $goods['user_id'],
            'server_day' => $server_day,
            'cat_name' => $goods['cat_name'],
            'goods_img' => $goods['goods_img'],
            'join_time' => mktime()
        );
        $result = $cartmodel->add($row); //信息写入数据库
        if ($result) {
            $data = '1';
        } else {
            $data = '-1';
        }
        $this->ajaxReturn($data);
        exit();
    }

    public function sellection_join() {
        if ($_POST['check'] !== 'sellection_join') {
            exit();
        }
        $user_id = $_SESSION['huiyuan']['user_id'];
        $server_day = $_POST['server_day'];
        $goods_id = $_POST['goods_id'];
        $sellectionmodel = D('Sellection');
        $count = $sellectionmodel->where("user_id=$user_id and goods_id=$goods_id")->count();
        if ($count != '0') {
            exit();
        }
        $row = array(
            'user_id' => $user_id,
            'goods_id' => $goods_id,
            'server_day' => $server_day,
            'add_time' => mktime()
        );
        $result = $sellectionmodel->add($row); //信息写入数据库
        if ($result) {
            $data = '1';
        } else {
            $data = '-1';
        }
        $this->ajaxReturn($data);
        exit();
    }

}
