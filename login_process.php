<?php
session_start();
include('db_connect.php');

// Collect and sanitize input
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = $_POST['password'];

// Fetch user from DB
$query = "SELECT * FROM user WHERE Email = '$email'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    if (password_verify($password, $user['Password'])) {
        // Save user session
        $_SESSION['user_id'] = $user['User_id'];
        $_SESSION['username'] = $user['User_name'];

        // Log user access
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $device_info = $_SERVER['HTTP_USER_AGENT'];
        $user_id = $user['User_id'];

        $log_sql = "INSERT INTO user_access_log (user_id, ip_address, device_info)
                    VALUES ('$user_id', '$ip_address', '$device_info')";
        mysqli_query($conn, $log_sql);

        // Redirect with success SweetAlert
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        Swal.fire({
            title: "Login Successful",
            text: "Welcome, ' . $user['User_name'] . '!",
            icon: "success"
        }).then(() => {
            window.location.href = "dist/pages/Admin/dsshboard.php"; // Your dashboard page
        });
        </script>';
        exit;
    }
}

// If login failed
echo '
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    title: "Login Failed",
    text: "Invalid email or password.",
    icon: "error"
}).then(() => {
    window.location.href = "index.php";
});
</script>';
exit;
?>
