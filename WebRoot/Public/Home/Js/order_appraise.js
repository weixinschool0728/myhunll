/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $('.pingjia_xingxing>img').bind('mouseover',function(){
     switch($(this).attr('id')){
         case '1_1':
             $('.yc_1').html('<strong>1 分 很差</strong>- 很差，严重与描述不相符合，缺东少西');
             $('.yc_1').css('display','block');
             break;
         case '1_2':
             $('.yc_1').html('<strong>2 分 不满</strong>- 不满，部分与描述不相符合');
             $('.yc_1').css('display','block');
             break;
         case '1_3':
             $('.yc_1').html('<strong>3 分 一般</strong>- 一般，基本与描述相符合，中规中矩');
             $('.yc_1').css('display','block');
             break;
         case '1_4':
             $('.yc_1').html('<strong>4 分 满意</strong>- 满意，与描述相符合，符合自己的预期');
             $('.yc_1').css('display','block');
             break;
         case '1_5':
             $('.yc_1').html('<strong>5 分 超级满意</strong>- 超级满意，超出自己的预期');
             $('.yc_1').css('display','block');
             break;
         case '2_1':
             $('.yc_2').html('<strong>1 分 很差</strong>- 很差,不守时，态度差 ');
             $('.yc_2').css('display','block');
             break;
         case '2_2':
             $('.yc_2').html('<strong>2 分 不满</strong>- 不满,对新人的承诺不兑现');
             $('.yc_2').css('display','block');
             break;
         case '2_3':
             $('.yc_2').html('<strong>3 分 一般</strong>- 一般,态度一般、服务不主动 ');
             $('.yc_2').css('display','block');
             break;
         case '2_4':
             $('.yc_2').html('<strong>4 分 满意</strong>- 满意,沟通流畅、服务主动');
             $('.yc_2').css('display','block');
             break;
         case '2_5':
             $('.yc_2').html('<strong>5 分 超级满意</strong>- 超级满意，考虑周全、完全超出预期');
             $('.yc_2').css('display','block');
             break;
         case '3_1':
             $('.yc_3').html('<strong>1 分 很差</strong>- 很差,水平很差，影响活动进行 ');
             $('.yc_3').css('display','block');
             break;
         case '3_2':
             $('.yc_3').html('<strong>2 分 不满</strong>- 不满, 水平差，将就着用');
             $('.yc_3').css('display','block');
             break;
         case '3_3':
             $('.yc_3').html('<strong>3 分 一般</strong>- 一般,家人、自己没有不满意，中规中矩 ');
             $('.yc_3').css('display','block');
             break;
         case '3_4':
             $('.yc_3').html('<strong>4 分 满意</strong>- 满意,亲朋好友说比较好，符合自己预期');
             $('.yc_3').css('display','block');
             break;
         case '3_5':
             $('.yc_3').html('<strong>5 分 超级满意</strong>- 超级满意，速度快、水平高，完全超出自己预期');
             $('.yc_3').css('display','block');
             break;
     }
 });
 $('.pingjia_xingxing>img').bind('mouseout',function(){
      $(this).parent().prev('div').css('display','none');
 });
 
 //上传文件必须是图片
$('.file_img').bind('change',function(){check_file_image($(this),$(this).next('span'),true);;});

//添加按钮动作
$('#button_jia').bind('click',function(){tianjia($(this));});
var i=1;
function tianjia(obj){
    var str=' <div class="file_tr"><div class="file_title"><input type="button" value="删除" class="bt_delete" /></div><input type="file" name="file_imgi" class="file_img1" /><span class="file_info"></span></div>';
    if($('input[type=file]').length>2){
        alert('最多添加3张图片作为商品展示图');
        return false;
    }
    obj.before(str);
    $('input[name=file_imgi]').attr('name','file_img'+i);
    i++;
}

//动态生成的元素添加事件
$('body').on('click','.bt_delete',function(){delete_file($(this));});
$('body').on('change','.file_img1',function(){check_file_image($(this),$(this).next('span'),true);});


function delete_file(obj){
    obj.parent().parent().remove();
}

//发表评论按钮绑定事件
$('#fabiao').bind('click',function(){
    var a=$('input[name=pingfen_1]').val(),b=$('input[name=pingfen_2]').val(),c=$('input[name=pingfen_3]').val();
    if(a===''||b===''||c===''){
        if(a===''){
            $('#1_des').html('您还未评分，请评分后再发表评论');
            $('#1_des').css('color','#F00');
        }
        if(b===''){
            $('#2_des').html('您还未评分，请评分后再发表评');
            $('#2_des').css('color','#F00');
        }
        if(c===''){
            $('#3_des').html('您还未评分，请评分后再发表评');
            $('#3_des').css('color','#F00');
        }
        return false;
    }else{
        $('form[name=m_appraiseform_appraise]').submit();
        return true;
    }
});