function asdf() {
	alert('asdf');
}
function createIcon() {
	var name = window.prompt('Icon name ?', 'default');
	if (name) {
		file = './components/iconssettingsComponent/External.php';
		classname = 'ExternalTools';
		methodname = 'createIcon';
		param = new Array();
		param[0] = name;
		callMethod(file, classname, methodname, param);
			while(getResult() == null){
			}
			alert('Fertig '+getResult())
	} else {
		alert('abgebrochen.');
	}
}