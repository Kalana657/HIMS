<?php
session_start();


?>




<!doctype html>
<html lang="en">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>HIMS ADMIN  | Distribute Request  Table</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

   
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
 
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
 
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="../../../dist/css/adminlte.css" />
    <script src="../../../dist/js/adminlte.js"></script>
 
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
  
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />
    
  </head>

  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
 
    <div class="app-wrapper">
     
      <nav class="app-header navbar navbar-expand bg-body">
    
        <div class="container-fluid">
         
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
          
             <?php
             
                include('uperslidebar.php');

             ?>


           
          </ul>
       
        </div>
      
      </nav>

      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
       
        <?php

            include('navbarlogo.php');
         ?>     
       
      
        <?php

            include('slidebar.php');
        ?>
    
      </aside>
   
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
                    window.location.href = "Addnewuser.php";
                });
            </script>';
            
           
            unset($_SESSION['status']);
            unset($_SESSION['message']);
        }
       ?>
            <?php
           

                    include('db_connect.php');
                    $sql = "SELECT 
                        inventory_item.item_name,
                        SUM(item_distributions.Approval_distributed_quantity) AS total_approved,
                        SUM(item_distributions.distributed_quantity) AS total_distributed
                    FROM 
                        item_distributions
                    JOIN 
                        inventory_item ON item_distributions.item_id = inventory_item.item_id
                    GROUP BY 
                        inventory_item.item_id";


                    $result = $conn->query($sql);
                    ?>

                    <div class="container mt-4">
                        <h4 class="mb-3">Drug Distribution Summary</h4>
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Drug Name</th>
                                    <th>Total Requested</th>
                                    <th>Total Approved</th>
                                    <th>Total Distributed</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()): 
                                    // Determine status
                                    $status = 'Pending';
                                    if ($row['total_distributed'] <= $row['total_approved']) {
                                        $status = 'Completed';
                                    } elseif ($row['total_distributed'] > 0) {
                                        $status = 'Partially Completed';
                                    }
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['item_name']) ?></td>
                                        <td><?= (int)$row['total_distributed'] ?></td>
                                        <td><?= (int)$row['total_approved'] ?></td>
                                        <td><?= (int)$row['total_distributed'] ?></td>
                                        <td>
                                            <?php if ($status === 'Completed'): ?>
                                                <span class="badge badge-success"><?= $status ?></span>
                                            <?php elseif ($status === 'Partially Completed'): ?>
                                                <span class="badge badge-info"><?= $status ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-warning"><?= $status ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#unitModal">View Units</button></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                     </div>



                <!-- Modal -->
                <div class="modal fade" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="unitModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="unitModalLabel">Unit Requests - Paracetamol 500mg</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                            <th>Unit</th>
                            <th>Requested Qty</th>
                            <th>Approved Qty</th>
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>Ward 01</td>
                            <td>100</td>
                            <td><input type="number" class="form-control form-control-sm" value="0"></td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            </tr>
                            <tr>
                            <td>ICU</td>
                            <td>200</td>
                            <td><input type="number" class="form-control form-control-sm" value="100"></td>
                            <td><span class="badge badge-success">Approved</span></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
    </div>







       

    </main>
      <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
     </script>

      <footer class="app-footer">
      
      </footer>
   
    </div>
   
  </body>





  
</html>
