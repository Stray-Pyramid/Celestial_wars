/*
	Settings for the jquery validation plugin
	
	In the future:
	Reduce the number of times AJAX calls are made
	At the moment, they are called every time a user types a letter, which creates a major congestion problem for the server.
	
	Instead, I would like to have a custom method where if another
	character is type, the previous Ajax request is cancelled (on delay of 500ms or so)
	and a new one is queued.
*/

//Valid image
var imgValid = "<img src='images/valid.png'>";

//Regex for username (Only Alphanumerical, and dashes)
$.validator.addMethod("usernameRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-]+$/i.test(value);
}, "Username must contain only letters, numbers, or dashes.");

//Regex for password (no sapces)
$.validator.addMethod("passwordRegex", function(value, element) {
        return this.optional(element) || /^[\S]+$/i.test(value);
}, "Password must not contain any spaces");

//notEqual method, opposite of equalTo
$.validator.addMethod("notEqual", function(value, element, param) {
 return this.optional(element) || value != $(param).val();
}, "This has to be different...");


$(document).ready(function(){
	$("#registerForm").validate({
		debug: false,
		onkeyup: false,
		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// Exclude valid image for tandcCheckbox
				// set &nbsp; as text for IE
				label.html("&nbsp;").addClass("checked").append(imgValid);
		},
		rules: {
			username: {
				required: true,
				minlength : 4,
				maxlength: 20,
				usernameRegex: true,
				remote: {
					url: "duplicate_check.php",
					type: "post"
				}
			},
			
			password: {
				required: true,
				minlength: 8,
				maxlength: 20,
				notEqual: "#username",
				passwordRegex: true
			},
			
			passwordConf: {
				required: true,
				equalTo: "#password"
			},
			
			email: {
					required: true,
					email: true,
					maxlength: 254,
					remote: {
						url: "duplicate_check.php",
						type: "post"
					}
			},
			
			tandcChkbox: "required"
				
		},
		messages: {
			username: {
				required: "<img src='images/invalid.png'><p>Please enter a username</p>",
				minlength: "<img src='images/invalid.png'><p>Your username must be atleast 8 characters long</p>",
				usernameRegex: "<img src='images/invalid.png'><p>Username must contain only letters, numbers, or dashes</p>",
				remote: "<img src='images/invalid.png'><p>This username is taken. Please choose another</p>"
			
			},
			
			password: {
				required: "<img src='images/invalid.png'><p>Please enter a password</p>",
				minlength: jQuery.validator.format("<img src='images/invalid.png'><p>Your password must be alteast {0} characters long</p>"),
				maxlength: "<img src='images/invalid.png'><p>Your password is too long</p>",
				notEqual: "<img src='images/invalid.png'><p>Your password must not be the same as your username</p>"
			},
			
			passwordConf: {
				required: "<img src='images/invalid.png'><p>Please enter the same password as above</p>",
				equalTo: "<img src='images/invalid.png'><p>Passwords do not match!</p>"
			},
			
			email: {
				required: "<img src='images/invalid.png'><p>Please enter an email address</p>",
				email: "<img src='images/invalid.png'><p>Please enter a valid email address</p>",
				maxlength: "<img src='images/invalid.png'><p>Please choose a shorter email address</p>",
				remote: "<img src='images/invalid.png'><p>This email is already registered. Did you forget your <a href='recovery'>password?</a></p>"
			},
			
			tandcChkbox: {
				required:"You must accept the Terms and Conditions to play Celestial Wars"
			}
		}
	});
});