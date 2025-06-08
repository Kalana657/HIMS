<?php
session_start();
include('db_connect.php');
$unitid = isset($_SESSION['unitin_id']) ? intval($_SESSION['unitin_id']) : 0;

if ($unitid === 0) {
    header("Location: login.php");
    exit();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'request';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HIMS - Unit Incharge Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="sub_style.css" rel="stylesheet">
    <style>
        .nav-unit a.nav-link.active {
            background-color: var(--unit-blue, #1976d2);
            color: white;
        }
    </style>
</head>
<body>

<?php include('header.php'); ?>

<!-- Top Navigation -->
<div class="container-fluid">
    <div class="nav-unit d-flex gap-3 p-3">
        <a class="nav-link <?php echo ($page == 'request' || !isset($_GET['page'])) ? 'active' : ''; ?>" href="?page=request">
            <i class="bi bi-tools me-2"></i>Request Repair
        </a>
        <a class="nav-link <?php echo ($page == 'records') ? 'active' : ''; ?>" href="?page=records">
            <i class="bi bi-table me-2"></i>Repair Records
        </a>
    </div>
</div>

<!-- Dashboard Content -->
<div class="container-fluid p-3">
    <?php if (isset($_SESSION['status']) && isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['status'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['status'], $_SESSION['message']); ?>
    <?php endif; ?>

    <?php
    if ($page === 'records') {
        // Show repair records
        include('repair_records.php');
    } else {
        // Show repair request form (your existing content)
        include('repair_request_section.php');
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
