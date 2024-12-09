<?php
session_start();
if (!isset($_SESSION['data'])) {
  header("Location: login.php");
}

require 'functions.php';

$queryIbu = "SELECT COUNT(*) as total FROM dataIbu";
$resultIbu = mysqli_query($conn, $queryIbu);
$dataIbu = mysqli_fetch_assoc($resultIbu);
$jumlahDataIbu = $dataIbu['total'];

$queryBalita = "SELECT COUNT(*) as total FROM dataBalita";
$resultBalita = mysqli_query($conn, $queryBalita);
$dataBalita = mysqli_fetch_assoc($resultBalita);
$jumlahDataBalita = $dataBalita['total'];

$queryPetugas = "SELECT COUNT(*) as total FROM user";
$resultPetugas = mysqli_query($conn, $queryPetugas);
$dataPetugas = mysqli_fetch_assoc($resultPetugas);
$jumlahDataPetugas = $dataPetugas['total'];

$queryStunting = "SELECT COUNT(*) as total FROM dataPenimbanganBalita WHERE keterangan='Stunting'";
$resultStunting = mysqli_query($conn, $queryStunting);
$dataStunting = mysqli_fetch_assoc($resultStunting);
$jumlahDataStunting = $dataStunting['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sistem Feedback Villa</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="css/style.min.css" />
</head>

<body>
  <!-- ! Body -->
  <div class="page-flex">
    <!-- ! Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-start">

        <div class="sidebar-head">
          <a href="" class="logo-wrapper" title="Home">
            <span class="icon logo" aria-hidden="true"></span>
            <div class="logo-text">
              <span class="logo-title">Villa</span>
            </div>
          </a>

          <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
            <span class="sr-only">Toggle menu</span>
            <span class="icon menu-toggle" aria-hidden="true"></span>
          </button>
        </div>

        <div class="sidebar-body">
          <ul class="sidebar-body-menu">

            <li>
              <a class="active" href="index.php"><span class="icon home" aria-hidden="true"></span>Dashboard</a>
            </li>

            <li>
              <a class="show-cat-btn" href="##">
                <span class="icon document" aria-hidden="true"></span>Master Data
                <span class="category__btn transparent-btn" title="Open list">
                  <span class="sr-only">Open list</span>
                  <span class="icon arrow-down" aria-hidden="true"></span>
                </span>
              </a>
              <ul class="cat-sub-menu">

                <?php
                if ($_SESSION['data']['role'] == 1) {
                ?>
                  <li>
                    <a href="dataPetugas.php">Data Petugas</a>
                  </li>
                <?php
                }
                ?>
              </ul>
            </li>


            <li>
              <a class="show-cat-btn" href="##">
                <span class="icon paper" aria-hidden="true"></span>Feedback
                <span class="category__btn transparent-btn" title="Open list">
                  <span class="sr-only">Open list</span>
                  <span class="icon arrow-down" aria-hidden="true"></span>
                </span>
              </a>
              <ul class="cat-sub-menu">
                <li>
                  <a href="dataFeedback.php">Data Feedback</a>
                </li>
                <li>
                  <a href="dataResponden.php">Data Responden</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </aside>

    <div class="main-wrapper">
      <!-- ! Main nav -->
      <nav class="main-nav--bg">
        <div class="container main-nav">
          <div class="main-nav-start">
            <h1>Sistem Feedback Villa Parikesit</h1>
          </div>
          <div class="main-nav-end">
            <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
              <span class="sr-only">Toggle menu</span>
              <span class="icon menu-toggle--gray" aria-hidden="true"></span>
            </button>

            <button class="theme-switcher gray-circle-btn" type="button" title="Switch theme">
              <span class="sr-only">Switch theme</span>
              <i class="sun-icon" data-feather="sun" aria-hidden="true"></i>
              <i class="moon-icon" data-feather="moon" aria-hidden="true"></i>
            </button>

            <div class="nav-user-wrapper">
              <a class="danger" href="logout.php">
                <i data-feather="log-out" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
      </nav>

      <!-- ! Main -->
      <main class="main users chart-page" id="skip-target">
        <div class="container">
          <h2 class="main-title">Dashboard</h2>
          <div class="row stat-cards">
              </article>
            </div>
            <div class="col-md-6 col-xl-3">
              <article class="stat-cards-item">
                <div class="stat-cards-icon primary">
                  <i data-feather="bar-chart-2" aria-hidden="true"></i>
                </div>
                <div class="stat-cards-info">
                  <p class="stat-cards-info__num"><?= $jumlahDataPetugas ?></p>
                  <p class="stat-cards-info__title">Total Data Petugas</p>
                </div>
              </article>
            </div>
            
            <?php

            // Query untuk mendapatkan data pertanyaan dan jumlah jawaban
            $query = "
    SELECT df.id_feedback, df.pertanyaan, fr.jawaban, COUNT(fr.jawaban) AS jumlah_jawaban
    FROM feedbackresponden fr
    JOIN datafeedback df ON fr.id_feedback = df.id_feedback
    GROUP BY df.id_feedback, fr.jawaban
";

            $dataResponden = mysqli_query($conn, $query);

            // Mengolah data untuk setiap grafik
            $feedbackData = [];
            while ($row = mysqli_fetch_assoc($dataResponden)) {
              $id_feedback = $row['id_feedback'];
              if (!isset($feedbackData[$id_feedback])) {
                $feedbackData[$id_feedback] = [
                  'pertanyaan' => $row['pertanyaan'],
                  'jawaban' => [],
                  'jumlah' => []
                ];
              }
              $feedbackData[$id_feedback]['jawaban'][] = $row['jawaban'];
              $feedbackData[$id_feedback]['jumlah'][] = (int)$row['jumlah_jawaban'];
            }
            ?>


            <div class="container">
              <h2 class="main-title">Feedback Statistik</h2>
              <div class="chart-grid">
                <?php foreach ($feedbackData as $id_feedback => $data): ?>
                  <div class="chart-item">
                    <h3 class="chart-title"><?= htmlspecialchars($data['pertanyaan']); ?></h3>
                    <canvas id="chart-<?= $id_feedback; ?>"></canvas>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>


            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
              // Data dari PHP
              const feedbackData = <?php echo json_encode($feedbackData); ?>;

              // Membuat grafik untuk setiap pertanyaan
              Object.keys(feedbackData).forEach(id_feedback => {
                const ctx = document.getElementById('chart-' + id_feedback).getContext('2d');
                const data = feedbackData[id_feedback];

                new Chart(ctx, {
                  type: 'bar',
                  data: {
                    labels: data.jawaban, // Label menggunakan jawaban
                    datasets: [{
                      label: 'Jumlah Jawaban',
                      data: data.jumlah, // Data jumlah jawaban
                      backgroundColor: '#76ABAE',
                      borderColor: '#76ABAE',
                      borderWidth: 1
                    }]
                  },
                  options: {
                    responsive: true,
                    scales: {
                      y: {
                        beginAtZero: true
                      }
                    }
                  }
                });
              });
            </script>

            <style>
              .chart-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
                /* 2 kolom per baris */
                gap: 20px;
              }

              .chart-item {
                border: 1px solid #ddd;
                padding: 15px;
                border-radius: 8px;
                background-color: #f9f9f9;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
              }

              .chart-title {
                text-align: center;
                font-size: 16px;
                margin-bottom: 10px;
              }
            </style>
            <!-- ! Footer -->
            <footer class="footer">
              <div class="container footer--flex">
                <div class="footer-start">
                  <p>
                    2024 © Sistem Feedback Villa
                  </p>
                </div>
              </div>
          </div>
        </div>
        <!-- Chart library -->
        <script src="plugins/chart.min.js"></script>
        <!-- Icons library -->
        <script src="plugins/feather.min.js"></script>
        <!-- Custom scripts -->
        <script src="js/script.js"></script>
</body>

</html>