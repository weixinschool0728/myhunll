<?php

namespace Home\Controller;

use Home\Controller;

class CeshiController extends FontEndController {


    
    public function index() {
        $this->display();
    }
    public function send_message() {
        $shoujihao=$_POST['shoujihao'].'a';
        $this->ajaxReturn($shoujihao);
        exit();
        vendor('taobaoali.TopSdk');//引入第三方类库
        date_default_timezone_set('Asia/Shanghai'); 
            $appkey="23304840";
            $secret="57d27c01c6d3f9af602de646019c4e3b";
            $c = new \TopClient;
            $c->appkey = $appkey;
            $c->secretKey = $secret;
            $c->format='json';
            $req = new \AlibabaAliqinFcSmsNumSendRequest;
            $req->setExtend("123456");
            $req->setSmsType("normal");
            $req->setSmsFreeSignName("一起网");
            $rand=rand(100000,999999);
            $_SESSION['send_message']="$rand";
            $req->setSmsParam("{\"code\":\"$rand\",\"product\":\"一起网\",\"item\":\"一起网\"}");
            $req->setRecNum($shoujihao);
            $req->setSmsTemplateCode("SMS_4705353");
            $resp = $c->execute($req);
            $data=$resp->result->success;
            $this->ajaxReturn($shoujihao);
    }

   
     
    


}
