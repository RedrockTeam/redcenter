var doc = document;
var select = doc.querySelectorAll(".select");
var select_product = doc.querySelector('#select-product');
var sec_select = doc.querySelector('#sec-product-wrap');
var choose_select = doc.querySelector('#dot-border-choosed');


function addClassName(ele, className) {
	var preClass = ' ' +  ele.className;
	var reg = new RegExp(' ' + className);
	if(reg.test(' ' + preClass)) {
		return;
	}
	ele.className += ' ' + className;
}


function removeClassName(ele, className) {
	var preClass = ' ' +  ele.className;
	ele.className = preClass.replace(' ' + className, '').trim();

}



select[0].addEventListener('click', function() {
	addClassName(select[0].children[0], 'dot-border-choosed');
	removeClassName(select[1].children[0], 'dot-border-choosed');
});

select[1].addEventListener('click', function() {
	addClassName(select[1].children[0], 'dot-border-choosed');
	removeClassName(select[0].children[0], 'dot-border-choosed');
});

select_product.addEventListener('click', function(event) {
	var event = event || window.event;
	var target = event.target || event.srcElement;

	var	sec_style = sec_select.style;
	sec_style.display = sec_style.display === 'none'? 'block': 'none';

	if(target.tagName.toLowerCase() === 'a') {
		choose_select.innerHTML = target.innerText;
	} else if(target.tagName.toLowerCase() === 'li') {
		choose_select.innerHTML = target.children[0].innerHTML;
	}

});

