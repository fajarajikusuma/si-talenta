<!-- partial:staradmin/dist/partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url() ?>">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <?php if (session()->get('level') == 'admin'): ?>
            <li class="nav-item nav-category">Master Data</li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('unit_kerja') ?>">
                    <i class="mdi mdi mdi-collage menu-icon"></i>
                    <span class="menu-title">Unit Kerja</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('daftar_kepala') ?>">
                    <i class="menu-icon mdi mdi-account-multiple"></i>
                    <span class="menu-title">Daftar Kepala</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('list_pekerjaan') ?>">
                    <i class="menu-icon mdi mdi-layers-outline"></i>
                    <span class="menu-title">List Pekerjaan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('dasar_hukum') ?>">
                    <i class="menu-icon mdi mdi-text-box-multiple"></i>
                    <span class="menu-title">Dasar Hukum</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('user_sistem') ?>">
                    <i class="menu-icon mdi mdi-account-group"></i>
                    <span class="menu-title">Pengguna</span>
                </a>
            </li>
        <?php endif; ?>
        <li class="nav-item nav-category">Transaction Processes</li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-pekerja" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-floor-plan"></i>
                <span class="menu-title">Data Pekerja</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-pekerja">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?= site_url('data_pekerja/new') ?>">Usulan Baru</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= site_url('data_pekerja/aktif') ?>">Aktif</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= site_url('data_pekerja/pensiun') ?>">Pensiun</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= site_url('data_pekerja/out') ?>">Tidak Aktif</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-daftar-pekerja" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-file-document"></i>
                <span class="menu-title">Penugasan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-daftar-pekerja">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?= site_url('penugasan') ?>">Pengajuan</a></li>
                    <?php if (session()->get('level') == 'user'): ?>
                        <li class="nav-item"> <a class="nav-link" href="<?= site_url('cetak_usulan_tugas_baru') ?>">Cetak Usulan</a></li>
                    <?php endif; ?>
                    <?php if (session()->get('level') == 'admin'): ?>
                        <li class="nav-item"> <a class="nav-link" href="<?= site_url('cetak_usulan_tugas_baru') ?>">Verifikasi Pengajuan</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">Report</li>
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('laporan') ?>">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">Cetak Dokumen</span>
            </a>
        </li>
        <?php if (session()->get('level') == 'root'): ?>
            <li class="nav-item nav-category">UI Elements</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <i class="menu-icon mdi mdi-floor-plan"></i>
                    <span class="menu-title">UI Elements</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="staradmin/dist/pages/ui-features/buttons.html">Buttons</a></li>
                        <li class="nav-item"> <a class="nav-link" href="staradmin/dist/pages/ui-features/dropdowns.html">Dropdowns</a></li>
                        <li class="nav-item"> <a class="nav-link" href="staradmin/dist/pages/ui-features/typography.html">Typography</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                    <i class="menu-icon mdi mdi-card-text-outline"></i>
                    <span class="menu-title">Form elements</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="form-elements">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="staradmin/dist/pages/forms/basic_elements.html">Basic Elements</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                    <i class="menu-icon mdi mdi-chart-line"></i>
                    <span class="menu-title">Charts</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="charts">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="staradmin/dist/pages/charts/chartjs.html">ChartJs</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                    <i class="menu-icon mdi mdi-table"></i>
                    <span class="menu-title">Tables</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="tables">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="staradmin/dist/pages/tables/basic-table.html">Basic table</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                    <i class="menu-icon mdi mdi-layers-outline"></i>
                    <span class="menu-title">Icons</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="icons">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="staradmin/dist/pages/icons/font-awesome.html">Font Awesome</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="menu-icon mdi mdi-account-circle-outline"></i>
                    <span class="menu-title">User Pages</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="auth">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="staradmin/dist/pages/samples/blank-page.html"> Blank Page </a></li>
                        <li class="nav-item"> <a class="nav-link" href="staradmin/dist/pages/samples/error-404.html"> 404 </a></li>
                        <li class="nav-item"> <a class="nav-link" href="staradmin/dist/pages/samples/error-500.html"> 500 </a></li>
                        <li class="nav-item"> <a class="nav-link" href="staradmin/dist/pages/samples/login.html"> Login </a></li>
                        <li class="nav-item"> <a class="nav-link" href="staradmin/dist/pages/samples/register.html"> Register </a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="staradmin/dist/docs/documentation.html">
                    <i class="menu-icon mdi mdi-file-document"></i>
                    <span class="menu-title">Documentation</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<!-- partial -->