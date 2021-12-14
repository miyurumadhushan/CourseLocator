<?php  
 //export.php  


 if(!empty($_FILES["excel_file"]))  
 {  
      $connect = mysqli_connect("localhost", "root", "", "course_locator");  
      $file_array = explode(".", $_FILES["excel_file"]["name"]);  
      if($file_array[1] == "xls")  
      {  
           include("PHPExcel/IOFactory.php");  
           $output = '';  
           $output .= "  
           <label class='text-success'>Data Inserted</label>  
                <table class='table table-bordered'>  
                     <tr>  
                          <th>Course Type ID</th>  
                          <th>Domain ID</th>  
                          <th>Course Name</th>  
                          <th>Institute ID</th>  
                          <th>Course Description</th>
                          <th>Course Duration</th> 
                          <th>Duration Type</th> 
                          <th>Course Fee</th>
                          <th>Course Enter By</th>
                          <th>Course Status</th>  
                     </tr>  
                     ";  
           $object = PHPExcel_IOFactory::load($_FILES["excel_file"]["tmp_name"]);  
           foreach($object->getWorksheetIterator() as $worksheet)  
           {  
                $highestRow = $worksheet->getHighestRow();  
                for($row=2; $row<=$highestRow; $row++)  
                {  
                     $course_type_id = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());  
                     $domain_id = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue());  
                     $course_name = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());  
                     $institute_id = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue());  
                     $course_description = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());  

                     $course_duration = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
                     $duration_type = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
                     $course_fee = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
                     $semester_fee = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(9, $row)->getValue());
                    
                     $course_enter_by = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(10, $row)->getValue());
                     $course_status= mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(11, $row)->getValue());
                     



                     $query = "  
                     INSERT INTO course  
                     (course_type_id, domain_id, course_name, institute_id, course_description, course_duration, duration_type, course_fee, semester_fee, course_enter_by, course_status)   
                     VALUES ('".$course_type_id."', '".$domain_id."', '".$course_name."', '".$institute_id."', '".$course_description."',  '".$course_duration."' ,  '".$duration_type."' ,  '".$course_fee."' ,  '".$semester_fee."', '".$course_enter_by."', '".$course_status."')  
                     ";  
                     mysqli_query($connect, $query);  
                     $output .= '  
                     <tr>  
                          <td>'.$course_type_id.'</td>  
                          <td>'.$domain_id.'</td>  
                          <td>'.$course_name.'</td>  
                          <td>'.$institute_id.'</td>  
                          <td>'.$course_description.'</td>  
                          <td>'.$course_duration.'</td>  
                          <td>'.$duration_type.'</td>  
                          <td>'.$course_fee.'</td>  
                          <td>'.$course_enter_by.'</td>  
                          <td>'.$course_status.'</td>  
                     </tr>  
                     ';  
                }  
           }  
           $output .= '</table>';  
           echo $output;  
      }  
      else  
      {  
           echo '<label class="text-danger">Invalid File</label>';  
      }  
 }  
 ?>  
