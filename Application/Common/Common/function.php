<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//tp验证码加密函数
   function authcode($str){
        $key = substr(md5('ThinkPHP.CN'), 5, 8);
        $str = substr(md5($str), 8, 10);
        return md5($key . $str);
    }


//比对验证码是否正确
function check_verify($code){ 
    //$verify = new \Think\Verify();
    //return $verify->check($code, $id);
    if(NOW_TIME - $_SESSION['d2d977c58444271d9c780187e93f80e5']['verify_time'] > 30){
        unset($_SESSION['d2d977c58444271d9c780187e93f80e5']);//清空session
        return -1;//验证码过期
    }elseif(authcode(strtoupper($code))!=$_SESSION['d2d977c58444271d9c780187e93f80e5']['verify_code']){
        return 0;//验证码错误
    }else {
        return 1;//验证码正确
    }
}



//验证手机号，如果是，返回true,否则返回false
function is_shoujihao($str){
    $reg='/^1[3458]\d{9}$/gi';
    $result=preg_match($reg,$str);
    if($result==0) {
        return false;
    }else{
        return true;
    }
}

//验证邮箱，如果是返回true,否则返回false
function is_youxiang($str){
    $reg='/^w+[.\w]@(\w+.)+\w{2,4}$/gi';
    $result=preg_match($reg,$str);
    if($result==0) {
        return false;
    }else{
        return true;
    }
}


//验证IP是否有效，如果是返回true,否则返回false
function is_ip($str){
    $reg='/^([1-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])(\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])){3}$/gi';
    $result=preg_match($reg,$str);
    if($result==0) {
        return false;
    }else{
        return true;
    }
}