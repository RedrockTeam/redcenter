;(function(doc){
	var select = doc.querySelectorAll(".select"),
		select_product = doc.querySelector('#select-product'),
		sec_select = doc.querySelector('#sec-product-wrap'),
		choose_select = doc.querySelector('#choosed-product');



	addEven(select[0], 'click', function() {
		addClass(select[0].children[0], 'dot-border-choosed');
		removeClass(select[1].children[0], 'dot-border-choosed');
	});
	addEven(select[1], 'click', function() {
		addClass(select[1].children[0], 'dot-border-choosed');
		removeClass(select[0].children[0], 'dot-border-choosed');
	});

	
	addEven(select_product, 'click', function(event) {
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
}(document));


