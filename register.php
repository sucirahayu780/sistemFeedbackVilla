<?php
require 'functions.php';

if (isset($_POST['REGISTER'])) {
  $result = register($_POST);
  if ($result == 200) {
    echo "<script>alert('Registrasi berhasil!'); window.location.href = 'register.php';</script>";
  } elseif ($result == 300) {
    echo "<script>alert('Registrasi gagal! Password dan konfrimasi password tidak sama.'); window.location.href = 'register.php';</script>";
  } else {
    echo "<script>alert('Registrasi gagal! Pengguna sudah terdaftar.'); window.location.href = 'register.php';</script>";
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Feedback Villa</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
  <!-- Custom styles -->
  <link rel="stylesheet" href="./css/style.min.css">
</head>

<body>
  <div class="layer"></div>
  <main class="page-center">
    <article class="sign-up">
      <h1 class="sign-up__title">Sistem Feedback Villa</h1>
      <p class="sign-up__subtitle">Registrasi</p>
      <form class="sign-up-form form" action="" method="post">
        <label class="form-label-wrapper">
          <p class="form-label">Username</p>
          <input class="form-input" type="text" name="username" placeholder="Ketikkan username" autocomplete="off" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Password</p>
          <input class="form-input" type="password" name="password" placeholder="Ketikkan password" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Konfirmasi Password</p>
          <input class="form-input" type="password" name="confirmPassword" placeholder="Konfirmasi password" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Nama</p>
          <input class="form-input" type="text" name="nama" placeholder="Ketikkan nama" autocomplete="off" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Tempat Lahir</p>
          <input class="form-input" type="text" name="tempat_lahir" placeholder="Ketikkan tempat lahir" autocomplete="off" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Tanggal Lahir</p>
          <input class="form-input" type="date" name="tanggal_lahir" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Nomor Handphone</p>
          <input class="form-input" type="number" name="telp" placeholder="Ketikkan nomor handphone" autocomplete="off" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Pendidikan Terakhir</p>
          <select name="pendidikan" class="form-input" required>
            <option value="SD / Sederajat">SD / Sederajat</option>
            <option value="SMP / Sederajat">SMP / Sederajat</option>
            <option value="SMA / Sederajat">SMA / Sederajat</option>
            <option value="Diploma / Sederajat">Diploma / Sederajat</option>
            <option value="Sarjana / Sederajat">Sarjana / Sederajat</option>
            <option value="Magister / Sederajat">Magister / Sederajat</option>
            <option value="Professor / Sederajat">Professor / Sederajat</option>
          </select>
        </label>
        <br>
        <button type="submit" name="REGISTER" class="form-btn primary-default-btn transparent-btn">Registrasi</button>
        <p class="form-label">Sudah memeiliki akun? <a href="login.php" style="color:blue">Masuk!</a></p>
      </form>
    </article>
  </main>
  <!-- Chart library -->
  <script src="./plugins/chart.min.js"></script>
  <!-- Icons library -->
  <script src="plugins/feather.min.js"></script>
  <!-- Custom scripts -->
  <script src="js/script.js"></script>
</body>

</html>