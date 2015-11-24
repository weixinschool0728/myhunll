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


//日历增加自己的JS功能
//让选择div移动到鼠标位置
$('body').on('click','#dateSelectionRili',function(e){
    var xx=e.pageX+10;
    var yy=e.pageY+10;
    $('#dateSelectionDiv').css({top: yy, left: xx});
});
//获取选择的日期
//$('body').unon('click','#tt td');
//$('body').on('click','#tt td'.bin,function(){
    //var year=$('#nian').html();
    //var month=$('#yue').html();
    //var day=$(this).children('font').html();
//});

//显示遮罩层
function showOverlay() {
    $("#overlay").height(pageHeight());
    $("#overlay").width(pageWidth());

    // fadeTo第一个参数为速度，第二个为透明度
    // 多重方式控制透明度，保证兼容性，但也带来修改麻烦的问题
    $("#overlay").fadeTo(200, 0.3);
    $('.mini_login').css('display','block');
    adjust("#mini_login");
}

/* 隐藏覆盖层 */
function hideOverlay() {
    $("#overlay").fadeOut(200);
    $('.mini_login').css('display','none');
}

/* 当前页面高度 */
function pageHeight() {
    return document.body.scrollHeight;
}

/* 当前页面宽度 */
function pageWidth() {
    return document.body.scrollWidth;
}

/* 关闭登录页面 */
$('#mini_close').bind('click',function(){
    var url=window.location.href;
    $.ajax({
        type:'post',
        url:url,
        datatype:'json'
    });
    hideOverlay();
});


/* 定位到页面中心 */
function adjust(id) {
    var w = $(id).width();
    var h = $(id).height();
    
    var t = scrollY() + (windowHeight()/2) - (h/2);
    if(t < 0) t = 0;
    
    var l = scrollX() + (windowWidth()/2) - (w/2);
    if(l < 0) l = 0;
    
    $(id).css({left: l+'px', top: t+'px'});
}

//浏览器视口的高度
function windowHeight() {
    var de = document.documentElement;

    return self.innerHeight || (de && de.clientHeight) || document.body.clientHeight;
}

//浏览器视口的宽度
function windowWidth() {
    var de = document.documentElement;

    return self.innerWidth || (de && de.clientWidth) || document.body.clientWidth
}

/* 浏览器垂直滚动位置 */
function scrollY() {
    var de = document.documentElement;

    return self.pageYOffset || (de && de.scrollTop) || document.body.scrollTop;
}

/* 浏览器水平滚动位置 */
function scrollX() {
    var de = document.documentElement;

    return self.pageXOffset || (de && de.scrollLeft) || document.body.scrollLeft;
}

//滚动条滚动事件绑定
$(window).bind('scroll',function(){
    adjust("#mini_login");
});

/* 关闭提示选择日期div */
$('#tishi_close').bind('click',function(){
    $('#buy').css('display','block');
    $('#buy_clone').css('display','none');
});

//选择日期 关闭提示选择日期
$('body').on('click','#tt>td',function(){
    $('#buy').css('display','block');
    $('#buy_clone').css('display','none');
});
//鼠标移动到日期 变手形，边框变红
$('body').on('mouseover','#tt>td',function(){
    $(this).children('font').css('color','red');
});
$('body').on('mouseout','#tt>td',function(){
    $(this).children('font').css('color','#666');
});