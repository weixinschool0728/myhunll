$('.jibie_1').bind('click',function(){
    if($(this).next('ul').css('display')==='none'){
        $(this).next('ul').css('display','block');
    }else{
        $(this).next('ul').css('display','none');
    }
});