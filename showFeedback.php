<?php
require 'functions.php';
session_start();
if (isset($_POST['submit_id_pelanggan'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $_SESSION['id_pelanggan'] = $id_pelanggan;
    $_SESSION['nama'] = $nama;
    $_SESSION['telp'] = $telp;
    header("Location: showFeedback.php");
    exit();
}

if (isset($_POST['submit_feedback']) && isset($_SESSION['id_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];
    $nama = $_SESSION['nama'];
    $telp = $_SESSION['telp'];
    foreach ($_POST['feedback'] as $id_feedback => $jawaban) {
        $id_feedback = intval($id_feedback);
        $jawaban = mysqli_real_escape_string($conn, $jawaban);
        $query = "INSERT INTO feedbackResponden (id_pelanggan, nama, telp, id_feedback, jawaban) 
                  VALUES ($id_pelanggan,'$nama', '$telp', $id_feedback, '$jawaban')";
        mysqli_query($conn, $query);
    }

    $_SESSION['success_message'] = "Terima kasih atas feedback Anda!";
    unset($_SESSION['id_pelanggan']);
    header("Location: showFeedback.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Feedback</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .feedback-item {
            margin-bottom: 15px;
        }

        .primary-default-btn {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }

        .primary-default-btn:hover {
            background-color: #0056b3;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Form Feedback</h1>

        <?php if (isset($_SESSION['success_message'])): ?>
            <p class="success-message"><?= $_SESSION['success_message'];
                                        unset($_SESSION['success_message']); ?></p>
        <?php endif; ?>

        <?php if (!isset($_SESSION['id_pelanggan'])): ?>
            <!-- Langkah 1: Pengisian ID Pelanggan -->
            <form action="showFeedback.php" method="POST">
                <label for="id_pelanggan">ID Pelanggan:</label>
                <input type="text" name="id_pelanggan" required placeholder="Masukkan ID Pelanggan">
                <label for="nama">Nama:</label>
                <input type="text" name="nama" required placeholder="Masukkan Nama">
                <label for="telp">No Telp:</label>
                <input type="number" name="telp" required placeholder="Masukkan No Telepon">
                <button type="submit" name="submit_id_pelanggan" class="primary-default-btn">Lanjutkan</button>
            </form>
        <?php else: ?>
            <!-- Langkah 2: Menampilkan Pertanyaan Feedback -->
            <form action="showFeedback.php" method="POST">
                <?php
                $dataFeedback = mysqli_query($conn, "SELECT * FROM dataFeedback");
                while ($row = mysqli_fetch_assoc($dataFeedback)):
                ?>
                    <div class="feedback-item">
                        <p><strong><?= htmlspecialchars($row['pertanyaan']); ?></strong></p>
                        <?php
                        $pilihan = explode(',', $row['pilihan']);
                        foreach ($pilihan as $option):
                        ?>
                            <label>
                                <input type="radio" name="feedback[<?= $row['id_feedback']; ?>]" value="<?= htmlspecialchars(trim($option)); ?>" required>
                                <?= htmlspecialchars(trim($option)); ?>
                            </label><br>
                        <?php endforeach; ?>
                    </div>
                    <hr>
                <?php endwhile; ?>
                <button type="submit" name="submit_feedback" class="primary-default-btn">Kirim Feedback</button>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>