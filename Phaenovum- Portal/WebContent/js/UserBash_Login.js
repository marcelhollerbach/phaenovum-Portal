function unvisible(id,root, stufe) {

	if (stufe == 1) {
		document.getElementById(id).style.opacity = 0.0;
	} else if (stufe == 0) {
		if (root.value == undefined|| root.value == '') {
			document.getElementById(id).style.opacity = 0.5;
		}
	}
}
function visible(id,root) {
	if (root.value == undefined
			|| root.value == '') {
		document.getElementById(id).style.opacity = 1;
	} else {

	}
}