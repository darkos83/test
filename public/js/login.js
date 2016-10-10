$('button').on('click', function(){
	var params = $(this).closest('form').serializeObject();
	$.ajax({
		url: 'login.php',
		type: 'POST',
		data: params,
	})
	.done(function(data) {
		console.log("success", data);
	})
	.fail(function(data) {
		console.log("error", data);
	});
})

$.fn.serializeObject = function() {
	var o = {};
	var a = this.serializeArray();
	$.each(a, function() {
		if (o[this.name]) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	return o;
};