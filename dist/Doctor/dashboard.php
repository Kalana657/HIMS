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



                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card">
                            <div class="icon">
                                <i class="fas fa-user-injured"></i>
                            </div>
                            <div class="number">24</div>
                            <div class="label">Today's Patients</div>
                            <div class="trend up">
                                <i class="fas fa-arrow-up me-1"></i> 12% from yesterday
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card">
                            <div class="icon">
                                <i class="fas fa-file-prescription"></i>
                            </div>
                            <div class="number">18</div>
                            <div class="label">Prescriptions Today</div>
                            <div class="trend up">
                                <i class="fas fa-arrow-up me-1"></i> 8% from yesterday
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card">
                            <div class="icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="number">3</div>
                            <div class="label">Pending Approvals</div>
                            <div class="trend down">
                                <i class="fas fa-arrow-down me-1"></i> 2 from yesterday
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card">
                            <div class="icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="number">12</div>
                            <div class="label">Tomorrow's Appointments</div>
                            <div class="trend">
                                <i class="fas fa-minus me-1"></i> Same as yesterday
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Row -->
                <div class="row mt-4">
                    <!-- Patient List & Drug Inventory -->
                    <div class="col-lg-5">
                        <!-- Patient List -->
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <i class="fas fa-user-injured"></i> Recent Patients
                                </div>
                                <button class="btn btn-outline-hospital btn-sm">
                                    <i class="fas fa-plus me-1"></i> New Patient
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="patient-list">
                                    <div class="patient-item active">
                                        <div class="patient-avatar">NR</div>
                                        <div class="patient-info">
                                            <h6>Nimal Rajapaksa</h6>
                                            <div class="meta">
                                                <span>ID: SL-2023-0012</span>
                                                <span>54 years</span>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-success">Completed</span>
                                        </div>
                                    </div>
                                    <div class="patient-item">
                                        <div class="patient-avatar">SJ</div>
                                        <div class="patient-info">
                                            <h6>Samantha Jayasuriya</h6>
                                            <div class="meta">
                                                <span>ID: SL-2023-0045</span>
                                                <span>32 years</span>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-warning">Pending</span>
                                        </div>
                                    </div>
                                    <div class="patient-item">
                                        <div class="patient-avatar">KP</div>
                                        <div class="patient-info">
                                            <h6>Kamala Perera</h6>
                                            <div class="meta">
                                                <span>ID: SL-2023-0033</span>
                                                <span>67 years</span>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-danger">Urgent</span>
                                        </div>
                                    </div>
                                    <div class="patient-item">
                                        <div class="patient-avatar">DG</div>
                                        <div class="patient-info">
                                            <h6>Dinesh Gunawardena</h6>
                                            <div class="meta">
                                                <span>ID: SL-2023-0056</span>
                                                <span>45 years</span>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-success">Completed</span>
                                        </div>
                                    </div>
                                    <div class="patient-item">
                                        <div class="patient-avatar">RS</div>
                                        <div class="patient-info">
                                            <h6>Ranjan Silva</h6>
                                            <div class="meta">
                                                <span>ID: SL-2023-0021</span>
                                                <span>28 years</span>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-info">New</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Drug Inventory -->
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <i class="fas fa-pills"></i> Drug Inventory
                                </div>
                                <button class="btn btn-outline-hospital btn-sm">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive drug-list">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Drug Name</th>
                                                <th>Dosage</th>
                                                <th>Stock</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Paracetamol</td>
                                                <td>500mg</td>
                                                <td>1,240</td>
                                                <td><span class="badge bg-success">In Stock</span></td>
                                            </tr>
                                            <tr>
                                                <td>Amoxicillin</td>
                                                <td>250mg</td>
                                                <td>342</td>
                                                <td><span class="badge bg-success">In Stock</span></td>
                                            </tr>
                                            <tr>
                                                <td>Atorvastatin</td>
                                                <td>20mg</td>
                                                <td>78</td>
                                                <td><span class="badge bg-warning">Low Stock</span></td>
                                            </tr>
                                            <tr>
                                                <td>Salbutamol</td>
                                                <td>100mcg</td>
                                                <td>45</td>
                                                <td><span class="badge bg-danger">Critical</span></td>
                                            </tr>
                                            <tr>
                                                <td>Omeprazole</td>
                                                <td>20mg</td>
                                                <td>512</td>
                                                <td><span class="badge bg-success">In Stock</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Prescription Form & Recent Prescriptions -->
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

                        <!-- Recent Prescriptions -->
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <i class="fas fa-history"></i> Recent Prescriptions
                                </div>
                                <button class="btn btn-outline-hospital btn-sm">
                                    <i class="fas fa-download me-1"></i> Export
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Kamala Perera</h6>
                                            <small>Today, 10:45 AM</small>
                                        </div>
                                        <p class="mb-1">Metformin, Lisinopril, Aspirin</p>
                                        <small class="text-muted">Diagnosis: Hypertension & Diabetes</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Samantha Jayasuriya</h6>
                                            <small>Yesterday, 3:30 PM</small>
                                        </div>
                                        <p class="mb-1">Amoxicillin, Paracetamol, Vitamin C</p>
                                        <small class="text-muted">Diagnosis: Upper Respiratory Infection</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Ranjan Silva</h6>
                                            <small>Jul 18, 2023, 11:20 AM</small>
                                        </div>
                                        <p class="mb-1">Ibuprofen, Vitamin D, Calcium</p>
                                        <small class="text-muted">Diagnosis: Muscle Strain & Vitamin Deficiency</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="footer">
                    <p>© 2023 Sri Lanka Hospital Management System. All rights reserved.</p>
                    <p>Colombo Central Hospital | Developed for Sri Lankan Healthcare Professionals</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Remove drug functionality
            const removeButtons = document.querySelectorAll('.remove-drug');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.drug-item').remove();
                });
            });
            
            // Add drug functionality
            const addDrugBtn = document.querySelector('.btn-outline-hospital');
            addDrugBtn.addEventListener('click', function() {
                const drugName = prompt('Enter drug name:');
                if (drugName) {
                    const newDrug = document.createElement('div');
                    newDrug.className = 'drug-item';
                    newDrug.innerHTML = `
                        <div class="drug-name">${drugName}</div>
                        <div class="drug-details">
                            <div class="detail-item">
                                <div class="detail-label">Dosage</div>
                                <div class="detail-value">100mg</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Frequency</div>
                                <div class="detail-value">1 time daily</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Duration</div>
                                <div class="detail-value">7 days</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Route</div>
                                <div class="detail-value">Oral</div>
                            </div>
                        </div>
                        <i class="fas fa-times remove-drug"></i>
                    `;
                    document.querySelector('.prescription-form .form-group:nth-child(4)').insertBefore(newDrug, this.parentNode);
                    
                    // Add event listener to new remove button
                    newDrug.querySelector('.remove-drug').addEventListener('click', function() {
                        this.closest('.drug-item').remove();
                    });
                }
            });
            
            // Patient selection
            const patientItems = document.querySelectorAll('.patient-item');
            patientItems.forEach(item => {
                item.addEventListener('click', function() {
                    patientItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Set patient in form
                    const patientName = this.querySelector('h6').textContent;
                    document.querySelector('.form-select option:first-child').textContent = patientName;
                    document.querySelector('.form-select').selectedIndex = 0;
                });
            });
            
            // Form submission
            const prescriptionForm = document.querySelector('.prescription-form');
            prescriptionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Prescription issued successfully!');
                this.reset();
            });
        });
    </script>
</body>
</html>