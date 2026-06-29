<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker3.min.css">
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

        #passingYearWrapper {
            position: relative;
        }

        .datepicker.dropdown-menu {
            width: 100% !important;
            min-width: unset !important;
            left: 0 !important;
            right: 0 !important;
        }

        .datepicker-years table {
            width: 100% !important;
            table-layout: fixed;
        }

        .datepicker-years td span.year {
            padding: 6px 0;
            font-size: 0.8rem;
        }
    </style>
</head>

<body>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-lg">
                    <div class="card-header text-white text-center">
                        <i class="bi bi-mortarboard-fill mb-2 d-block"></i>
                        <h3 class="mb-0">Education Details</h3>
                        <small class="opacity-75">Enter your educational background</small>
                    </div>

                    <div class="card-body p-4">

                        <form method="post" action="<?= site_url('Users/save_education') ?>">

                            <!-- Qualification -->
                            <div class="section-block">
                                <h5 class="sub-section-title"><i class="bi bi-patch-check-fill"></i> Qualification</h5>

                                <select id="qualification" name="qualification_id" class="form-select">

                                    <option value="">Select Qualification</option>

                                    <?php foreach ($qualifications as $qualification) { ?>
                                        <option value="<?= $qualification->id ?>" data-type="<?= $qualification->type ?>"
                                            <?= (!empty($education) && $education->qualification_id == $qualification->id) ? 'selected' : ''; ?>>
                                            <?= $qualification->qualification_name ?>
                                        </option>
                                    <?php } ?>

                                </select>
                            </div>


                            <!-- ===================== -->
                            <!-- SCHOOL SECTION -->
                            <!-- ===================== -->

                            <div id="schoolSection" class="section-block" style="display:none;">

                                <h5 class="sub-section-title"><i class="bi bi-building"></i> School Details</h5>

                                <div class="mb-3">
                                    <label class="form-label section-label">Board</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-bank2"></i></span>
                                        <input type="text" name="board" class="form-control" required
                                            value="<?= !empty($education) ? $education->board : '' ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label section-label">School</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-building"></i></span>
                                        <input type="text" name="school" class="form-control" required
                                            value="<?= !empty($education) ? $education->school : '' ?>">
                                    </div>
                                </div>

                                <div class="mb-1">
                                    <label class="form-label section-label">Percentage</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-percent"></i></span>
                                        <input type="text" name="percentage" class="form-control" required
                                            value="<?= !empty($education) ? $education->percentage : '' ?>">
                                    </div>
                                </div>

                            </div>


                            <!-- ===================== -->
                            <!-- COLLEGE SECTION -->
                            <!-- ===================== -->

                            <div id="collegeSection" class="section-block" style="display:none;">

                                <h5 class="sub-section-title"><i class="bi bi-mortarboard"></i> College Details</h5>

                                <!-- Degree -->
                                <div class="mb-3">
                                    <label class="form-label section-label">Degree</label>
                                    <select id="degree" name="degree_id" class="form-select" required
                                        data-selected="<?= !empty($education) ? $education->degree_id : '' ?>">
                                        <option value="">Select Degree</option>
                                    </select>
                                </div>

                                <!-- Stream -->
                                <div class="mb-3">
                                    <label class="form-label section-label">Stream</label>
                                    <select id="stream" name="stream_id" class="form-select" required
                                        data-selected="<?= !empty($education) ? $education->stream_id : '' ?>">
                                        <option value="">Select Stream</option>
                                    </select>
                                </div>

                                <!-- College -->
                                <div class="mb-3">
                                    <label class="form-label section-label">College / University</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-bank"></i></span>
                                        <input type="text" name="college" class="form-control" required
                                            value="<?= !empty($education) ? $education->college : '' ?>">
                                    </div>
                                </div>

                                <!-- Passing Year -->
                                <div class="mb-3" id="passingYearWrapper">

                                    <label class="form-label section-label">
                                        Passing Year
                                    </label>

                                    <input type="text" id="passing_year" name="passing_year" class="form-control"
                                        required value="<?= !empty($education) ? $education->passing_year : '' ?>"
                                        placeholder="Select Year" readonly>

                                </div>
                                <!-- CGPA -->
                                <div class="mb-1">
                                    <label class="form-label section-label">CGPA</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-graph-up"></i></span>
                                        <input type="text" name="cgpa" class="form-control" required
                                            value="<?= !empty($education) ? $education->cgpa : '' ?>">
                                    </div>
                                </div>

                            </div>


                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <a href="<?= site_url('Users') ?>" class="btn btn-outline-secondary w-50">
                                    <i class="bi bi-arrow-left me-1"></i> Previous
                                </a>

                                <button class="btn btn-primary w-50">
                                    Next <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {

            // Select2 initializations — sab yahan andar
            $('#degree').select2({ placeholder: "Select Degree", width: '100%' });
            $('#stream').select2({ placeholder: "Select Stream", width: '100%' });
            $('#qualification').select2({ placeholder: "Select Qualification", width: '100%' });

            function toggleSections() {
                var type = $("#qualification option:selected").data("type");

                if (type == "school") {
                    $("#schoolSection").show().find('input').attr('required', true);
                    $("#collegeSection").hide().find('input, select').removeAttr('required');
                } else if (type == "college") {
                    $("#collegeSection").show().find('input, select').attr('required', true);
                    $("#schoolSection").hide().find('input').removeAttr('required');
                } else {
                    $("#schoolSection").hide().find('input').removeAttr('required');
                    $("#collegeSection").hide().find('input, select').removeAttr('required');
                }
            }

            function loadDegrees(qualification_id, selectedDegree) {
                $.ajax({
                    url: "<?= site_url('Users/get_degrees'); ?>",
                    type: "POST",
                    data: { qualification_id: qualification_id },
                    dataType: "json",
                    success: function (response) {

                        $('#degree').empty().append('<option value="">Select Degree</option>');

                        $.each(response, function (index, degree) {
                            var sel = (selectedDegree && selectedDegree == degree.id) ? 'selected' : '';
                            $('#degree').append(
                                '<option value="' + degree.id + '" ' + sel + '>' + degree.degree_name + '</option>'
                            );
                        });

                        $('#degree').trigger('change.select2');   // Select2 ko refresh karne ke liye

                        if (selectedDegree) {
                            loadStreams(selectedDegree, $('#stream').data('selected'));
                        }
                    }
                });
            }

            function loadStreams(degree_id, selectedStream) {
                $.ajax({
                    url: "<?= site_url('Users/get_streams'); ?>",
                    type: "POST",
                    data: { degree_id: degree_id },
                    dataType: "json",
                    success: function (response) {

                        $('#stream').empty().append('<option value="">Select Stream</option>');

                        $.each(response, function (index, stream) {
                            var sel = (selectedStream && selectedStream == stream.id) ? 'selected' : '';
                            $('#stream').append(
                                '<option value="' + stream.id + '" ' + sel + '>' + stream.stream_name + '</option>'
                            );
                        });

                        $('#stream').trigger('change.select2');
                    }
                });
            }

            // Initial load
            toggleSections();

            var initial_qualification_id = $('#qualification').val();
            if (initial_qualification_id != '') {
                loadDegrees(initial_qualification_id, $('#degree').data('selected'));
            }

            $('#qualification').change(function () {
                toggleSections();
                var qualification_id = $(this).val();
                $('#degree').html('<option value="">Select Degree</option>').trigger('change.select2');
                $('#stream').html('<option value="">Select Stream</option>').trigger('change.select2');
                if (qualification_id == '') return;
                loadDegrees(qualification_id, '');
            });

            $('#degree').change(function () {
                var degree_id = $(this).val();
                $('#stream').html('<option value="">Select Stream</option>').trigger('change.select2');
                if (degree_id == '') return;
                loadStreams(degree_id, '');
            });

            // Datepicker
            $('#passing_year').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: 2,
                autoclose: true,
                container: '#passingYearWrapper',
                orientation: "bottom auto"
            });

        });
    </script>
</body>

</html>