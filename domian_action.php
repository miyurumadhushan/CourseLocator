<?php

//domian_action.php

include('database_connection.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "

		INSERT INTO domain (domain_name) 
		VALUES (:domain_name)

		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				
				':domain_name'	=>	$_POST["domain_name"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Domian Name Added';
		}
	}

	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM domain WHERE domain_id = :domain_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':domain_id'	=>	$_POST["domain_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
		
			$output['domain_name'] = $row['domain_name'];
		}
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE domain set 
		domain_name = :domain_name 
		WHERE domain_id = :domain_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':domain_name'	=>	$_POST["domain_name"],
				':domain_id'		=>	$_POST["domain_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Domain Name Edited';
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
		UPDATE domain 
		SET domain_status = :domain_status 
		WHERE domain_id = :domain_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':domain_status'	=>	$status,
				':domain_id'		=>	$_POST["domain_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Domain status change to ' . $status;
		}
	}
}

?>