<!DOCTYPE html>
<html>
<head>
    <title>Add Login User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .card { border: none; border-radius: 1rem; }
        .card-header {
            border-radius: 1rem 1rem 0 0 !important;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        }
        .form-control, .form-select { border-radius: 0.6rem; padding: 0.65rem 1rem; }
        .btn { border-radius: 0.6rem; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg">
                <div class="card-header text-white text-center p-4">
                    <i class="bi bi-person-plus-fill mb-2 d-block fs-2"></i>
                    <h4 class="mb-0">Add New Login User</h4>
                    <small class="opacity-75">Only admin can create accounts with a role</small>
                </div>

                <div class="card-body p-4">
                    <form method="post" action="<?= site_url('Auth/store_user'); ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="user">User (view only)</option>
                                <option value="manager">Manager (view + edit)</option>
                                <option value="admin">Admin (full access)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle me-1"></i> Create Account
                        </button>

                        <a href="<?= site_url('Auth/manage_users'); ?>" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>