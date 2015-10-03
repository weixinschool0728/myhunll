// JavaScript Document
//onfocus
//onblur
var obj_form=document.zhuce;
var yanzhengma;
$.ajaxSetup({ 
    async : false 
});     
obj_form.shoujihao.onfocus=function (){yzshouji_foucs();}
obj_form.shoujihao.onblur=function (){yzshouji_blur();}
obj_form.yanzhengma.onfocus=function (){yanzhengma_foucs();}
obj_form.yanzhengma.onblur=function (){yanzhengma_blur();}
document.getElementById("tyxy").onclick=function (){tyxy_click();}
function yzshouji_foucs(){
	var obj=document.getElementById("infor_shoujihao");
	obj.style.cssText="color:#666;";
	obj.innerHTML="请输入你的手机号码";
	}
function yzshouji_blur(){
	var obj=document.getElementById("infor_shoujihao");
	if(obj_form.shoujihao.value==""){
		obj.style.cssText="color:red;";
		obj.innerHTML="手机号码为空，请输入你的手机号码";
		return false;
		}
		else if(!is_shoujihao(obj_form.shoujihao.value)){
			obj.style.cssText="color:red;";
			obj.innerHTML="手机号不对，请输入正确的11位手机号码";
			return false;
			}
		else{
			obj.innerHTML="&radic;";
			return true;
			}
	}

function yanzhengma_foucs(){
	var obj=document.getElementById("infor_yanzhengma");
	obj.style.cssText="color:#666;";
	obj.innerHTML="请输入以下图片中的数字";
	}
function yanzhengma_blur(){
    var obj=document.getElementById("infor_yanzhengma");
    if($('input[name=yanzhengma]').val()===''){
        obj.style.cssText="color:red;";
        obj.innerHTML="验证码为空，请输入验证码";
        return false;
    }else{
    var data={
        yanzhengma:$('input[name=yanzhengma]').val(),
        check:"yanzhengma"
    };
    $.post('zhuce/check_yanzhengma',data,function(msg){
        yanzhengma=msg;
        if(msg==0){
            obj.style.cssText="color:red;";
            obj.innerHTML="验证码错误，请重新输入";
        }
        else if(msg==-1){
            obj.style.cssText="color:red;";
            obj.innerHTML="验证码已过期，请点击图片刷新";
        }
        else {
            obj.innerHTML="&radic;";
        }
    });
    }
    if(yanzhengma==1){
        return true;
    }else{
        return false;
    }
}

function checkForm(obj){
	yzshouji_blur();
        //yanzhengma_blur();
	if(yanzhengma_blur()&&yzshouji_blur()){
		obj_form.submit();
                return false;
	}else{
            return false;
        }
  }
  
  //点击同意协议
function tyxy_click(){
	document.getElementById("zcxy").style.cssText="display:none;";
	return false;
	}
        
        
        
//验证码刷新
var captcha_img=$('.zhuce1_yanzhengma');
captcha_img.attr('title','点击刷新');
var captcha_img_src=captcha_img.attr('src');
captcha_img.bind('click',yanzhengma_click);
function yanzhengma_click(){
    if(captcha_img_src.indexOf('?')>0){  
        $(this).attr("src", captcha_img_src+'&date='+new Date().getTime());  
    }else{  
        $(this).attr("src", captcha_img_src.replace(/\?.*$/,'')+'?'+new Date().getTime());  
    }
}

