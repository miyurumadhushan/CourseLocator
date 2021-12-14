<?php

//coursetype_action.php

include('database_connection.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO course_type (course_type_name) 
		VALUES (:course_type_name)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':course_type_name'	=>	$_POST["course_type_name"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Course Type Added';
		}
	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM course_type WHERE course_type_id = :course_type_id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':course_type_id'	=>	$_POST["course_type_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['course_type_name'] = $row['course_type_name'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE course_type set course_type_name = :course_type_name  
		WHERE course_type_id = :course_type_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':course_type_name'	=>	$_POST["course_type_name"],
				':course_type_id'		=>	$_POST["course_type_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Course Type Edited';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'inactive';	
		}
		$query = "
		UPDATE course_type 
		SET course_type_status = :course_type_status 
		WHERE course_type_id = :course_type_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':course_type_status'	=>	$status,
				':course_type_id'		=>	$_POST["course_type_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Course type status change to ' . $status;
		}
	}
}

?>