<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Institute Registration</title>
	<link href="css/styles.css" rel="stylesheet" />
	<link rel="icon" type="image/x-icon" href="assets/logo.png" />
</head>
<body>

<div>
	<?php
	
	?>	
</div>

<div>
	<form action="institute_registration.php" method="post">
		<div class="container">
			

			<div class="account-form-inner">
				<div class="account-container">

					<div class="heading-bx left">
						<p class="title-head"><b>Register as an </b> <span>Instructor</span></p>
					
					</div>
			
				</div>
			</div>

			<div class="row justify-content-md-center" >
				<div class="col-sm-4">
					<!-- <h1>Institute Registration</h1> -->
					
					<p>
					<label for="firstname"><b>Email</b></label>
					<input class="form-control" id="user_email" type="email" name="user_email" required>

					<label for="lastname"><b>Password</b></label>
					<input class="form-control" id="user_password"  type="password" name="user_password" required>

					<label for="email"><b>User Name</b></label>
					<input class="form-control" id="user_name"  type="text" name="user_name" required>
					</p>

					<p><p><p>
					<label for="email"><b>Institute Name</b></label>
					<input class="form-control" id="institute_name"  type="text" name="institute_name" required>

					<label for="email"><b>Institute Address</b></label>
					<input class="form-control" id="institute_address"  type="text" name="institute_address" required>

					<label for="email"><b>Institute Description</b></label>
					<input class="form-control" id="institute_description"  type="text" name="institute_description" required>

					</p></p></p>



					<input class="form-control" id="user_type"  type="hidden" name="user_type" required>

					<input class="form-control" id="user_status"  type="hidden" name="user_status" required>
					<input class="form-control" id="institute_status"  type="hidden" name="institute_status" required>



					<p>

					<center>
					<input class="btn btn-primary" type="submit" id="register" name="create" value="Sign Up">
					<input class="btn btn-primary" type="button" id="login" onclick="window.location.href='/CourseLocator/login.php';" value="Login">
					<input type="button" name="home" value="Home Page" class="btn btn-primary" onclick="window.location.href='/CourseLocator/index.php';"/>

					</center>

				</p>
				</div>
			</div>
		</div>
	</form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
	$(function(){
		$('#register').click(function(e){

			var valid = this.form.checkValidity();

			if(valid){


			var user_email 	= $('#user_email').val();
			var user_password 	= $('#user_password').val();
			var user_name	= $('#user_name').val();
			var user_type 		= 'Institute';
			var user_status 		= 'Active';


			var institute_name = $('#institute_name').val();
			var institute_address	= $('#institute_address').val();
			var institute_description	= $('#institute_description').val();
			var institute_status 		= 'Active';

			
			

				e.preventDefault();	

				$.ajax({
					type: 'POST',
					url: 'institute_registration_fetch.php',
					data: {user_email: user_email,user_password: user_password,user_name: user_name,user_type: user_type,user_status: user_status,institute_name:institute_name,institute_address: institute_address,institute_description:institute_description,institute_status: institute_status},
					success: function(data){
					Swal.fire({
								'title': 'Successful',
								'text': data,
								'type': 'success'
								})
							
					},
					error: function(data){
						Swal.fire({
								'title': 'Errors',
								'text': 'There were errors while saving the data.',
								'type': 'error'
								})
					}
				});

				
			}else{
				
			}

			



		});		

		
	});
	
</script>
</body>
</html>