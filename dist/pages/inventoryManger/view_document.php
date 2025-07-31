<?php
include 'db_connect.php';

$table = mysqli_real_escape_string($conn, $_GET['table']);
$id = intval($_GET['id']);

$allowed_tables = ['drug_complaints']; // Add other table names here for security

if (!in_array($table, $allowed_tables)) {
    die("Unauthorized table access.");
}

$query = "SELECT * FROM `$table` WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h3 class="mb-3">Document Details from <?= htmlspecialchars($table) ?></h3>

    <?php if ($data): ?>
        <table class="table table-striped">
            <?php foreach ($data as $key => $value): ?>
                <tr>
                    <th><?= htmlspecialchars(ucwords(str_replace('_', ' ', $key))) ?></th>
                    <td><?= htmlspecialchars($value) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <div class="alert alert-danger">Document not found.</div>
    <?php endif; ?>

    <a href="documents.php" class="btn btn-secondary mt-3">Back to Document List</a>
</body>
</html>
