<?php
require_once('config.php');
?>
<?php

if(isset($_POST)){

	$user_email 		= $_POST['user_email'];
	// $user_password 		= sha1($_POST['user_password']);
	$user_password 		= password_hash($_POST['user_password'], PASSWORD_DEFAULT);
	// $password = password_hash($password, PASSWORD_DEFAULT);  
	$user_name 		= $_POST['user_name'];
	$user_type 			= $_POST['user_type'];
	$user_status 			= $_POST['user_status'];
	

		$sql = "INSERT INTO user_details (user_email, user_password, user_name, user_type, user_status) VALUES(?,?,?,?,?)";
		$stmtinsert = $db->prepare($sql);
		$result = $stmtinsert->execute([$user_email, $user_password, $user_name, $user_type, $user_status]);
		if($result){
			echo 'Successfully saved.';
		}else{
			echo 'There were erros while saving the data.';
		}
}else{
	echo 'No data';
}