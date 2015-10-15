// JavaScript Document
//onfocus
//onblur
//var obj_form=document.sv_cont;
//var server_content=obj_form.server_content;
$('select[name=server_content]').bind('change',function(){sc_change();});
$(':text[name=title]').bind('focus',function(){text_focus($('#info_title'),'商品标题可以尽量多包含关键字');});
$(':text[name=title]').bind('blur',function(){text_blue($(this),$('#info_title'));});
$(':text[name=price]').bind('focus',function(){text_focus($('#info_price'),'填写售价');});
$(':text[name=price]').bind('blur',function(){price_blue($(this),$('#info_price'));});
$(':text[name=yuan_price]').bind('focus',function(){text_focus($('#info_yuan_price'),'填写原价');});
$(':text[name=yuan_price]').bind('blur',function(){price_blue($(this),$('#info_yuan_price'));});
$('#xiayibu').bind('click',function(){$('form[name=release_goods]').submit();return false;});

//给性别radio一个默认值
$('input[name=radio_sex]:eq(0)').attr('checked','checked');

    //引入在线编辑器
    var editor;
    KindEditor.ready(function(K) {
        var options = {
            items:[
        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about'
],
            uploadJson:"/Home/Member/editor_check",
            allowMediaUpload:true,
            allowFileManager : false
        };
        editor = K.create('textarea[name="content"]',options);
    });


function sc_change(){
    $('form[name=sv_cont]').submit();
}

function price_blue(obj,obj_info){
    if(!text_blue(obj,obj_info)){
        return false;
    }
    var reg = /^\d+$/gi;
    var result= reg.test(obj.val());
    if(result){
        obj_info.html('&radic;');
        return true;
    }else{
        obj_info.css('color','red');
        obj_info.html('含有非数字字符，请填入正确价格');
        return false;
    }
}