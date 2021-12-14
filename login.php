<?php
//login.php

include('database_connection.php');

if(isset($_SESSION['type']))
{
	header("location:user.php");
}

$message = '';

if(isset($_POST["login"]))
{
	$query = "
	SELECT * FROM user_details 
		WHERE user_email = :user_email
	";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
				'user_email'	=>	$_POST["user_email"]
			)
	);
	$count = $statement->rowCount();
	if($count > 0)
	{
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			if($row['user_status'] == 'Active')
			{
				if(password_verify($_POST["user_password"], $row["user_password"]))
				{
				
					$_SESSION['type'] = $row['user_type'];
					$_SESSION['user_id'] = $row['user_id'];
					$_SESSION['user_name'] = $row['user_name'];
					header("location:user.php");
				}
				else
				{
					$message = "<label>Wrong Password</label>";
				}
			}
			else
			{
				$message = "<label>Your account is disabled, Contact Master</label>";
			}
		}
	}
	else
	{
		$message = "<label>Wrong Email Address</labe>";
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Course Locator</title>		
		<script src="js/jquery-1.10.2.min.js"></script>
		<link href="css/styles.css" rel="stylesheet" />
		<script src="js/bootstrap.min.js"></script>
		<link rel="icon" type="image/x-icon" href="assets/logo.png" />
	</head>
	<body>
	</br>

		<div class="container">

		

			<div class="account-form-inner">
				<div class="account-container">

					<div class="heading-bx left">
						<p class="title-head"><b>Login to your</b> <span>Account</span></p>
					
					</div>
			
				</div>
			</div>

		
			

			
			<center>
	

			<div class="row justify-content-md-center">
				<div class="col-sm-4">

					<div class="panel panel-default">
						<div class="panel-body">
                			<p>	<img src="assets/images/user.png" alt="" width="150" height="150" class="userimage"></p>
            	

							<form method="post">
							<?php echo $message; ?>

							<div class="form-group">
								<p> <input type="text" name="user_email" class="form-control" placeholder="Email address" autofocus size="40" required /> </p>
							</div>

							<div class="form-group">
								<p> <input type="password" name="user_password" class="form-control" placeholder="Password" size="35" required /> </p>
							</div>

							<p>
								<div class="form-group">
									<input type="submit" name="login" value="Login" class="btn btn-primary" />
									<input type="button" name="home" value="Home Page" class="btn btn-primary" onclick="window.location.href='/CourseLocator/index.php';"/>
								</div>
							</p>
							</form>
						</div>
				
					</div>
				</div>
			</div>

			</center>
			</div>



			
		
		



	</body>
</html>