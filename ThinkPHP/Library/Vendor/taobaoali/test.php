<?php
	include "./TopSdk.php";
	date_default_timezone_set('Asia/Shanghai'); 

$appkey="23304840";
$secret="57d27c01c6d3f9af602de646019c4e3b";
    //实例化TopClient类
//
//$c = new TopClient;
//
//$c->appkey = "23304840";
//
//$c->secretKey = "57d27c01c6d3f9af602de646019c4e3b";
//
//$sessionkey= "test";   //如沙箱测试帐号sandbox_c_1授权后得到的sessionkey
//
////实例化具体API对应的Request类
//
//$req = new UserSellerGetRequest();
//
//$req->setFields("nick,user_id,type");
//
////$req->setNick("sandbox_c_1");
//    
//$resp = $c->execute($req,$sessionkey);
//
//echo "result:";
//
//print_r($resp);

//
//
//	$httpdns = new HttpdnsGetRequest;
//	$client = new ClusterTopClient("4272","0ebbcccfee18d7ad1aebc5b135ffa906");
//	$client->gatewayUrl = "http://api.daily.taobao.net/router/rest";
//	var_dump($client->execute($httpdns,"6100e23657fb0b2d0c78568e55a3031134be9a3a5d4b3a365753805"));
//

$c = new TopClient;
$c->appkey = $appkey;
$c->secretKey = $secret;
$req = new AlibabaAliqinFcSmsNumSendRequest;
$req->setExtend("123456");
$req->setSmsType("normal");
$req->setSmsFreeSignName("阿里大鱼");
$req->setSmsParam("{\"code\":\"1234\",\"product\":\"阿里大鱼\",\"item\":\"阿里大鱼\"}");
$req->setRecNum("13000000000");
$req->setSmsTemplateCode("SMS_585014");
//$req->
$resp = $c->execute($req);
print_r($resp);

?>