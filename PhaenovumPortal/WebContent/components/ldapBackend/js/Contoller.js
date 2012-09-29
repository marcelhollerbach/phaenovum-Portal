function $n(name) {
	return document.getElementsByName(name);
}

function setChecks(name, rawpermissions) {
	for ( var count in $n('permission[]')) {
		$n('permission[]')[count].checked = 0;
	}
	var permissions = rawpermissions.split("&");
	$n('ldap-headline')[0].innerHTML = name;
	$n('groupname')[0].value = name;
	if (rawpermissions != '') {
		for ( var permission in permissions) {
			if(permission != 0){
			//alert(permission);
			//alert(permissionValue(permissions[permission]));
			object = permissionValue(permissions[permission]);
			object.checked = 1;
			}
		}
	}
}
function permissionValue(value) {
	for ( var permission in $n('permission[]')) {
		if ($n('permission[]')[permission].value == value) {
			return $n('permission[]')[permission];
		}
	}
	return null;
}