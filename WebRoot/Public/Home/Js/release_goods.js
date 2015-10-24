// JavaScript Document
//onfocus
//onblur
//var obj_form=document.sv_cont;
//var server_content=obj_form.server_content;
$('select[name=server_content]').bind('change',function(){sc_change();});
$(':text[name=title]').bind('focus',function(){text_focus($('#info_title'),'商品标题可以尽量多包含关键字');});
$(':text[name=title]').bind('blur',function(){text_blue($(this),$('#info_title'));});
$('input[name=file_img]').bind('change',function(){check_file_image($(this),$('#span_touxiang'),true);;});
$('#button_jia').bind('click',function(){tianjia($(this));});
$(':text[name=price]').bind('focus',function(){text_focus($('#info_price'),'填写售价');});
$(':text[name=price]').bind('blur',function(){price_blue($(this),$('#info_price'));});
$(':text[name=yuan_price]').bind('focus',function(){text_focus($('#info_yuan_price'),'填写原价');});
$(':text[name=yuan_price]').bind('blur',function(){price_blue($(this),$('#info_yuan_price'));});
$('#xiayibu').bind('click',function(){fabu();});
//动态生成的元素添加事件
$('body').on('click','.bt_delete',function(){delete_file($(this));});
$('body').on('change','.input_img1',function(){check_file_image($(this),$(this).next('span'),true);});

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
            allowMediaUpload:false,//true时显示视音频上传按钮。
            allowFlashUpload:false,//true时显示Flash上传按钮。
            allowFileUpload:false,//true时显示文件上传按钮。
            allowFileManager:false,//true时显示浏览远程服务器按钮。
            fontSizeTable:['9px', '10px', '12px', '14px', '16px', '18px', '24px', '32px']//指定文字大小。
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



var i=1;
function tianjia(obj){
    var str=' <div  class="tr" id="insert_img"><div class="tr_td1"><input type="button" value="删除" class="bt_delete" /></div><input name="file_imgi" type="file" class="tr_td2 input_img1" /><span id="span_touxiang2"></span></div>';
    if($('input[type=file]').length>3){
        alert('最多添加4张图片作为商品展示图');
        return false;
    }
    obj.before(str);
    $('input[name=file_imgi]').attr('name','file_img'+i);
    i++;
}


function delete_file(obj){
    obj.parent().parent().remove();
}













function fabu(){
    //text_blue($('input[name=title]'),$('#info_title'));
    check_file_image($('input[name=file_img]'),$('#span_touxiang'),false);
    price_blue($('input[name=price]'),$('#info_price'));
    price_blue($('input[name=yuan_price]'),$('#info_yuan_price'));
    if(text_blue($('input[name=title]'),$('#info_title'))&&check_file_image($('input[name=file_img]'),$('#span_touxiang'),false)&&price_blue($('input[name=price]'),$('#info_price'))&&price_blue($('input[name=yuan_price]'),$('#info_yuan_price'))){
        $('form[name=release_goods]').submit();
    }
    return false;
}
