/*
#username
	-must not already exist in the database

#email
	-must not already exist in the database
		-Show account recovery if it does exist

Align error messages for TandC and Avatar Picture

valid and invalid png must be outside of the input (beside)

Function to handle error messages received from the php script
*/

$.validator.addMethod("usernameRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
}, "Username must contain only letters, numbers, or dashes.");

$.validator.addMethod("passwordRegex", function(value, element) {
        return this.optional(element) || /^[\S]+$/i.test(value);
}, "Password must not contain any spaces");

$.validator.addMethod("notEqual", function(value, element, param) {
 return this.optional(element) || value != $(param).val();
}, "This has to be different...");

$(document).ready(function(){
	$("#registerForm").validate({
		debug: false,
		rules: {
			username: {
				required: true,
				minlength : 4,
				maxlength: 20,
				usernameRegex: true
			},
			
			password: {
				required: true,
				minlength: 7,
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
					maxlength: 80
			},
			
			tandcChkbox: "required",
			
			avatarUpload: {
				required: false,
				extension: "jpg|jpeg|png"
			}
				
		},
		messages: {
			username: {
				required: "Please enter a username",
				minlength: jQuery.validator.format("Your username must be atleast {0} characters long"),
				usernameRegex: "Username must contain only letters, numbers, or dashes."
			
			},
			
			password: {
				required: "Please enter a password",
				minlength: jQuery.validator.format("Your password must be alteast {0} characters long"),
				maxlength: "Your password is too long!",
				notEqual: "Your password must not be the same as your username"
			},
			
			passwordConf: {
				required: "Please enter the same password as above",
				equalTo: "Passwords do not match!"
			},
			
			email: {
				required: "Please enter an email address",
				email: "Please enter a valid email address",
				maxlength: "Please choose a shorter email address"
			},
			
			tandcChkbox: {
				required:"You must accept the Terms and Conditions to play Celestial Wars"
			},
			
			avatarUpload: {
				extension: "The file you have chosen is not valid!"
			}
		}
	});
});