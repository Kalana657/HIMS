<?php
session_start();
include('db_connect.php');

// Check user login and unit ID
if (!isset($_SESSION['unitin_id'])) {
    die("Access denied. Please login first.");
}
$unit_id = $_SESSION['unitin_id'];

// Check patient ID from GET
if (!isset($_GET['pid'])) {
    die("Patient ID is missing.");
}
$patient_id = intval($_GET['pid']); // Sanitize

// Fetch patient details
$stmt = $conn->prepare("SELECT fname, lname, dob FROM patients WHERE patient_id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$patient_result = $stmt->get_result();

if ($patient_result->num_rows !== 1) {
    die("Patient not found.");
}

$patient = $patient_result->fetch_assoc();

// Fetch drugs for dropdown and build $drugOptionsHTML and $drugMap
$drugOptionsHTML = "";
$drugMap = [];

$sql = "SELECT inventory_item.item_id, inventory_item.item_name 
        FROM item_distributions
        JOIN units ON units.unit_id = item_distributions.unit_id
        JOIN inventory_item ON inventory_item.item_id = item_distributions.item_id
        WHERE item_distributions.unit_id = ? AND inventory_item.type_id = 2";

$stmt_drugs = $conn->prepare($sql);
$stmt_drugs->bind_param("i", $unit_id);
$stmt_drugs->execute();
$drug_result = $stmt_drugs->get_result();

while ($d = $drug_result->fetch_assoc()) {
    $drugMap[$d['item_id']] = $d['item_name'];
    $drugOptionsHTML .= '<option value="' . htmlspecialchars($d['item_id']) . '">' . htmlspecialchars($d['item_name']) . '</option>';
}


    

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Prescription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4 text-primary">
        Prescription for <?= htmlspecialchars($patient['fname'] . ' ' . $patient['lname']) ?> (DOB: <?= htmlspecialchars($patient['dob']) ?>)
    </h3>
     
<?php
echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Prescription saved and stock updated successfully.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'add_prescription.php';
        });
    </script>";

?>

    <form method="POST" action="save_prescription.php">
        <input type="hidden" class="form-control" name="patient_id" value="<?= htmlspecialchars($patient_id) ?>" >
        <div class="mb-3">
            <label class="form-label">Diagnosis <span class="text-danger">*</span></label>
            <textarea class="form-control" name="diagnosis" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Additional Notes</label>
            <textarea class="form-control" name="notes"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Prescribed By <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="prescribed_by" required>
        </div>

        <!-- Drug Items -->
        <div id="drug-items">
            <div class="row mb-2 drug-item">
                <div class="col-md-2">
                    <select name="drug_name[]" class="form-control" required>
                        <option value="">-- Select Drug --</option>
                        <?= $drugOptionsHTML ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" min="0" step="any" name="dose[]" class="form-control" placeholder="Dose" required>
                </div>
                <div class="col-md-2">
                    <select name="frequency[]" class="form-control" required>
                        <option value="">-- Frequency --</option>
                        <option value="1">Once daily</option>
                        <option value="2">Twice daily</option>
                        <option value="3">Thrice daily</option>
                        <option value="4">Every 6 hours</option>
                        <option value="As needed">As needed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="duration[]" class="form-control" required>
                        <option value="">-- Duration --</option>
                        <option value="3">3 days</option>
                        <option value="5">5 days</option>
                        <option value="7">7 days</option>
                        <option value="10">10 days</option>
                        <option value="14">14 days</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="route[]" class="form-control" required>
                        <option value="">-- Route --</option>
                        <option value="Oral">Oral</option>
                        <option value="IV">IV</option>
                        <option value="IM">IM</option>
                        <option value="Subcutaneous">Subcutaneous</option>
                        <option value="Topical">Topical</option>
                        <option value="Inhalation">Inhalation</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="instructions[]" class="form-control">
                        <option value="">-- Instructions --</option>
                        <option value="After meals">After meals</option>
                        <option value="Before meals">Before meals</option>
                        <option value="With water">With water</option>
                        <option value="Do not drive">Do not drive</option>
                        <option value="Avoid alcohol">Avoid alcohol</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addDrugItem()">+ Add More</button>

        <div class="text-end">
            <button type="submit" class="btn btn-success">Submit Prescription</button>
        </div>
    </form>
</div>

<script>
function addDrugItem() {
    const container = document.getElementById('drug-items');
    const newItem = document.createElement('div');
    newItem.classList.add('row', 'mb-2', 'drug-item');

    newItem.innerHTML = `
        <div class="col-md-2">
            <select name="drug_name[]" class="form-control" required>
                <option value="">-- Select Drug --</option>
                <?= $drugOptionsHTML ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" min="0" step="any" name="dose[]" class="form-control" placeholder="Dose" required>
        </div>
        <div class="col-md-2">
            <select name="frequency[]" class="form-control" required>
                <option value="">-- Frequency --</option>
                <option value="Once daily">Once daily</option>
                <option value="Twice daily">Twice daily</option>
                <option value="Thrice daily">Thrice daily</option>
                <option value="Every 6 hours">Every 6 hours</option>
                <option value="As needed">As needed</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="duration[]" class="form-control" required>
                <option value="">-- Duration --</option>
                <option value="3 days">3 days</option>
                <option value="5 days">5 days</option>
                <option value="7 days">7 days</option>
                <option value="10 days">10 days</option>
                <option value="14 days">14 days</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="route[]" class="form-control" required>
                <option value="">-- Route --</option>
                <option value="Oral">Oral</option>
                <option value="IV">IV</option>
                <option value="IM">IM</option>
                <option value="Subcutaneous">Subcutaneous</option>
                <option value="Topical">Topical</option>
                <option value="Inhalation">Inhalation</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="instructions[]" class="form-control">
                <option value="">-- Instructions --</option>
                <option value="After meals">After meals</option>
                <option value="Before meals">Before meals</option>
                <option value="With water">With water</option>
                <option value="Do not drive">Do not drive</option>
                <option value="Avoid alcohol">Avoid alcohol</option>
            </select>
        </div>
    `;
    container.appendChild(newItem);
}
</script>
</body>
</html>
