<?php
session_start();
if (isset($_SESSION['data'])) {
  header("Location: index.php");
}

require 'functions.php';

if (isset($_POST['LOGIN'])) {
  $result = login($_POST);
  if ($result == 200) {
    $username = $_POST['username'];
    $user = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    $user = mysqli_fetch_assoc($user);
    $_SESSION['data'] = $user;
    header("Location: index.php");
    exit();
  } elseif ($result == 300) {
    echo "<script>alert('Gagal masuk! Username atau password salah.'); window.location.href = 'login.php';</script>";
  } else {
    echo "<script>alert('Gagal masuk! Pengguna tidak terdaftar.'); window.location.href = 'login.php';</script>";
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
  <link rel="shortcut icon" href="img/svg/Logo.svg" type="image/x-icon">

  <!-- Custom styles -->
  <link rel="stylesheet" href="css/style.min.css">
</head>

<body>
  <div class="layer"></div>
  <main class="page-center">
    <article class="sign-up">
      <h1 class="sign-up__title">Sistem Feedback Villa</h1>
      <p class="sign-up__subtitle">Masuk</p>
      <form class="sign-up-form form" action="" method="post">
        <label class="form-label-wrapper">
          <p class="form-label">Username</p>
          <input class="form-input" type="text" name="username" placeholder="Enter username" autocomplete="off" required>
        </label>
        <label class="form-label-wrapper">
          <p class="form-label">Password</p>
          <input class="form-input" type="password" name="password" placeholder="Enter your password" required>
        </label>
        <button type="submit" name="LOGIN" class="form-btn primary-default-btn transparent-btn">Masuk</button>

        <p class="form-label">Belum memiliki akun? <a href="register.php" style="color:blue">Registrasi!</a></p>
      </form>
    </article>
  </main>

  <!-- Chart library -->
  <script src="plugins/chart.min.js"></script>

  <!-- Icons library -->
  <script src="plugins/feather.min.js"></script>

  <!-- Custom scripts -->
  <script src="js/script.js"></script>
</body>

</html>