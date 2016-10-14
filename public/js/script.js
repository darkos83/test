$('form').submit(function(e){
 	var valid = true
 	  , inputs = $('input', this);
 	for (var i = 0; i < inputs.length; i++) {
 		if ($(inputs[i]).is(':hidden')) continue;
 		if ($(inputs[i]).val() == '') {
			$(inputs[i]).parent().addClass('has-error');
			valid = false;
		} else {
			$(inputs[i]).parent().removeClass('has-error');
		}
 	}
 	if (!valid) e.preventDefault();
 });
