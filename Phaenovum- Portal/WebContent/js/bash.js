function showSettingsBash() {
	dropin();
	//parent.document.getElementsByName("bash_pane0")[0].style.display = 'block';
	parent.document.getElementById('bash_holder').style.display = 'block';
}

function hideSettingsBash() {
	parent.document.getElementById('bash_holder').style.display = 'none';
	// orangen striefen verstecken
	parent.document.getElementById('small_sidebar').style.display = 'block';
}