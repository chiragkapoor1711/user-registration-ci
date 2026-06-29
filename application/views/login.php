<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            display: flex;
            align-items: center;
        }
        .card {
            border: none;
            border-radius: 1rem;
        }
        .card-header {
            border-radius: 1rem 1rem 0 0 !important;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
            padding: 2rem 1rem;
        }
        .card-header i {
            font-size: 2.5rem;
        }
        .form-control {
            border-radius: 0.6rem;
            padding: 0.65rem 1rem;
        }
        .btn {
            border-radius: 0.6rem;
            padding: 0.65rem 1rem;
            font-weight: 500;
        }
        .input-group-text {
            border-radius: 0.6rem 0 0 0.6rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-lg">
                <div class="card-header text-white text-center">
                    <i class="bi bi-shield-lock-fill mb-2 d-block"></i>
                    <h3 class="mb-0">Welcome Back</h3>
                    <small class="opacity-75">Please login to your account</small>
                </div>

                <div class="card-body p-4">

                    <form method="post" action="<?= site_url('Auth/check_login'); ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                <input type="text"
                                       name="username"
                                       class="form-control"
                                       placeholder="Enter your username"
                                       required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="Enter your password"
                                       required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </button>

                        <div class="text-center mt-3">
                            <span class="text-muted">Don't have an account?</span>
                            <a href="<?= site_url('Auth/signup'); ?>"
                               class="text-decoration-none fw-semibold">
                                Sign Up
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>


</body>
</html>