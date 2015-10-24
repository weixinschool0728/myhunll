// JavaScript Document


    $('.touxiang>img').each(function(i,item){
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
                    $('#div_li').html(msg.li);
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
                    $('#div_li').html(msg.li);
                    $('.page_foot').html(msg.page_foot);
            }
        });
    });

