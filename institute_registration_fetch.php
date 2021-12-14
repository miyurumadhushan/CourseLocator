<?php
require_once('config.php');
?>
<?php

if(isset($_POST)){

	$user_email 		= $_POST['user_email'];
	// $user_password 	= sha1($_POST['user_password']);
	$user_password 		= password_hash($_POST['user_password'], PASSWORD_DEFAULT);
	// $password        = password_hash($password, PASSWORD_DEFAULT);  
	$user_name 		    = $_POST['user_name'];
	$user_type 			= $_POST['user_type'];
	$user_status 	    = $_POST['user_status'];



	$institute_name 		= $_POST['institute_name'];
	$institute_address 		= $_POST['institute_address'];
	$institute_description 	= $_POST['institute_description'];
	$institute_status 		= $_POST['institute_status'];



	

		$sql = "INSERT INTO user_details (user_email, user_password, user_name, user_type, user_status) VALUES(?,?,?,?,?)";
		$sql1 = "INSERT INTO institute (institute_name, institute_address, institute_description, institute_status) VALUES(?,?,?,?)";
		$stmtinsert = $db->prepare($sql);
		$stmtinsert1 = $db->prepare($sql1);
		$result = $stmtinsert->execute([$user_email, $user_password, $user_name, $user_type, $user_status]);
		$result1 = $stmtinsert1->execute([$institute_name, $institute_address, $institute_description, $institute_status]);
		if($result && $result1){
			echo 'Successfully saved.';
		}else{
			echo 'There were erros while saving the data.';
		}
}else{
	echo 'No data';
}