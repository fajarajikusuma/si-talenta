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

    // Inisialisasi DataTable dengan responsive dan tanpa sorting
    const table = new DataTable('#tableDataPekerja', {
        responsive: true,
        ordering: false,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
        pageLength: 10 // Default awal (bisa diganti ke 25 atau lainnya)
    });

    // Hapus label "entries per page" jika ada
    const label = document.querySelector('label[for="dt-length-0"]');
    if (label) label.remove();

    // Tambahkan class text-start ke semua th dan td
    document.querySelectorAll("#tableDataPekerja th, #tableDataPekerja td").forEach((el) => {
        el.classList.add("text-start");
    });
});
