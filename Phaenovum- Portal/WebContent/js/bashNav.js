var counter = 0;
var margin = 0;
var speed = 5;
var iconHeight = 64;
var viewpoint = 0;
var run_t = 0;
var run_b = 0;
function $(id) {
	return document.getElementsByName(id)[0];
}
function initNav(number) {
	counter = number;
	// alert(counter);
}
function rendersize() {
	viewpoint = window.innerHeight - 64;
	// alert(viewpoint);
}
function moveTop(start) {
	if (start == 1) {
		run_t = 1;
		_moveTop();
	} else {
		run_t = 0;
	}
}
function moveBot(start) {
	if (start == 1) {
		run_b = 1;
		_moveBot();
	} else {
		run_b = 0;
	}
}
function _moveTop() {
	// alert(margin + viewpoint);
	// alert(counter * iconHeight);
	if (margin * -1 + viewpoint < (counter * iconHeight)) {
		margin -= speed;
		$('viewpoint').style.marginTop = margin + "px";
	}
	if (run_t == 1) {
		window.setTimeout("_moveTop()", 100);
	}
}
function _moveBot() {
	if (margin < 0) {
		margin += speed;
		$('viewpoint').style.marginTop = margin + "px";
	}
	if (run_b == 1) {
		window.setTimeout("_moveBot()", 100);
	}
}
