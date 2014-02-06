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
		var inputsSection = form.find('#marketo-subscribe-inputs');
		var invalidEmail = form.find('#marketo-subscribe-invalid-email');
		var submitButton = form.find('input[type="submit"]');

		if (!isEmail(form.find('#marketo-subscriber-email').val())) {
			invalidEmail
			.html('<p>Please use a valid email address</p>')
			.slideDown(500);

			return false;
		}

		submitButton.attr('disabled','disabled');

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

		function failure() {
			submitButton.removeAttr('disabled','disabled');
			inputsSection.append('<p>There was a problem submitting your information. Please try again later.</p>');
		}

		function success() {
			inputsSection.slideUp(500);
			form.find('#marketo-subscribe-thank-you').slideDown(500);
		}

		function isEmail(email) {
			var emailRegex = /.+\@.+\..+/;
			return emailRegex.test(email);
		}
	});
});