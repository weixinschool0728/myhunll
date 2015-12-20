// JavaScript Document
//var backurl=document.referrer;
var obj_form=document.zhuce;
var huiyuanming;
document.getElementById("dlm_sjh").style.cssText="background-color:#03BA8A;color:#FFF";
obj_form.huiyuanming.onfocus=function (){huiyuanming_foucs();}
obj_form.huiyuanming.onblur=function (){huiyuanming_blur();}
obj_form.shezhimima.onfocus=function (){shezhimima_foucs();}
obj_form.shezhimima.onblur=function (){shezhimima_blur();}
obj_form.shezhimima.onkeyup=function (){shezhimima_keyup();}
obj_form.querenmima.onfocus=function (){querenmima_foucs();}
obj_form.querenmima.onblur=function (){querenmima_blur();}
document.getElementById("zhuce1_xiayibu").onclick=function (){return checkForm(this);}

function huiyuanming_foucs(){
	var obj=document.getElementById("infor_huiyuanming");
	obj.style.cssText="color:#666;";
	obj.innerHTML="输入您想要的会员名，不可更改，建议使用中文";
	}
function huiyuanming_blur(){
	var obj=document.getElementById("infor_huiyuanming");
	if(obj_form.huiyuanming.value==""){
		obj.style.cssText="color:red;";
		obj.innerHTML="会员名为空，请输入你的会员名";
		return false;
		}
		else if(obj_form.huiyuanming.value.length<2||obj_form.huiyuanming.value.length>12){
			obj.style.cssText="color:red;";
			obj.innerHTML="会员名小于2个字符或者大于12个字符";
			return false;
			}
                else if(is_feifa(obj_form.huiyuanming.value)){
                    obj.style.cssText="color:red;";
                    obj.innerHTML="会员名含有非法字符";
                    return false;
                }
		else{
                    var data={
                            huiyuanming:$('input[name=huiyuanming]').val(),
                            check:"huiyuanming"
                            };
                    var url='/Home/zhuce/check.html';
                    $.ajax({
                        type:'post',
                        async : false,
                        url:url,
                        data:data,
                        datatype:'json',
                        beforeSend:function(){
                            obj.innerHTML="检验中...";
                        },
                        success:function(msg){
                        huiyuanming=msg;
                        if(msg!=='0'){
                            obj.style.cssText="color:red;";
                            obj.innerHTML="会员名已经被注册，请重新填写";
                            }else {
                                obj.innerHTML="&radic;";
                                }
                        }
                    });
                    if(huiyuanming==='0'){
                        return true;
                    }else{
                        return false;
                    }			
			}
	}
function shezhimima_foucs(){
	var obj=document.getElementById("infor_shezhimima");
	obj.style.cssText="color:#666;";
	obj.innerHTML="设置您的密码，建议使用英文与数字结合";
	}
	
function shezhimima_blur(){
	querenmima_blur();	
	var obj=document.getElementById("infor_shezhimima");
	if(obj_form.shezhimima.value==""){
		obj.style.cssText="color:red;";
		obj.innerHTML="密码为空，请输入您的密码";
		return false;
		}
		else if(obj_form.shezhimima.value.length<5||obj_form.shezhimima.value.length>32){
			obj.style.cssText="color:red;";
			obj.innerHTML="密码小于5个字符或者大于32个字符";
			return false;
			}
		else if(!querenmima_blur()){
			obj.innerHTML="&radic;";
			return false;
			}
		else {
			return true;}
	}
function shezhimima_keyup(){
	var obj=document.getElementById("mimaxiaoguo");
	var arr=obj.getElementsByTagName("div");
	if(isNaN(obj_form.shezhimima.value)&&/\d/.test(obj_form.shezhimima.value)){
		if(obj_form.shezhimima.value.length<5&&obj_form.shezhimima.value.length>0){
			arr[0].style.cssText="background-color:#F76120;";
			arr[1].style.cssText="background-color:#EEEEEE;";
			arr[2].style.cssText="background-color:#EEEEEE;";
			}
			else if(obj_form.shezhimima.value.length>=5&&obj_form.shezhimima.value.length<8){
				arr[0].style.cssText="background-color:#FF8900;";
				arr[1].style.cssText="background-color:#FF8900;";
				arr[2].style.cssText="background-color:#EEEEEE;";
				}
			else if(obj_form.shezhimima.value.length>=8){
				arr[0].style.cssText="background-color:#5BAB3C;";
				arr[1].style.cssText="background-color:#5BAB3C;";
				arr[2].style.cssText="background-color:#5BAB3C;";
				}
			else {
				arr[0].style.cssText="background-color:#EEEEEE;";
				arr[1].style.cssText="background-color:#EEEEEE;";
				arr[2].style.cssText="background-color:#EEEEEE;";
				}
	}
		else{
			if(obj_form.shezhimima.value.length<15&&obj_form.shezhimima.value.length>0){
				arr[0].style.cssText="background-color:#F76120;";
				arr[1].style.cssText="background-color:#EEEEEE;";
				arr[2].style.cssText="background-color:#EEEEEE;";
				}
				else if(obj_form.shezhimima.value.length>=15){
					arr[0].style.cssText="background-color:#FF8900;";
					arr[1].style.cssText="background-color:#FF8900;";
					arr[2].style.cssText="background-color:#EEEEEE;";
					}
				else {
					arr[0].style.cssText="background-color:#EEEEEE;";
					arr[1].style.cssText="background-color:#EEEEEE;";
					arr[2].style.cssText="background-color:#EEEEEE;";
					}
			}
	}
function querenmima_foucs(){
	var obj=document.getElementById("infor_querenmima");
	obj.style.cssText="color:#666;";
	obj.innerHTML="请再次输入您的密码";
	}
function querenmima_blur(){
	var obj=document.getElementById("infor_querenmima");
	if(obj_form.querenmima.value==""){
		obj.style.cssText="color:red;";
		obj.innerHTML="确认密码为空，请再次输入您的密码";
		return false;
		}
		else if(!(obj_form.querenmima.value==obj_form.shezhimima.value)){
			obj.innerHTML="两次输入的密码不相同，请重新输入";
			return false;
			}
		else {
			obj.innerHTML="&radic;";
			return true;
			}
	}
function checkForm(obj){
	shezhimima_blur();
	if(huiyuanming_blur()&&shezhimima_blur()){
		obj_form.submit();
		return false;
		}
		else {
			return false;
			}
	}