document.addEventListener("DOMContentLoaded", function () {
    const tableEl = document.getElementById('tableDataPekerja');
    if (!tableEl) return; // hanya jalan di halaman yang punya tabel ini

    // Tambahkan style CSS khusus secara dinamis
    const style = document.createElement("style");
    style.innerHTML = `
        #tableDataPekerja td {
            white-space: normal !important;
            word-wrap: break-word;
            word-break: break-word;
        }
        #tableDataPekerja th.sorting::before,
        #tableDataPekerja th.sorting::after,
        #tableDataPekerja th.sorting_asc::before,
        #tableDataPekerja th.sorting_asc::after,
        #tableDataPekerja th.sorting_desc::before,
        #tableDataPekerja th.sorting_desc::after {
            display: none !important;
        }
    `;
    document.head.appendChild(style);

    const SEARCH_KEY = 'dataPekerja_search';
    const isDataPekerjaPage = window.location.pathname.includes('/data_pekerja/');

    // Restore search hanya di halaman data pekerja
    const savedSearch = isDataPekerjaPage ? (sessionStorage.getItem(SEARCH_KEY) || '') : '';

    const dt = new DataTable('#tableDataPekerja', {
        responsive: true,
        ordering: false,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
        pageLength: 10,
        search: { search: savedSearch },
    });

    if (isDataPekerjaPage) {
        // Simpan search setiap berubah
        dt.on('search.dt', function () {
            const current = dt.search();
            if (current) {
                sessionStorage.setItem(SEARCH_KEY, current);
            } else {
                // User kosongkan search — hapus dari storage
                sessionStorage.removeItem(SEARCH_KEY);
            }
        });

        // Simpan saat klik tombol riwayat (sebelum navigasi)
        document.querySelectorAll('a[href*="riwayat_kerja/riwayat/"]').forEach(function (link) {
            link.addEventListener('click', function () {
                sessionStorage.setItem(SEARCH_KEY, dt.search());
            });
        });
    }

    // Hapus label "entries per page" jika ada
    const label = document.querySelector('label[for="dt-length-0"]');
    if (label) label.remove();

    // Tambahkan class text-start ke semua th dan td
    document.querySelectorAll("#tableDataPekerja th, #tableDataPekerja td").forEach((el) => {
        el.classList.add("text-start");
    });
});
