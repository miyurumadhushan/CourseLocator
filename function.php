<?php
//function.php

function fill_course_type_list($connect)
{
	$query = "
	SELECT * FROM course_type 
	WHERE course_type_status = 'active' 
	ORDER BY course_type_name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["course_type_id"].'">'.$row["course_type_name"].'</option>';
	}
	return $output;
}



function fill_institute_list($connect)
{
	$query = "
	SELECT * FROM institute
	WHERE institute_status = 'Active' 
	ORDER BY institute_name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["institute_id"].'">'.$row["institute_name"].'</option>';
	}
	return $output;
}


function fill_domain_list($connect)
{
	$query = "
	SELECT * FROM domain
	WHERE domain_status = 'active' 
	ORDER BY domain_name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["domain_id"].'">'.$row["domain_name"].'</option>';
	}
	return $output;
}


function get_user_name($connect, $user_id)
{
	$query = "
	SELECT user_name FROM user_details WHERE user_id = '".$user_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['user_name'];
	}
}



?>