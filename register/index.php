<?php

//I'm sure object oriented code would work great in this script.

session_start();
$errors = array();

require_once '../../../../CW_Config/connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	dbConnect($con);
	
	//Request all input variables, trim and put into new variables (Except TandC)
	$username 		= trim($_POST['username']);
	$email 				= trim($_POST['email']);
	$password			= trim($_POST['password']);
	$passwordConf	= trim($_POST['passwordConf']);
	
	//Connect to database
	dbConnect($con);
	
	//Function for checking uniqueness
	function isUnique($field, $value, $con){
		$query_scaf = "SELECT %s FROM users WHERE %s LIKE '%s'";
		//For query and Escape strings
		$escField = $con->escape_string($field);
		$escValue = $con->escape_string($value);
		
		$query = sprintf($query_scaf, $escField, $escField, $escValue);
		//Query for submitted username
		$check = dbQuery($con, $query);
		
		//If username was found (0 < rows were returned), return false
		if($check->num_rows > 0){
			return false;
		} else {
		//else return true.
			return true;
		}
		$check->free_result();
	}
	
	//Function for printing errors correctly
	function printError($errors){
		echo "<div id='box-error'>";
		foreach($errors as $error){
			echo "<ul>";
			echo "<li>" . $error . "</li>";
			echo "</ul>";
		}
		echo "</div>";
	}
	
	function isBannedEmail($email, $con){
		$procedure = "Call REGEXRUN(@a, '%s');";
		$get_data 	= "SELECT @a;";
		
		$query = sprintf($procedure, $con->escape_string($email));
		//Query for email
		dbQuery($con, $query);
		$result = dbQuery($con, $get_data);
		
		$row = $result->fetch_assoc();
		if($row['@a'] == 1){
			return TRUE;
		} else{
			RETURN FALSE;
		}
	}
	
	//Validate Username
	if(empty($username)){
		array_push($errors, 'No username was submitted');
	}elseif(!isUnique('username', $username, $con)){
		array_push($errors, 'This username already exists');
	}else{
		if(strlen($username) < 4){
			array_push($errors, 'The username you submitted was too short');
		} elseif(strlen($username) > 20){
			array_push($errors, 'The username you submitted was too long');
		}
		if(!preg_match("/^[a-z0-9\-]+$/i",$username)){
			array_push($errors, 'Username must only contain alphanumeric characters and dashes');
			
		}
	}
		
	//Validate Email	
	if(empty($email)){
			array_push($errors, 'No email was submitted');
	} elseif(!isUnique('email', $email, $con)){
		array_push($errors, 'This email is registered to another user.');
	} elseif(isBannedEmail($email, $con)){
	 array_push($errors, 'The email you have entered has been banned or disallowed');
	} else{
		if(strlen($email) > 254){
			array_push($errors, 'This email is too long!');
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			array_push($errors, 'The email you have entered is not valid');
		}	
	}

	//Validate Password
	if(empty($password)){
		array_push($errors, 'A password is required');
	} else{
		if(strlen($password) < 8){
			array_push($errors, 'Your password is too short');
		} elseif(strlen($password) > 20){ //Considering increasing this to 40+ for unique users
			array_push($errors, 'Your password was too long'); 
		} 
		if($password == $username){
			array_push($errors, 'Your password must not be the same as your username'); 
		} 
		if(!preg_match("/^[\S]+$/i", $password)){
			array_push($errors, 'Your password must not contain spaces');
		}
		if($password != $passwordConf){
			array_push($errors, 'Your password and password confirmation are not the same');
		}
	}
	
	//Validate Password Confirmation
	if(empty($passwordConf)){
		array_push($errors, 'You must confirm your password');
	}
	
	//Check if Terms and Conditions was accepted
	if(empty($_POST['TandC']) || $_POST['TandC'] != "Yes"){
		array_push($errors, 'You must accept the terms and conditions to play');
	}
	
	//If $errors array has no errors, all values are considered valid and sent to the DB.
	if(empty($errors)){
			
		//Get date FORMAT (YYYY-MM-DD HH:MM:SS)
		$regdate = date('Y-m-d H:I:s');
		
		//hash password
		$options = array('cost' => 11);
		$passhash = password_hash($password, PASSWORD_BCRYPT, $options);
		//If passhash is shorter than 13 characters, rehash
		
		
		//Convert IP address into integer 
		$ip = ip2long($_SERVER['REMOTE_ADDR']);
		
		//Put into database and confirm
		$sql = sprintf("INSERT INTO users ".
								"(username, email, passhash, reg_date, reg_ip) ".
								"VALUES ('%s', '%s', '%s', '%s', '%s');",
								$con->escape_string($username),
								$con->escape_string($email),
								$con->escape_string($passhash),
								$con->escape_string($regdate),
								$con->escape_string($ip));
		
		dbQuery($con, $sql);
		
		//Send validation email (TODO)
		//Concatenate email and password together, bcrypt, set to email.
		
		//Redirect to "Registration complete, email sent" page
		dbClose($con);
		header("Location: verification");
		echo "Done";
		die();
	}
	
	dbClose($con);
}


//Echo values except password into inputs
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Register for Celestial Wars</title>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" href="registerStyle.css" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/register_validation.js"></script>
	</head>
	<body>
		<header>
			<h1>Celestial Wars</h1>
			<img src="../images/logo.png" />
		</header>
		<section class="register_form">
			<h2>Register</h2>
			<?php if(!empty($errors)) printError($errors); ?>
			<form id="registerForm" action="" method=POST>
				<fieldset class="box-acnt_info">
					<!--Account Info-->
					<div class="box">
						<label for="username">Username:</label>
						<input type="text" id="username" name="username" maxlength="20" value="<?php if (isset($username)) echo $username; ?>"/>
					</div>
					<div class="box">
						<label for="password">Password:</label>
						<input type="password" id="password" name="password" maxlength="20"/>
					</div>
					<div class="box">
						<label for="passwordConf">Confirm Password:</label>
						<input type="password" id="passwordConf" name="passwordConf" maxlength="20"/>
					</div>
					<div class="box">
						<label for="email">Email:</label>
						<input type="email" id="email" name="email" maxlength="254" value="<?php if (isset($email)) echo $email; ?>"/>
					</div>
					<div class="box">
						<div class="box-TandC">
							<label class="TandC" for="TandC">By ticking this box, I accept the <a href="TermsAndCond">Terms and Conditions</a> required to play Celestial Wars</label>
							<input type="checkbox" id="tandcChkbox" name="TandC" value="Yes"<?php if (isset($_POST['TandC'])) echo 'checked';?>>
						</div>
					</div>
				</fieldset>
				<fieldset class="box-submit">
					<!--Submit and errors-->
					<input type="submit" value="Register" />
					<div id="box-error"></div>
				</fieldset>
			</form>
		</section>
	</body>
</html>
<?php
die();
?>
