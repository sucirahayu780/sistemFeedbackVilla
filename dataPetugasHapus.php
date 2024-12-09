<?php
session_start();
if (!isset($_SESSION['data'])) {
    header("Location: login.php");
}

require 'functions.php';

if (!isset($_GET['id'])) {
    header("Location: dataPetugas.php");
    exit();
}

if ($_SESSION['data']['id'] != $user['id']) {
    header("Location: dataPetugas.php");
    exit();
}

$id = $_GET['id'];

$dataPetugas = mysqli_query($conn, "SELECT * FROM user WHERE id='$id'");

if (mysqli_num_rows($dataPetugas) == 0) {
    header("Location: dataPetugas.php");
    exit();
}

mysqli_query($conn, "DELETE FROM user WHERE id='$id'");

echo "<script>alert('Berhasil menghapus data petugas!'); window.location.href = 'dataPetugas.php';</script>";
