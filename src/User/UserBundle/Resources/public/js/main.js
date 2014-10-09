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

});