
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
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128+Text&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 
    
    <link href="adminstyle.css" rel="stylesheet">
    <style>
       .timeline li::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: #dee2e6;
}
.timeline li {
    border-left: 4px solid #0d6efd;
    padding-left: 15px;
    position: relative;
}
</style> 
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

  <div class="container mt-5">
    <h4 class="mb-4">🛠 Repair Progress - <span class="text-primary">ECG Monito SN Number-345671(WD 01)</span></h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <ul class="timeline list-unstyled">
                <!-- Stage 1 -->
                <li class="mb-4 position-relative ps-4">
                    <span class="badge bg-secondary mb-2"><i class="bi bi-flag"></i> Request Submitted</span>
                    <div class="text-muted small">Requested on: 2025-07-06</div>
                    <div>Issue: Screen not working properly</div>
                </li>

                <!-- Stage 2 -->
                <li class="mb-4 position-relative ps-4">
                    <span class="badge bg-info text-dark mb-2"><i class="bi bi-person-check"></i> Approved by Admin</span>
                    <div class="text-muted small">Approved on: 2025-07-07</div>
                    <div>Verified and forwarded to technician</div>
                </li>

                <!-- Stage 3 -->
                <li class="mb-4 position-relative ps-4">
                    <span class="badge bg-warning text-dark mb-2"><i class="bi bi-wrench"></i> Under Repair</span>
                    <div class="text-muted small">Started on: 2025-07-08</div>
                    <div>Technician: Mr. Silva (Electronics Dept)</div>
                </li>

                <!-- Stage 4 (Completed) -->
                <li class="mb-4 position-relative ps-4">
                    <span class="badge bg-success mb-2"><i class="bi bi-check-circle"></i> Repair Completed</span>
                    <div class="text-muted small">Completed on: 2025-07-09</div>
                    <div>Reinstalled in Emergency Unit</div>
                </li>
            </ul>
        </div>
    </div>
</div>

