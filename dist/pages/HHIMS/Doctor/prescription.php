<?php
session_start();
include('db_connect.php'); // Database connection file

$unitid = $_SESSION['unitin_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HHIMS - Prescription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include('sidebar.php') ?>

        <!-- Main Content -->
        <div class="col-md-10 ms-sm-auto main-content">
            <!-- Header -->
            <?php include('header.php') ?>

            <!-- Prescription Form -->
            <div class="col-lg-7">
                <div class="card mt-4">
                    <div class="card-header">
                        <div><i class="fas fa-file-medical"></i> Create New Prescription</div>
                        <div class="prescription-number">RX#: SL-2023-0720-001</div>
                    </div>
                    <div class="card-body">
                        <form class="prescription-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Patient</label>
                                        <select class="form-select">
                                            <option selected>Select a patient</option>
                                            <option>Nimal Rajapaksa (ID: SL-2023-0012)</option>
                                            <option>Samantha Jayasuriya (ID: SL-2023-0045)</option>
                                            <option>Kamala Perera (ID: SL-2023-0033)</option>
                                            <option>Dinesh Gunawardena (ID: SL-2023-0056)</option>
                                            <option>Ranjan Silva (ID: SL-2023-0021)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Date</label>
                                        <input type="date" class="form-control" value="2023-07-20">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Diagnosis</label>
                                <textarea class="form-control" rows="2">Hypertension and Type 2 Diabetes</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Medications</label>
                                <div class="drug-item">
                                    <div class="drug-name">Metformin</div>
                                    <div class="drug-details">
                                        <div class="detail-item"><strong>Dosage:</strong> 500mg</div>
                                        <div class="detail-item"><strong>Frequency:</strong> 2 times daily</div>
                                        <div class="detail-item"><strong>Duration:</strong> 30 days</div>
                                        <div class="detail-item"><strong>Route:</strong> Oral</div>
                                    </div>
                                    <i class="fas fa-times remove-drug"></i>
                                </div>
                                <div class="drug-item">
                                    <div class="drug-name">Lisinopril</div>
                                    <div class="drug-details">
                                        <div class="detail-item"><strong>Dosage:</strong> 10mg</div>
                                        <div class="detail-item"><strong>Frequency:</strong> 1 time daily</div>
                                        <div class="detail-item"><strong>Duration:</strong> 30 days</div>
                                        <div class="detail-item"><strong>Route:</strong> Oral</div>
                                    </div>
                                    <i class="fas fa-times remove-drug"></i>
                                </div>
                                <button type="button" class="btn btn-outline-hospital mt-3">
                                    <i class="fas fa-plus me-1"></i> Add Medication
                                </button>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Instructions</label>
                                <textarea class="form-control" rows="3">Take medications after meals. Monitor blood pressure twice daily. Follow up in 2 weeks.</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Next Appointment</label>
                                        <input type="date" class="form-control" value="2023-08-03">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Doctor</label>
                                        <input type="text" class="form-control" value="Dr. Sanjaya Perera" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4 gap-3">
                                <button type="button" class="btn btn-outline-hospital">Save Draft</button>
                                <button type="submit" class="btn btn-hospital">Issue Prescription</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Distributed Items Summary -->
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <i class="fas fa-clipboard-list"></i> Distributed Items Summary
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Distribution ID</th>
                                        <th>Item Name</th>
                                        <th>Distributed Qty</th>
                                        <th>Approved Qty</th>
                                        <th>Serial No</th>
                                        <th>BN No</th>
                                        <th>Distributed Date</th>
                                        <th>Remarks</th>
                                        <th>Admin Recommend</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT 
                                                d.distribution_id,
                                                d.unit_id,
                                                d.item_id,
                                                d.distributed_quantity,
                                                d.Approval_distributed_quantity,
                                                d.remarks,
                                                d.`admin recommend`,
                                                d.distributed_at,
                                                i.item_name,
                                                i.serial_number,
                                                i.bn_number
                                            FROM item_distributions d
                                            JOIN inventory_item i ON d.item_id = i.item_id
                                            WHERE d.unit_id = ?
                                            ORDER BY d.distributed_at DESC";

                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $unitid);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$row['distribution_id']}</td>
                                                <td>" . htmlspecialchars($row['item_name']) . "</td>
                                                <td>{$row['distributed_quantity']}</td>
                                                <td>{$row['Approval_distributed_quantity']}</td>
                                                <td>" . htmlspecialchars($row['serial_number']) . "</td>
                                                <td>" . htmlspecialchars($row['bn_number']) . "</td>
                                                <td>{$row['distributed_at']}</td>
                                                <td>" . htmlspecialchars($row['remarks']) . "</td>
                                                <td>" . htmlspecialchars($row['admin recommend']) . "</td>
                                            </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- End Main Content -->
    </div> <!-- End Row -->
</div> <!-- End Container -->

<!-- JS (Optional Bootstrap 5 JS) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
