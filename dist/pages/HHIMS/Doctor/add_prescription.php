<?php
session_start();
include('db_connect.php');

// Make sure the user is logged in and unit ID is available
if (!isset($_SESSION['unitin_id'])) {
    die("Access denied. Please login first.");
}

$unit_id = $_SESSION['unitin_id'];

if (!isset($_GET['pid'])) {
    die("Patient ID is missing.");
}

$patient_id = $_GET['pid'];

// Fetch patient details
$stmt = $conn->prepare("SELECT fname, lname, dob FROM patients WHERE patient_id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$patient_result = $stmt->get_result();

if ($patient_result->num_rows !== 1) {
    die("Patient not found.");
}

$patient = $patient_result->fetch_assoc();

// Prepare select options for drug names (reused in JavaScript)
$drugOptionsHTML = "";
$drug_result = $conn->query("SELECT * FROM item_distributions
    JOIN units ON units.unit_id = item_distributions.unit_id
    JOIN inventory_item ON inventory_item.item_id = item_distributions.item_id
    WHERE item_distributions.unit_id = $unit_id AND inventory_item.type_id = 2");

while ($d = $drug_result->fetch_assoc()) {
    $drugOptionsHTML .= '<option value="' . htmlspecialchars($d['item_name']) . '">' . htmlspecialchars($d['item_name']) . '</option>';
}

// Handle prescription form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $diagnosis = $_POST['diagnosis'];
    $notes = $_POST['notes'];
    $prescribed_by = $_POST['prescribed_by'];

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO prescriptions (patient_id, unit_id, diagnosis, notes, prescribed_by) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $patient_id, $unit_id, $diagnosis, $notes, $prescribed_by);
        $stmt->execute();
        $prescription_id = $stmt->insert_id;

        foreach ($_POST['drug_name'] as $i => $drug_name) {
            if (!empty($drug_name)) {
                $dose = $_POST['dose'][$i];
                $frequency = $_POST['frequency'][$i];
                $duration = $_POST['duration'][$i];
                $route = $_POST['route'][$i];
                $instructions = $_POST['instructions'][$i];

                $stmt_item = $conn->prepare("INSERT INTO prescription_items (prescription_id, drug_name, dose, frequency, duration, route, instructions) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt_item->bind_param("issssss", $prescription_id, $drug_name, $dose, $frequency, $duration, $route, $instructions);
                $stmt_item->execute();
            }
        }

        $conn->commit();
        echo "<script>alert('Prescription added successfully!'); window.location.href = 'patients_by_unit.php';</script>";
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
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
    <h3 class="mb-4 text-primary">Prescription for <?= htmlspecialchars($patient['fname'] . ' ' . $patient['lname']) ?> (DOB: <?= $patient['dob'] ?>)</h3>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Diagnosis</label>
            <textarea class="form-control" name="diagnosis" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Additional Notes</label>
            <textarea class="form-control" name="notes"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Prescribed By</label>
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
                <div class="col-md-2"><input type="text" name="dose[]" class="form-control" placeholder="Dose"></div>
                <div class="col-md-2">
                    <select name="frequency[]" class="form-control">
                        <option value="">-- Frequency --</option>
                        <option value="Once daily">Once daily</option>
                        <option value="Twice daily">Twice daily</option>
                        <option value="Thrice daily">Thrice daily</option>
                        <option value="Every 6 hours">Every 6 hours</option>
                        <option value="As needed">As needed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="duration[]" class="form-control">
                        <option value="">-- Duration --</option>
                        <option value="3 days">3 days</option>
                        <option value="5 days">5 days</option>
                        <option value="7 days">7 days</option>
                        <option value="10 days">10 days</option>
                        <option value="14 days">14 days</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="route[]" class="form-control">
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
        <div class="col-md-2"><input type="text" name="dose[]" class="form-control" placeholder="Dose"></div>
        <div class="col-md-2">
            <select name="frequency[]" class="form-control">
                <option value="">-- Frequency --</option>
                <option value="Once daily">Once daily</option>
                <option value="Twice daily">Twice daily</option>
                <option value="Thrice daily">Thrice daily</option>
                <option value="Every 6 hours">Every 6 hours</option>
                <option value="As needed">As needed</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="duration[]" class="form-control">
                <option value="">-- Duration --</option>
                <option value="3 days">3 days</option>
                <option value="5 days">5 days</option>
                <option value="7 days">7 days</option>
                <option value="10 days">10 days</option>
                <option value="14 days">14 days</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="route[]" class="form-control">
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
