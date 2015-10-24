// JavaScript Document


    $('.datouxiang_div>img').each(function(i,item){
        if($(item).height()<300){
            $(item).css('height','300px');
            $(item).css('width','auto');
        }
    });
    $('.xiaotouxiang img').each(function(i,item){
        if($(item).height()<68){
            $(item).css('height','68px');
            $(item).css('width','auto');
        }
    });
    
    //网页一开始就需要获取ajax信息
    var url_y=window.location.href;
    var url=url_y.replace('index','page');
    $.ajax({
            type:'post',
            async : true,
            url:url,
            datatype:'json',
            success:function(msg){
                var str="";
                $(msg.li).each(function(i,item){
                    str+='<li class="other_goods"> ';
                    str+='<a href="/Home/Goods/index/goods_id/'+item.goods_id+'.html" class="other_a">';
                    str+='<span class="span1">['+item.cat_name+']'+item.goods_name+'</span>';
                    str+='<span class="span2 hlljg">&yen; '+item.price+'</span><span class="span2 mdj">&yen; '+item.yuan_price+'</span><span class="span2 ys">200</span>';
                    str+='</a></li>';
                });
                
                
                
                $('#div_li').html(str);
                    $('.page_foot').html(msg.page_foot);
            }
        });
    
    //动态生成的必须用$('body').on('click','.num',function()｛｝）添加事件
$('body').on('click','.page_foot a',function(event){
    event.preventDefault();
    var url=$(this).attr('href');
    $.ajax({
            type:'post',
            async : true,
            url:url,
            datatype:'json',
            success:function(msg){
                var str='';
                $(msg.li).each(function(i,item){
                    str+='<li class="other_goods"> ';
                    str+='<a href="/Home/Goods/index/goods_id/'+item.goods_id+'.html" class="other_a">';
                    str+='<span class="span1">['+item.cat_name+']'+item.goods_name+'</span>';
                    str+='<span class="span2 hlljg">&yen; '+item.price+'</span><span class="span2 mdj">&yen; '+item.yuan_price+'</span><span class="span2 ys">200</span>';
                    str+='</a></li>';
                });
                
                
                $('#div_li').html(str);
                $('.page_foot').html(msg.page_foot);
            }
        });
    });

//鼠标放到小头像，大头像变化
$('.xiaotouxiang img').bind('mouseover',function(){
    var img_src=$(this).attr('src');
    $('.datouxiang').attr('src',img_src);
});

//鼠标放到大头像，再放大图片
$('.datouxiang').bind('mouseover',function(){
    var img_src=$(this).attr('src');
    var img_fangda='<img class="datouxiang_fangda" />';
    $('.touxiang').after(img_fangda);
    $('.datouxiang_fangda').attr('src',img_src);
});
$('.datouxiang').bind('mouseout',function(){
    $('.datouxiang_fangda').remove();
    });
