;(function(){
	
	var list = document.querySelector('.set-list'),
		title = list.querySelectorAll('.set-title'),
		form = document.querySelectorAll('form');
		underline = document.querySelector('.set-title-underline'),
		input =document.querySelectorAll('input')
	

	//切换
	var timer =null
	function goUnderline(speed,left){
		timer=setInterval(function(){
			if(underline.offsetLeft == left){
			clearInterval(timer);
			}else{
				underline.style.left =  underline.offsetLeft +speed/90+'px';
				//console.log(underline.offsetLeft);
			}	
		},300/90);	
	}
	
	addEven(title[1],'mouseover',function(){
		goUnderline(88,88);
		title[1].className = 'set-title set-title-hover';
		title[0].className = 'set-title';
		form[1].style.display = 'block';
		form[0].style.display = 'none';

	})

	addEven(title[0],'mouseover',function(){
		goUnderline(-88,8);
		title[0].className = 'set-title set-title-hover';
		title[1].className = 'set-title';
		form[0].style.display = 'block';
		form[1].style.display = 'none';

	})

	//ie placeholder

	var label =document.querySelectorAll('.set-label'),
		laLen = label.length;
		safe =document.querySelector('.safe-info');

	function placeholder(nodes) {
       if(nodes.length && !("placeholder" in document.createElement('input'))){
          for(i=0;i<nodes.length;i++){
            nodes[i].index = i;
            nodes[i].onfocus = function(){
              	console.log(this.index);
                    if(label[this.index].style.display == 'block'){
                     label[this.index].style.display ='none';
                }               
            }
            nodes[i].onblur = function(){
                if(this.value == ''){
                    label[this.index].style.display = 'block';
                     
                }              
            }  
            label[i].onclick = function(){
              	this.style.display ='none';
            }
            nodes[i].onmouseout = function(){
                if(this.value == ''){
                    label[this.index].style.display = 'block';
                     
                }              
            }                                       
            label[i].style.display = 'block'; 
                        
        }
    }
 }    

    placeholder(input);
})();