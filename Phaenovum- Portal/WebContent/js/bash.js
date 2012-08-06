function showSettingsBash(url) {
				dropin();
				if (url == 'settings') {
					//settings öffnen
					parent.document.getElementsByName("bash_pane0")[0].style.display = 'block';
					parent.document.getElementsByName("bash_pane1")[0].style.display = 'none';
					parent.document.getElementById('bash_holder').style.display = 'block';
					//orangen striefen verstecken
					parent.document.getElementById('small_sidebar').style.display = 'none';
				} else {
					//zeige den iframe mit dieser seite
					//parent.document.getElementsByName("bash_pane0")[0].style.display = 'none';
					//parent.document.getElementsByName("bash_pane1")[0].style.display = 'block';
					//parent.document.getElementsByName("_bash_output")[0].src = url;
					//parent.document.getElementById('bash_holder').style.display = 'block';
					//orangen striefen verstecken
					//parent.document.getElementById('small_sidebar').style.display = 'none';
					alert('Nicht stabil ! ');
				}

			}

			function hideSettingsBash() {
				parent.document.getElementById('bash_holder').style.display = 'none';
				//orangen striefen verstecken
				parent.document.getElementById('small_sidebar').style.display = 'block';
			}