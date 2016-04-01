//搜索栏动画
    var stu = document.querySelector('#search-stu>input');
    stu.onfocus = function(e){
        this.style.width = '342px';
        this.style.borderColor = '#C0C0C0';
    };
    stu.onblur = function(e){
        this.style.cssText = '';
    };

    //select控制
    var select = document.getElementsByTagName('select')[0],
            selUl = document.querySelector('.search-sel'),
            selLi = document.querySelectorAll('.search-sel-li'),
            selOp = document.getElementsByTagName('option'),
            selLiFirst = document.querySelector('.search-sel-first');
    selUl.onclick = function(e){
        e = e||window.event;
        var target = e.target||e.srcElement,
                i;
        if(target.tagName.toLowerCase() === 'li'){
            selLiFirst.innerHTML = target.innerHTML;
            for(i = 1;i<5;i++){
                selLi[i].style.display = 'none';
                if(target.innerHTML === selOp[i-1].innerHTML)select.value = selOp[i-1].value;
            }
        }else {
            var liDis = window.getComputedStyle?window.getComputedStyle(selLi[1],null).display:selLi[1].currentStyle.display;
            if(liDis === 'none'){
                for(i = 1;i<5;i++){
                    selLi[i].style.display = 'block';
                }
            }else {
                for(i = 1;i<5;i++){
                    selLi[i].style.display = 'none';
                }
            }
        }
    }