<?php
  
      session_start();
      if (!isset($_SESSION['user_id'])) {
          header("Location: login.php");
          exit;
      }
 ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link href="adminstyle.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
     <?php
       include('Slide_bar.php');

     ?>

     
        <div class="main-content">
            <!-- Topbar -->
           <?php
             include('Topbar.php');

           ?>
      
      <?php

            if (isset($_SESSION['status'])) {
            $status = $_SESSION['status'];
            $message = $_SESSION['message'];

            echo "<script>
                Swal.fire({
                icon: '$status',
                title: '$message',
                showConfirmButton: true
                });
            </script>";
            unset($_SESSION['status']);
            unset($_SESSION['message']);
            }
     ?>

        <form action="add_user_role.php" method="POST">
            <div class="container mt-5">
            <div class="card shadow-sm">
                <div class="card-header  text-black">
                <h5 class="mb-0">Add New User Role</h5>
                </div>
                <div class="card-body">
                <form action="add_user_role.php" method="POST">
                    <div class="form-group">
                    <label for="role_name">Role Name</label>
                    <input type="text" id="role_name" name="role_name" class="form-control" placeholder="Enter role name" required>
                    </div>
                    <button type="submit" class="btn btn-success">Create Role</button>
                </form>
                </div>
            </div>
            </div>
        </form>
            <?php

                if (isset($_SESSION['status'])) {
                $status = $_SESSION['status'];
                $message = $_SESSION['message'];

                echo "<script>
                    Swal.fire({
                    icon: '$status',
                    title: '$message',
                    showConfirmButton: true
                    });
                </script>";
                unset($_SESSION['status']);
                unset($_SESSION['message']);
                }
            ?>




       

      </main>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

      <footer class="app-footer">
      
      </footer>
   
    </div>
   
  </body>





  
</html>
