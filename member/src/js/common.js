/**
 * Created by zxy on 2016/3/3.
 */
;(function($){git
    var $selectImg = $('.content-li-img'),
        imgLen = $selectImg.length,
        $select = $('.content-left-li');
    for(var i = 0;i < imgLen; i++){
        $($selectImg[i]).css('background-position-x', 24 * i + 'px');
    }
    $select.on('click',function(e){
        var $checked = $('.content-li-clicked'),
            $oldImg = $checked.find('.content-li-img'),
            $img = $(this).find('.content-li-img');
        if($checked.length){
            $oldImg.css('background-position-y', 0);
            $checked.find('.content-li-bar').css('width','0px');
            $checked.removeClass('content-li-clicked');
        }
        $(this).addClass('content-li-clicked');
        $img.css('background-position-y', 24 + 'px');
        $(this).find('.content-li-bar').css('width','4px');
    });



    //window.onload = window.onresize = function() {
    //    var docWidth = document.documentElement.offsetWidth;
    //    setFixedLeft($('.content-left'));
    //    setFixedLeft($('.header-left'));
    //    function setFixedLeft(obj) {
    //        obj.css('left', docWidth/2-496);
    //        if(docWidth < 1080) {
    //            obj.css('left', 0);
    //        }
    //    }
    //}

}(jQuery));