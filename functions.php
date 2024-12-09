<?php
date_default_timezone_set('Asia/Jakarta');

$conn = mysqli_connect("localhost", "root", "", "posyandu");

function register($data)
{
    global $conn;

    $username = strtolower(htmlspecialchars($data['username'], ENT_QUOTES, 'UTF-8'));
    $user = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($user) > 0) {
        return 400; // GAGAL! USER TELAH TERDAFTAR
    }
    $nama = htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8');
    $tempat_lahir = $data['tempat_lahir'];
    $tanggal_lahir = new DateTime($data['tanggal_lahir']);
    $tanggal_lahir = $tanggal_lahir->format('Y-m-d');
    $telp = $data['telp'];
    $pendidikan = $data['pendidikan'];
    $role = 2;

    $password = $data['password'];
    $confirmPassword = $data['confirmPassword'];

    if ($password !== $confirmPassword) {
        return 300; // PASSWORD DAN CONFIRM PASSWORD TIDAK MATCH
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO user VALUES ('', '$username', '$password', '$nama', '$tempat_lahir', '$tanggal_lahir', '$telp', '$pendidikan', '$role')");
    return 200; // SUCCESS
}

function login($data)
{
    global $conn;

    $username = strtolower(htmlspecialchars($data['username'], ENT_QUOTES, 'UTF-8'));
    $user = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($user) === 0) {
        return 400; // GAGAL! USER TIDAK TERDAFTAR
    }

    $user = mysqli_fetch_assoc($user);

    $password = $data['password'];

    if (!password_verify($password, $user['password'])) {
        return 300; // PASSWORD SALAH
    }

    return 200; // SUCCESS
}

function tambahDataIbu($data)
{
    global $conn;

    $nik = $data['nik'];
    $dataIbu = mysqli_query($conn, "SELECT * FROM dataIbu WHERE nik='$nik'");
    if (mysqli_num_rows($dataIbu) > 0) {
        return 300; // GAGAL! NIK TELAH TERDAFTAR
    }

    $nama = htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8');
    $tempat_lahir = $data['tempat_lahir'];
    $tanggal_lahir = new DateTime($data['tanggal_lahir']);
    $tanggal_lahir = $tanggal_lahir->format('Y-m-d');
    $alamat = $data['alamat'];
    $golongan_darah = $data['golongan_darah'];
    $suami = $data['suami'];
    $telp = $data['telp'];

    mysqli_query($conn, "INSERT INTO dataIbu VALUES ('', '$nik', '$nama', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$golongan_darah', '$suami', '$telp')");
    return 200; // SUCCESS
}

function suntingDataIbu($data)
{
    global $conn;

    $nik = $data['nik'];
    $nama = htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8');
    $tempat_lahir = $data['tempat_lahir'];
    $tanggal_lahir = new DateTime($data['tanggal_lahir']);
    $tanggal_lahir = $tanggal_lahir->format('Y-m-d');
    $alamat = $data['alamat'];
    $golongan_darah = $data['golongan_darah'];
    $suami = $data['suami'];
    $telp = $data['telp'];

    mysqli_query($conn, "UPDATE dataIbu SET nama='$nama', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', alamat='$alamat', golongan_darah='$golongan_darah', suami='$suami', telp='$telp' WHERE nik='$nik'");
    return 200; // SUCCESS
}

function hitungUmur($tanggal_lahir)
{
    $lahir = new DateTime($tanggal_lahir);
    $hari_ini = new DateTime('today');
    $umur = $lahir->diff($hari_ini);

    return $umur->y . " tahun, " . $umur->m . " bulan, " . $umur->d . " hari";
}

function tambahDataBalita($data)
{
    global $conn;

    $nama = htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8');
    $tempat_lahir = $data['tempat_lahir'];
    $tanggal_lahir = new DateTime($data['tanggal_lahir']);
    $tanggal_lahir = $tanggal_lahir->format('Y-m-d');
    $jenis_kelamin = $data['jenis_kelamin'];
    $ibu_id = $data['ibu_id'];

    mysqli_query($conn, "INSERT INTO dataBalita VALUES ('', '$nama', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$ibu_id')");
    return 200; // SUCCESS
}

function suntingDataBalita($data)
{
    global $conn;

    $id = $data['id'];
    $nama = htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8');
    $tempat_lahir = $data['tempat_lahir'];
    $tanggal_lahir = new DateTime($data['tanggal_lahir']);
    $tanggal_lahir = $tanggal_lahir->format('Y-m-d');
    $jenis_kelamin = $data['jenis_kelamin'];
    $ibu_id = $data['ibu_id'];

    mysqli_query($conn, "UPDATE dataBalita SET 
        nama='$nama', 
        tempat_lahir='$tempat_lahir', 
        tanggal_lahir='$tanggal_lahir', 
        jenis_kelamin='$jenis_kelamin', 
        ibu_id='$ibu_id' 
        WHERE id='$id'");
    return 200; // SUCCESS
}

function tambahDataJenisImunisasi($data)
{
    global $conn;

    $nama = htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8');
    $keterangan = $data['keterangan'];

    mysqli_query($conn, "INSERT INTO dataImunisasi VALUES ('', '$nama', '$keterangan')");
    return 200; // SUCCESS
}

function suntingDataJenisImunisasi($data)
{
    global $conn;

    $id = $data['id'];
    $nama = htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8');
    $keterangan = $data['keterangan'];

    mysqli_query($conn, "UPDATE dataImunisasi SET 
        nama='$nama', 
        keterangan='$keterangan' 
        WHERE id='$id'");
    return 200; // SUCCESS
}

function calculate_haz($umur, $tinggi_badan, $growth_standards)
{
    if (isset($growth_standards[$umur])) {
        $median_height = $growth_standards[$umur][0];
        $standard_deviation = $growth_standards[$umur][1];
        $haz = ($tinggi_badan - $median_height) / $standard_deviation;
        return $haz;
    } else {
        return null; // Tidak ada data standar untuk usia ini
    }
}

function categorize_growth_status($haz)
{
    if ($haz === null) {
        return 'Data Tidak Lengkap';
    } elseif ($haz >= -2) {
        return 'Normal';
    } elseif ($haz >= -3 && $haz < -2) {
        return 'Potensi Stunting';
    } else {
        return 'Stunting';
    }
}

function deteksi_tbu($haz)
{
    if ($haz === null) {
        return 'Data Tidak Lengkap';
    } elseif ($haz > +2) {
        return 'Tinggi';
    } elseif ($haz >= -2) {
        return 'Normal';
    } elseif ($haz >= -3 && $haz < -2) {
        return 'Pendek';
    } else {
        return 'Sangat Pendek';
    }
}

function tambahDataPenimbanganBalita($data)
{
    global $conn;

    $hari_ini = date('Y-m-d');
    $tanggal = new DateTime($hari_ini);
    $tanggal = $tanggal->format('Y-m-d');
    $petugas_id = $_SESSION['data']['id'];
    $balita_id = $data['balita_id'];
    $dataBalita = mysqli_query($conn, "SELECT * FROM dataBalita WHERE id='$balita_id'");
    $dataBalita = mysqli_fetch_assoc($dataBalita);
    $ibu_id = $dataBalita['ibu_id'];
    $tanggal_lahir = $dataBalita['tanggal_lahir'];
    $berat_badan = $data['berat_badan'];
    $tinggi_badan = $data['tinggi_badan'];
    $lingkar_kepala = $data['lingkar_kepala'];

    // Hitung umur balita dalam tahun
    $dob = new DateTime($tanggal_lahir);
    $today = new DateTime($hari_ini);
    $umur_tahun = $today->diff($dob)->y;

    $who_growth_standards = [
        0 => [49.9, 2.0],
        1 => [54.7, 2.2],
        2 => [58.4, 2.3],
        3 => [61.4, 2.4],
        4 => [63.9, 2.5],
        5 => [65.9, 2.5],
    ];

    $haz = calculate_haz($umur_tahun, $tinggi_badan, $who_growth_standards);
    $keterangan = categorize_growth_status($haz);
    $deteksi_tbu = deteksi_tbu($haz);

    mysqli_query($conn, "INSERT INTO dataPenimbanganBalita VALUES ('', '$tanggal', '$petugas_id', '$balita_id', '$ibu_id', '$tanggal_lahir', '$berat_badan', '$tinggi_badan', '$lingkar_kepala', '$deteksi_tbu', '$keterangan')");
    return 200; // SUCCESS
}

function tambahDataImunisasi($data)
{
    global $conn;

    $hari_ini = date('Y-m-d');
    $tanggal = new DateTime($hari_ini);
    $tanggal = $tanggal->format('Y-m-d');
    $balita_id = $data['balita_id'];
    $dataBalita = mysqli_query($conn, "SELECT * FROM dataBalita WHERE id='$balita_id'");
    $dataBalita = mysqli_fetch_assoc($dataBalita);
    $ibu_id = $dataBalita['ibu_id'];
    $tanggal_lahir = $dataBalita['tanggal_lahir'];
    $imunisasi_id = $data['imunisasi_id'];
    $vitamin_a = $data['vitamin_a'];
    $keterangan = $data['keterangan'];

    mysqli_query($conn, "INSERT INTO imunisasi VALUES ('', '$tanggal', '$balita_id', '$ibu_id', '$tanggal_lahir', '$imunisasi_id', '$vitamin_a', '$keterangan')");
    return 200; // SUCCESS
}
