jQuery(document).ready(function($){

	$('#marketo-subscriber-email').click(function(){
		if (this.value == 'Email Address') { this.value = ''; }
	});

	$('#marketo-subscriber-email').blur(function(){
		if (this.value == '') { this.value = 'Email Address'; }
	});

	$('#marketo-subscribe-form').submit(function(e){
		e.preventDefault();

		var form = $(this);

		$.ajax({
			url: form.attr('action'),
			type: 'post',
			dataType: 'json',
			data: form.serialize()
		})
		.done(function(data) {
			if (data.type == 'success') {
				success();
			} else {
				failure();
			}
		})
		.fail(function() {
			failure();
		});

		var failure = function()
		{
			form.find('#marketo-subscribe-inputs').append('<p>There was a problem submitting your information. Please try again later.</p>');
		}

		var success = function()
		{
			form.find('#marketo-subscribe-inputs').slideUp(500);
			form.find('#marketo-subscribe-thank-you').slideDown(500);
		}
	});
});