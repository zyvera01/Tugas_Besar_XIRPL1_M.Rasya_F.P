<?php
require_once 'koneksi.php';
if (($_SESSION['role'] ?? '') !== 'admin') {
    http_response_code(403);
    exit('Akses ditolak.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'] ?? '';
    $id = (int)($_POST['id'] ?? 0);
    $mapel_id = (int)($_POST['mapel_id'] ?? 0);
    $siswa_id = (int)($_POST['siswa_id'] ?? 0);

    if ($aksi === 'hapus') {
        $stmt = siapkan($koneksi, 'DELETE FROM mengajar WHERE id = ?', 'i', $id);
        if ($stmt) { mysqli_stmt_close($stmt); alert_redirect('Data mengajar berhasil dihapus.', 'mengajar.php'); }
        alert_redirect('Data mengajar gagal dihapus.', 'mengajar.php');
    }

    if ($mapel_id < 1 || $siswa_id < 1) {
        alert_redirect('Mata pelajaran dan siswa wajib dipilih.', 'mengajar.php');
    }

    if ($aksi === 'tambah') {
        $stmt = siapkan($koneksi, 'INSERT INTO mengajar (mapel_id, siswa_id) VALUES (?, ?)', 'ii', $mapel_id, $siswa_id);
        if ($stmt) { mysqli_stmt_close($stmt); alert_redirect('Data mengajar berhasil ditambahkan.', 'mengajar.php'); }
        alert_redirect('Data gagal ditambahkan. Pasangan mata pelajaran dan siswa mungkin sudah ada atau tidak valid.', 'mengajar.php');
    }

    if ($aksi === 'ubah') {
        $stmt = siapkan($koneksi, 'UPDATE mengajar SET mapel_id = ?, siswa_id = ? WHERE id = ?', 'iii', $mapel_id, $siswa_id, $id);
        if ($stmt) { mysqli_stmt_close($stmt); alert_redirect('Data mengajar berhasil diperbarui.', 'mengajar.php'); }
        alert_redirect('Data mengajar gagal diperbarui.', 'mengajar.php');
    }
}

$edit_id = (int)($_GET['edit'] ?? 0);
$edit_data = $edit_id ? ambil_satu($koneksi, 'SELECT id, mapel_id, siswa_id FROM mengajar WHERE id = ?', 'i', $edit_id) : null;
$mapel = ambil_semua($koneksi, 'SELECT id, kode_mapel, nama_mapel FROM mapel ORDER BY nama_mapel');
$siswa = ambil_semua($koneksi, 'SELECT id, nis, nama, kelas FROM siswa ORDER BY nama');
$data = ambil_semua($koneksi, 'SELECT m.id, m.mapel_id, m.siswa_id, mp.kode_mapel, mp.nama_mapel, s.nis, s.nama AS nama_siswa, s.kelas FROM mengajar m JOIN mapel mp ON mp.id=m.mapel_id JOIN siswa s ON s.id=m.siswa_id ORDER BY m.id DESC');
require 'navbar.php';
?>
<main class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div><h1 class="h2 mb-1">Kelola Mengajar</h1><p class="text-secondary mb-0">Atur relasi mata pelajaran dan siswa.</p></div>
    </div>
    <div class="card border-0 shadow-sm mb-4"><div class="card-body p-4">
        <h2 class="h5 mb-3"><?= $edit_data ? 'Edit data mengajar' : 'Tambah data mengajar' ?></h2>
        <form method="post" class="row g-3">
            <input type="hidden" name="aksi" value="<?= $edit_data ? 'ubah' : 'tambah' ?>">
            <?php if ($edit_data): ?><input type="hidden" name="id" value="<?= (int)$edit_data['id'] ?>"><?php endif; ?>
            <div class="col-md-6"><label for="mapel_id" class="form-label">Mata pelajaran</label><select class="form-select" id="mapel_id" name="mapel_id" required><option value="">Pilih mapel</option><?php foreach ($mapel as $m): ?><option value="<?= (int)$m['id'] ?>" <?= (int)($edit_data['mapel_id'] ?? 0)===(int)$m['id']?'selected':'' ?>><?= e($m['kode_mapel'].' — '.$m['nama_mapel']) ?></option><?php endforeach; ?></select></div>
            <div class="col-md-6"><label for="siswa_id" class="form-label">Siswa</label><select class="form-select" id="siswa_id" name="siswa_id" required><option value="">Pilih siswa</option><?php foreach ($siswa as $s): ?><option value="<?= (int)$s['id'] ?>" <?= (int)($edit_data['siswa_id'] ?? 0)===(int)$s['id']?'selected':'' ?>><?= e($s['nis'].' — '.$s['nama'].' ('.$s['kelas'].')') ?></option><?php endforeach; ?></select></div>
            <div class="col-12"><button class="btn btn-primary" type="submit"><?= $edit_data ? 'Simpan perubahan' : 'Tambah relasi' ?></button><?php if ($edit_data): ?> <a class="btn btn-outline-secondary" href="mengajar.php">Batal</a><?php endif; ?></div>
        </form>
        <?php if (!$mapel || !$siswa): ?><p class="small text-danger mt-3 mb-0">Tambahkan minimal satu data mapel dan siswa terlebih dahulu.</p><?php endif; ?>
    </div></div>
    <div class="card border-0 shadow-sm"><div class="card-body p-0"><div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead class="table-light"><tr><th class="ps-3">ID</th><th>Kode Mapel</th><th>Mata Pelajaran</th><th>NIS</th><th>Nama Siswa</th><th>Kelas</th><th>Aksi</th></tr></thead><tbody>
    <?php if (!$data): ?><tr><td colspan="7" class="text-center text-secondary py-4">Belum ada data mengajar.</td></tr><?php endif; ?>
    <?php foreach ($data as $d): ?><tr><td class="ps-3"><?= (int)$d['id'] ?></td><td><?= e($d['kode_mapel']) ?></td><td><?= e($d['nama_mapel']) ?></td><td><?= e($d['nis']) ?></td><td><?= e($d['nama_siswa']) ?></td><td><?= e($d['kelas']) ?></td><td><a class="btn btn-sm btn-outline-primary" href="mengajar.php?edit=<?= (int)$d['id'] ?>">Edit</a> <form method="post" class="d-inline" onsubmit="return confirm('Hapus relasi mengajar ini?')"><input type="hidden" name="aksi" value="hapus"><input type="hidden" name="id" value="<?= (int)$d['id'] ?>"><button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button></form></td></tr><?php endforeach; ?>
    </tbody></table></div></div></div>
</main>
<?php require 'footer.php'; ?>
