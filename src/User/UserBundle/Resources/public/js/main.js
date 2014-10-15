$(document).ready(function(){
	console.info('main.js is loaded');

	$('#frmEditUser').submit(function(){
		//e.preventDefault();
		if(confirm('Are you sure you want to update your account?')) {
			return true;
		} else {
			return false;
		}
	});

	$('#formChangePass').submit(function(){
		//e.preventDefault();
		if(confirm('Are you sure you want to update your password?')) {
			return true;
		} else {
			return false;
		}
		
	});

	/*
		Menus Active 
	*/

	var pathArray = window.location.pathname.split( '/' );
	switch (pathArray[2]) {
		case 'changepass':
			$('#menu2').addClass('active');
			$('#menu1').removeClass('active');
			break;
		case 'dashboard':
			$('#menu1').addClass('active');
			$('#menu2').removeClass('active');
			break;
	}

	$('#frmSignup').submit(function(){
		$('#btnsaveuser').attr('disabled', 'disabled').val('Please wait...');
	});

	$('#frmForgotPass').on('submit', function(e){
		e.preventDefault();

		var data = $(this).serialize();
		$.ajax({
			url		:'saveforgotpass',
			type 	:'post',
			cache 	: false,
			data 	: data,
			dataType: 'json',
			beforeSend: function() {
				$('#forgotPassForm_submitemail').html('<span class="fa fa-spin fa-spinner"></span>').attr('disabled', 'disabled'); 
				$('#forgotPassForm_email').attr('disabled','disabled');
			},
			success: function(data) {
				console.log(data);
				if(data.error == 0) {
					$('div#error').addClass('alert alert-success').html('Reset password link successfully send to your email');
					$('#forgotPassForm_submitemail').html('Send me and Email').removeAttr('disabled');
					$('#forgotPassForm_email').removeAttr('disabled');
					$('#forgotPassForm_email').val('');
				} else {
					$('div#error').addClass('alert alert-success').html(data.msg);
				}
			}
		});
	})

});