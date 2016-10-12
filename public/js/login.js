 $('.promeniAkciju').on('click', function(event) {
 	var akcija = $(this).data().value
 	  , text = $(this).text();
 	$('.promeniAkciju').removeClass('hidden');
 	if (akcija === 'logovanje') {
 		$('.za-registraciju').addClass('hidden');
 	} else {
 		$('.za-registraciju').removeClass('hidden')
 	}
 	$(this).addClass('hidden');
 	$('h3').text(text);
 	$('[type="hidden"]').val(akcija);
 });