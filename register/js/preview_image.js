function imgPreview(input) {
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]){
		if(ext == "png" || ext == "jpeg" || ext == "jpg"){
		    
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#avatar-preview').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		} else {
			$('#avatar-preview').attr('src', 'images/avatar-invalid.png');
		}

    }else{
         $('#avatar-preview').attr('src', 'images/avatar-placeholder.png');
    }
}