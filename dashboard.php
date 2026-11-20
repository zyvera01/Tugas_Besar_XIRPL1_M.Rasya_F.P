<?php
require_once "koneksi.php";

$role = $_SESSION['role'] ?? '';
$user_id = (int)($_SESSION['id'] ?? 0);
$nama = $_SESSION['nama'] ?? $_SESSION['username'] ?? 'Pengguna';

function total_data($koneksi, $sql, $types = "", ...$params) {
    $row = ambil_satu($koneksi, $sql, $types, ...$params);
    return (int)($row['total'] ?? 0);
}

$jumlah_user = 0;
$jumlah_guru = 0;
$jumlah_siswa = 0;
$jumlah_mapel = 0;
$jumlah_nilai = 0;
$nilai_rata = null;
$user_terbaru = [];

if ($role === 'admin') {
    $jumlah_user  = total_data($koneksi, "SELECT COUNT(*) AS total FROM users");
    $jumlah_guru  = total_data($koneksi, "SELECT COUNT(*) AS total FROM guru");
    $jumlah_siswa = total_data($koneksi, "SELECT COUNT(*) AS total FROM siswa");
    $jumlah_mapel = total_data($koneksi, "SELECT COUNT(*) AS total FROM mapel");

    $user_terbaru = ambil_semua($koneksi, "SELECT username, role, created_at FROM users ORDER BY id DESC LIMIT 5");

} elseif ($role === 'guru') {
    $jumlah_siswa = total_data($koneksi, "SELECT COUNT(*) AS total FROM siswa");
    $jumlah_mapel = total_data($koneksi, "SELECT COUNT(*) AS total FROM mapel m JOIN guru g ON m.guru_id=g.id WHERE g.user_id=?", "i", $user_id);
    $jumlah_nilai = total_data($koneksi, "SELECT COUNT(*) AS total FROM nilai_rapor n JOIN mapel m ON n.mapel_id=m.id JOIN guru g ON m.guru_id=g.id WHERE g.user_id=?", "i", $user_id);

} elseif ($role === 'siswa') {
    $jumlah_mapel = total_data($koneksi, "SELECT COUNT(*) AS total FROM mapel");
    $jumlah_nilai = total_data($koneksi, "SELECT COUNT(*) AS total FROM nilai_rapor n JOIN siswa s ON n.siswa_id=s.id WHERE s.user_id=?", "i", $user_id);

    $ringkasan = ambil_satu($koneksi, "SELECT AVG((n.nilai_pengetahuan + n.nilai_keterampilan) / 2) AS rata FROM nilai_rapor n JOIN siswa s ON n.siswa_id=s.id WHERE s.user_id=?", "i", $user_id);
    $nilai_rata = $ringkasan['rata'] ?? null;
}

require "navbar.php";
?>

<main class="dashboard-wrap">
    <h1 class="dashboard-heading">Dashboard</h1>
    <p class="dashboard-subtitle">Ringkasan data Sistem Informasi Pengelolaan Nilai.</p>

    <div class="row g-3 g-lg-4 mb-4">

        <?php if ($role === 'admin'): ?>
        <div class="col-6 col-lg-4">
            <div class="card stat-card" style="--accent:#6865ed;--soft:#f0efff">
                <div class="card-body">
                    <div class="stat-label">User</div>
                    <div class="stat-number"><?= $jumlah_user ?></div>
                    <a class="stat-link" href="daftar_user.php">Lihat data <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
        <div class="col-6 col-lg-4">
            <div class="card stat-card" style="--accent:#20b5a5;--soft:#e6f8f5">
                <div class="card-body">
                    <div class="stat-label">Guru</div>
                    <div class="stat-number"><?= $jumlah_guru ?></div>
                    <a class="stat-link" href="daftar_guru.php">Lihat data <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($role === 'admin' || $role === 'guru'): ?>
        <div class="col-6 col-lg-4">
            <div class="card stat-card" style="--accent:#20a6d8;--soft:#e7f6fc">
                <div class="card-body">
                    <div class="stat-label">Siswa</div>
                    <div class="stat-number"><?= $jumlah_siswa ?></div>
                    <a class="stat-link" href="daftar_siswa.php">Lihat data <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="col-6 col-lg-4">
            <div class="card stat-card" style="--accent:#e9a11b;--soft:#fff6df">
                <div class="card-body">
                    <div class="stat-label"><?= $role === 'guru' ? 'Mapel Diampu' : 'Mapel' ?></div>
                    <div class="stat-number"><?= $jumlah_mapel ?></div>
                    <a class="stat-link" href="<?= $role === 'admin' ? 'mapel.php' : ($role === 'guru' ? 'mapel_guru.php' : 'mapel_siswa.php') ?>">Lihat data <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>

        <?php if ($role !== 'admin'): ?>
        <div class="col-6 col-lg-4">
            <div class="card stat-card" style="--accent:#ed4b70;--soft:#ffedf1">
                <div class="card-body">
                    <div class="stat-label"><?= $role === 'siswa' ? 'Nilai Saya' : 'Nilai' ?></div>
                    <div class="stat-number"><?= $jumlah_nilai ?></div>
                    <a class="stat-link" href="<?= $role === 'siswa' ? 'nilai_siswa.php' : 'nilai.php' ?>">Lihat data <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <div class="row g-3 g-lg-4">

        <?php if ($role === 'siswa'): ?>
        <div class="col-12">
            <section class="card panel-card">
                <div class="card-body">
                    <h2 class="h5 panel-title">Ringkasan Nilai Saya</h2>

                    <?php if ($jumlah_nilai < 1 || $nilai_rata === null): ?>
                        <p class="empty-state mb-0">Belum ada data nilai.</p>
                    <?php else: ?>
                        <div class="d-flex align-items-end gap-2">
                            <span style="font-size:2.5rem;font-weight:780;letter-spacing:-.04em;color:#ed4b70"><?= number_format((float)$nilai_rata, 1, ',', '.') ?></span>
                            <span class="text-secondary mb-2">rata-rata nilai saya</span>
                        </div>
                        <p class="text-secondary small mb-0">Rata-rata dihitung dari nilai pengetahuan dan keterampilan milikmu.</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
        <div class="col-12">
            <section class="card panel-card">
                <div class="card-body">
                    <h2 class="h5 panel-title">User Terbaru</h2>

                    <?php if (!$user_terbaru): ?>
                        <p class="empty-state mb-0">Belum ada data pengguna.</p>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sipn">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user_terbaru as $user): ?>
                                <tr>
                                    <td><?= e($user['username']) ?></td>
                                    <td><span class="role-pill role-<?= e($user['role']) ?>"><?= e($user['role']) ?></span></td>
                                    <td class="text-secondary"><?= !empty($user['created_at']) ? e(date('d M Y', strtotime($user['created_at']))) : '-' ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <?php else: ?>
        <div class="col-12">
            <section class="card panel-card">
                <div class="card-body">
                    <h2 class="h5 panel-title">Selamat datang, <?= e($nama) ?>!</h2>
                    <p class="text-secondary mb-0">Kamu login sebagai <strong><?= e($role) ?></strong>. Gunakan menu navigasi untuk membuka fitur sesuai akunmu.</p>
                </div>
            </section>
        </div>
        <?php endif; ?>

    </div>
</main>

<?php require "footer.php"; ?>
