// JavaScript Document
//onfocus
//onblur
$('input[name=tixian]').bind('focus',function(){
    $('#tixian_tishi').html('输入提现金额，如100.00');
});
$('input[name=tixian]').bind('keyup',function(){
    var str=$('input[name=tixian]').val();
    if(is_tixian(str)){
    $('#tixian_tishi').html('您将提现: &yen;'+parseFloat(str).toFixed(2));  
    }else{
        $('#tixian_tishi').html('您输入的金额不符合规范，请重新输入'); 
    }
});

function is_tixian(str){
    var reg=/^\d+\.?\d{0,2}$/gi;
    return reg.test(str);
}

