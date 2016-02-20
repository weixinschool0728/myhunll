$('.qrsc').bind('click',function(){
    if(window.confirm('确定要上传网站首页轮播广告吗？')){
        var name=$(this).attr('id');
        if($('form[name='+name+']').children('input').attr('value')===''){
            alert('您没有更改广告图片');
        }else{
            $('form[name='+name+']').submit();
        }
    };
});



$('.goods_img').bind('mouseover',function(){
    var src=$(this).attr('src');
    $('.fangda').attr('src',src);
    $('.fangda').css('display','block');
    
});
$('.goods_img').bind('mousemove',function(e){
    $('.fangda').css('display','block');
    var pointx=e.pageX+100;
    var pointy=e.pageY-150;
    $('.fangda').css('top',pointy);
    $('.fangda').css('left',pointx);
});
$('.goods_img').bind('mouseout',function(){
    $('.fangda').css('display','none');
});



$('.goods_img').bind('click',function(){
    var id=$(this).attr('id');
    $('input[name='+id+']').trigger('click');
});




$('input[type=file]').bind('change',function(){
    if(check_file_image($(this),$("#span_touxiang"),true)){
        file_jia_change($(this));
    };
    
});

//文件上传控件内容改变时的ajax上传函数
function file_jia_change(obj){
    var id=obj.attr('name');
    $("#form_"+id).ajaxSubmit({  
                    type: 'post',  
                    dataType:"json",
                    async : false,
                    success: function(msg){
                        var img_url='';
                        if(id==='file_1'){
                            img_url=msg.file_1;
                        }else if(id==='file_2'){
                            img_url=msg.file_2;
                        }else if(id==='file_3'){
                            img_url=msg.file_3;
                        }else if(id==='file_11'){
                            img_url=msg.file_11;
                        }else if(id==='file_12'){
                            img_url=msg.file_12;
                        }else if(id==='file_13'){
                            img_url=msg.file_13;
                        }else if(id==='file_14'){
                            img_url=msg.file_14;
                        }else if(id==='file_15'){
                            img_url=msg.file_15;
                        }else if(id==='file_21'){
                            img_url=msg.file_21;
                        }else if(id==='file_22'){
                            img_url=msg.file_22;
                        }else if(id==='file_23'){
                            img_url=msg.file_23;
                        }else if(id==='file_24'){
                            img_url=msg.file_24;
                        }else if(id==='file_25'){
                            img_url=msg.file_25;
                        }else if(id==='file_61'){
                            img_url=msg.file_61;
                        }else if(id==='file_62'){
                            img_url=msg.file_62;
                        }else if(id==='file_63'){
                            img_url=msg.file_63;
                        }
                        $('#'+id).attr('src','/'+img_url);
                        $('input[name=text_'+id+']').attr('value',img_url);
                        return true; 
                    },  
                    error: function(){  
                        alert('上传文件出错');
                        return false;
                    }  
                });  
}