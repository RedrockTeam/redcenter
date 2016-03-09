var doc = document;
var select = doc.querySelector('#select-product');
var sec_select = doc.querySelector('#sec-product-wrap');
var choose_select = doc.querySelector('#choosed-product');


select.addEventListener('click', function(event) {
	var event = event || window.event;
	var target = event.target || event.srcElement;

	var	sec_style = sec_select.style;
	sec_style.display = sec_style.display === 'none'? 'block': 'none';

	if(target.tagName.toLowerCase() === 'a') {
		choose_select.innerHTML = target.innerText;
	} else if(target.tagName.toLowerCase() === 'li') {
		choose_select.innerHTML = target.children[0].innerHTML;
	}

	// console.log(target);
});


// select.addEventListener('mouseover', function() {
// 	var	sec_style = sec_select.style;
// 	sec_style.display = 'none';
// })