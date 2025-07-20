
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
    <h4 class="mb-4">Auto-Filled Procurement Request Form</h4>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Drug Reorder Form</strong>
        </div>
        <div class="card-body">
            <form id="autoProcurementForm">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Drug Name</label>
                        <input type="text" class="form-control" value="Paracetamol 500mg" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Current Stock</label>
                        <input type="number" class="form-control" value="45" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Suggested Qty</label>
                        <input type="number" class="form-control" value="155" name="required_qty" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Preferred Vendor</label>
                        <select class="form-select" name="vendor">
                            <option selected>ABC Pharmaceuticals</option>
                            <option>MediPlus Lanka Pvt Ltd</option>
                            <option>HealWell Suppliers</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Reason / Justification</label>
                        <textarea class="form-control" rows="2" placeholder="e.g., High prescription rate over last week" required></textarea>
                    </div>
                </div>

                <div class="mb-3 text-muted">
                    <small><i class="bi bi-info-circle"></i> Used <strong>210 units</strong> in the last 30 days</small>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send-check"></i> Submit Procurement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
