<?php
//header.php
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
       
        <title>Course Locator</title>
         <!-- Logo    -->

        <link rel="icon" type="image/x-icon" href="assets/logo.png" />
        <!-- CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
        <!-- JS -->
        <script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

    </head>

    <body class="d-flex flex-column h-100">

        <main class="flex-shrink-0">
            <!-- Navigation-->

            <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top ">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.php"><img src="East.png" height="50px" width="120px"></a>
                    <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button> -->
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <ul class="nav navbar-nav navbar-right ">        

                            <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span> <?php echo $_SESSION["user_name"]; ?></a>
                            <ul class="dropdown-menu">
                                <li><a href="profile.php">Profile</a></li>
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                            </li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                           <?php
                           if($_SESSION['type'] == 'Admin')
                           {
                           ?>
                            <li><a href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="user.php">Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="coursetype.php">Course Types</a></li>
                            <li class="nav-item"><a class="nav-link" href="domian.php">Course Domains</a></li>
                            <li class="nav-item"><a class="nav-link" href="course.php">Courses</a></li> 
                            <li class="nav-item"><a class="nav-link" href="institute.php">Institutes</a></li> 
                            <li class="nav-item"><a class="nav-link" href="bulk_institutes.php">Upload Bulk Institutes</a></li>   
                            

                            <?php
                            }
                            ?>

                            <?php
                            if($_SESSION['type'] == 'Student')
                            {
                            ?>
                            <!-- <li><a href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="user.php">Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="coursetype.php">Course Types</a></li>
                            <li class="nav-item"><a class="nav-link" href="domian.php">Course Domains</a></li>
                            <li class="nav-item"><a class="nav-link" href="course.php">Courses</a></li> 
                            <li class="nav-item"><a class="nav-link" href="institute.php">Institutes</a></li> 
                            <li class="nav-item"><a class="nav-link" href="bulk_institutes.php">Upload Bulk Institutes</a></li>   -->
                            <?php
                            }
                            ?>  
                        </ul>
                        
                        
                    </div>
                </div>
            </nav>


    </body>
</html>
