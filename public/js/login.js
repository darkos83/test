 $('.promeniAkciju').on('click', function(event) {
 	var akcija = $(this).data().value
 	  , text = $(this).text();
 	$('.promeniAkciju').removeClass('hidden');
 	if (akcija === 'logovanje') {
 		$('.za-registraciju').addClass('hidden');
 		$('[type="submit"]').text('Uloguj se');
 	} else {
 		$('.za-registraciju').removeClass('hidden');
 		$('[type="submit"]').text('Registruj se');
 	}
 	$(this).addClass('hidden');
 	$('h3').text(text);
 	$('[type="hidden"]').val(akcija);
 });
 