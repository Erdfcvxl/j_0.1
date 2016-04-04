function popup(url, data)
{
	console.log(data);

	$.ajax({
		url: url,
		data: data,
		type: 'POST',
		success: function(data){
			console.log('popup success');
			$('.wrap').prepend(data);
		},
		error: function(e){
			console.log('popup error');
			console.log(e.responseText);

		}
	});
}
