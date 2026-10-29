<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$nis = trim($_POST['nis'] ?? '');
$kelas = trim($_POST['kelas'] ?? '');
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($nama === '' || $nis === '' || $kelas === '' || $username === '' || $password === '') {
    alert_redirect('Semua kolom wajib diisi.', 'register.php');
}
if (!in_array($jenis_kelamin, ['L', 'P'], true)) {
    alert_redirect('Jenis kelamin tidak valid.', 'register.php');
}
if (strlen($password) < 8) {
    alert_redirect('Password minimal 8 karakter.', 'register.php');
}
if (ambil_satu($koneksi, 'SELECT id FROM users WHERE username = ?', 's', $username)) {
    alert_redirect('Username sudah digunakan. Silakan pilih username lain.', 'register.php');
}
if (ambil_satu($koneksi, 'SELECT id FROM siswa WHERE nis = ?', 's', $nis)) {
    alert_redirect('NIS sudah terdaftar.', 'register.php');
}

mysqli_begin_transaction($koneksi);
try {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmtUser = siapkan($koneksi, "INSERT INTO users (username, password, role) VALUES (?, ?, 'siswa')", 'ss', $username, $hash);
    if (!$stmtUser) {
        throw new Exception('Gagal membuat akun.');
    }
    mysqli_stmt_close($stmtUser);
    $userId = mysqli_insert_id($koneksi);

    $stmtSiswa = siapkan($koneksi, 'INSERT INTO siswa (nis, nama, kelas, jenis_kelamin, user_id) VALUES (?, ?, ?, ?, ?)', 'ssssi', $nis, $nama, $kelas, $jenis_kelamin, $userId);
    if (!$stmtSiswa) {
        throw new Exception('Gagal menyimpan profil siswa. Pastikan NIS belum digunakan.');
    }
    mysqli_stmt_close($stmtSiswa);
    mysqli_commit($koneksi);
    alert_redirect('Pendaftaran berhasil. Silakan login menggunakan akun yang dibuat.', 'login.php');
} catch (Exception $e) {
    mysqli_rollback($koneksi);
    alert_redirect($e->getMessage(), 'register.php');
}
