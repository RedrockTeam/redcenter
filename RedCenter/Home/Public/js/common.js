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
    

        var navList = document.querySelector('.content-left').querySelectorAll('a');

        for(var i = 0, len = navList.length; i < len; i++) {
            navList[i].addEventListener('mouseover', function() {
                this.className = 'nav-check';
            });
            navList[i].addEventListener('mouseout', function() {
                this.className = '';
            });

        }
})();

$.post("/redcenter/index.php/Home/Index/returnData.html", 'dataType=getSelfInfo',function(res) {
    var res = res;
    $('#user-header').attr('src', '/redcenter/RedCenter/Home/Public/' +res.headImage);
    $('#user-name').text(res.nickname);
});

$.post("/redcenter/index.php/Home/Index/returnData.html", 'dataType=newNewsNum',function(res) {
    console.log(res);
    $('#user-message').text('您有'+ res + '条新的消息');
})