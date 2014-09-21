<!DOCTYPE HTML>
<html>
	<head>
		<title>Register for Celestial Wars</title>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-16" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" href="registerStyle.css" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="js/preview_image.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/additional-methods.min.js"></script>
		<script type="text/javascript" src="js/register_validation.js"></script>	
	</head>
	<body>
		<header>
			<h1>Celestial Wars</h1>
			<img src="../images/logo.png" />
		</header>
		<section class="register_form">
		<h2>Register</h2>
			<form id="registerForm" action="" method=POST>
				<fieldset class="box-acnt_info">
					<!--Account Info-->
					<div class="box">
						<label for="username">Username:</label>
						<input type="text" id="username" name="username" maxlength="20" />
					</div>
					<div class="box">
						<label for="password">Password:</label>
						<input type="password" id="password" name="password" maxlength="20" />
					</div>
					<div class="box">
						<label for="passwordConf">Confirm Password:</label>
						<input type="password" id="passwordConf" name="passwordConf" maxlength="20" />
					</div>
					<div class="box">
						<label for="email">Email:</label>
						<input type="email" id="email" name="email" maxlength="80" />
					</div>
					<div class="box">
						<div class="box-TandC">
							<label class="TandC" for="tandcChkbox">By ticking this box, I accept the <a href="TermsAndCond">Terms and Conditions</a> required to play Celestial Wars</label>
							<input type="checkbox" id="tandcChkbox" name="tandcChkbox" value="TandC">
						</div>
					</div>
				</fieldset>
				<fieldset class="box-avatar">
					<!-- Profile Pic -->
					<div id="box-avatar-preview" class="avatar">
						<img id="avatar-preview" src="images/avatar-placeholder.png" />
					</div>
					<label for="user_pic"><b>OPTIONAL-</b>Upload an Avatar:</label>
					<input type="file" name="avatarUpload" size="30" id="avatarUpload" />
				</fieldset class="box-submit">
				<fieldset class="box-submit">
					<!--Submit and errors-->
					<input type="submit" value="Register" />
					<div id="box-error"></div>
				</fieldset>
			</form>
		</section>
	</body>
	<script type="text/javascript">
		$("#avatarUpload").change(function(){
			imgPreview(this);
		});
	</script>
</html>
