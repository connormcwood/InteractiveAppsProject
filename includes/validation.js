$(function() {
	$("#login-form").validate({
	rules: {
		username: {
			required: true
		},
		password: {
			required: true
		}
		},
	messages: {
		username: {
			required: 'Please Enter A Valid Username'
			},
		password: {
			required: 'Please Enter A Valid Password'
			}
		}
	});	
});
