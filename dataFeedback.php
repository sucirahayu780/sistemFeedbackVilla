<?php
session_start();

require 'functions.php';
require 'templates/header.php';

// Tambah data feedback
if (isset($_POST['submit_tambah'])) {
    $pertanyaan = mysqli_real_escape_string($conn, $_POST['pertanyaan']);
    $pilihan = mysqli_real_escape_string($conn, $_POST['pilihan']);
    $query = "INSERT INTO dataFeedback (pertanyaan, pilihan) VALUES ('$pertanyaan', '$pilihan')";
    mysqli_query($conn, $query);
    header("Location: dataFeedback.php");
}

// Hapus data feedback
if (isset($_GET['delete'])) {
    $id_feedback = intval($_GET['delete']);
    $query = "DELETE FROM dataFeedback WHERE id_feedback = $id_feedback";
    mysqli_query($conn, $query);
    header("Location: dataFeedback.php");
}

// Ambil semua data feedback
$dataFeedback = mysqli_query($conn, "SELECT * FROM dataFeedback");
?>
<style>
    .primary-default-btn,
    .danger-default-btn {
        text-decoration: none;
        color: white;
        padding: 10px 15px;
        border-radius: 4px;
        display: inline-block;
        cursor: pointer;
    }

    .primary-default-btn {
        background-color: #7EACB5;
    }

    .primary-default-btn:hover {
        background-color: #507687;
    }

    .danger-default-btn {
        background-color: #dc3545;
    }

    .danger-default-btn:hover {
        background-color: #c82333;
    }

    .users-table table-wrapper {
        margin-top: 20px;
        overflow-x: auto;
    }

    /* Form Styling */
    #form-tambah {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 10px;
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
        background-color: #95D2B3;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 6px;
        font-size: 1.1em;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #55AD9B;
    }

    /* Table Styling */
    .posts-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .posts-table th,
    .posts-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .posts-table th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: bold;
    }

    .posts-table tr:hover {
        background-color: #f1f1f1;
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<main class="main users chart-page" id="skip-target">
    <div class="container">
        <h2 class="main-title">Data Feedback</h2>
        <a href="#" class="primary-default-btn" onclick="toggleForm()">Tambah Data Feedback</a>
        <br><br>

        <!-- Form Tambah Data -->
        <div id="form-tambah" style="display:none; margin-top: 10px;">
            <form action="dataFeedback.php" method="POST">
                <label for="pertanyaan">Pertanyaan:</label>
                <textarea id="pertanyaan" name="pertanyaan" required></textarea><br>
                <label for="pilihan">Pilihan (pisahkan dengan tanda koma):</label>
                <input type="text" id="pilihan" name="pilihan" required><br>
                <button type="submit" name="submit_tambah" class="primary-default-btn">Simpan</button>
            </form>
        </div>

        <div class="users-table table-wrapper">
            <table id="dataFeedback" class="posts-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pertanyaan</th>
                        <th>Pilihan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($dataFeedback)): ?>
                        <tr>
                            <td><?= $row['id_feedback']; ?></td>
                            <td><?= htmlspecialchars($row['pertanyaan']); ?></td>
                            <td><?= htmlspecialchars($row['pilihan']); ?></td>
                            <td>
                                <a href="dataFeedbackEdit.php?id=<?= $row['id_feedback']; ?>" class="primary-default-btn">
                                    <i class="fas fa-edit"></i> <!-- Ikon Edit -->
                                </a>
                                <a href="?delete=<?= $row['id_feedback']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?');" class="danger-default-btn">
                                    <i class="fas fa-trash-alt"></i> <!-- Ikon Hapus -->
                                </a>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    function toggleForm() {
        const form = document.getElementById('form-tambah');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>

<?php
require 'templates/footer.php';
?>