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



