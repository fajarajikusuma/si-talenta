document.addEventListener("DOMContentLoaded", function () {
    // Tambahkan style CSS khusus secara dinamis
    const style = document.createElement("style");
    style.innerHTML = `
        /* Atur tampilan isi sel */
        #tableDataPekerja td {
            white-space: normal !important;
            word-wrap: break-word;
            word-break: break-word;
        }

        /* Hilangkan panah sorting DataTables versi vanilla (ES6-style) dan jQuery-style */
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

    // ── Restore search term dari sessionStorage jika ada ─────────────────────
    const SEARCH_KEY = 'dataPekerja_search';
    const savedSearch = sessionStorage.getItem(SEARCH_KEY) || '';

    // Inisialisasi DataTable dengan responsive dan tanpa sorting
    const table = new DataTable('#tableDataPekerja', {
        responsive: true,
        ordering: false,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
        pageLength: 10,
        search: { search: savedSearch }, // langsung isi dengan nilai yang disimpan
    });

    // Simpan search term setiap kali berubah
    table.on('search.dt', function () {
        const currentSearch = table.search();
        sessionStorage.setItem(SEARCH_KEY, currentSearch);
    });

    // ── Simpan search saat klik tombol riwayat ────────────────────────────────
    // Ini memastikan search tersimpan bahkan sebelum event search.dt sempat fire
    document.querySelectorAll('a[href*="riwayat_kerja/riwayat/"]').forEach(function (link) {
        link.addEventListener('click', function () {
            sessionStorage.setItem(SEARCH_KEY, table.search());
        });
    });

    // Hapus label "entries per page" jika ada
    const label = document.querySelector('label[for="dt-length-0"]');
    if (label) label.remove();

    // Tambahkan class text-start ke semua th dan td
    document.querySelectorAll("#tableDataPekerja th, #tableDataPekerja td").forEach((el) => {
        el.classList.add("text-start");
    });
});
