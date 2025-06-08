<?php

include('db_connect.php'); 

$unitName = "HIMS"; // Default value
if (isset($_SESSION['unitin_id']) && isset($_SESSION['user_id'])) {
    $unitQuery = "SELECT units.unit_name
                  FROM units
                  JOIN user ON units.unit_id = user.unitin_id
                  WHERE user.User_id = ?";
    $stmt = $conn->prepare($unitQuery);
    $stmt->bind_param("i", $_SESSION['user_id']); // Use user_id from session
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $unit = $result->fetch_assoc();
        $unitName = $unit['unit_name'];
    }
    $stmt->close();
}

// Fetch user details if user_id is set in session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$email = isset($_SESSION['Email']) ? $_SESSION['Email'] : 'N/A';
$userInitials = isset($_SESSION['username']) ? strtoupper(substr($username, 0, 2)) : 'GU';
?>

<header class="unit-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="unit-info">
                <div class="unit-icon">
                    <i class="bi bi-heart-pulse"></i>
                </div>
                <div class="unit-title">
                    <h2><?= htmlspecialchars($unitName) ?></h2>
                    
                </div>
            </div>
            <div class="d-flex align-items-center gap-4">
                <div class="position-relative">
                    <button class="btn btn-light position-relative">
                        <i class="bi bi-bell fs-5"></i>
                        <span class="notification-badge">3</span>
                    </button>
                </div>
                <div class="dropdown">
                    <div class="d-flex align-items-center" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            <?= $userInitials ?>
                        </div>
                        <div class="ms-2">
                            <p class="mb-0 fw-medium">
                                <?= htmlspecialchars($username) ?>
                                (ID: <?= htmlspecialchars($_SESSION['unitin_id'] ?? 'N/A') ?>)
                            </p>
                            <small>Unit Incharge</small>
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="unit-stats">
            <div class="unit-stat">
                <h3>24</h3>
                <p>Current Patients</p>
            </div>
            <div class="unit-stat">
                <h3>18</h3>
                <p>Active Medications</p>
            </div>
            <div class="unit-stat">
                <h3>5</h3>
                <p>Low Stock Items</p>
            </div>
            <div class="unit-stat">
                <h3>12</h3>
                <p>Pending Requests</p>
            </div>
        </div>
    </div>
</header>