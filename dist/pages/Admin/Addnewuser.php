<?php
session_start();
?>
<!doctype html>
<html lang="en">



<!doctype html>
<html lang="en">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>HIMS ADMIN  | Add User</title>
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

        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
           <?php
             include('Topbar.php');

           ?>

 
      
      <?php

        if (isset($_SESSION['status']) && isset($_SESSION['message'])) {
            echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    title: "' . ucfirst($_SESSION['status']) . '!",
                    text: "' . $_SESSION['message'] . '",
                    icon: "' . $_SESSION['status'] . '",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "Addnewuser.php";
                });
            </script>';
            
            // Clear session variables after displaying the message
            unset($_SESSION['status']);
            unset($_SESSION['message']);
        }
?>








       <div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header">
      <h5 class="mb-0">Add New User</h5>
    </div>
    <div class="card-body">
      <form action="add_user.php" method="POST">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="role">User Role</label>
          <select id="role" name="role" class="form-control" required>
                <option value="">-- Select Role --</option>
                <?php
                  // Include your DB connection
                  include('db_connect.php'); // or wherever your DB config is

                  $query = "SELECT Role_id, Role_name FROM user_role";
                  $result = mysqli_query($conn, $query);

                  if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo '<option value="' . $row['Role_id'] . '">' . htmlspecialchars($row['Role_name']) . '</option>';
                    }
                  } else {
                    echo '<option disabled>No roles found</option>';
                  }
                ?>
           </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Create User</button>
      </form>
    </div>
  </div>
</div>

      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
      
      </footer>
   
    </div>
   
  </body>
  <!--end::Body-->




  
</html>
