<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .table thead th {
            background-color: #f8f9fc;
            border-bottom: 2px solid #e3e6f0;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            color: #5a5c69;
            white-space: nowrap;
        }

        .table tbody tr:hover {
            background-color: #f1f4ff;
        }

        .table td {
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .avatar-img {
            width: 46px;
            height: 46px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #e3e6f0;
        }

        .avatar-placeholder {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background-color: #e3e6f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #b7b9cc;
            font-size: 1.2rem;
        }

        .chip {
            display: inline-block;
            background-color: #eef1fb;
            color: #4e73df;
            border-radius: 1rem;
            padding: 0.2rem 0.65rem;
            font-size: 0.75rem;
            font-weight: 500;
            margin: 0 0.2rem 0.2rem 0;
            white-space: nowrap;
        }

        .chip-muted {
            background-color: #f1f1f1;
            color: #9a9a9a;
        }

        .text-truncate-cell {
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
            vertical-align: middle;
        }

        .btn-sm {
            border-radius: 0.5rem;
        }
    </style>
</head>

<body>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Country Code</th>
                    <th>Mobile</th>
                    <th>Gender</th>
                    <th>Hobbies</th>
                    <th>Address</th>
                    <th>Qualification</th>
                    <th>College</th>
                    <th>Passing Year</th>
                    <th>Preferred Locations</th>
                    <th>Skills</th>
                    <th>Employment Type</th>
                    <th>Status</th>
                    <?php if (in_array($role, array('admin', 'manager'))) { ?>
                        <th class="text-center">Action</th>
                    <?php } ?>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($users)) { ?>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td>
                                <?= $user->id; ?>
                            </td>
                            <td>
                                <?php if (!empty($user->photo)) { ?>
                                    <img src="<?= base_url('uploads/' . $user->photo); ?>" class="avatar-img">
                                <?php } else { ?>
                                    <div class="avatar-placeholder"><i class="bi bi-person-fill"></i></div>
                                <?php } ?>
                            </td>
                            <td>
                                <?= $user->name; ?>
                            </td>
                            <td>
                                <?= $user->email; ?>
                            </td>
                            <td>
                                <?= $user->country_code; ?>
                            </td>
                            <td>
                                <?= $user->mobile; ?>
                            </td>
                            <td>
                                <?php if (strtolower($user->gender) == 'male') { ?>
                                    <span class="badge bg-primary">Male</span>
                                <?php } elseif (strtolower($user->gender) == 'female') { ?>
                                    <span class="badge bg-danger">Female</span>
                                <?php } else { ?>
                                    <span class="badge bg-secondary">
                                        <?= $user->gender; ?>
                                    </span>
                                <?php } ?>
                            </td>
                            <td>
                                <?= $user->hobbies; ?>
                            </td>
                            <td>
                                <?= $user->address; ?>
                            </td>
                            <td>
                                <?= $user->qualification ?? '-'; ?>
                            </td>
                            <td>
                                <?= $user->college ?? '-'; ?>
                            </td>
                            <td>
                                <?= $user->passing_year ?? '-'; ?>
                            </td>
                            <td>
                                <?= !empty($user->location_names) ? $user->location_names : '-'; ?>
                            </td>
                            <td>
                                <?= !empty($user->skill_names) ? $user->skill_names : '-'; ?>
                            </td>
                            <td>
                                <?= !empty($user->employment_names) ? $user->employment_names : '-'; ?>
                            </td>

                            <td>
                                <?php if ($user->status == 'verified') { ?>
                                    <span class="badge bg-success">Verified</span>
                                <?php } elseif ($user->status == 'rejected') { ?>
                                    <span class="badge bg-danger">Rejected</span>
                                <?php } else { ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php } ?>
                            </td>

                            <?php if (in_array($role, array('admin', 'manager'))) { ?>
                                <td class="text-center text-nowrap">

                                    <a href="<?= site_url('Users/edit/' . $user->id); ?>" class="btn btn-warning btn-sm"
                                        title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <?php if ($user->status == 'pending') { ?>
                                        <a href="<?= site_url('Users/verify/' . $user->id); ?>" class="btn btn-success btn-sm"
                                            title="Verify" onclick="return confirm('Verify this user?');">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </a>

                                        <a href="<?= site_url('Users/reject/' . $user->id); ?>" class="btn btn-secondary btn-sm"
                                            title="Reject" onclick="return confirm('Reject this user?');">
                                            <i class="bi bi-x-circle-fill"></i>
                                        </a>
                                    <?php } ?>

                                    <?php if ($role == 'admin') { ?>
                                        <a href="<?= site_url('Users/delete/' . $user->id); ?>" class="btn btn-danger btn-sm"
                                            title="Delete" onclick="return confirm('Are you sure you want to delete this user?');">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    <?php } ?>

                                </td>
                            <?php } ?>

                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="17" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            No Records Found
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <?= $pagination_links; ?>
    </div>

</body>

</html>