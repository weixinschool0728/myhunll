

//验证手机号，如果是，返回true,否则返回false
function is_shoujihao(str){
    var reg=/^1[3458]\d{9}$/gi;
    return reg.test(str);
}


//验证邮箱，如果是返回true,否则返回false
function is_youxiang(str){
    var reg=/^w+[.\w]@(\w+.)+\w{2,4}$/gi;
    return reg.test(str);
}


//验证IP是否有效，如果是返回true,否则返回false
function is_ip(str){
    var reg = /^([1-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])(\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])){3}$/gi;
    return reg.test(str);
}
