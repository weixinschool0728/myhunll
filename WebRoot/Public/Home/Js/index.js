// JavaScript Document
window.onload=function(){
var n,nx,t1,t2,lunbobz;//t是需要轮播图片张数,n记录一张图片走完
var time1,time2;
var obj_lunbo_m=document.getElementById("lunbo_m"),obj_lunbo_m_gd=document.getElementById("lunbo_m_gd"),obj_lunbo_mx=document.getElementById("lunbo_mx"),obj_lunbo_mx_gd=document.getElementById("lunbo_mx_gd");
var body_scrolltop;
if(navigator.appName!=="Microsoft Internet Explorer"){
	window.onblur=stop_lunbo;
	window.onfocus=start_lunbo;
	}

    lunbochushi();
    $('.shopping_img img').each(function(i,item){
        if($(item).height()<191){
            $(item).css('height','191px');
            $(item).css('width','auto');
        }
    });
  

document.getElementById("lunbo_m0").onmouseover=function(){lunbo_icon_over('icon');}
document.getElementById("lunbo_m0").onmouseout=function(){lunbo_icon_out('icon');}
document.getElementById("icon_l").onclick=function(){icon_l('icon');}
document.getElementById("icon_r").onclick=function(){icon_r('icon');}
document.getElementById("lunbo_mx0").onmouseover=function(){lunbo_icon_over('iconx');}
document.getElementById("lunbo_mx0").onmouseout=function(){lunbo_icon_out('iconx');}
document.getElementById("iconx_l").onclick=function(){icon_l('iconx');}
document.getElementById("iconx_r").onclick=function(){icon_r('iconx');}

function start_lunbo(){
	if(lunbobz){
                clearInterval(time1);
                clearInterval(time2);
		time1=setInterval(lunbo,5000);
		time2=setInterval(lunbox,5000);
                lunbobz=false;
		}
	}
function stop_lunbo(){
	clearInterval(time1);
	clearInterval(time2);
	lunbobz=true;
	}
function lunbochushi(){
	n=0,t1=3,t2=2,nx=0;
	lunbobz=false;
	obj_lunbo_m_gd.style.width=735*t1*2+"px";
	obj_lunbo_m_gd.style.left="0px";
	obj_lunbo_m_gd.innerHTML+=obj_lunbo_m_gd.innerHTML;
	time1=setInterval(lunbo,5000);

	
	obj_lunbo_mx_gd.style.width=735*t2*2+"px";
	obj_lunbo_mx_gd.style.left="0px";
	obj_lunbo_mx_gd.innerHTML+=obj_lunbo_mx_gd.innerHTML;
	time2=setInterval(lunbox,5000);

	}
function getLeft(str){
	var left_i=str.length-2;
	var left_s=str.substring(0,left_i);
	var left=Number(left_s);
	return(left);
	}
function lunbo(){ var times=setInterval(function(){
	var left=getLeft(obj_lunbo_m_gd.style.left);
	if(obj_lunbo_m_gd.offsetWidth/2+left<=0){
    	obj_lunbo_m_gd.style.left="0px";
		}
		else {
			if(n>=735){
				clearInterval(times);
				n=0;
				return n;}
				else {
			left+=-49;
			obj_lunbo_m_gd.style.left=left+"px";
			n+=49;
				}
		}
    },30); }
function lunbo_l(){ var timesl=setInterval(function(){
	var left=getLeft(obj_lunbo_m_gd.style.left);
	if(left>=0){
    	obj_lunbo_m_gd.style.left="-"+obj_lunbo_m_gd.offsetWidth/2+"px";
		}
		else {
			if(n>=735){
				clearInterval(timesl);
				n=0;
				return n;}
				else {
			left+=49;
			obj_lunbo_m_gd.style.left=left+"px";
			n+=49;
				}
		}
    },30); }
function lunbo_icon_over(ic1){
	var ic1;
	var obj_l=document.getElementById(ic1+"_l");
	var obj_r=document.getElementById(ic1+"_r");
	obj_l.style.cssText="display:block;"
	obj_r.style.cssText="display:block;"
	ic1=="icon" ? clearInterval(time1) : clearInterval(time2);
	}

function lunbo_icon_out(ic2){
	var ic2;
	var obj_l=document.getElementById(ic2+"_l");
	var obj_r=document.getElementById(ic2+"_r");
	obj_l.style.cssText="display:none;"
	obj_r.style.cssText="display:none;"
	ic2=="icon" ? time1=setInterval(lunbo,5000) :time2=setInterval(lunbox,5000) ;
	}
function icon_l(ic3){
	var ic3;
	ic3=="icon" ? lunbo_l() :lunbox_l();
	}
function icon_r(ic4){
	var ic4;
	ic4=="icon" ? lunbo() : lunbox();
	}
	
function lunbox(){  
var timesx=setInterval(function(){													
	var left=getLeft(obj_lunbo_mx_gd.style.left);
	if(obj_lunbo_mx_gd.offsetWidth/2+left<=0){
    	obj_lunbo_mx_gd.style.left="0px";
		}
		else {
			if(nx>=735){
				clearInterval(timesx);
				nx=0;
				return nx;}
				else {
			left+=-49;
			obj_lunbo_mx_gd.style.left=left+"px";
			nx+=49;
				}
		}
    },30); }
function lunbox_l(){ var timesxl=setInterval(function(){
	var left=getLeft(obj_lunbo_mx_gd.style.left);
	if(left>=0){
    	obj_lunbo_mx_gd.style.left="-"+obj_lunbo_mx_gd.offsetWidth/2+"px";
		}
		else {
			if(nx>=735){
				clearInterval(timesxl);
				nx=0;
				return nx;}
				else {
			left+=49;
			obj_lunbo_mx_gd.style.left=left+"px";
			nx+=49;
				}
		}
    },30); }

function gj_l_onscroll(){
	var b=document.documentElement.scrollTop||document.body.scrollTop;
	var a=document.getElementById("a_gj_1").offsetTop,a1=document.getElementById("a_gj_11").offsetTop;
	var c=(window.innerHeight ? window.innerHeight : document.documentElement.clientHeight);

	if(b<(a+30)){
		var str="position:absolute;";
		str+="top:"+(a+80)+"px;";
		document.getElementById("gj_l").style.cssText=str;
	}
	else if(b>=(a1-c)){
		str="position:absolute;";
		str+="top:"+(a1-c+50)+"px;";
		document.getElementById("gj_l").style.cssText=str;
		}
	else{
		str="position:fixed;";
		str+="top:50px;";
		document.getElementById("gj_l").style.cssText=str;
		}
	
	for(var i=1;i<=10;i++){
	if(b>=document.getElementById("a_gj_"+i).offsetTop&&b<document.getElementById("a_gj_"+(i+1)).offsetTop){
		for(var n=1;n<=10;n++){
		document.getElementById("gj_l_"+n).style.cssText="background-color:#FFFFFF;color:#666;";
		}
		document.getElementById("gj_l_"+i).style.cssText="background-color:#03BA8A;color:#FFFFFF;";
		}		
	}
	}


        
        window.onscroll=function(){
	gj_l_onscroll();
	}
};
function a_mouse(obj){
	obj.style.cssText="background-color:#03BA8A;color:#FFFFFF;";
	}
function a_out(obj){
	var obj,obj1,obj2,b,i;
	b=document.documentElement.scrollTop||document.body.scrollTop;
	obj1=document.getElementById(obj.className);
	i=obj.className;
	i=i.charAt(i.length-1);
	i=(i=="0"? "10" : i );
	i=Number(i);
	obj2=document.getElementById("a_gj_"+(i+1));
	if(b<obj1.offsetTop||b>=obj2.offsetTop){obj.style.cssText="background-color:#FFFFFF;color:#666;";}
	}
function click_miaodian(obj){
	var obj,obj1,scrotop,s1=400,s2=100,s3=10;
	obj1=document.getElementById(obj.className);
	var time=setInterval(function (){
	scrotop=document.documentElement.scrollTop||document.body.scrollTop;
	if(obj1.offsetTop-scrotop>=s1){
		document.documentElement.scrollTop ? document.documentElement.scrollTop+=s1 : document.body.scrollTop+=s1;
		}
		else if(scrotop-obj1.offsetTop>=s1){
			document.documentElement.scrollTop ? document.documentElement.scrollTop-=s1 : document.body.scrollTop-=s1;
			}
		else if(obj1.offsetTop-scrotop<s1&&obj1.offsetTop-scrotop>=s2){
		document.documentElement.scrollTop ? document.documentElement.scrollTop+=s2 : document.body.scrollTop+=s2;
		}
		else if(obj1.offsetTop-scrotop<100&&obj1.offsetTop-scrotop>=10){
		document.documentElement.scrollTop ? document.documentElement.scrollTop+=s3 : document.body.scrollTop+=s3;
		}
		else if(obj1.offsetTop-scrotop<10&&obj1.offsetTop-scrotop>0){
		document.documentElement.scrollTop ? document.documentElement.scrollTop+=1 : document.body.scrollTop+=1;
		}
		else if(scrotop-obj1.offsetTop<400&&scrotop-obj1.offsetTop>=100){
		document.documentElement.scrollTop ? document.documentElement.scrollTop-=s2 : document.body.scrollTop-=s2;
		}
		else if(scrotop-obj1.offsetTop<100&&scrotop-obj1.offsetTop>=10){
		document.documentElement.scrollTop ? document.documentElement.scrollTop-=s3 : document.body.scrollTop-=s3;
		}
		else if(scrotop-obj1.offsetTop<10&&scrotop-obj1.offsetTop>0){
		document.documentElement.scrollTop ? document.documentElement.scrollTop-=1 : document.body.scrollTop-=1;
		}
		else{
				clearInterval(time);
				}
								   },1);
	return false;
	}
        
       $('.shopping').bind('mouseover',function(){
           $(this).css('border-color','red');
       });
       $('.shopping').bind('mouseout',function(){
           $(this).css('border-color','#DDD');
       });

//右侧广告最后一个取消下边框
$('.lunbo_r .guanggao:last').css('border','none');