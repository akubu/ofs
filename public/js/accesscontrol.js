(function() {
	$(document).ready(function() {
		$('.save-user').click(function() {
			alert(1);
			$.ajax({
				url: '/accessControl/save/user',
				type: 'POST',
				data: $('form').serialize(),
				success: function(response) {
					
				},
				error: function() {
					
				}
			});
		});
	})
})();
