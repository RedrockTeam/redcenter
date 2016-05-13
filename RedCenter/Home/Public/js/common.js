/**
 * Created by zxy on 2016/3/3.
 */

/**
 * add addClass removeClass
 * 冯秋明
 * 
 */
function addEven(target,event_name,handler,useCapture){
    useCapture = useCapture||false;
    if(target.addEventListener){
        target.addEventListener(event_name,handler,useCapture);
    }else if(target.attachEvent){
        target.attachEvent("on"+event_name,handler);
    }else{
        target["on"+event_name] = handler;
    }
}

function addClass(ele, className) {
    var preClass = ' ' +  ele.className;
    var reg = new RegExp(' ' + className);
    if(reg.test(' ' + preClass)) {
        return;
    }
    ele.className += ' ' + className;
}

function removeClass(ele, className) {
    var preClass = ' ' +  ele.className;
    ele.className = preClass.replace(' ' + className, '').trim();
}



//侧栏图标
;(function(){
    var selectImg = document.querySelectorAll('.content-li-img'),
        imgLen = selectImg.length,
        list = document.querySelector('.content-left');
    for(var i = 0;i < imgLen;i++)selectImg[i].style.backgroundPositionX = 24*i+'px';
    
    addEven(list,'click',function(e){
        e = e||window.event;
        var target = e.target || e.srcElement;
        if(target.nodeName.toLowerCase() === 'ul')return;
        if(target.nodeName.toLowerCase() !== 'li')target = target.parentElement;
        var checked = document.querySelector('.content-li-clicked'),
            img = target.querySelector('.content-li-img');
        if(checked){
            checked.querySelector('.content-li-img').style.backgroundPositionY = 0;
            checked.querySelector('.content-li-bar').style.width = 0;
            checked.className = "content-left-li";
        }
        target.className = "content-left-li content-li-clicked";
        img.style.backgroundPositionY = 24+'px';
        target.querySelector('.content-li-bar').style.width = '4px';
    });
})();

$.post("/redcenter/index.php/Home/Index/returnData.html", 'dataType=getSelfInfo',function(res) {
    var res = res;
    $('#user-header').attr('src', '/redcenter/RedCenter/Home/Public/' +res.headImage);
    $('#user-name').text(res.nickname);
});

$.post("/redcenter/index.php/Home/Index/returnData.html", 'dataType=newNewsNum',function(res) {
    var res = JSON.parse(res);
    $('#user-message').text('您有'+ res + '条消息');
})