/**
 * Created by zxy on 2016/3/3.
 */

//侧栏图标
;(function(){
    var selectImg = document.querySelectorAll('.content-li-img'),
        imgLen = selectImg.length,
        list = document.querySelector('.content-left');
    for(var i = 0;i < imgLen;i++)selectImg[i].style.backgroundPositionX = 24*i+'px';
    list.addEventListener('click',function(e){
        e = e||window.event;
        var target = e.target || e.srcElement;
        if(target.nodeName.toLowerCase() !== 'li')target = target.parentElement;
        var checked = document.querySelector('.content-li-clicked'),
            img = target.querySelector('.content-li-img');
        if(checked){
            checked.childNodes[3].style.backgroundPositionY = 0;
            checked.querySelector('.content-li-bar').style.width = 0;
            checked.className = "content-left-li";
        }
        target.className = "content-left-li content-li-clicked";
        img.style.backgroundPositionY = 24+'px';
        target.querySelector('.content-li-bar').style.width = '4px';
    });
})();
