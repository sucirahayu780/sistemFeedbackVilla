<?php
session_start();

require 'functions.php';
require 'templates/header.php';

// Query untuk mendapatkan data responden unik berdasarkan id_pelanggan
$dataResponden = mysqli_query($conn, "
    SELECT id_pelanggan, nama, telp, 
    DATE(waktu_submit) AS tanggal_submit, 
    TIME(waktu_submit) AS waktu_submit
    FROM feedbackresponden
    GROUP BY id_pelanggan, nama, telp, DATE(waktu_submit), TIME(waktu_submit)
");
?>

<main class="main users chart-page" id="skip-target">
    <div class="container">
        <h2 class="main-title">Data Responden</h2>
        <div class="users-table table-wrapper">
            <table id="dataResponden" class="posts-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pelanggan</th>
                        <th>Nama</th>
                        <th>No Telp</th>
                        <th>Waktu</th>
                        <th>Tanggal</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1; // Nomor urut
                    while ($row = mysqli_fetch_assoc($dataResponden)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['id_pelanggan']); ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= htmlspecialchars($row['telp']); ?></td>
                            <td><?= htmlspecialchars($row['waktu_submit']); ?></td>
                            <td><?= htmlspecialchars($row['tanggal_submit']); ?></td>
                            <td>
                                <a href="detailFeedback.php?id_pelanggan=<?= $row['id_pelanggan']; ?>&tanggal=<?= $row['tanggal_submit']; ?>&waktu=<?= $row['waktu_submit']; ?>"
                                    class="primary-default-btn">Detail</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Inisialisasi DataTables -->
<script>
    $(document).ready(function() {
        $('#dataResponden').DataTable({
            "pageLength": 10, // Menampilkan 10 data per halaman
            dom: 'Bfrtip',
            buttons: [
                'pdfHtml5',
                'excelHtml5'
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });
    });
</script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<!-- Chart library -->
<script src="plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>

<?php
require 'templates/footer.php';
?>