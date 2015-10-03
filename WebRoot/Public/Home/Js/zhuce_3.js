// JavaScript Document
var backurl=document.referrer;
backurl=backurl.substr(0,34);
if(backurl!="http://www.hunll.com/zhuce/zhuce-2"){location.href="zhuce-1.html"}
var backurl=document.referrer;
if(backurl==""){location.href="zhuce-1.html"}
var url=location.href;
var arr = url.split("?");
var dengluming=(arr[1].split("="))[1];
var huiyuanming=unescape((arr[2].split("="))[1]);
document.getElementById("dlm_sjh").innerHTML=dengluming;
document.getElementById("dlm_sjh").style.cssText="background-color:#03BA8A;color:#FFF";
document.getElementById("hym_sjh").innerHTML=huiyuanming;
document.getElementById("hym_sjh").style.cssText="background-color:#03BA8A;color:#FFF";