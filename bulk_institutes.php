
<?php

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

          
           <div class="container box">  
                <h3 align="center">Upload Courses as a Bulk</h3>  
                <br /><br />  
                <br /><br />  


               <center>
                    <div class="main">
                     <form>
                         <i class="fas fa-file-excel" style="color:black"></i>
                         <a href="assets/template.xls" download="">
                         <input type="button" value="Download" style="color:black">
                         <i class="fas fa-file-excel" style="color:black"></i>
                         </a>
                    </form>
          
                    </div>
               </center>




                <form mehtod="post" id="export_excel">  
                     <label>Select Excel</label>  
                     <input type="file" name="excel_file" id="excel_file" />  
                </form>  
                <br />  
                <br />  
                <div id="result">  
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      $('#excel_file').change(function(){  
           $('#export_excel').submit();  
      });  
      $('#export_excel').on('submit', function(event){  
           event.preventDefault();  
           $.ajax({  
                url:"bulk_institutes_fetch.php",  
                method:"POST",  
                data:new FormData(this),  
                contentType:false,  
                processData:false,  
                success:function(data){  
                     $('#result').html(data);  
                     $('#excel_file').val('');  
                }  
           });  
      });  
 });  
 </script>  

<?php
include('footer.php');
?>