<?php
session_start();
if (!isset($_SESSION['data'])) {
    header("Location: login.php");
}
require 'functions.php';
require 'templates/header.php';
if (!isset($_GET['id'])) {
    header("Location: dataFeedback.php");
}

$id_feedback = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM dataFeedback WHERE id_feedback = $id_feedback");
$feedback = mysqli_fetch_assoc($result);

if (isset($_POST['submit_edit'])) {
    $pertanyaan = mysqli_real_escape_string($conn, $_POST['pertanyaan']);
    $pilihan = mysqli_real_escape_string($conn, $_POST['pilihan']);
    $query = "UPDATE dataFeedback SET pertanyaan = '$pertanyaan', pilihan = '$pilihan' WHERE id_feedback = $id_feedback";
    mysqli_query($conn, $query);
    header("Location: dataFeedback.php");
}
?>
<style>
    /* Umum */


    .main-title,
    h2 {
        text-align: center;
        font-size: 2em;
        margin-bottom: 20px;
    }

    .primary-default-btn,
    .back-link {
        text-decoration: none;
        color: white;
        padding: 10px 15px;
        border-radius: 4px;
        display: inline-block;
        cursor: pointer;
    }

    .primary-default-btn {
        background-color: #222831;
    }

    .primary-default-btn:hover {
        background-color: #222831;
    }

    .back-link {
        background-color: #6c757d;
        color: white;
        padding: 8px 15px;
        text-align: center;
        display: inline-block;
        margin-top: 10px;
        border-radius: 4px;
    }

    .back-link:hover {
        background-color: #222831;
    }

    /* Form Styling */
    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 15px;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 1.1em;
    }

    textarea,
    input[type="text"] {
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1em;
        width: 100%;
    }

    textarea {
        resize: vertical;
    }

    button[type="submit"] {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 6px;
        font-size: 1em;
        cursor: pointer;
        margin-top: 15px;
    }

    button[type="submit"]:hover {
        background-color: #218838;
    }
</style>
<main class="main users chart-page" id="skip-target">
    <div class="container">
        <h2>Edit Feedback</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="pertanyaan">Pertanyaan:</label>
                <textarea id="pertanyaan" name="pertanyaan" required placeholder="Masukkan pertanyaan feedback"><?= htmlspecialchars($feedback['pertanyaan']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="pilihan">Pilihan (pisahkan dengan tanda koma):</label>
                <input type="text" id="pilihan" name="pilihan" value="<?= htmlspecialchars($feedback['pilihan']); ?>" required placeholder="Masukkan pilihan, pisahkan dengan koma">
            </div>
            <a href="dataFeedback.php" class="back-link">Kembali</a>
            <button type="submit" name="submit_edit" class="primary-default-btn">Simpan Perubahan</button>
        </form>
    </div>
</main>

<?php
require 'templates/footer.php';
?>