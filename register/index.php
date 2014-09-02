<!DOCTYPE HTML>
<html>
	<head>
		<title>Register for Celestial Wars</title>
		<link href="//222.154.12.144/celestial_wars/css/main_style.css" rel="stylesheet" type="text/stylesheet" />
		<link href="css/jquery.validate.password.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
		<script type="text/javascript">	
			jQuery.validator.setDefaults({
			  debug: true,
			  success: "valid"
			});		
			
			$(document).ready(function() {
				$("#form").validate({
					rules: {
						username: {
							required: true,
							minlength: 8
						},
						password: {
							required: true,
							minlength: 7
						},
						password_conf: {
							required: true,
							minlength: 7,
							equalTo: "#password"
						},
						email: {
							required: true,
							email: true
						},
						TandC:{
							required: true
						}
					},
					messages: {
						username: {
							minlength: "Your username is too short"
						},
						password: {
							minlength: "Passwords must be at least 7 characters"
						},
						password_conf: {
							equalTo: "Your passwords do not match"
						},
						email: {
							required: "Please enter a valid email address",
							email: "Please enter a valid email address"
						},
						TandC: {
							required: "You need to accept the terms and conditions"
						}
					}
				});
			});
		</script>
	</head>
	<body>
		<h1>Celestial Wars</h1>
		<h2>Register</h2>
		<form id="form" action="" method=POST>
			<label for="username">Username:</label>
			<input type="text" name="username" maxlength="32" /><br/>
			<label for="password">Passowrd:</label>
			<input type="password" id="password" name="password" maxlength="20" /><br/>
			<div class="password-meter">
				<div class="password-meter-message"></div>
				<div class="password-meter-bg">
					<div class="password-meter-bar"></div>
				</div>
			</div>
			<label for="password_conf">Confirm Password:</label>
			<input type="password" name="password_conf" maxlength="20" /><br/>
			<label for="email">Email:</label>
			<input type="email" name="email" maxlength="80" /><br/>
			<input type="checkbox" name="TandC" value="tandc">
			<label class="TandC" for="TandC">By registering for Celestial Wars I accept the <a href="TermsAndCond">Terms and Conditions</a></label><br/>
			<label id="TandC-error" class="error" for="TandC"></label><br/>
			<input type="submit" value="Register" />
		</form>
	</body>
</html>
