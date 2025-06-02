   <div class="topbar">
                <div class="page-title">
                    <h1>Administrator Dashboard</h1>
                    <p>Welcome back, <?= $_SESSION['username']; ?>. Here's your system overview</p>
                </div>
                <div class="topbar-actions">
                    <div class="search-bar">
                        <input type="text" class="form-control" placeholder="Search inventory...">
                        <button class="btn btn-primary position-absolute end-0 top-0 h-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <div class="user-info">
                        <button class="btn btn-light position-relative">
                            <i class="bi bi-bell fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                5
                            </span>
                        </button>
                        <div class="dropdown">
                            <div class="d-flex align-items-center" data-bs-toggle="dropdown">
                                <div class="user-avatar">AD</div>
                                <div class="ms-2 d-none d-md-block">
                                    <p class="mb-0 fw-medium"><?= $_SESSION['username']; ?></p>
                                    <small class="text-muted">Administrator</small>
                                </div>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>