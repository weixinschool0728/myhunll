
//时间戳转换成时间
function getDate(tm){
    var tt=new Date(parseInt(tm) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ")
    return tt;
} 
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
    var reg = /[=;:#&\\\/\^\$\(\)\[\]\{\}\*\+\?\-\"\']+/gi;
    var result= reg.exec(str);
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
        //obj_info.html('含有非法字符=;:#&\/^$()[]{}*+?-"，请重新输入');
        obj_info.html('含有非法字符：'+is_feifa(obj.val()));
        return false;
    }else{
        obj_info.html('&radic;');
        return true;
    }
}

//验证图片是否上传和类型是否正确，第一个参数是文件对象，第二个参数是信息对象，第三个参数为真，则弹出对话框，为假，不弹出。  参数为JQ对象
function check_file_image(obj_file,obj_info,flag){
	var arr_image=["jpg","jpeg","png","gif",'swf','bmp'];
	var str_suffix=obj_file.val().substr(obj_file.val().lastIndexOf(".")+1).toLowerCase();//获取后缀
        if(str_suffix==false){
            obj_info.css('color','red');
            obj_info.html("未上传文件，请上传图片");
            return false;
        }
	for(var i=0;i<arr_image.length;i++){
		if(str_suffix==arr_image[i]){
                    obj_info.css('color','#666');
                    obj_info.html("&radic;");
                    return true;
                    break;
			}
		}
                if(flag){
                    alert("文件类型不允许上传，请选择图片格式");
                    obj_file.val('');
                }
            obj_info.css('color','red');
            obj_info.html("文件类型不允许，请上传正确的图片格式");
            return false;
	}
//ajax请求判断用户是否登录
function check_login(){
    var data;
    var url='/Home/login/is_login.html';
    $.ajax({
        type:'post',
        async : false,
        url:url,
        datatype:'json',
        success:function(msg){
            if(msg===0){
                data=0;
            }else{
                data=msg;
            }
        }
    });
    return data;
}


//星星分数变成百分数
function xingxing_baifenbi(score){
    var score1=score/5;
    score1=score1.toFixed(2)*100;
    return score1+'%';
}