<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?= base_url() ?>">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="staradmin/dist/assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="staradmin/dist/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="staradmin/dist/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="staradmin/dist/assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="staradmin/dist/assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="staradmin/dist/assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="staradmin/dist/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="staradmin/dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- endinject -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="staradmin/dist/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="staradmin/dist/assets/js/select.dataTables.min.css">
    <!-- Data Tables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.min.js"></script>
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="staradmin/dist/assets/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="staradmin/dist/assets/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5 rounded-2">
                            <div class="brand-logo">
                                <h2 class="text-primary m-0"><b><span class="text-dark">Si</span>-Talenta</b></h2>
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="fw-light">Sign in to continue.</h6>
                            <?php if (session()->getFlashdata('success')) : ?>
                                <div class="alert alert-success alert-dismissible fade show m-0 mt-2" role="alert">
                                    <?= session()->getFlashdata('success') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php elseif (session()->getFlashdata('error')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show m-0 mt-2" role="alert">
                                    <?= session()->getFlashdata('error') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <form class="pt-3" method="POST" action="<?= site_url('login_load') ?>">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" id="exampleInputtext1" placeholder="Username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" name="password" required>
                                </div>
                                <hr>
                                <div class="mt-3 d-flex gap-2 justify-content-between">
                                    <a id="back-home-btn" class="btn btn-secondary btn-md fw-medium auth-form-btn rounded-5">
                                        <i class="ti-arrow-left"></i>
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-md fw-medium auth-form-btn rounded-5 flex-fill">LOGIN</button>
                                </div>
                                <!-- <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                                    </div>
                                    <a href="#" class="auth-link text-black">Forgot password?</a>
                                </div>
                                <div class="mb-2 d-grid gap-2">
                                    <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                                        <i class="ti-facebook me-2"></i>Connect using facebook </button>
                                </div>
                                <div class="text-center mt-4 fw-light"> Don't have an account? <a href="register.html" class="text-primary">Create</a>
                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="staradmin/dist/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="staradmin/dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="staradmin/dist/assets/js/off-canvas.js"></script>
    <script src="staradmin/dist/assets/js/template.js"></script>
    <script src="staradmin/dist/assets/js/settings.js"></script>
    <script src="staradmin/dist/assets/js/hoverable-collapse.js"></script>
    <script src="staradmin/dist/assets/js/todolist.js"></script>
    <script>
        const backBtn = document.getElementById('back-home-btn');

        // Buat URL dinamis: ambil protocol + host
        const baseUrl = window.location.origin;

        // Tambah path jika perlu
        backBtn.href = baseUrl;
        // Kalau mau selalu ke / beranda: baseUrl + '/'

        // Debug (opsional)
        console.log('Back URL:', backBtn.href);
    </script>
    <!-- endinject -->
</body>

</html>