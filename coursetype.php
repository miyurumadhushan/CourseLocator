<?php
//coursetype.php

include('database_connection.php');

if(!isset($_SESSION['type']))
{
	header('location:login.php');
}

if($_SESSION['type'] != 'Admin')
{
	header("location:user.php");
}

include('header.php');

?>

<div class="container px-5 my-5 py-5">
	<span id="alert_action"></span>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <div class="row">
                            <h3 class="panel-title">Course Type List</h3>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row" align="right">
                             <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#coursetypeModal" class="btn btn-success btn-xs">Add</button>   		
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                    	<div class="col-sm-12 table-responsive">
                    		<table id="coursetype_data" class="table table-bordered table-striped">
                    			<thead><tr>
									<th>ID</th>
									<th>Course Type Name</th>
									<th>Status</th>
									<th>Edit</th>
									<th>Delete</th>
								</tr></thead>
                    		</table>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="coursetypeModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="coursetype_form">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Course Type</h4>
    				</div>
    				<div class="modal-body">
    					<label>Enter Course Type Name</label>
						<input type="text" name="course_type_name" id="course_type_name" class="form-control" required />
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="course_type_id" id="course_type_id"/>
    					<input type="hidden" name="btn_action" id="btn_action"/>
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
</div>    
<script>
$(document).ready(function(){

	$('#add_button').click(function(){
		$('#coursetype_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Course Type");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});

	$(document).on('submit','#coursetype_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"coursetype_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#coursetype_form')[0].reset();
				$('#coursetypeModal').modal('hide');
				$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
				$('#action').attr('disabled', false);
				coursetypedataTable.ajax.reload();
			}
		})
	});

// Update Button Features	

	$(document).on('click', '.update', function(){
		var course_type_id = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:"coursetype_action.php",
			method:"POST",
			data:{course_type_id:course_type_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#coursetypeModal').modal('show');
				$('#course_type_name').val(data.course_type_name);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Course Type");
				$('#course_type_id').val(course_type_id);
				$('#action').val('Edit');
				$('#btn_action').val("Edit");
			}
		})
	});

	var coursetypedataTable = $('#coursetype_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"coursetype_fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[3, 4],
				"orderable":false,
			},
		],
		"pageLength": 25
	});

// Delete Button Features
	$(document).on('click', '.delete', function(){
		var course_type_id = $(this).attr('id');
		var status = $(this).data("status");
		var btn_action = 'delete';
		if(confirm("Are you sure you want to change status?"))
		{
			$.ajax({
				url:"coursetype_action.php",
				method:"POST",
				data:{course_type_id:course_type_id, status:status, btn_action:btn_action},
				success:function(data)
				{
					$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
					coursetypedataTable.ajax.reload();
				}
			})
		}
		else
		{
			return false;
		}
	});
});
</script>

<?php
include('footer.php');
?>


				