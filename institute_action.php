<?php

//institute_action.php

include('database_connection.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO institute (institute_name, institute_address, institute_description,institute_status) 
		VALUES (:institute_name, :institute_address,:institute_description,:institute_status)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':institute_name'			=>	$_POST["institute_name"],
				':institute_address'		=>	$_POST["institute_address"],
				':institute_description'	=>	$_POST["institute_description"],	
				':institute_status'			=>	'Active'					 
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Institute Added';
		}
	}

	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM institute WHERE institute_id = :institute_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':institute_id'	=>	$_POST["institute_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['institute_name'] = $row['institute_name'];
			$output['institute_address'] = $row['institute_address'];
			$output['institute_description'] = $row['institute_description'];
			
		}
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE institute set 
		institute_name = :institute_name, 
		institute_address = :institute_address, 
		institute_description = :institute_description
		WHERE institute_id = :institute_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':institute_name'	=>	$_POST["institute_name"],
				':institute_address'	=>	$_POST["institute_address"],
				':institute_description'	=>	$_POST["institute_description"],
				':institute_id'		=>	$_POST["institute_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Institute Details Edited';
		}
	}

	if($_POST['btn_action'] == 'delete')
	{
		$status = 'Active';
		if($_POST['status'] == 'Active')
		{
			$status = 'Inactive';
		}
		$query = "
		UPDATE institute 
		SET institute_status = :institute_status
		WHERE institute_id = :institute_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':institute_status'	=>	$status,
				':institute_id'		=>	$_POST["institute_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Institute status change to ' . $status;
		}
	}
}

?>