/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('select[name=server_content]').bind('change',function(){sc_change();});
function sc_change(){
    $('form[name=sv_cont]').submit();
}

$('#qrxg').bind('click',function(event){
    if(window.confirm('确定要修改分类属性吗？')){
    }else{
        event.preventDefault();
    }
});