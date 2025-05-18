<?php
session_start();
?>
<!doctype html>
<html lang="en">



<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>HIMS ADMIN  | Add User</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
        <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery (Required for Bootstrap JS) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- Popper.js (Required for dropdowns, tooltips, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Bootstrap 4 JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
     <!-- SweetAlert2 -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../../../dist/css/adminlte.css" />
    <script src="../../../dist/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
    <!-- jsvectormap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />
    
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
          </ul>
        
          <ul class="navbar-nav ms-auto">
        
            <li class="nav-item">
              <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="bi bi-search"></i>
              </a>
            </li>
            <!--end::Navbar Search-->
            <!--begin::Messages Dropdown Menu-->
             <?php
             
                include('uperslidebar.php');

             ?>


            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
      
      </nav>

      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <?php

            include('navbarlogo.php');
         ?>     
       
        <!--begin::Sidebar Wrapper-->
        <?php

            include('slidebar.php');
        ?>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
      
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
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
      
      </footer>
   
    </div>
   
  </body>
  <!--end::Body-->




  
</html>
