<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills & Preferences</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

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
        .sub-section-title {
            font-weight: 700;
            color: #4e73df;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
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
        .language-row {
            background-color: #fff;
            border: 1px solid #e3e6f0;
            border-radius: 0.6rem;
            padding: 0.75rem 0.5rem;
            margin-bottom: 0.6rem !important;
        }

        /* Select2 styling */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da;
            border-radius: 0.6rem;
            min-height: 42px;
            padding: 4px 8px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #4e73df;
            border: none;
            color: #fff;
            border-radius: 0.4rem;
            padding: 4px 10px;
            margin-top: 5px;
            font-size: 0.85rem;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
            margin-right: 3px;
            border: none;
            background: transparent;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #ff4d4d;
            background-color: #fff;
            border-radius: 50%;
        }
        .select2-dropdown {
            border-radius: 0.6rem;
            border: 1px solid #4e73df;
        }
        .select2-search__field {
            border-radius: 0.4rem !important;
        }
    </style>
</head>

<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg">
                <div class="card-header text-white text-center">
                    <i class="bi bi-clipboard2-data-fill mb-2 d-block"></i>
                    <h3 class="mb-0">Skills & Preferences</h3>
                    <small class="opacity-75">Tell us about your work preferences and abilities</small>
                </div>

                <div class="card-body p-4">

                    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                    <?php if ($this->session->flashdata('error')) { ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                    <?php } ?>

                    <form method="post" action="<?= site_url('Users/save_skills_form') ?>" enctype="multipart/form-data" id="skillsForm">

                        <!-- SECTION 1: Preferred Locations -->
                        <div class="section-block">
                            <h5 class="sub-section-title"><i class="bi bi-geo-alt-fill"></i> Preferred Work Locations <span class="text-danger">*</span></h5>
                            <?php foreach ($location_options as $loc) { ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="preferred_locations[]"
                                        value="<?= $loc->id ?>"
                                        <?= in_array($loc->id, $selected_locations) ? 'checked' : '' ?>>
                                    <label class="form-check-label"><?= $loc->location_name ?></label>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- SECTION 2: Skills -->
                        <div class="section-block">
                            <h5 class="sub-section-title"><i class="bi bi-stars"></i> Skills <span class="text-danger">*</span></h5>

                            <select name="skills[]" id="skillsSelect" class="form-select" multiple>
                                <?php foreach ($skill_options as $skill) { ?>
                                    <option value="<?= $skill->id ?>"
                                        <?= in_array($skill->id, $selected_skills) ? 'selected' : '' ?>>
                                        <?= $skill->skill_name ?>
                                    </option>
                                <?php } ?>
                            </select>

                            <small class="text-muted d-block mt-2">
                                <span id="skillCount">0</span> skill(s) selected
                            </small>
                        </div>

                        <!-- SECTION 3: Employment Type -->
                        <div class="section-block">
                            <h5 class="sub-section-title"><i class="bi bi-briefcase-fill"></i> Employment Type <span class="text-danger">*</span></h5>
                            <?php foreach ($employment_options as $type) { ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="employment_type[]"
                                        value="<?= $type->id ?>"
                                        <?= in_array($type->id, $selected_employment) ? 'checked' : '' ?>>
                                    <label class="form-check-label"><?= $type->type_name ?></label>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- SECTION 4: Languages -->
                        <div class="section-block">
                            <h5 class="sub-section-title"><i class="bi bi-translate"></i> Languages <span class="text-danger">*</span></h5>

                            <div id="languageContainer">
                                <?php if (!empty($languages)) { ?>
                                    <?php foreach ($languages as $lang) { ?>
                                        <div class="row mb-2 language-row align-items-center">
                                            <div class="col-5">
                                                <input type="text" name="language_name[]" class="form-control"
                                                    placeholder="Language" value="<?= $lang->language_name ?>">
                                            </div>
                                            <div class="col-5">
                                                <select name="proficiency_id[]" class="form-select">
                                                    <option value="">Select Level</option>
                                                    <?php foreach ($proficiency_options as $level) { ?>
                                                        <option value="<?= $level->id ?>"
                                                            <?= ($lang->proficiency_id == $level->id) ? 'selected' : '' ?>>
                                                            <?= $level->level_name ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-2 text-center">
                                                <button type="button" class="btn btn-outline-danger btn-sm removeLanguage">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="row mb-2 language-row align-items-center">
                                        <div class="col-5">
                                            <input type="text" name="language_name[]" class="form-control" placeholder="Language">
                                        </div>
                                        <div class="col-5">
                                            <select name="proficiency_id[]" class="form-select">
                                                <option value="">Select Level</option>
                                                <?php foreach ($proficiency_options as $level) { ?>
                                                    <option value="<?= $level->id ?>"><?= $level->level_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-2 text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm removeLanguage">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <button type="button" id="addLanguage" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="bi bi-plus-circle me-1"></i> Add More Language
                            </button>
                        </div>

                        <!-- SECTION 5: Resume -->
                        <div class="section-block mb-0">
                            <h5 class="sub-section-title"><i class="bi bi-file-earmark-text-fill"></i> Resume Upload <span class="text-danger">*</span></h5>

                            <?php if (!empty($resume->resume)) { ?>
                                <p class="mb-2">
                                    <i class="bi bi-paperclip"></i>
                                    Current:
                                    <a href="<?= base_url('uploads/resume/' . $resume->resume) ?>" target="_blank">
                                        <?= $resume->resume ?>
                                    </a>
                                </p>
                            <?php } ?>

                            <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx">
                            <small class="text-muted">Allowed: PDF, DOC, DOCX. Max size: 5MB</small>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <a href="<?= site_url('Users/education') ?>" class="btn btn-outline-secondary w-50">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary w-50">
                                Submit <i class="bi bi-check-circle ms-1"></i>
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {

    var proficiencyOptionsHTML = `<option value="">Select Level</option><?php foreach ($proficiency_options as $level) { ?><option value="<?= $level->id ?>"><?= $level->level_name ?></option><?php } ?>`;

    $('#addLanguage').click(function() {
        var row = `
            <div class="row mb-2 language-row align-items-center">
                <div class="col-5">
                    <input type="text" name="language_name[]" class="form-control" placeholder="Language">
                </div>
                <div class="col-5">
                    <select name="proficiency_id[]" class="form-select">${proficiencyOptionsHTML}</select>
                </div>
                <div class="col-2 text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm removeLanguage">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>`;
        $('#languageContainer').append(row);
    });

    $(document).on('click', '.removeLanguage', function() {
        if ($('.language-row').length > 1) {
            $(this).closest('.language-row').remove();
        } else {
            alert('At least one language is required.');
        }
    });

    $('#skillsForm').on('submit', function(e) {
        var valid = true;
        var msgs = [];

        if ($('input[name="preferred_locations[]"]:checked').length === 0) {
            valid = false; msgs.push('Select at least one preferred location.');
        }
        if ($('select[name="skills[]"] option:selected').length === 0) {
            valid = false; msgs.push('Select at least one skill.');
        }
        if ($('input[name="employment_type[]"]:checked').length === 0) {
            valid = false; msgs.push('Select at least one employment type.');
        }

        var langOk = true;
        $('.language-row').each(function() {
            var lang = $(this).find('input[name="language_name[]"]').val().trim();
            var prof = $(this).find('select[name="proficiency_id[]"]').val();
            if (!lang || !prof) langOk = false;
        });
        if (!langOk) { valid = false; msgs.push('Each language row needs both Language and Proficiency.'); }

        if (!valid) {
            e.preventDefault();
            alert(msgs.join('\n'));
        }
    });

});

$(document).ready(function() {

    $('#skillsSelect').select2({
        placeholder: "Search and select skills",
        width: '100%',
        closeOnSelect: false
    });

    function updateSkillCount() {
        var count = $('#skillsSelect').val() ? $('#skillsSelect').val().length : 0;
        $('#skillCount').text(count);
    }

    updateSkillCount();

    $('#skillsSelect').on('change', function() {
        updateSkillCount();
    });

});
</script>
</body>
</html>