<?php
session_start();

require 'functions.php';
require 'templates/header.php';
// Ambil data dari URL
$id_pelanggan = $_GET['id_pelanggan'];
$tanggal = $_GET['tanggal'];
$waktu = $_GET['waktu'];

// Query untuk mengambil feedback berdasarkan pelanggan dan waktu_submit
$feedbackQuery = mysqli_query($conn, "
    SELECT df.pertanyaan, fr.jawaban
    FROM feedbackresponden fr
    JOIN datafeedback df ON fr.id_feedback = df.id_feedback
    WHERE fr.id_pelanggan = '$id_pelanggan' 
    AND DATE(fr.waktu_submit) = '$tanggal' 
    AND TIME(fr.waktu_submit) = '$waktu'
");

?>

<main class="main users chart-page" id="skip-target">
    <div class="container">
        <h2 class="main-title">Data Responden</h2>
        <div class="users-table table-wrapper">
            <table class="posts-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pertanyaan</th>
                        <th>Jawaban</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($feedbackQuery)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['pertanyaan']); ?></td>
                            <td><?= htmlspecialchars($row['jawaban']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <a href="dataResponden.php" class="primary-default-btn">Kembali</a>
        </div>
    </div>
</main>

<?php
require 'templates/footer.php';
?>