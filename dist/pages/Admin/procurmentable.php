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
                            window.location.href = "Add_unit.php";
                        });
                    </script>';
                    
                    // Clear session variables after displaying the message
                    unset($_SESSION['status']);
                    unset($_SESSION['message']);
                }
        ?>

     <?php
// Include DB connection
include('db_connect.php');

// Handle form submission to add a new unit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unit_name = mysqli_real_escape_string($conn, $_POST['unit_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $priority_level = mysqli_real_escape_string($conn, $_POST['priority_level']);

    if (!empty($unit_name) && !empty($priority_level)) {
        $insertQuery = "INSERT INTO units (unit_name, description, priority_level) VALUES ('$unit_name', '$description', '$priority_level')";
        if (mysqli_query($conn, $insertQuery)) {
            $successMessage = "Unit added successfully!";
        } else {
            $errorMessage = "Error adding unit: " . mysqli_error($conn);
        }
    } else {
        $errorMessage = "Please fill in required fields.";
    }
}

// Fetch existing units
$unitsQuery = "SELECT * FROM units ORDER BY unit_name ASC";
$unitsResult = mysqli_query($conn, $unitsQuery);

?>


        <div class="container mt-4">

                    <!-- Alert Messages -->
                    <?php if (!empty($successMessage)) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($successMessage) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($errorMessage)) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($errorMessage) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Add Unit Form -->
                    <div class="card shadow-sm mb-5">
                        <div class="card-header">
                        <h5 class="mb-0">Add New Unit</h5>
                        </div>
                        <div class="card-body">
                        <form action="Add_unit_insert.php" method="POST" novalidate>
                            
                            <div class="mb-3">
                            <label for="unit_name" class="form-label">Unit Name <span class="text-danger">*</span></label>
                            <input type="text" id="unit_name" name="unit_name" class="form-control" required placeholder="Enter unit name, e.g. ICU" />
                            </div>

                            <div class="mb-3">
                            <label for="description" class="form-label">Description (optional)</label>
                            <textarea id="description" name="description" class="form-control" rows="3" placeholder="Description about this unit"></textarea>
                            </div>

                         

                            <button type="submit" class="btn btn-primary">Add Unit</button>
                        </form>
                        </div>
                    </div>

                    <!-- Existing Units List -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Existing Units</h5>
                        </div>
                        <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                            <table class="table table-striped table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                <th>#</th>
                                <th>Unit Name</th>
                                <th>Description</th>
                              
                                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                if ($unitsResult && mysqli_num_rows($unitsResult) > 0) {
                                    while ($unit = mysqli_fetch_assoc($unitsResult)) {
                                       

                                        echo '<tr>';
                                        echo '<td>' . $count++ . '</td>';
                                        echo '<td>' . htmlspecialchars($unit['unit_name']) . '</td>';
                                        echo '<td>' . htmlspecialchars($unit['description']) . '</td>';
                                      
                                        echo '<td>
                                                <a href="edit_unit.php?id=' . $unit['unit_id'] . '" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="delete_unit.php?id=' . $unit['unit_id'] . '" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm(\'Are you sure you want to delete this unit?\');">
                                                <i class="bi bi-trash"></i>
                                                </a>
                                            </td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="5" class="text-center text-muted">No units found.</td></tr>';
                                }
                                ?>
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>

       </div>










       

    </main>
   
      <footer class="app-footer">
      
      </footer>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </div>
   
  </body>





  
</html>
