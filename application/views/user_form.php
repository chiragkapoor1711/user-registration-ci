<!DOCTYPE html>
<html>

<head>
    <title>User Registration</title>
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
            padding: 2rem 1rem 1.5rem;
        }

        .form-control.is-invalid {
            border-color: #dc3545 !important;
            box-shadow: none;
        }

        .form-control,
        .form-select {
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

        .sub-section-title {
            font-weight: 700;
            color: #4e73df;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.1rem;
        }

        .section-block {
            background-color: #f8f9fc;
            border: 1px solid #e3e6f0;
            border-radius: 0.8rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .form-check-inline {
            background-color: #fff;
            border: 1px solid #e3e6f0;
            border-radius: 0.5rem;
            padding: 0.45rem 0.9rem 0.45rem 1.6rem;
            margin: 0 0.4rem 0.5rem 0;
        }

        /* Profile photo upload component */
        .photo-upload-wrapper {
            padding: 4px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
        }

        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18);
            transition: transform 0.25s ease;
        }

        .default-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #eef1fb;
            color: #4e73df;
            font-size: 3rem;
        }

        .profile-photo:hover {
            transform: scale(1.03);
        }

        .photo-edit-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #2b2b2b;
            color: #fff;
            border: 2px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
            transition: background 0.2s ease, transform 0.2s ease;
            outline: none;
        }

        .photo-edit-btn:hover {
            background: #444;
            transform: scale(1.08);
        }
    </style>

</head>

<body>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <div class="card shadow-lg">

                    <div class="card-header text-center">

                        <h3 class="text-white mb-1">User Registration Form</h3>
                        <small class="text-white opacity-75 d-block mb-3">Fill in the details below to register</small>

                        <!-- Profile Photo Preview -->
                        <div class="text-center">
                            <div class="photo-upload-wrapper position-relative d-inline-block">

                                <?php if (!empty($user->photo)): ?>
                                    <img id="photoPreview"
                                        src="<?= htmlspecialchars(base_url('uploads/' . $user->photo), ENT_QUOTES, 'UTF-8'); ?>"
                                        class="profile-photo" width="120" height="120">
                                <?php else: ?>
                                    <div id="photoPreview" class="profile-photo default-avatar">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                <?php endif; ?>

                                <button type="button" class="photo-edit-btn"
                                    onclick="document.getElementById('photoInput').click();">
                                    <i class="bi bi-camera-fill"></i>
                                </button>

                            </div>

                            <p class="text-white-50 small mt-2 mb-0">Click the camera icon to change your photo</p>
                        </div>

                    </div>

                    <div class="card-body p-4">

                        <form method="post" action="<?php echo site_url('Users/submit'); ?>"
                            enctype="multipart/form-data">

                            <!-- Hidden File Input (must stay inside the form so it actually submits) -->
                            <input type="file" name="photo" id="photoInput" accept="image/*" style="display:none;">

                            <!-- ===== Basic Info ===== -->
                            <div class="section-block">
                                <h5 class="sub-section-title"><i class="bi bi-person-fill"></i> Basic Information</h5>

                                <!-- Name -->
                                <div class="mb-3">
                                    <label class="form-label section-label">Name</label>

                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-person-fill"></i>
                                        </span>

                                        <input type="text" id="name" name="name"
                                            class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>"
                                            placeholder="Enter full name"
                                            value="<?= !empty($user) ? $user->name : set_value('name'); ?>">
                                    </div>

                                    <div id="nameError" class="text-danger mt-1"></div>
                                    <?= form_error('name', '<div class="text-danger mt-1">', '</div>'); ?>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="form-label section-label">Email</label>

                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-envelope-fill"></i>
                                        </span>

                                        <input type="email" id="email" name="email"
                                            class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>"
                                            placeholder="Enter email address"
                                            value="<?= !empty($user) ? $user->email : set_value('email'); ?>">
                                    </div>

                                    <div id="emailError" class="text-danger mt-1"></div>
                                    <?= form_error('email', '<div class="text-danger mt-1">', '</div>'); ?>
                                </div>

                                <!-- Country Code + Mobile -->
                                <div class="row">
                                    <div class="col-4 mb-3">
                                        <label class="form-label section-label">Country Code</label>
                                        <select name="country_code" class="form-select">
                                            <option value="+91">India (+91)</option>
                                            <option value="+1">USA (+1)</option>
                                            <option value="+44">UK (+44)</option>
                                            <option value="+61">Australia (+61)</option>
                                        </select>
                                    </div>

                                    <div class="col-8 mb-3">
                                        <label class="form-label section-label">Mobile Number</label>

                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-telephone-fill"></i>
                                            </span>

                                            <input type="text" id="mobile" name="mobile"
                                                class="form-control <?= form_error('mobile') ? 'is-invalid' : '' ?>"
                                                placeholder="Enter mobile number"
                                                value="<?= !empty($user) ? $user->mobile : set_value('mobile'); ?>">
                                        </div>

                                        <div id="mobileError" class="text-danger mt-1"></div>
                                        <?= form_error('mobile', '<div class="text-danger mt-1">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- row closed properly here -->

                            </div>

                            <!-- ===== Personal Details ===== -->
                            <div class="section-block">
                                <h5 class="sub-section-title"><i class="bi bi-info-circle-fill"></i> Personal Details</h5>

                                <!-- Gender Radio -->
                                <div class="mb-3">
                                    <label class="form-label section-label d-block">Gender</label>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="genderMale"
                                            value="Male" <?= (!empty($user) && $user->gender == 'Male') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="genderMale">Male</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="genderFemale"
                                            value="Female" <?= (!empty($user) && $user->gender == 'Female') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="genderFemale">Female</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="genderOther"
                                            value="Other" <?= (!empty($user) && $user->gender == 'Other') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="genderOther">Other</label>
                                    </div>
                                </div>

                                <!-- Hobbies Checkbox -->
                                <?php
                                $hobbies = !empty($user->hobbies)
                                    ? explode(',', $user->hobbies)
                                    : [];
                                ?>

                                <div class="mb-3">
                                    <label class="form-label section-label d-block">Hobbies</label>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="hobbies[]"
                                            id="hobbyReading" value="Reading" <?= in_array('Reading', $hobbies) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="hobbyReading">Reading</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="hobbies[]" id="hobbyMusic"
                                            value="Music" <?= in_array('Music', $hobbies) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="hobbyMusic">Music</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="hobbies[]"
                                            id="hobbySports" value="Sports" <?= in_array('Sports', $hobbies) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="hobbySports">Sports</label>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="mb-1">
                                    <label class="form-label section-label">Address</label>
                                    <textarea name="address" class="form-control" rows="3"
                                        placeholder="Enter address"><?= !empty($user) ? $user->address : ''; ?></textarea>
                                </div>
                            </div>

                            <!-- ===== Action Buttons ===== -->
                            <?php if (
                                !$this->session->userdata('edit_user_id')
                                && !$this->session->userdata('reg_user_id')
                            ) { ?>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <button type="submit" name="action" value="save" class="btn btn-success w-100">
                                            <i class="bi bi-check-circle me-1"></i> Save
                                        </button>
                                    </div>

                                    <div class="col-6">
                                        <button type="submit" name="action" value="next" class="btn btn-primary w-100">
                                            Next <i class="bi bi-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>

                            <?php } else { ?>

                                <div class="row g-2">
                                    <div class="col-12">
                                        <button type="submit" name="action" value="next" class="btn btn-primary w-100">
                                            Next <i class="bi bi-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>

                            <?php } ?>

                            <?php if ($this->session->userdata('role') != 'user') { ?>

                                <a href="<?= site_url('Users/users_list'); ?>"
                                    class="btn btn-outline-secondary w-100 mt-2">
                                    <i class="bi bi-list-ul me-1"></i> View Users
                                </a>

                            <?php } else { ?>

                                <a href="<?= site_url('Auth/logout'); ?>" class="btn btn-danger w-100 mt-2">
                                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                                </a>

                            <?php } ?>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>

        // Name Validation
        document.getElementById('name').addEventListener('keyup', function () {

            let name = this.value.trim();
            let regex = /^[A-Za-z]+(\s+[A-Za-z]+)+$/;

            if (name === '') {
                document.getElementById('nameError').innerHTML = '';
                this.classList.remove('is-invalid');
            }
            else if (!regex.test(name)) {
                document.getElementById('nameError').innerHTML =
                    'Please enter full name';
                this.classList.add('is-invalid');
            }
            else {
                document.getElementById('nameError').innerHTML = '';
                this.classList.remove('is-invalid');
            }
        });


        // Email Validation
        document.getElementById('email').addEventListener('keyup', function () {

            let email = this.value.trim();
            let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email === '') {
                document.getElementById('emailError').innerHTML = '';
                this.classList.remove('is-invalid');
            }
            else if (!regex.test(email)) {
                document.getElementById('emailError').innerHTML =
                    'Please enter a valid email address';
                this.classList.add('is-invalid');
            }
            else {
                document.getElementById('emailError').innerHTML = '';
                this.classList.remove('is-invalid');
            }
        });


        // Mobile Validation
        document.getElementById('mobile').addEventListener('keyup', function () {

            let mobile = this.value.trim();

            if (mobile === '') {
                document.getElementById('mobileError').innerHTML = '';
                this.classList.remove('is-invalid');
            }
            else if (!/^\d{10}$/.test(mobile)) {
                document.getElementById('mobileError').innerHTML =
                    'Mobile number must be 10 digits';
                this.classList.add('is-invalid');
            }
            else {
                document.getElementById('mobileError').innerHTML = '';
                this.classList.remove('is-invalid');
            }
        });


        // Profile preview section
        document.getElementById('photoInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file.');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (event) {
                const preview = document.getElementById('photoPreview');

                // If current preview is the icon div, replace it with an actual <img>
                if (preview.tagName.toLowerCase() === 'div') {
                    const newImg = document.createElement('img');
                    newImg.id = 'photoPreview';
                    newImg.className = 'profile-photo';
                    newImg.width = 120;
                    newImg.height = 120;
                    newImg.src = event.target.result;
                    preview.replaceWith(newImg);
                } else {
                    preview.src = event.target.result;
                }
            };
            reader.readAsDataURL(file);
        });
    </script>
</body>

</html>