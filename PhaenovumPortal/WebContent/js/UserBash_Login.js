var visible;
function $(id) {
	return document.getElementsByName(id)[0];
}

function unvisible(id, root, stufe) {

	if (stufe == 1) {
		document.getElementById(id).style.opacity = 0.0;
	} else if (stufe == 0) {
		if (root.value == undefined || root.value == '') {
			document.getElementById(id).style.opacity = 0.5;
		}
	} else if (stufe == -1) {
		if (root.value == undefined || root.value == '') {
			document.getElementById(id).style.opacity = 1;
		}
	}
}

// function to(id) {
// if ($(visible) == undefined) {
// $('tabbed0').style.display = 'none';
// $(id).style.display = 'block';
// } else {
// $(visible).style.display = 'none';
// $(id).style.display = 'block';
// }
// visible = id;
// }
