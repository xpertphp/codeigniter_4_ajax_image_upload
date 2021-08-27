<!DOCTYPE html>
<html>
<head>
  <title>Codeigniter 4 Ajax Image Upload with Preview Example - XpertPhp</title>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<style>
.hideImage{
	display:none;
}
#preview-image{
	margin-top:10px;
	width:200px;
	height:200px;
}
</style>
</head>
<body>
 <div class="container">
	<div class="row">
		<div class="col-md-9">
			<h2>Add Student</h2>
		</div>
	</div>
    <div class="row">
      <div class="col-md-9">
        <form method="post" name="frmAddStudent" id="frmAddStudent"  enctype="multipart/form-data">
          <div class="form-group">
            <label for="txtFname">First Name</label>
			<input type="text" name="txtFname" class="form-control" id="txtFname" placeholder="Please enter first name" />
          </div> 
		   <div class="form-group">
            <label for="txtLname">Last Name</label>
			<input type="text" name="txtLname" class="form-control" id="txtLname" placeholder="Please enter last name" />
          </div> 
          <div class="form-group">
            <label for="txtEmail">Email</label>
			<input type="text" name="txtEmail" class="form-control" id="txtEmail" placeholder="Please enter email" />
          </div>
		<div class="form-group">
            <label for="txtMobile">Mobile</label>
			<input type="text" name="txtMobile" class="form-control" id="txtMobile" placeholder="Please enter mobile number." />
          </div>		  
          <div class="form-group">
            <label for="txtAddress">Address</label>
			<textarea name="txtAddress" class="form-control"></textarea>
          </div>
		  <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control" id="image" onchange="previewImageFile(this);" accept="image/*" />
			<img src="" alt="Image preview" id="preview-image" class="hideImage">
          </div>
          <div class="form-group">
		   <input type="submit" value="Add" name="btnadd" id="btnadd" class="btn btn-success" />
          </div>
        </form>
      </div>
    </div>
	<span class="d-none alert alert-success mb-3" id="res_message"></span>
</div>
<script>
   if ($("#frmAddStudent").length > 0) {
      $("#frmAddStudent").validate({
    rules: {
      txtFname: {
        required: true,
      },
	  txtLname: {
        required: true,
      },
      txtEmail: {
        required: true,
        maxlength: 50,
        email: true,
      }, 
	  txtMobile: {
        required: true,
		number: true,
        maxlength: 12,
        minlength: 10,
      }, 
      txtAddress: {
        required: true,
      },
	   image: {
        required: true,
		extension: "png|jpeg|jpg|gif",
      },	
    },
    messages: {
      txtFname: {
        required: "Please enter first name",
      },
	   txtLname: {
        required: "Please enter last name",
      },
      txtEmail: {
        required: "Please enter valid email",
        email: "Please enter valid email",
        maxlength: "The email name should less than or equal to 50 characters",
     },      
	 txtMobile: {
        required: "Please enter mobile number",
		number:"Please enter numbers Only",
		maxlength: "The mobile number should less than or equal to 12 characters",
		minlength: "The mobile number should be 10 characters",
     },	
     txtAddress: {
        required: "Please enter address",
     },
	 image: {
        required: "Please choose image",
		extension: "Only PNG , JPEG , JPG, GIF File Allowed",
     },
    },
	submitHandler: function(form) {
		$('#btnadd').val('Sending..');
		$.ajax({
			url: "<?php echo site_url('student/store') ?>",
			type: "POST",
			data: new FormData(form),
			contentType: false,  
            cache: false,  
            processData:false,  
            dataType: "json",
			success: function(response) {
				console.log(response);
				if(response.success){
					$('#btnadd').val('Add');
					$('#res_message').html(response.msg);
					$('#res_message').show();
					$('#res_message').removeClass('d-none');
					$('#frmAddStudent')[0].reset();
					setTimeout(function() {
						$('#res_message').hide();
						$('#res_message').html('');
					}, 3000);
				}else{
					$('#res_message').html(response.msg);
					$('#res_message').show();
				}
				
			}
		});
	}
    })
}
</script>
<script>
  function previewImageFile(input, id) {
    var output = document.getElementById('preview-image');
        output.removeAttribute("class");
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src)
        }
 }
</script>
</body>
</html>