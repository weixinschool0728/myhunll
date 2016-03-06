// JavaScript Document
//onfocus
//onblur
$('input[name=tixian]').bind('focus',function(){
    $('#tixian_tishi').text('输入提现金额，如100.00');
});
$('input[name=tixian]').bind('blur',function(){
    
    $('#tixian_tishi').text('输入提现金额，如100.00');
});

function is_tixian(str){
    var reg=/^1[3458]\d{9}$/gi;
    return reg.test(str);
}