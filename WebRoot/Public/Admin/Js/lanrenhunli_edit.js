/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//获取商品列表
var url="/admin/Advert/goods_list.html";
get_goods_list(url);
function get_goods_list(url){
    var server=$('option:selected').val();
    var serch_name=$('input[name=serch]').val();
    var data={
        server_content:server,
        serch:serch_name
        };
    $.ajax({
        type:'post',
        async : true,
        url:url,
        datatype:'json',
        data:data,
        success:function(msg){
            var str="";
            $(msg.li).each(function(i,item){
                str+='<div class="content">';
                str+='<div class="td1">'+i+'</div>';
                str+="<div class='td2'>"+item.goods_name+"(id:"+item.goods_id+")</div>";
                str+='<div class="td3"><a href="/Home/Goods/index?goods_id='+item.goods_id+'"><img src="'+item.goods_img+'" class="img_zst"/></a></div>';
                str+="<div class='td4'>&yen;"+item.price+"</div>";
                str+="<div class='td5'>"+getDate(item.add_time)+"</div>";
                str+='<div class="td6"><input type="button" class="input_button" id="'+item.goods_id+'"  name="'+item.goods_name+'"  value="加入" /></div>';
                str+='</div>';
            });
            $('#goods_list').html(str);
            $('.page_foot').html(msg.page_foot);
        }
    });
}
$('body').on('click','.page_foot a',function(event){
    event.preventDefault();
    var url_p=$(this).attr('href');
    get_goods_list(url_p);
});
//动态生成元素绑定事件
$('body').on('click','.del_button',function(){
    if(window.confirm('确定要把该商品从套餐中删除吗吗？')){
        $(this).parent().remove();
    }else{
        return false;
    }
});
$('input[name=serch_sm]').bind('click',function(){
    sc_change();
});
$('select[name=server_content]').bind('change',function(){
    sc_change();
});
    function sc_change(){
        get_goods_list(url);
    }
    
    $('body').on('click','.input_button',function(){
        var id=$(this).attr('id');
        var name=$(this).attr('name');
        var server=$('option:selected').val();
        var length=$('.combo_input[name='+server+']').length;
        if(length===0){
            if(window.confirm('确定要把  ['+name+'] 加入'+combo_name+' 套餐吗？')){
                var str='<div class="combo_good">';
                str+=server+'： ';
                str+='商品ID:<input name="'+server+'" type="text" readonly="readonly" class="combo_input" value="'+id+'" />';
                str+='<input type="button" value="删除" class="del_button" />';
                str+='</div>';
                $('#edit_form').append(str);
            }else{
                return false;
            }
        }else{
            alert('该服务类型已经添加了商品');
        } 
    });
$('#edit_queding').bind('click',function(){
    $('#edit_form').submit();
});