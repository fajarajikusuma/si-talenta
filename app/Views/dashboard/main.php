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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
  <style>
    table.dataTable,
    table.dataTable th,
    table.dataTable td {
      border: 1px solid #ccc !important;
      border-collapse: collapse !important;
    }

    table.dataTable {
      width: 100%;
      border-collapse: collapse !important;
    }
  </style>
</head>

<body class="with-welcome-text">
  <div class="container-scroller">
    <!-- <div class="row p-0 m-0 proBanner" id="proBanner">
      <div class="col-md-12 p-0 m-0">
        <div class="card-body card-body-padding px-3 d-flex align-items-center justify-content-between">
          <div class="ps-lg-3">
            <div class="d-flex align-items-center justify-content-between">
              <p class="mb-0 fw-medium me-3 buy-now-text">Free 24/7 customer support, updates, and more with this template!</p>
              <a href="https://www.bootstrapdash.com/product/star-admin-pro/" target="_blank" class="btn me-2 buy-now-btn border-0">Buy Now</a>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <a href="https://www.bootstrapdash.com/product/star-admin-pro/"><i class="ti-home me-3 text-white"></i></a>
            <button id="bannerClose" class="btn border-0 p-0">
              <i class="ti-close text-white"></i>
            </button>
          </div>
        </div>
      </div>
    </div> -->
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
            <span class="icon-menu"></span>
          </button>
        </div>
        <div>
          <a class="navbar-brand brand-logo" href="<?= site_url('/') ?>">
            <h2 class="text-primary m-0 mb-1"><b><span class="text-dark">Si</span>-Talenta</b></h2>
          </a>
          <!-- <a class="navbar-brand brand-logo-mini" href="#">
            <img src="staradmin/dist/assets/images/logo-mini.svg" alt="logo" />
          </a> -->
          <a class="navbar-brand brand-logo-mini mb-3 ms-2" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <img class="img-xs rounded-circle" src="<?= site_url('uploads/user_pict/') . session()->get('foto') ?>" alt="Profile image">
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown ms-3" aria-labelledby="UserDropdown">
            <div class="dropdown-header text-center">
              <img class="img-sm rounded-circle" src="<?= site_url('uploads/user_pict/') . session()->get('foto') ?>" alt="Profile image">
              <p class="mb-1 mt-3 fw-semibold"><?= session()->get('nama_lengkap') ?></p>
              <p class="fw-light text-muted mb-0"><?= session()->get('unitKerja') ?></p>
            </div>
            <a class="dropdown-item" href="<?= site_url('user_detail/') . session()->get('userId') ?>"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i>
              My Profile
              <!-- <span class="badge badge-pill badge-danger">1</span> -->
            </a>
            <!-- <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-message-text-outline text-primary me-2"></i> Messages</a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-calendar-check-outline text-primary me-2"></i> Activity</a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-help-circle-outline text-primary me-2"></i> FAQ</a> -->
            <a class="dropdown-item" href="<?= site_url('logout') ?>"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Log Out</a>
          </div>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
          <li class="nav-item fw-semibold d-none d-lg-block ms-0">
            <h1 class="welcome-text">Sugeng Rawuh, <span class="text-black fw-bold"><?= session()->get('nama_lengkap') ?></span></h1>
            <!-- <h3 class="welcome-sub-text">Your performance summary this week </h3> -->
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <!-- <li class="nav-item dropdown d-none d-lg-block">
            <a class="nav-link dropdown-bordered dropdown-toggle dropdown-toggle-split" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false"> Select Category </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="messageDropdown">
              <a class="dropdown-item py-3">
                <p class="mb-0 fw-medium float-start">Select category</p>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis fw-medium text-dark">Bootstrap Bundle </p>
                  <p class="fw-light small-text mb-0">This is a Bundle featuring 16 unique dashboards</p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis fw-medium text-dark">Angular Bundle</p>
                  <p class="fw-light small-text mb-0">Everything you’ll ever need for your Angular projects</p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis fw-medium text-dark">VUE Bundle</p>
                  <p class="fw-light small-text mb-0">Bundle of 6 Premium Vue Admin Dashboard</p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis fw-medium text-dark">React Bundle</p>
                  <p class="fw-light small-text mb-0">Bundle of 8 Premium React Admin Dashboard</p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item d-none d-lg-block">
            <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
              <span class="input-group-addon input-group-prepend border-right">
                <span class="icon-calendar input-group-text calendar-icon"></span>
              </span>
              <input type="text" class="form-control">
            </div>
          </li>
          <li class="nav-item">
            <form class="search-form" action="#">
              <i class="icon-search"></i>
              <input type="search" class="form-control" placeholder="Search Here" title="Search here">
            </form>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
              <i class="icon-bell"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
              <a class="dropdown-item py-3 border-bottom">
                <p class="mb-0 fw-medium float-start">You have 4 new notifications </p>
                <span class="badge badge-pill badge-primary float-end">View all</span>
              </a>
              <a class="dropdown-item preview-item py-3">
                <div class="preview-thumbnail">
                  <i class="mdi mdi-alert m-auto text-primary"></i>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject fw-normal text-dark mb-1">Application Error</h6>
                  <p class="fw-light small-text mb-0"> Just now </p>
                </div>
              </a>
              <a class="dropdown-item preview-item py-3">
                <div class="preview-thumbnail">
                  <i class="mdi mdi-lock-outline m-auto text-primary"></i>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject fw-normal text-dark mb-1">Settings</h6>
                  <p class="fw-light small-text mb-0"> Private message </p>
                </div>
              </a>
              <a class="dropdown-item preview-item py-3">
                <div class="preview-thumbnail">
                  <i class="mdi mdi-airballoon m-auto text-primary"></i>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject fw-normal text-dark mb-1">New user registration</h6>
                  <p class="fw-light small-text mb-0"> 2 days ago </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="icon-mail icon-lg"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="countDropdown">
              <a class="dropdown-item py-3">
                <p class="mb-0 fw-medium float-start">You have 7 unread mails </p>
                <span class="badge badge-pill badge-primary float-end">View all</span>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="staradmin/dist/assets/images/faces/face10.jpg" alt="image" class="img-sm profile-pic">
                </div>
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis fw-medium text-dark">Marian Garner </p>
                  <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="staradmin/dist/assets/images/faces/face12.jpg" alt="image" class="img-sm profile-pic">
                </div>
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis fw-medium text-dark">David Grey </p>
                  <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="staradmin/dist/assets/images/faces/face1.jpg" alt="image" class="img-sm profile-pic">
                </div>
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis fw-medium text-dark">Travis Jenkins </p>
                  <p class="fw-light small-text mb-0"> The meeting is cancelled </p>
                </div>
              </a>
            </div>
          </li> -->
          <li class="nav-item dropdown d-none d-lg-block user-dropdown">
            <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="me-2">Hi, <?= session()->get('nama_lengkap') ?></span><img class="img-xs rounded-circle" src="<?= site_url('uploads/user_pict/') . session()->get('foto') ?>" alt="Profile image"> </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <div class="dropdown-header text-center">
                <img class="img-sm rounded-circle" src="<?= site_url('uploads/user_pict/') . session()->get('foto') ?>" alt="Profile image">
                <p class="mb-1 mt-3 fw-semibold"><?= session()->get('nama_lengkap') ?></p>
                <p class="fw-light text-muted mb-0"><?= session()->get('unitKerja') ?></p>
              </div>
              <a class="dropdown-item" href="<?= site_url('user_detail/') . session()->get('userId') ?>"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i>
                My Profile
                <!-- <span class="badge badge-pill badge-danger">1</span> -->
              </a>
              <!-- <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-message-text-outline text-primary me-2"></i> Messages</a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-calendar-check-outline text-primary me-2"></i> Activity</a>
              <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-help-circle-outline text-primary me-2"></i> FAQ</a> -->
              <a class="dropdown-item" href="<?= site_url('logout') ?>"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Log Out</a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center pe-3" type="button" data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <!-- Sidebar -->
      <?= $this->include('dashboard/menu') ?>
      <!-- End Sidebar -->
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <!-- Body Content -->
          <?= $this->renderSection('content') ?>
          <!-- End Body Content -->
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Created with ❤ by <a href="https://fajarajikusuma.vercel.app/" target="_blank" style="text-decoration: none;">Fajar Aji Kusuma, S.Kom.</a> </span>
            <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center">Copyright © <?= date('Y') == '2025' ? '2025' : '2025' . ' ' . date('Y') ?>. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="staradmin/dist/assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="staradmin/dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="staradmin/dist/assets/vendors/chart.js/chart.umd.js"></script>
  <script src="staradmin/dist/assets/vendors/progressbar.js/progressbar.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="staradmin/dist/assets/js/off-canvas.js"></script>
  <script src="staradmin/dist/assets/js/template.js"></script>
  <script src="staradmin/dist/assets/js/settings.js"></script>
  <script src="staradmin/dist/assets/js/hoverable-collapse.js"></script>
  <script src="staradmin/dist/assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="staradmin/dist/assets/js/jquery.cookie.js" type="text/javascript"></script>
  <script src="staradmin/dist/assets/js/dashboard.js"></script>
  <!-- <script src="staradmin/dist/assets/js/Chart.roundedBarCharts.js"></script> -->
  <!-- Custom JS -->
  <script src="custom/datatables.js"></script>
  <script src="custom/custom.js"></script>
  <!-- End custom js for this page-->
</body>

</html>