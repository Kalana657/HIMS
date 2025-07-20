<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>HIMS | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" />
    
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" />

    <link rel="stylesheet" href="dist/css/adminlte.css" />
    <link rel="stylesheet" href="dist/css/newadd.css" />

    <style>
     
    </style>
  </head>

  <body class="login-page bg-body-secondary">
    <div class="login-box">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <a href="../index2.html">
            <img src="images/logo.jpeg" alt="Logo" class="logo-img" />
          </a>
        </div>

        <div class="card-body login-card-body">
          <p class="login-box-msg">Hospital Inventory Management System</p>

       
          <form action="login_process.php" method="POST" class="mt-4">
            <div class="input-group mb-3">
              <div class="form-floating flex-grow-1">
                <input
                  id="loginEmail"
                  name="email"
                  type="text"
                  class="form-control"
                  placeholder="name@example.com"
                  required
                />
                <label for="loginEmail">User Name</label>
              </div>
              <span class="input-group-text"><i class="bi bi-person"></i></span>
            </div>

            <div class="input-group mb-3">
              <div class="form-floating flex-grow-1">
                <input
                  id="loginPassword"
                  name="password"
                  type="password"
                  class="form-control"
                  placeholder="Password"
                  required
                />
                <label for="loginPassword">Password</label>
              </div>
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            </div>

            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-primary">Sign In</button>
            </div>
          </form>

          <a href="forgot-password.html" class="forgot-link">Forgot your password?</a>
        </div>
      </div>
    </div>
  </body>
</html>
