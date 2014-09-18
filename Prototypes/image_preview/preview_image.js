function readURL(input) {
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]){
		if(ext == "png" || ext == "jpeg" || ext == "jpg"){
		    
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#imagepreview').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		} else {
			$('#imagepreview').attr('src', 'avatar-invalid.png');
		}

    }else{
         $('#imagepreview').attr('src', 'avatar-placeholder.png');
    }
}