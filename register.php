<?php
session_start();
if (!empty($_SESSION['login'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Siswa - SIPN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{min-height:100vh;background:#f1f3f5}.kotak-daftar{width:100%;max-width:520px}</style>
</head>
<body class="d-flex align-items-center justify-content-center p-3">
<div class="kotak-daftar">
    <div class="text-center mb-4"><h1 class="fw-semibold mb-1">SIPN</h1><p class="text-muted mb-0">Pendaftaran akun siswa</p></div>
    <div class="card shadow-sm"><div class="card-body p-4">
        <h4 class="mb-3">Buat akun siswa</h4>
        <form action="aksi_register.php" method="post" autocomplete="on">
            <div class="mb-3"><label class="form-label" for="nama">Nama lengkap</label><input class="form-control" id="nama" name="nama" maxlength="100" required></div>
            <div class="row g-3">
                <div class="col-sm-6"><label class="form-label" for="nis">NIS</label><input class="form-control" id="nis" name="nis" maxlength="10" required></div>
                <div class="col-sm-6"><label class="form-label" for="kelas">Kelas</label><input class="form-control" id="kelas" name="kelas" maxlength="10" placeholder="XI RPL 1" required></div>
            </div>
            <div class="mt-3 mb-3"><label class="form-label" for="jenis_kelamin">Jenis kelamin</label><select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required><option value="">Pilih jenis kelamin</option><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>
            <hr>
            <div class="mb-3"><label class="form-label" for="username">Username</label><input class="form-control" id="username" name="username" maxlength="50" autocomplete="username" required></div>
            <div class="mb-4"><label class="form-label" for="password">Password (minimal 8 karakter)</label><input type="password" class="form-control" id="password" name="password" minlength="8" autocomplete="new-password" required></div>
            <button class="btn btn-primary w-100" type="submit">Daftar</button>
        </form>
        <p class="text-center text-muted small mt-3 mb-0">Sudah punya akun? <a href="login.php">Masuk</a></p>
    </div></div>
</div>
</body>
</html>
