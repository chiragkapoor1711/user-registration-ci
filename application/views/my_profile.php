<!DOCTYPE html>
<html>

<head>
    <title>My Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .profile-img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #0d6efd;
        }

        .table td {
            padding: 12px;
        }
    </style>

</head>

<body>

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-header bg-primary text-white text-center">
                <h3><i class="bi bi-person-circle"></i> My Profile</h3>

                <div class="mt-2">
                    <?php if ($user->status == 'verified') { ?>
                        <span class="badge bg-success"><i class="bi bi-patch-check-fill"></i> Verified Profile</span>
                    <?php } elseif ($user->status == 'rejected') { ?>
                        <span class="badge bg-danger"><i class="bi bi-x-circle-fill"></i> Profile Rejected</span>
                    <?php } else { ?>
                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Pending
                            Verification</span>
                    <?php } ?>
                </div>
            </div>

            <div class="card-body">

                <div class="text-center mb-4">
                    <?php if (!empty($user->photo)) { ?>
                        <img src="<?= base_url('uploads/' . $user->photo); ?>" class="profile-img">
                    <?php } else { ?>
                        <img src="<?= base_url('uploads/default.png'); ?>" class="profile-img">
                    <?php } ?>
                </div>

                <table class="table table-bordered">

                    <tr>
                        <th width="30%">Name</th>
                        <td><?= $user->name; ?></td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td><?= $user->email; ?></td>
                    </tr>

                    <tr>
                        <th>Country Code</th>
                        <td><?= $user->country_code; ?></td>
                    </tr>

                    <tr>
                        <th>Mobile</th>
                        <td><?= $user->mobile; ?></td>
                    </tr>

                    <tr>
                        <th>Gender</th>
                        <td><?= $user->gender; ?></td>
                    </tr>

                    <tr>
                        <th>Hobbies</th>
                        <td><?= $user->hobbies; ?></td>
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td><?= $user->address; ?></td>
                    </tr>

                    <tr>
                        <th>Qualification</th>
                        <td><?= !empty($education) ? $education->qualification_name : ''; ?></td>
                    </tr>

                    <tr>
                        <th>College</th>
                        <td><?= !empty($education) ? $education->college : ''; ?></td>
                    </tr>

                    <tr>
                        <th>Passing Year</th>
                        <td><?= !empty($education) ? $education->passing_year : ''; ?></td>
                    </tr>

                    <!-- Preferred Locations -->
                    <tr>
                        <th>Preferred Locations</th>
                        <td>
                            <?php
                            if (!empty($locations)) {
                                echo implode(', ', array_column($locations, 'location_name'));
                            }
                            ?>
                        </td>
                    </tr>

                    <!-- Skills (multiple) -->
                    <tr>
                        <th>Skills</th>
                        <td>
                            <?php
                            if (!empty($skills)) {
                                echo implode(', ', array_column($skills, 'skill_name'));
                            }
                            ?>
                        </td>
                    </tr>

                    <!-- Employment Type -->
                    <tr>
                        <th>Employment Type</th>
                        <td>
                            <?php
                            if (!empty($employment)) {
                                echo implode(', ', array_column($employment, 'type_name'));
                            }
                            ?>
                        </td>
                    </tr>

                    <!-- Languages -->
                    <tr>
                        <th>Languages</th>
                        <td>
                            <?php if (!empty($languages)) { ?>
                                <ul class="mb-0 ps-3">
                                    <?php foreach ($languages as $lang) { ?>
                                        <li><?= $lang->language_name; ?> — <?= $lang->level_name; ?></li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </td>
                    </tr>

                    <!-- Resume -->
                    <tr>
                        <th>Resume</th>
                        <td>
                            <?php if (!empty($resume->resume)) { ?>
                                <a href="<?= base_url('uploads/resume/' . $resume->resume); ?>" target="_blank">
                                    <i class="bi bi-file-earmark-text"></i> View Resume
                                </a>
                            <?php } else { ?>
                                Not uploaded
                            <?php } ?>
                        </td>
                    </tr>

                </table>

                <div class="text-center mt-4">

                    <a href="<?= site_url('Users/edit/' . $user->id); ?>" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Edit Profile
                    </a>

                    <a href="<?= site_url('Auth/change_password'); ?>" class="btn btn-warning">
                        <i class="bi bi-key-fill"></i> Change Password
                    </a>

                    <a href="<?= site_url('Auth/logout'); ?>" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>

</html>