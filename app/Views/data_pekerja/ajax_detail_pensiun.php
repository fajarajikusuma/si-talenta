<?php if (count($data) > 0): ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Pekerjaan</th>
                    <th>Unit Kerja</th>
                    <th>Tanggal Lahir</th>
                    <th>Tanggal Pensiun</th>
                    <th>Usia Saat Ini</th>
                    <!-- <th>Usia Saat Pensiun</th> -->
                    <th>Hitung Mundur Pensiun</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($data as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($row['nama']) ?></td>
                        <td><?= esc($row['pekerjaan']) ?></td>
                        <td><?= esc($row['unit_kerja']) ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_lahir'])) ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_pensiun'])) ?></td>
                        <td>
                            <?php
                            $tanggalLahir = new DateTime($row['tanggal_lahir']);
                            $tanggalSekarang = new DateTime();
                            $usia = $tanggalSekarang->diff($tanggalLahir)->y;
                            echo $usia . ' tahun';
                            ?>
                        </td>
                        <!-- <td>
                            <?php
                            $tanggalLahir = new DateTime($row['tanggal_lahir']);
                            $tanggalPensiun = new DateTime($row['tanggal_pensiun']);
                            $usia = $tanggalPensiun->diff($tanggalLahir)->y;
                            echo $usia . ' tahun';
                            ?>
                        </td> -->
                        <td>
                            <?php
                            $tanggalPensiun = new DateTime($row['tanggal_pensiun']);
                            $tanggalSekarang = new DateTime();
                            $interval = $tanggalSekarang->diff($tanggalPensiun);
                            if ($interval->invert == 0) {
                                echo $interval->format('%y tahun %m bulan %d hari');
                            } else {
                                echo 'Sudah Pensiun';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p class="text-muted">Tidak ada pegawai pensiun di bulan ini.</p>
<?php endif; ?>