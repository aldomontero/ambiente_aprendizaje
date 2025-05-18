function setup(type, page_default){
	$.ajaxSetup({
		type: type,
		url: page_default,
		// See: http://www.maheshchari.com/jquery-ajax-error-handling/
		error: function(x, e) {
			var s = x.status, 
				m = 'Ajax error: ' ; 
			if (s === 0) {
				m += 'Check your network connection.';
			}
			if (s === 404 || s === 500) {
				m += s;
			}
			if (e === 'parsererror' || e === 'timeout') {
				m += e;
			}
			alert(m);
		}
	});
}