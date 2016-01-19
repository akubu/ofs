$(document).ready(function() {
	$('.form-login').submit(function(event) {
		event.preventDefault();
		if($.trim($('[name="username"]').val()) === '') {
			$.growl.error({
				message: 'Username field can\'t be empty.', 
				size: 'large',
				duration: 10000
			});
			return;
		}
		if($.trim($('[name="password"]').val()) === '') {
			$.growl.error({
				message: 'Password field can\'t be empty.', 
				size: 'large',
				duration: 10000
			});
			return;
		}
		$('#login').addClass('hide');
		$('#login').next().removeClass('hide');
		$.ajax({
			type: "POST",
			url: "/auth/vtiger/user",
			dataType: "json",
			data: $(this).serialize(),
			success: function(response) {
				$('#login').removeClass('hide');
				$('#login').next().addClass('hide');
				if(response.error) {
					$.growl.error({
						message: response.message, 
						size: 'large',
						duration: 10000
					});
					return;
				}
				
				window.location.href = response.redirect;
			},
			error : function(xhr, status, error) {
				$('#login').removeClass('hide');
				$('#login').next().addClass('hide');
				$.growl.error({
					message: status, 
					size: 'large',
					duration: 10000
				});
			}
		});
	});
});
