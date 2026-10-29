<?php
require_once "koneksi.php";
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: profil.php"); exit; }
$user_id = (int)$_SESSION['id'];
$role = $_SESSION['role'] ?? '';
$username = trim($_POST['username'] ?? '');
if ($username === '' || strlen($username) > 50 || !preg_match('/^[A-Za-z0-9_.-]+$/', $username)) {
    alert_redirect("Username wajib diisi (maksimal 50 karakter; gunakan huruf, angka, titik, garis bawah, atau strip).", "profil.php");
}
$duplikat = ambil_satu($koneksi, "SELECT id FROM users WHERE username = ? AND id <> ?", "si", $username, $user_id);
if ($duplikat) alert_redirect("Username sudah digunakan akun lain.", "profil.php");
$user = ambil_satu($koneksi, "SELECT password FROM users WHERE id = ?", "i", $user_id);
if (!$user) alert_redirect("Akun tidak ditemukan. Silakan login ulang.", "logout.php");
$nama = trim($_POST['nama'] ?? '');
$jk = $_POST['jenis_kelamin'] ?? '';
if (($role === 'guru' || $role === 'siswa') && ($nama === '' || strlen($nama) > 100 || !in_array($jk, ['L','P'], true))) {
    alert_redirect("Nama dan jenis kelamin harus diisi dengan benar.", "profil.php");
}
$lama = $_POST['password_lama'] ?? '';
$baru = $_POST['password_baru'] ?? '';
$konfirmasi = $_POST['konfirmasi_password'] ?? '';
if ($baru !== '' || $lama !== '' || $konfirmasi !== '') {
    if (!password_verify($lama, $user['password'])) alert_redirect("Password saat ini tidak sesuai.", "profil.php");
    if ($baru !== $konfirmasi) alert_redirect("Konfirmasi password baru tidak sama.", "profil.php");
    $hash = password_hash($baru, PASSWORD_DEFAULT);
    if (!siapkan($koneksi, "UPDATE users SET username = ?, password = ? WHERE id = ?", "ssi", $username, $hash, $user_id)) alert_redirect("Gagal memperbarui akun.", "profil.php");
} else {
    if (!siapkan($koneksi, "UPDATE users SET username = ? WHERE id = ?", "si", $username, $user_id)) alert_redirect("Gagal memperbarui username.", "profil.php");
}
if ($role === 'guru' || $role === 'siswa') {
    $tabel = $role === 'guru' ? 'guru' : 'siswa';
    if (!siapkan($koneksi, "UPDATE {$tabel} SET nama = ?, jenis_kelamin = ? WHERE user_id = ?", "ssi", $nama, $jk, $user_id)) alert_redirect("Akun diperbarui, tetapi data profil gagal disimpan.", "profil.php");
    $_SESSION['nama'] = $nama;
}
$_SESSION['username'] = $username;
if ($role === 'admin') $_SESSION['nama'] = $username;
alert_redirect("Profil berhasil diperbarui.", "profil.php?sukses=1");
