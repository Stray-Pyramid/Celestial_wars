$(document).ready(function(){
	$('#login_form').removeAttr("action");
	
	var username = $('#usernameInput').val();
	var password = $('#passwordInput').val();

	$('#loginSubmit').click(function(){
		$.post( "login/loginAjax.php", { username: username, password: password })
			.done(function(data){
				alert( "Data Loaded: " + data );
			})
			.fail(function(){
				alert("Ajax request fail!");
			})
	});
});