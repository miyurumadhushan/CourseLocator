<?php

//course_action.php

include('database_connection.php');

include('function.php');


if(isset($_POST['btn_action']))
{

	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO course (course_type_id, domain_id, course_name, institute_id, course_description, course_duration, duration_type, course_fee, semester_fee, course_enter_by, course_status, course_date) 
		VALUES (:course_type_id, :domain_id, :course_name, :institute_id, :course_description, :course_duration, :duration_type, :course_fee, :semester_fee, :course_enter_by, :course_status, :course_date)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':course_type_id'		=>	$_POST['course_type_id'],
				':domain_id'			=>	$_POST['domain_id'],
				':course_name'			=>	$_POST['course_name'],
				':institute_id'			=>	$_POST['institute_id'],
				':course_description'	=>	$_POST['course_description'],
				':course_duration'		=>	$_POST['course_duration'],
				':duration_type'		=>	$_POST['duration_type'],
				':course_fee'	        =>	$_POST['course_fee'],
				':semester_fee'			=>	$_POST['semester_fee'],
				':course_enter_by'		=>	$_SESSION["user_id"],
				':course_status'		=>	'active',
				':course_date'			=>	date("Y-m-d")
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Course Added';
		}
	}
	if($_POST['btn_action'] == 'course_details')
	{
		$query = "
		SELECT * FROM course 
		INNER JOIN course_type ON course_type.course_type_id = course.course_type_id 
		INNER JOIN domain ON domain.domain_id = course.domain_id 
		INNER JOIN institute ON institute.institute_id = course.institute_id
		INNER JOIN user_details ON user_details.user_id = course.course_enter_by 
		WHERE course.course_id = '".$_POST["course_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$output = '
		<div class="table-responsive">
			<table class="table table-boredered">
		';
		foreach($result as $row)
		{
			$status = '';
			if($row['course_status'] == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}
			else
			{
				$status = '<span class="label label-danger">Inactive</span>';
			}
			$output .= '
			<tr>
				<td>Course Name</td>
				<td>'.$row["course_name"].'</td>
			</tr>
			<tr>
				<td>Course Description</td>
				<td>'.$row["course_description"].'</td>
			</tr>
			<tr>
				<td>Course Type Name</td>
				<td>'.$row["course_type_name"].'</td>
			</tr>
			<tr>
				<td>Domain Name</td>
				<td>'.$row["domain_name"].'</td>
			</tr>
			<tr>
				<td>Institute Name</td>
				<td>'.$row["institute_name"].'</td>
			</tr>
			<tr>
				<td>Course Duration</td>
				<td>'.$row["course_duration"].' '.$row["duration_type"].'</td>
			</tr>
			<tr>
				<td>Course Fee</td>
				<td>'.$row["course_fee"].'</td>
			</tr>
			<tr>
				<td>Semester Fee</td>
				<td>'.$row["semester_fee"].'</td>
			</tr>
			<tr>
				<td>Enter By</td>
				<td>'.$row["user_name"].'</td>
			</tr>
			<tr>
				<td>Status</td>
				<td>'.$status.'</td>
			</tr>
			';
		}
		$output .= '
			</table>
		</div>
		';
		echo $output;
	}
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM course WHERE course_id = :course_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':course_id'	=>	$_POST["course_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['course_type_id'] = $row['course_type_id'];
			$output['domain_id'] = $row['domain_id'];
			$output['course_name'] = $row['course_name'];
			$output['institute_id'] = $row['institute_id'];
			$output['course_description'] = $row['course_description'];
			$output['course_duration'] = $row['course_duration'];
			$output['duration_type'] = $row['duration_type'];

			$output['course_fee'] = $row['course_fee'];
			$output['semester_fee'] = $row['semester_fee'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE course 
		set course_type_id = :course_type_id, 
		domain_id = :domain_id,
		course_name = :course_name,
		institute_id= :institute_id,
		course_description = :course_description, 
		course_duration = :course_duration, 
		duration_type = :duration_type, 
		course_fee = :course_fee, 
		semester_fee = :semester_fee 
		WHERE course_id = :course_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':course_type_id'		=>	$_POST['course_type_id'],
				':domain_id'			=>	$_POST['domain_id'],
				':course_name'			=>	$_POST['course_name'],
				':institute_id'			=>	$_POST['institute_id'],
				':course_description'	=>	$_POST['course_description'],
				':course_duration'		=>	$_POST['course_duration'],
				':duration_type'		=>	$_POST['duration_type'],
				':course_fee'	        =>	$_POST['course_fee'],
				':semester_fee'			=>	$_POST['semester_fee'],
				':course_id'			=>	$_POST['course_id']
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Course Details Edited';
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
		UPDATE course 
		SET course_status = :course_status 
		WHERE course_id = :course_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':course_status'	=>	$status,
				':course_id'		=>	$_POST["course_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Course status change to ' . $status;
		}
	}
}


?>