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
        :root {
    --primary: #1a76d2;
    --secondary: #2e7d32;
    --accent: #ff6f00;
    --light-bg: #f8f9fa;
    --dark-text: #2c3e50;
    --unit-blue: #1976d2;
    --unit-green: #388e3c;
    --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

/* Global Reset */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f7ff;
    color: var(--dark-text);
    margin: 0;
    overflow-x: hidden;
}

/* Fixed Vertical Sidebar */
.sidebar-unit {
    width: 80px;
    background: white;
    border-right: 1px solid #e9ecef;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px 0;
    z-index: 1000;
}

.sidebar-unit .nav-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 15px 0;
    padding: 10px 15px;
    color: #6c757d;
    font-weight: 500;
    font-size: 14px;
    text-align: center;
    text-decoration: none;
    transition: all 0.3s;
    width: 100%;
}

.sidebar-unit .nav-link i {
    font-size: 1.5rem;
    margin-bottom: 5px;
}

.sidebar-unit .nav-link.active,
.sidebar-unit .nav-link:hover {
    background: rgba(25, 118, 210, 0.1);
    color: var(--unit-blue);
    border-radius: 10px;
}

/* Main content area next to sidebar */
.main-content {
    margin-left: 80px;
    padding: 30px;
}

/* Top Navigation Tabs (inside main content) */
.nav-unit {
    background: white;
    border-radius: 15px;
    padding: 10px;
    display: flex;
    margin-bottom: 25px;
    box-shadow: var(--card-shadow);
    justify-content: space-around;
}

.nav-unit .nav-link {
    flex: 1;
    text-align: center;
    padding: 12px;
    border-radius: 10px;
    color: #6c757d;
    font-weight: 500;
    transition: all 0.3s;
}

.nav-unit .nav-link.active {
    background: rgba(25, 118, 210, 0.1);
    color: var(--unit-blue);
}

/* Header Styles */
.unit-header {
    background: linear-gradient(120deg, var(--unit-blue), var(--unit-green));
    color: white;
    padding: 25px 30px;
    border-radius: 0 0 20px 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

/* Cards */
.card-unit {
    background: white;
    border-radius: 15px;
    box-shadow: var(--card-shadow);
    border: none;
    margin-bottom: 25px;
    transition: all 0.3s;
    border-top: 4px solid var(--unit-blue);
}

.card-unit:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.card-header-unit {
    background: rgba(25, 118, 210, 0.05);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 15px 20px;
    border-radius: 15px 15px 0 0;
    font-weight: 600;
    color: var(--unit-blue);
}

/* Buttons */
.btn-unit {
    background: var(--unit-blue);
    border-color: var(--unit-blue);
    color: white;
    border-radius: 10px;
    padding: 8px 20px;
    font-weight: 500;
}

.btn-unit:hover {
    background: #1565c0;
    border-color: #1565c0;
}

.btn-unit-outline {
    border-color: var(--unit-blue);
    color: var(--unit-blue);
    border-radius: 10px;
    padding: 8px 20px;
    font-weight: 500;
}

.btn-unit-outline:hover {
    background: var(--unit-blue);
    color: white;
}

/* Utility */
.badge-unit {
    background: rgba(25, 118, 210, 0.1);
    color: var(--unit-blue);
    padding: 4px 12px;
    border-radius: 20px;
    font-weight: 500;
    font-size: 13px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
        padding: 15px;
    }

    .sidebar-unit {
        position: relative;
        width: 100%;
        height: auto;
        flex-direction: row;
        justify-content: space-around;
        border-right: none;
        border-bottom: 1px solid #e9ecef;
    }

    .sidebar-unit .nav-link {
        flex: 1;
        margin: 0;
        font-size: 12px;
    }

    .nav-unit {
        flex-direction: column;
    }

    .nav-unit .nav-link {
        margin-bottom: 5px;
    }
}

    </style>
</head>
<body>
<?php include('slide_bar.php') ?>

   
 <div class="main-content">
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
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
