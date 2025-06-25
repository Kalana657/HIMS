<?php
session_start();

  $unitid = $_SESSION['unitin_id'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HHIMS</title>
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



<div class="col-lg-7">
                        <!-- Prescription Form -->
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <i class="fas fa-file-medical"></i> Create New Prescription
                                </div>
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
                                        <textarea class="form-control" rows="2" placeholder="Enter diagnosis...">Hypertension and Type 2 Diabetes</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Medications</label>
                                        <div class="drug-item">
                                            <div class="drug-name">Metformin</div>
                                            <div class="drug-details">
                                                <div class="detail-item">
                                                    <div class="detail-label">Dosage</div>
                                                    <div class="detail-value">500mg</div>
                                                </div>
                                                <div class="detail-item">
                                                    <div class="detail-label">Frequency</div>
                                                    <div class="detail-value">2 times daily</div>
                                                </div>
                                                <div class="detail-item">
                                                    <div class="detail-label">Duration</div>
                                                    <div class="detail-value">30 days</div>
                                                </div>
                                                <div class="detail-item">
                                                    <div class="detail-label">Route</div>
                                                    <div class="detail-value">Oral</div>
                                                </div>
                                            </div>
                                            <i class="fas fa-times remove-drug"></i>
                                        </div>
                                        <div class="drug-item">
                                            <div class="drug-name">Lisinopril</div>
                                            <div class="drug-details">
                                                <div class="detail-item">
                                                    <div class="detail-label">Dosage</div>
                                                    <div class="detail-value">10mg</div>
                                                </div>
                                                <div class="detail-item">
                                                    <div class="detail-label">Frequency</div>
                                                    <div class="detail-value">1 time daily</div>
                                                </div>
                                                <div class="detail-item">
                                                    <div class="detail-label">Duration</div>
                                                    <div class="detail-value">30 days</div>
                                                </div>
                                                <div class="detail-item">
                                                    <div class="detail-label">Route</div>
                                                    <div class="detail-value">Oral</div>
                                                </div>
                                            </div>
                                            <i class="fas fa-times remove-drug"></i>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-outline-hospital">
                                                <i class="fas fa-plus me-1"></i> Add Medication
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Instructions</label>
                                        <textarea class="form-control" rows="3" placeholder="Enter instructions for the patient...">Take medications after meals. Monitor blood pressure twice daily. Follow up in 2 weeks.</textarea>
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

</body>
</html>                   