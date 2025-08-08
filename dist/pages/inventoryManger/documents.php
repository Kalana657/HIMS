<?php
include 'db_connect.php';

$type_filter = isset($_GET['type']) ? mysqli_real_escape_string($conn, $_GET['type']) : '';
$query = "SELECT * FROM documents";
if ($type_filter) {
    $query .= " WHERE document_type = '$type_filter'";
}
$query .= " ORDER BY created_at DESC";
$documents = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Document Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h3 class="mb-4">Hospital Documentation Center</h3>
    <form method="GET" class="mb-3">
        <div class="input-group">
            <select name="type" class="form-select">
                <option value="">-- All Types --</option>
                <option value="Drug Complaint">Drug Complaint</option>
                <option value="Report">Report</option>
                <option value="Lab Result">Lab Result</option>
                <option value="Purchase Order">Purchase Order</option>
            </select>
            <button class="btn btn-outline-primary">Filter</button>
        </div>
    </form>
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Document Name</th>
                <th>Type</th>
                <th>View</th>
                <th>Export PDF</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; while($doc = mysqli_fetch_assoc($documents)): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($doc['document_name']) ?></td>
                <td><?= htmlspecialchars($doc['document_type']) ?></td>
                <td>
                    <a href="view_document.php?table=<?= urlencode($doc['related_table']) ?>&id=<?= $doc['related_record_id'] ?>" class="btn btn-sm btn-primary">
                        View
                    </a>
                </td>
                <td>
                    <a href="export_pdf.php?table=<?= urlencode($doc['related_table']) ?>&id=<?= $doc['related_record_id'] ?>" class="btn btn-danger btn-sm">
                        Export PDF
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
