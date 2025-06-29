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

                
             <div class="container mt-5">
                    <h3 class="mb-4 text-primary"><i class="fas fa-users"></i> Patients in Your Unit</h3>

                    <?php
                    $stmt = $conn->prepare("SELECT patient_id, fname, lname, dob, phone, gender, created_at FROM patients WHERE punit_id = ?");
                    $stmt->bind_param("i", $unitid);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    ?>

                    <?php if ($result->num_rows > 0): ?>
                        <table class="table table-hover table-bordered bg-white">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Patient Name</th>
                                    <th>DOB / Age</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Created At</th>
                                    <th>Prescription</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count = 1;
                                while ($row = $result->fetch_assoc()): 
                                    $fullName = $row['fname'] . ' ' . $row['lname'];
                                    $birthDate = new DateTime($row['dob']);
                                    $today = new DateTime();
                                    $age = $today->diff($birthDate)->y;
                                ?>
                                    <tr>
                                        <td><?= $count++ ?></td>
                                        <td><?= htmlspecialchars($fullName) ?></td>
                                        <td><?= $row['dob'] ?> / <?= $age ?> yrs</td>
                                        <td><?= $row['gender'] ?></td>
                                        <td><?= htmlspecialchars($row['phone']) ?></td>
                                        <td><?= $row['created_at'] ?></td>
                                        <td>
                                            <a href="add_prescription.php?pid=<?= $row['patient_id'] ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-notes-medical"></i> Add Prescription
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-warning">No patients found for this unit.</div>
                    <?php endif; ?>

                </div>
                                
                <!-- Footer -->
                <div class="footer">
                    
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