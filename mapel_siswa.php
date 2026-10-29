<?php
require_once "koneksi.php";

/*
 * Daftar mapel siswa ditampilkan jika mapel sudah:
 * 1. dihubungkan ke siswa melalui tabel mengajar, atau
 * 2. memiliki nilai rapor untuk siswa tersebut.
 * Dengan begitu, mapel yang sudah diberi nilai tidak hilang hanya karena
 * relasi pada tabel mengajar belum dibuat.
 */
$data = ambil_semua(
    $koneksi,
    "SELECT DISTINCT mp.kode_mapel, mp.nama_mapel, g.nama AS nama_guru
     FROM siswa s
     JOIN (
         SELECT mapel_id, siswa_id FROM mengajar
         UNION
         SELECT mapel_id, siswa_id FROM nilai_rapor
     ) relasi ON relasi.siswa_id = s.id
     JOIN mapel mp ON mp.id = relasi.mapel_id
     LEFT JOIN guru g ON mp.guru_id = g.id
     WHERE s.user_id = ?
     ORDER BY mp.nama_mapel ASC",
    "i",
    (int)$_SESSION['id']
);

require "navbar.php";
?>

<div class="container mt-4">
    <h1 class="h2 mb-3">Daftar Mata Pelajaran</h1>

    <div class="tabel-bingkai">
        <div class="table-responsive">
            <table class="table table-hover tabel-sip">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Mapel</th>
                        <th>Nama Mapel</th>
                        <th>Guru Pengampu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($data): ?>
                        <?php foreach ($data as $i => $mapel): ?>
                            <tr>
                                <td class="tengah"><?= $i + 1 ?></td>
                                <td><?= e($mapel['kode_mapel']) ?></td>
                                <td><?= e($mapel['nama_mapel']) ?></td>
                                <td><?= e($mapel['nama_guru'] ?? 'Belum ditentukan') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                Belum ada mata pelajaran yang terhubung dengan akun siswa ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>
