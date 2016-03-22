/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('input[name=add]').bind('click',function(){
    var number=$('select[name=combo_id]>option').length+1;
    var str="<option value='"+number+"'>"+number+"</option>";
    var url='/Admin/Advert/lanrenhunli_add.html';
    var data={
        check:'combo_add'
    };
    $.ajax({
        type:'post',
        async : false,
        url:url,
        data:data,
        datatype:'json',
        success:function(msg){
            var lo_url="/Admin/Advert/lanrenhunli.html?combo_id="+msg;
            window.location.href=lo_url;
        }
    }); 
});
$('input[name=del]').bind('click',function(){
    var id=$('select[name=combo_id]>option:selected').val();
    var url='/Admin/Advert/lanrenhunli_del.html';
    var data={
        check:'combo_del',
        id:id
    };
    $.ajax({
        type:'post',
        async : false,
        url:url,
        data:data,
        datatype:'json',
        success:function(msg){
            var lo_url="/Admin/Advert/lanrenhunli.html";
            window.location.href=lo_url;
        }
    }); 
});

