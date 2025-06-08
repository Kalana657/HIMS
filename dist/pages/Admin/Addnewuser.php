<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>HIMS ADMIN | Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="adminstyle.css" rel="stylesheet">
</head>

<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <?php include('Slide_bar.php'); ?>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
            <?php include('Topbar.php'); ?>

            <?php
            if (isset($_SESSION['status'])) {
                echo '
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    Swal.fire({
                        title: "' . ucfirst($_SESSION['status']) . '!",
                        text: "' . $_SESSION['message'] . '",
                        icon: "' . $_SESSION['status'] . '",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "Addnewuser.php";
                    });
                </script>';
                
                unset($_SESSION['status']);
                unset($_SESSION['message']);
            }
            ?>

            <div class="container mt-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Add New User</h5>
                    </div>
                    <div class="card-body">
                        <form action="add_user.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="role">User Role</label>
                                <select id="role" name="role" class="form-control" required>
                                    <option value="">-- Select Role --</option>
                                    <?php
                                    include('db_connect.php');
                                    $query = "SELECT Role_id, Role_name FROM user_role";
                                    $result = mysqli_query($conn, $query);

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row['Role_id'] . '">' . htmlspecialchars($row['Role_name']) . '</option>';
                                        }
                                    } else {
                                        echo '<option disabled>No roles found</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group mb-3" id="unitField" style="display: none;">
                                <label for="unit">Unit</label>
                                <select id="unit" name="unit" class="form-control">
                                    <option value="">-- Select Unit --</option>
                                    <?php
                                    $unitQuery = "SELECT unit_id, unit_name FROM units";
                                    $unitResult = mysqli_query($conn, $unitQuery);
                                    
                                    if ($unitResult && mysqli_num_rows($unitResult) > 0) {
                                        while ($unit = mysqli_fetch_assoc($unitResult)) {
                                            echo '<option value="' . $unit['unit_id'] . '">' . htmlspecialchars($unit['unit_name']) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success mt-3">Create User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Show/hide unit field based on role selection
            $('#role').change(function() {
                if ($(this).val() == '4') {
                    $('#unitField').show();
                    $('#unit').prop('required', true);
                } else {
                    $('#unitField').hide();
                    $('#unit').prop('required', false);
                }
            });
        });
    </script>
</body>
</html>