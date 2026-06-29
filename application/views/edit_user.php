<!DOCTYPE html>
<html>

<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .card {
            border: none;
            border-radius: 1rem;
        }
        .card-header {
            border-radius: 1rem 1rem 0 0 !important;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
            padding: 1.75rem 1rem;
        }
        .card-header i {
            font-size: 2.2rem;
        }
        .form-control, .form-select {
            border-radius: 0.6rem;
            padding: 0.65rem 1rem;
        }
        .btn {
            border-radius: 0.6rem;
            padding: 0.65rem 1rem;
            font-weight: 500;
        }
        .section-label {
            font-weight: 600;
            color: #4e4e4e;
        }
        .form-check-inline {
            margin-right: 1.25rem;
        }
        .sub-section-title {
            font-weight: 700;
            color: #4e73df;
            border-bottom: 2px solid #e3e6f0;
            padding-bottom: 0.5rem;
            margin-bottom: 1.25rem;
        }
        .sub-section-title.skills {
            color: #1cc88a;
        }
    </style>
</head>

<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-lg">
                <div class="card-header text-white text-center">
                    <i class="bi bi-pencil-square mb-2 d-block"></i>
                    <h3 class="mb-0">Edit User</h3>
                    <small class="opacity-75">Update profile, education, and skill details</small>
                </div>

                <div class="card-body p-4">

                    <form method="post" action="<?= site_url('Users/update/' . $user->id); ?>">

                        <!-- ===== Profile Info ===== -->
                        <h5 class="sub-section-title"><i class="bi bi-person-fill me-1"></i> Profile Information</h5>

                        <div class="mb-3">
                            <label class="form-label section-label">Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person-fill"></i></span>
                                <input type="text" name="name" class="form-control" value="<?= $user->name; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label section-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" name="email" class="form-control" value="<?= $user->email; ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4 mb-3">
                                <label class="form-label section-label">Country Code</label>
                                <select name="country_code" class="form-select">
                                    <option value="+91" <?= ($user->country_code == '+91') ? 'selected' : ''; ?>>India (+91)</option>
                                    <option value="+1" <?= ($user->country_code == '+1') ? 'selected' : ''; ?>>USA (+1)</option>
                                    <option value="+44" <?= ($user->country_code == '+44') ? 'selected' : ''; ?>>UK (+44)</option>
                                    <option value="+61" <?= ($user->country_code == '+61') ? 'selected' : ''; ?>>Australia (+61)</option>
                                </select>
                            </div>

                            <div class="col-8 mb-3">
                                <label class="form-label section-label">Mobile</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-telephone-fill"></i></span>
                                    <input type="text" name="mobile" class="form-control" value="<?= $user->mobile; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label section-label d-block">Gender</label>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" <?= ($user->gender == 'Male') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="genderMale">Male</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female" <?= ($user->gender == 'Female') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="genderFemale">Female</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="genderOther" value="Other" <?= ($user->gender == 'Other') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="genderOther">Other</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label section-label">Address</label>
                            <textarea name="address" class="form-control" rows="3"><?= $user->address; ?></textarea>
                        </div>

                        <!-- ===== Education ===== -->
                        <h5 class="sub-section-title"><i class="bi bi-mortarboard-fill me-1"></i> Education</h5>

                        <div class="mb-3">
                            <label class="form-label section-label">Qualification</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-mortarboard-fill"></i></span>
                                <input type="text" name="qualification" class="form-control"
                                       value="<?= !empty($education) ? $education->qualification : ''; ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label section-label">College</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-building"></i></span>
                                <input type="text" name="college" class="form-control"
                                       value="<?= !empty($education) ? $education->college : ''; ?>">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label section-label">Passing Year</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-calendar-event-fill"></i></span>
                                <input type="text" name="passing_year" class="form-control"
                                       value="<?= !empty($education) ? $education->passing_year : ''; ?>">
                            </div>
                        </div>

                        <!-- ===== Skills ===== -->
                        <h5 class="sub-section-title skills"><i class="bi bi-stars me-1"></i> Skills</h5>

                        <div class="mb-3">
                            <label class="form-label section-label">Skill</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-stars"></i></span>
                                <input type="text" name="skill_name" class="form-control"
                                       value="<?= !empty($skill) ? $skill->skill_name : ''; ?>">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label section-label">Experience</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-clock-history"></i></span>
                                <input type="text" name="experience" class="form-control"
                                       value="<?= !empty($skill) ? $skill->experience : ''; ?>">
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="<?= site_url('Users/users_list'); ?>" class="btn btn-outline-secondary w-50">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </a>

                            <button type="submit" class="btn btn-primary w-50">
                                <i class="bi bi-check-circle me-1"></i> Update User
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>

</html>