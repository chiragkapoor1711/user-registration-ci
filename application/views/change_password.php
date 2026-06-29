<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            display: flex;
            align-items: center;
        }
        .card { border: none; border-radius: 1rem; }
        .card-header {
            border-radius: 1rem 1rem 0 0 !important;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
            padding: 2rem 1rem;
        }
        .form-control { border-radius: 0.6rem; padding: 0.65rem 1rem; }
        .btn { border-radius: 0.6rem; padding: 0.65rem 1rem; font-weight: 500; }
        .input-group-text { border-radius: 0.6rem 0 0 0.6rem; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-lg">
                <div class="card-header text-white text-center">
                    <i class="bi bi-key-fill mb-2 d-block fs-2"></i>
                    <h3 class="mb-0">Change Password</h3>
                    <small class="opacity-75">Keep your account secure</small>
                </div>

                <div class="card-body p-4">

                    <form method="post" action="<?= site_url('Auth/update_password'); ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Old Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="old_password" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-key-fill"></i></span>
                                <input type="password" name="new_password" class="form-control" required minlength="6">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-key-fill"></i></span>
                                <input type="password" name="confirm_password" class="form-control" required minlength="6">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle me-1"></i> Update Password
                        </button>

                        <a href="<?= site_url('Users/users_list'); ?>" class="btn btn-outline-secondary w-100 mt-2">
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