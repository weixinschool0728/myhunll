

//验证手机号，如果是，返回true,否则返回false
function is_shoujihao(str){
    var reg=/^1[3458]\d{9}$/gi;
    return reg.test(str);
}


//验证邮箱，如果是返回true,否则返回false
function is_youxiang(str){
    var reg=/^\w+[.\w]*@(\w+\.)+\w{2,4}$/gi;
    return reg.test(str);
}


//验证IP是否有效，如果是返回true,否则返回false
function is_ip(str){
    var reg = /^([1-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])(\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])){3}$/gi;
    return reg.test(str);
}

//验证是否含有非法字符，含有非法返回true，否则返回false
function is_feifa(str){
    var reg = /[=!;:@#&\.\\\/\^\$\(\)\[\]\{\}\*\+\?\-\"\']+/gi;
    var result= reg.test(str);
    return result;
}

//文本框获取焦点时，提示文字显示的（第一个参数是需要显示信息的jq对象，第二个参数是要显示的提示文字）
function text_focus(obj,str){
    obj.html(str);
}

//文本框失去焦点，检查是否为空和非法（第一个参数是失去焦点的本身对象（this），第二个参数是需要显示信息的jq对象）
function text_blue(obj,obj_info){
    if(obj.val()==''){
        obj_info.css('color','red');
        obj_info.html('为空，请输入内容');
        return false;
    }else if(is_feifa(obj.val())){
        obj_info.css('color','red');
        obj_info.html('含有非法字符，请重新输入');
        return false;
    }else{
        obj_info.html('&radic;');
        return true;
    }
}
