var _names;
var _position;
var _icon;
var _in_network;
var _out_network;
var _popup;
var _publish;
function setEdits(names, position, icon, in_network, out_network, popup,
		publish) {
	_names = names;
	_position = position;
	_icon = icon;
	_in_network = in_network;
	_out_network = out_network;
	_popup = popup;
	_publish = publish;
}
function $n(name) {
	return document.getElementsByName(name);
}
function setIconName() {
	var name = 'none';
	var tmpname = prompt("Icon name:", "default");
	if (tmpname != null && tmpname != '') {
		name = tmpname;
	}
	$n('iconname')[0].value = name;
	$n('newIcon')[0].submit();
}
function submitDelete() {
	$n('iconselect')[0].submit();
}
function setEdit(id) {
	$n('currentname')[0].value = _names[id];
	$n('new_name')[0].value = _names[id];
	if (_icon[id] != '') {
		$n('currentpic')[0].style.display = 'block';
		$n('currpic')[0].src = _icon[id];
	}
	$n('in_network')[0].value = _in_network[id];
	$n('out_network')[0].value = _out_network[id];
	$n('check[]')[0].checked = _popup[id];
	$n('check[]')[1].checked = _publish[id];
}