function scriptolutions_fiverrscript_toggleit(obj) {
	var el = document.getElementById(obj);
	if ( el.style.display != 'none' ) {
		$('#' + obj).hide();
	}
	else {
		$('#' + obj).show();
	}
}