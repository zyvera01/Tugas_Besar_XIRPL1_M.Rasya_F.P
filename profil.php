<?php
require_once "koneksi.php";
$user_id = (int)$_SESSION['id'];
$role = $_SESSION['role'] ?? '';
$user = ambil_satu($koneksi, "SELECT id, username, role, created_at FROM users WHERE id = ?", "i", $user_id);
$profil = null;
if ($role === 'guru') {
    $profil = ambil_satu($koneksi, "SELECT nip AS nomor, nama, jenis_kelamin FROM guru WHERE user_id = ?", "i", $user_id);
} elseif ($role === 'siswa') {
    $profil = ambil_satu($koneksi, "SELECT nis AS nomor, nama, kelas, jenis_kelamin FROM siswa WHERE user_id = ?", "i", $user_id);
}
if (!$user) { header("Location: logout.php"); exit; }
require "navbar.php";
?>
<div class="container mt-4 mb-5" style="max-width:850px">
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div><h1 class="h2 mb-1">Profil Saya</h1><p class="text-secondary mb-0">Kelola informasi akun dan data pribadi.</p></div>
    <span class="badge text-bg-primary text-uppercase"><?= e($role) ?></span>
  </div>
  <?php if (!empty($_GET['sukses'])): ?><div class="alert alert-success">Profil berhasil diperbarui.</div><?php endif; ?>
  <?php if ($role !== 'admin' && !$profil): ?><div class="alert alert-warning">Data profil belum terhubung dengan akun ini. Hubungi admin sekolah.</div><?php endif; ?>
  <div class="card shadow-sm mb-4"><div class="card-header fw-semibold">Informasi Akun</div><div class="card-body">
    <div class="row mb-2"><div class="col-sm-4 text-secondary">Username</div><div class="col-sm-8"><?= e($user['username']) ?></div></div>
    <div class="row mb-2"><div class="col-sm-4 text-secondary">Role</div><div class="col-sm-8 text-capitalize"><?= e($role) ?></div></div>
    <div class="row"><div class="col-sm-4 text-secondary">Akun dibuat</div><div class="col-sm-8"><?= e($user['created_at'] ?? '-') ?></div></div>
  </div></div>
  <div class="card shadow-sm"><div class="card-header fw-semibold">Edit Profil</div><div class="card-body">
    <form action="aksi_profil.php" method="post">
      <div class="mb-3"><label class="form-label" for="username">Username</label><input class="form-control" id="username" name="username" maxlength="50" value="<?= e($user['username']) ?>" required></div>
      <?php if ($role === 'guru' || $role === 'siswa'): ?>
      <div class="mb-3"><label class="form-label" for="nomor"><?= $role === 'guru' ? 'NIP' : 'NIS' ?></label><input class="form-control" id="nomor" value="<?= e($profil['nomor'] ?? '') ?>" disabled><div class="form-text">Nomor identitas dikelola oleh admin.</div></div>
      <div class="mb-3"><label class="form-label" for="nama">Nama lengkap</label><input class="form-control" id="nama" name="nama" maxlength="100" value="<?= e($profil['nama'] ?? '') ?>" required></div>
      <?php if ($role === 'siswa'): ?><div class="mb-3"><label class="form-label" for="kelas">Kelas</label><input class="form-control" id="kelas" value="<?= e($profil['kelas'] ?? '') ?>" disabled><div class="form-text">Perubahan kelas dilakukan oleh admin.</div></div><?php endif; ?>
      <div class="mb-3"><label class="form-label" for="jenis_kelamin">Jenis kelamin</label><select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required><option value="L" <?= ($profil['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' ?>>Laki-laki</option><option value="P" <?= ($profil['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>Perempuan</option></select></div>
      <?php endif; ?>
      <hr><h2 class="h6">Ganti Password <span class="text-secondary fw-normal">(opsional)</span></h2>
      <div class="mb-3"><label class="form-label" for="password_lama">Password saat ini</label><input class="form-control" type="password" id="password_lama" name="password_lama" autocomplete="current-password"><div class="form-text">Wajib diisi jika ingin mengganti password.</div></div>
      <div class="mb-3"><label class="form-label" for="password_baru">Password baru</label><input class="form-control" type="password" id="password_baru" name="password_baru" autocomplete="new-password"><div class="form-text">Isi password baru sesuai keinginanmu.</div></div>
      <div class="mb-3"><label class="form-label" for="konfirmasi_password">Ulangi password baru</label><input class="form-control" type="password" id="konfirmasi_password" name="konfirmasi_password" autocomplete="new-password"></div>
      <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
      <a class="btn btn-outline-secondary" href="dashboard.php">Batal</a>
    </form>
  </div></div>
</div>
<?php require "footer.php"; ?>
