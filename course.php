<?php
//course.php

include('database_connection.php');
include('function.php');

if(!isset($_SESSION["type"]))
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
        <span id='alert_action'></span>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">Courses List</h3>
                            </div>
                        
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="course_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Course Type</th>
                                    <th>Course Domain</th>
                                    <th>Course Name</th>
                                    <th>Institute Name</th>
                                    <th>Course Duration</th>
                                    <th>Enter By</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr></thead>
                            </table>
                        </div></div>
                    </div>
                </div>
			</div>
		</div>

        <div id="courseModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="course_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Add Course</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Select Course Type</label>
                                <select name="course_type_id" id="course_type_id" class="form-control" required>
                                    <option value="">Select Course Type</option>
                                    <?php echo fill_course_type_list($connect);?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Domain</label>
                                <select name="domain_id" id="domain_id" class="form-control" required>
                                    <option value="">Select Domain</option>
                                    <?php echo fill_domain_list($connect);?>
                                </select>
                            </div>


                             <div class="form-group">
                                <label>Select Institute</label>
                                <select name="institute_id" id="institute_id" class="form-control" required>
                                    <option value="">Select Institute</option>
                                    <?php echo fill_institute_list($connect);?>
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Enter Course Name</label>
                                <input type="text" name="course_name" id="course_name" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Enter Course Description</label>
                                <textarea name="course_description" id="course_description" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Enter Course Duration</label>
                                <div class="input-group">
                                    <input type="text" name="course_duration" id="course_duration" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" /> 
                                    <span class="input-group-addon">
                                        <select name="duration_type" id="duration_type" required>
                                            <option value="">Duration Type</option>
                                            <option value="Years">Years</option>
                                            <option value="Months">Months</option>
                                            <option value="Hours">Hours</option>
                                           
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Enter Course Fee</label>
                                <input type="text" name="course_fee" id="course_fee" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
                            </div>
                            <div class="form-group">
                                <label>Enter Semester Fee</label>
                                <input type="text" name="semester_fee" id="semester_fee" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="course_id" id="course_id" />
                            <input type="hidden" name="btn_action" id="btn_action" />
                            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="coursedetailsModal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="course_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Course Details</h4>
                        </div>
                        <div class="modal-body">
                            <Div id="course_details"></Div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
$(document).ready(function(){
    var coursedataTable = $('#course_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"course_fetch.php",
            type:"POST"
        },
        "columnDefs":[
            {
                "targets":[8, 9, 10],
                "orderable":false,
            },
        ],
        "pageLength": 10
    });

    $('#add_button').click(function(){
        $('#courseModal').modal('show');
        $('#course_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Course");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });


    $(document).on('submit', '#course_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"course_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#course_form')[0].reset();
                $('#courseModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                coursedataTable.ajax.reload();
            }
        })
    });


    // View Button Features

    $(document).on('click', '.view', function(){
        var course_id = $(this).attr("id");
        var btn_action = 'course_details';
        $.ajax({
            url:"course_action.php",
            method:"POST",
            data:{course_id:course_id, btn_action:btn_action},
            success:function(data){
                $('#coursedetailsModal').modal('show');
                $('#course_details').html(data);
            }
        })
    });


 // Update Button Features


    $(document).on('click', '.update', function(){
        var course_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"course_action.php",
            method:"POST",
            data:{course_id:course_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#courseModal').modal('show');
                $('#course_type_id').val(data.course_type_id);
                $('#domain_id').val(data.domain_id);
                $('#course_name').val(data.course_name);
                $('#institute_id').val(data.institute_id);
                $('#course_description').val(data.course_description);
                $('#course_duration').val(data.course_duration);
                $('#duration_type').val(data.duration_type);
                $('#course_fee').val(data.course_fee);
                $('#semester_fee').val(data.semester_fee);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Course");
                $('#course_id').val(course_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });


     // Delete Button Features

    $(document).on('click', '.delete', function(){
        var course_id = $(this).attr("id");
        var status = $(this).data("status");
        var btn_action = 'delete';
        if(confirm("Are you sure you want to change status?"))
        {
            $.ajax({
                url:"course_action.php",
                method:"POST",
                data:{course_id:course_id, status:status, btn_action:btn_action},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    coursedataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;
        }
    });

});
</script>
