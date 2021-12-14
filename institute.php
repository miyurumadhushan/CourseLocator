<?php
//institute.php
include('database_connection.php');

include('function.php');

if(!isset($_SESSION['type']))
{
	header('location:login.php');
}

if($_SESSION['type'] != 'Admin')
{
	header('location:user.php');
}

include('header.php');

?>
	<div class="container px-5 my-5 py-5">
	<span id="alert_action"></span>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
                		<div class="col-md-10">
                			<h3 class="panel-title">Institute List</h3>
                		</div>
                		<div class="col-md-2" align="right">
                			<button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
                		</div>
                	</div>
                </div>
                <div class="panel-body">
                	<table id="institute_data" class="table table-bordered table-striped">
                		<thead>
							<tr>
								<th>ID</th>
								<th>Institute Name</th>
								<th>Institute Address</th>
								<th>Institute Description</th>
								<th>Status</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
                	</table>
                </div>
            </div>
        </div>
    </div>

    <div id="instituteModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="institute_form">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Institute</h4>
    				</div>
    				<div class="modal-body">
    					<div class="form-group">

    						<label>Enter Institute Name</label>
							<input type="text" name="institute_name" id="institute_name" class="form-control" required />

    					</div>
    					<div class="form-group">

							<label>Enter Institute Address</label>
							<input type="text" name="institute_address" id="institute_address" class="form-control" required />
						</div>
						<div class="form-group">

							<label>Enter Institute Description</label>
							<input type="text" name="institute_description" id="institute_description" class="form-control" required />
						</div>
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="institute_id" id="institute_id" />
    					<input type="hidden" name="btn_action" id="btn_action" />
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
		$('#instituteModal').modal('show');
		$('#institute_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Institute");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});

	$(document).on('submit','#institute_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"institute_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#institute_form')[0].reset();
				$('#instituteModal').modal('hide');
				$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
				$('#action').attr('disabled', false);
				institutedataTable.ajax.reload();
			}
		})
	});

 // Update Button Features	

	$(document).on('click', '.update', function(){
		var institute_id = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:'institute_action.php',
			method:"POST",
			data:{institute_id:institute_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#instituteModal').modal('show');
				$('#institute_name').val(data.institute_name);
				$('#institute_address').val(data.institute_address);
				$('#institute_description').val(data.institute_description);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Institute");
				$('#institute_id').val(institute_id);
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
			}
		})
	});

// Delete Button Features	

	$(document).on('click','.delete', function(){
		var institute_id = $(this).attr("id");
		var status  = $(this).data('status');
		var btn_action = 'delete';
		if(confirm("Are you sure you want to change status?"))
		{
			$.ajax({
				url:"institute_action.php",
				method:"POST",
				data:{institute_id:institute_id, status:status, btn_action:btn_action},
				success:function(data)
				{
					$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
					institutedataTable.ajax.reload();
				}
			})
		}
		else
		{
			return false;
		}
	});


	var institutedataTable = $('#institute_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"institute_fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[5, 6],
				"orderable":false,
			},
		],
		"pageLength": 10
	});

});
</script>


<?php
include('footer.php');
?>