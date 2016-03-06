/**
 * Created by zxy on 2016/3/3.
 */
;(function($){
    var $selectImg = $('.content-li-img'),
        imgLen = $selectImg.length,
        $select = $('.content-left-li');
    for(var i = 0;i < imgLen;i++){
        $($selectImg[i]).css('background-position',(240-24*i)+'px'+' 0');
    }
    $select.on('click',function(e){
        var $checked = $('.content-li-clicked'),
            $oldImg = $checked.find('.content-li-img'),
            $img = $(this).find('.content-li-img');
        if($checked.length){
            $oldImg.css('background-position',parseInt($oldImg.css('background-position'))+120+'px'+' 0');
            $checked.find('.content-li-bar').css('width','0px');
            $checked.removeClass('content-li-clicked');
        }
        $(this).addClass('content-li-clicked');
        $img.css('background-position',parseInt($img.css('background-position'))-120+'px'+' 0');
        $(this).find('.content-li-bar').css('width','4px');
        //console.log(parseInt($img.css('background-position')));
    });
}(jQuery));