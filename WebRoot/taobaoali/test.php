<?php
	include "TopSdk.php";
        
        
        //实例化TopClient类

$c = new TopClient;

$c->appkey = "test";

$c->secretKey = "test";

$sessionkey= "test";   //如沙箱测试帐号sandbox_c_1授权后得到的sessionkey

//实例化具体API对应的Request类

$req = new UserSellerGetRequest;

$req->setFields("nick,user_id,type");

//$req->setNick("sandbox_c_1");

 

//执行API请求并打印结果

$resp = $c->execute($req,$sessionkey);

echo "result:";

print_r($resp);
        
        
        
        
        
	date_default_timezone_set('Asia/Shanghai'); 

	$httpdns = new HttpdnsGetRequest;
	$client = new ClusterTopClient("4272","0ebbcccfee18d7ad1aebc5b135ffa906");
	$client->gatewayUrl = "http://api.daily.taobao.net/router/rest";
	var_dump($client->execute($httpdns,"6100e23657fb0b2d0c78568e55a3031134be9a3a5d4b3a365753805"));

?>