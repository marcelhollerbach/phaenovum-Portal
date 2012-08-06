function $(id) {
	return document.getElementsByName(id)[0];
}

function login() {
	var pw = $('pw').value;
	var usr = $('usr').value;
	var http = null;
	// Mozilla
	if (window.XMLHttpRequest) {
		http = new XMLHttpRequest();
	}
	// IE
	else if (window.ActiveXObject) {
		http = new ActiveXObject("Microsoft.XMLHTTP");
	}

	var url = "./bash/auth.php";
	var params = "type=log&usr=" + usr + "&pw=" + pw;
	http.open("POST", url, true);

	// Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", params.length);
	http.setRequestHeader("Connection", "close");
	http.onreadystatechange = function() {// Call a function when the state
		// changes.
		if (http.readyState == 4 && http.status == 200) {
			refreshlogin(http.responseText);
		} else if (http.readyState != 4) {
			$('bash_pane0').innerHTML = 'Seite wird geladen ...';
		}
	};
	http.send(params);
}
function logout() {
	var http = null;
	// Mozilla
	if (window.XMLHttpRequest) {
		http = new XMLHttpRequest();
	}
	// IE
	else if (window.ActiveXObject) {
		http = new ActiveXObject("Microsoft.XMLHTTP");
	}

	var url = "./bash/auth.php";
	var params = "type=logout";
	http.open("POST", url, true);

	// Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", params.length);
	http.setRequestHeader("Connection", "close");
	http.onreadystatechange = function() {// Call a function when the state
		// changes.
		if (http.readyState == 4 && http.status == 200) {
			$('bash_pane0').innerHTML = http.responseText;
			refreshlogin(1);
		} else if (http.readyState != 4) {
			$('bash_pane0').innerHTML = 'Seite wird geladen ...';
		}
	};
	http.send(params);
}
function refreshlogin(key) {
	if (key != -1) {
		var xmlhttp = null;
		// Mozilla
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		}
		// IE
		else if (window.ActiveXObject) {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.open("GET", './bash/auth.php', true);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState != 4) {
				$('bash_pane0').innerHTML = 'Seite wird geladen ...';
			} else if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				$('bash_pane0').innerHTML = xmlhttp.responseText;
			}
		};
		xmlhttp.send(null);
	} else {
		$('bash_pane0').innerHTML = 'Fehler beim login <a onclick="refreshlogin(1)">neuer versuch</a>';
	}
}