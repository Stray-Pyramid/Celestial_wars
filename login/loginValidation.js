$(document).ready(function(){

	$('#loginSubmit').click(function(e) { 
		//Disable submit button and show loading.gif
		
		
		var errorBox = $('#error');
		
		function displayError(msg, location){
			location.empty().append(msg);
			$('#loginSubmit').removeAttr('disabled');
			$('#loadingGif').hide();
		}
	
		 // this code prevents form from actually being submitted
		e.preventDefault();
		e.returnValue = false;
		
		//Get values from inputs
		var $username = $('#usernameInput').val();
		var $password = $('#passwordInput').val();
		 // some validation code here: if invalid, displayError message
		 
		$(this).attr('disabled', 'disabled');
		$('#loadingGif').show();
		
		
		if ($username.length <= 0 && $password.length <= 0) { 
			displayError("No username or password detected", errorBox);
		} else if($username.length <= 0) {
			displayError("No username detected", errorBox);
		} else if($password.length <= 0) {
			displayError("No password detected", errorBox);
		} else {
			var $form = $(this);

			// this is the important part. you want to submit
			// the form but only after the ajax call has returned true.
			 $.ajax({ 
				 url: 'login/loginAjax.php', 
				 type: 'POST',
				 datatype: 'html',
				 context: $form, // context will be "this" in your handlers
				 data: { username: $username, password: $password }
			})
				 .done(function(msg) { // your success handler
					// make sure that you are no longer handling the submit event; clear handler
					if(msg == "TRUE"){
						$('form#login_form').submit();
					} else {
						displayError(msg, errorBox);
					}
					// actually submit the form

				 })
				 .fail(function(msg) { // your error handler
					alert("Error submitting Ajax request: " + msg );
				 });

		};
	});
});