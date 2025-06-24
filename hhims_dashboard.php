
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HHIMS </title>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --hhims-primary: #4361ee;
            --hhims-secondary: #3a0ca3;
            --hhims-accent: #4cc9f0;
            --hhims-light: #f8f9fa;
            --hhims-dark: #212529;
            --hhims-gray: #6c757d;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: white;
        }

        .login-header {
            background: linear-gradient(135deg, var(--hhims-primary) 0%, var(--hhims-secondary) 100%);
            color: white;
            padding: 1.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: "";
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -50px;
            right: -50px;
        }

        .login-header::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }

        .logo {
            height: 150px;
            margin-bottom: 1rem;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .login-body {
            padding: 2rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid #e1e5eb;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--hhims-primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.2);
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
        }

        .input-with-icon {
            border-left: none;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--hhims-primary) 0%, var(--hhims-secondary) 100%);
            border: none;
            padding: 0.75rem;
            font-weight: 500;
            width: 100%;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .forgot-password {
            color: var(--hhims-gray);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--hhims-primary);
        }

        .footer-text {
            color: var(--hhims-gray);
            font-size: 0.75rem;
            text-align: center;
            margin-top: 1.5rem;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        .google-btn { background-color: #DB4437; }
        .microsoft-btn { background-color: #0078D4; }
        .apple-btn { background-color: #000000; }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="card login-card">
            <!-- Header with Gradient Background -->
            <div class="login-header">
                <img src="images/hhims_logo.png" alt="HHIMS Logo" class="logo">
                <h4 class="mb-0">Hospital Health Information Management System</h4>
            </div>

            <!-- Login Form -->
            <div class="login-body">
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control input-with-icon" id="username" placeholder="Enter username" name="username" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control input-with-icon" id="password" placeholder="Enter password" name="password" required>
                        </div>
                    </div>
                       <div class="mb-3">
                        <label for="unit" class="form-label">Select Unit</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                             <?php include('db_connect.php'); ?> 

                                <select class="form-control input-with-icon" id="unit" name="unit" required>
                                    <option value="">-- Select Unit --</option>
                                    <?php
                                        $sql = "SELECT unit_id, unit_name, description FROM units";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo '<option value="' . $row["unit_id"] . '">' . htmlspecialchars($row["unit_name"]) . ' (' . htmlspecialchars($row["description"]) . ')</option>';
                                            }
                                        } else {
                                            echo '<option disabled>No units found</option>';
                                        }

                                        $conn->close();
                                    ?>
                                </select>

                        </div>
                      </div>




                    

                    <button type="submit" class="btn btn-login mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </button>

                   
                  
                   
                </form>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

