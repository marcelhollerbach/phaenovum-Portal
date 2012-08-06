			function contextIn(id) {
				parent.document.getElementsByName("context")[id].style.display = 'none';
			}

			function contextOut(id) {
				parent.document.getElementsByName("context")[id].style.display = 'block';
			}

			function pop(file) {
				helpwindow = window.open(file, "pophelp", "f1,f2,f3");
				helpwindow.focus();
				return false;
			}

			function dropOut() {
				parent.document.getElementById('sidebar_holder').style.display = 'block';
				parent.document.getElementById('small_sidebar').style.background = 'transparent';
			}

			function dropin() {
				parent.document.getElementById('sidebar_holder').style.display = 'none';
				parent.document.getElementById('small_sidebar').style.background = 'rgb(242,146,0)';
			}