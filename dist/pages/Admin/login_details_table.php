<?php
session_start();
include('db_connect.php');

// Fetch user logs with role name
$sql = "SELECT
            u.user_id,
            u.user_name,
            u.email,
            r.role_id,
            r.role_name,
            u.unitin_id,
            u.update_time,
            l.log_id,
            l.login_time,
            l.logout_time,
            l.ip_address,
            l.device_info
        FROM user_access_log l
        JOIN user u ON l.user_id = u.user_id
        JOIN user_role r ON u.role_id = r.role_id
        ORDER BY l.login_time DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link href="adminstyle.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
     <?php
       include('Slide_bar.php');

     ?>

     
        <div class="main-content">
            <!-- Topbar -->
           <?php
             include('Topbar.php');

           ?>
      
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Log ID</th>
                <th>User ID</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Unit ID</th>
                <th>Last Update</th>
                <th>Login Time</th>
              
                <th>IP Address</th>
                <th>Device Info</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['log_id']) ?></td>
                        <td><?= htmlspecialchars($row['user_id']) ?></td>
                        <td><?= htmlspecialchars($row['user_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['role_name']) ?> (ID: <?= htmlspecialchars($row['role_id']) ?>)</td>
                        <td><?= htmlspecialchars($row['unitin_id']) ?></td>
                        <td><?= htmlspecialchars($row['update_time']) ?></td>
                        <td><?= htmlspecialchars($row['login_time']) ?></td>
                        
                        <td><?= htmlspecialchars($row['ip_address']) ?></td>
                        <td><?= htmlspecialchars($row['device_info']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="11" class="text-center">No access logs found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
