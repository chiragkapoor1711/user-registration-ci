<!DOCTYPE html>
<html>
<head>
    <title>Manage Users & Roles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .page-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border-radius: 1rem;
            padding: 1.5rem 2rem;
            color: #fff;
            margin-bottom: 1.5rem;
        }
        .card { border: none; border-radius: 1rem; }
        .form-select { border-radius: 0.5rem; }
        .btn { border-radius: 0.6rem; }
    </style>
</head>
<body>

<div class="container mt-5">

    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2 class="mb-0"><i class="bi bi-shield-lock-fill me-2"></i>Manage Login Accounts</h2>
            <small class="opacity-75">Assign or change roles for each account</small>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= site_url('Auth/add_user'); ?>" class="btn btn-light">
                <i class="bi bi-person-plus-fill me-1"></i> Add New Login User
            </a>
            <a href="<?= site_url('Users/users_list'); ?>" class="btn btn-outline-light">
                <i class="bi bi-arrow-left me-1"></i> Back to Data
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Current Role</th>
                        <th>Change Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts as $acc) { ?>
                        <tr>
                            <td><?= $acc->id; ?></td>
                            <td class="fw-semibold"><?= $acc->username; ?></td>
                            <td>
                                <?php
                                    $badgeClass = $acc->role == 'admin' ? 'bg-danger'
                                                : ($acc->role == 'manager' ? 'bg-warning text-dark' : 'bg-secondary');
                                ?>
                                <span class="badge <?= $badgeClass; ?>"><?= ucfirst($acc->role); ?></span>
                            </td>
                            <td>
                                <?php if ($acc->username != $this->session->userdata('username')) { ?>
                                    <form method="post" action="<?= site_url('Auth/update_role/'.$acc->id); ?>" class="d-flex gap-2">
                                        <select name="role" class="form-select form-select-sm" style="width:140px;">
                                            <option value="user"    <?= $acc->role=='user'    ? 'selected' : ''; ?>>User</option>
                                            <option value="manager" <?= $acc->role=='manager' ? 'selected' : ''; ?>>Manager</option>
                                            <option value="admin"   <?= $acc->role=='admin'   ? 'selected' : ''; ?>>Admin</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-check-lg"></i> Save
                                        </button>
                                    </form>
                                <?php } else { ?>
                                    <span class="text-muted small">— You can't change your own role —</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>