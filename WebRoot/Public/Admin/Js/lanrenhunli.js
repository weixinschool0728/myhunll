/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('input[name=add]').bind('click',function(){
    var number=$('select[name=combo_id]>option').length+1;
    var str="<option value='"+number+"'>"+number+"</option>";
    $('select[name=combo_id]').append(str);
});
$('.edit_button').bind('click',function(){
    $('form[name=combo_edit]').submit();
});