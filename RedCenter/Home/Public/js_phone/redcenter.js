(function(){
	var exchangeBtn = document.querySelector("#exchange-btn");
	
	function touchBtn(event) {
		if(event.type === 'touchstart' || event.type === 'touchmove')
			exchangeBtn.style.backgroundColor = "#ec8a17";
		else if(event.type === 'touchend' || event.type === 'touchcancel')
			exchangeBtn.style.backgroundColor = "#ffa825";
	}
	exchangeBtn.addEventListener("touchstart", touchBtn);
	exchangeBtn.addEventListener("touchmove", touchBtn);
	exchangeBtn.addEventListener("touchend", touchBtn);
	exchangeBtn.addEventListener("touchcancel", touchBtn);
})();