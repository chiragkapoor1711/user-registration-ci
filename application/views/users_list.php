<!DOCTYPE html>
<html>

<head>
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .page-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border-radius: 1rem;
            padding: 1.5rem 2rem;
            color: #fff;
            margin-bottom: 1.5rem;
        }

        #back-btn {
            background: #224abe;
        }

        .card {
            border: none;
            border-radius: 1rem;
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

        .table td {
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f1f4ff;
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

        .btn {
            border-radius: 0.6rem;
        }

        .role-badge {
            font-size: 0.75rem;
            vertical-align: middle;
        }

        .search-box {
            border-radius: 0.6rem;
            padding: 0.6rem 1rem;
            max-width: 320px;
        }

        #tableLoader {
            display: none;
            text-align: center;
            padding: 2rem 0;
        }
    </style>
</head>

<body>

    <?php $role = $this->session->userdata('role'); ?>

    <div class="container mt-5 mb-5">

        <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="mb-0">
                    <i class="bi bi-people-fill me-2"></i>Registered Users
                    <span class="badge bg-light text-dark role-badge ms-2">
                        <?= ucfirst($role); ?>
                    </span>
                </h2>
                <small class="opacity-75">Manage all registered user accounts</small>
            </div>
            <div class="d-flex gap-2 flex-wrap">

                <?php if ($role == 'admin') { ?>
                    <a href="<?= site_url('Users/add_new'); ?>" class="btn btn-light">
                        <i class="bi bi-person-plus-fill me-1"></i> Add New User
                    </a>

                    <a href="<?= site_url('Auth/manage_users'); ?>" class="btn btn-light">
                        <i class="bi bi-shield-lock-fill me-1"></i> Manage Roles
                    </a>
                <?php } ?>
                <a href="<?= site_url('Auth/change_password'); ?>" class="btn btn-light">
                    <i class="bi bi-key-fill me-1"></i> Change Password
                </a>

                <a href="<?= site_url('Users/export_excel'); ?>" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
                </a>

                <a href="<?= site_url('Auth/logout'); ?>" class="btn btn-danger">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </a>

            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <div class="input-group search-box">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" id="userSearch" class="form-control"
                            placeholder="Search by name or email...">
                    </div>
                </div>

                <div id="tableLoader">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted mt-2 mb-0">Loading...</p>
                </div>

                <div class="table-responsive" id="userTableContainer">
                    <?php
                    echo $this->load->view('users_list_table', [
                        'users' => $users,
                        'role' => $role,
                        'pagination_links' => $pagination_links
                    ], true);
                    ?>
                </div>

            </div>
        </div>

    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {

            // Event delegation — kyunki pagination links AJAX se baad me bhi aayenge
            $(document).on('click', '#userTableContainer .pagination a', function (e) {
                e.preventDefault();

                var url = $(this).attr('href');   // jaise: Users/users_list_ajax/10

                $('#tableLoader').show();
                $('#userTableContainer').css('opacity', '0.4');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) {
                        $('#userTableContainer').html(response).css('opacity', '1');
                        $('#tableLoader').hide();
                    },
                    error: function () {
                        $('#tableLoader').hide();
                        $('#userTableContainer').css('opacity', '1');
                        alert('Something went wrong while loading the page.');
                    }
                });
            });

            // Simple client-side filter on the currently loaded rows (per page)
            $('#userSearch').on('keyup', function () {
                var value = $(this).val().toLowerCase();
                $('#userTableContainer tbody tr').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

        });
    </script>
</body>

</html>