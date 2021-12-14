<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Student Registration</title>
	<link href="css/styles.css" rel="stylesheet" />

   
    <link rel="icon" type="image/x-icon" href="assets/logo.png" />
	
</head>
<body>

<div>
	<?php
	
	?>	
</div>

<div>
	<form action="student_registration.php" method="post">
		<div class="container">

			<div class="account-form-inner">
				<div class="account-container">

					<div class="heading-bx left">
						<p class="title-head"><b>Register as a </b> <span>Student</span></p>
					
					</div>
			
				</div>
			</div>




			
			<div class="row justify-content-md-center">
				<div class="col-sm-4">
					<!-- <h2>Student Registration</h2> -->
					
					<hr class="mb-3">
					<label for="firstname"><b>Email</b></label>
					<input class="form-control" id="user_email" type="email" name="user_email" required>

					<label for="lastname"><b>Password</b></label>
					<input class="form-control" id="user_password"  type="password" name="user_password" required>

					<label for="email"><b>User Name</b></label>
					<input class="form-control" id="user_name"  type="text" name="user_name" required>

					<input class="form-control" id="user_type"  type="hidden" name="user_type" required>

					<input class="form-control" id="user_status"  type="hidden" name="user_status" required>


					<hr class="mb-3">
					<center><input class="btn btn-primary" type="submit" id="register" name="create" value="Sign Up">   <input class="btn btn-primary" type="button" id="login" onclick="window.location.href='/CourseLocator/login.php';" value="Login">   <input type="button" name="home" value="Home Page" class="btn btn-primary" onclick="window.location.href='/CourseLocator/index.php';"/> </center>
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
			var user_type 		= 'Student';
			var user_status 		= 'Active';
			
			

				e.preventDefault();	

				$.ajax({
					type: 'POST',
					url: 'student_registration_fetch.php',
					data: {user_email: user_email,user_password: user_password,user_name: user_name,user_type: user_type,user_status: user_status},
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