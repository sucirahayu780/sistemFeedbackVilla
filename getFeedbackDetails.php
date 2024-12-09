<?php
require 'functions.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil data pertanyaan dan jawaban berdasarkan ID
    $query = "SELECT f.pertanyaan, r.jawaban 
              FROM feedbackresponden r
              JOIN feedback f ON r.id_feedback = f.id_feedback
              WHERE r.id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode(['pertanyaan' => 'Tidak ditemukan', 'jawaban' => 'Tidak ditemukan']);
    }
}
