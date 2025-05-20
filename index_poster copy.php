<?php
// Mulai sesi di awal file sebelum kirim output apapun
session_start();
include 'connection_db.php';

// Pastikan user sudah login - pindahkan semua logika login ke sini
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Anda harus login terlebih dahulu.";
    header("Location: login.php");
    exit();
}

// Handle filter status jika ada
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
$status_condition = "";

if ($status_filter !== 'all') {
    $status_condition = " AND status_lowongan = '$status_filter'";
}

// Ambil data lowongan yang diposting oleh user dengan informasi lebih lengkap
$sql = "SELECT id_lowongan, nama_lowongan, jenis_lowongan, tanggal_unggah, tanggal_tutup, 
               status_lowongan, limit_pelamar, jumlah_pelamar, harga_jasa
        FROM lowongan 
        WHERE user_id = ? $status_condition
        ORDER BY tanggal_unggah DESC";
        
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

// Hitung statistik dashboard
$total_lowongan = $result->num_rows;

// Hitung lowongan berdasarkan status
$sql_stats = "SELECT status_lowongan, COUNT(*) as status_count 
              FROM lowongan 
              WHERE user_id = ? 
              GROUP BY status_lowongan";
$stmt_stats = $conn->prepare($sql_stats);
$stmt_stats->bind_param("i", $_SESSION['user_id']);
$stmt_stats->execute();
$result_stats = $stmt_stats->get_result();

$status_counts = [
    'aktif' => 0,
    'tutup' => 0,
    'selesai' => 0
];

while ($stat = $result_stats->fetch_assoc()) {
    $status_counts[$stat['status_lowongan']] = $stat['status_count'];
}

// Format mata uang
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// Format tanggal ke format Indonesia
function formatTanggal($tanggal) {
    $date = new DateTime($tanggal);
    return $date->format('d M Y');
}

// Hitung sisa hari
function hitungSisaHari($tanggal_tutup) {
    $sekarang = new DateTime();
    $tutup = new DateTime($tanggal_tutup);
    $selisih = $sekarang->diff($tutup);
    
    if ($tutup < $sekarang) {
        return 'Sudah tutup';
    }
    
    return $selisih->days . ' hari lagi';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Utama</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> <!-- Menggunakan bootstrap.bundle.min.js -->
  
  <style>
  body {
    background-color: #FFFFFF;
    font-family: Arial, sans-serif;
    display: contents;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
  }
</style>

</head>

<body>

<!-- NAVBAR AREA -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <!-- Logo -->
    <a class="navbar-brand" href="index_poster.php">
      <img src="asset/img/logo2.png" alt="Logo" style="height: 85px;">
    </a>

    <!-- Menu navigasi -->
    <div class="d-flex justify-content-center flex-grow-1" style="font-size: 30px;">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Jelajah</a></li>
        <li class="nav-item"><a class="nav-link disabled" aria-disabled="true">Hubungi</a></li>
      </ul>
    </div>

    <!-- Search dan Profil -->
    <div class="d-flex align-items-center">
      <form class="d-flex me-3" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>

    <!-- Dropdown Profil -->
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profil
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="profil_poster.php">Profil</a></li>
            <li><a class="dropdown-item" href="logout.php">Keluar</a></li>
          </ul>
        </li>
    </ul>
  </div>
</nav>


<!-- CONTENT AREA -->
<div class="flex" style="text-align: center;">
  <h1>KERJA <br>LEPAS</h1>
</div>
<div class="flex" style="text-align: center;">
  <h1>PICT</h1>
</div>

<!-- CONTENT 1 -->
<section class="container mx-auto row">
  <div class="bg-light col-12 col-md-6 mx-auto shadow p-2 px-4 rounded-3" id="form-lowongan">
    <h2 class="text-center fw-semibold text-primary p-0 m-0">Unggah Lowongan</h2>
    <div class="w-100 mb-1">
      <div class="border-success border-2 w-25 border-top mx-auto"></div>
    </div>
    <div class="w-100 mb-3">
      <div class="border-success border-2 border-top mx-auto" style="width:15%"></div>
    </div>
    <form action="submit_lowongan.php" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="nama" class="form-label fw-medium">Nama Lowongan:</label>
        <input type="text" class="form-control border-2 border-dark-subtle bg-body-tertiary"
               name="nama_lowongan" required id="nama" aria-describedby="namahelp">
      </div>
      <div class="mb-3">
        <label for="jenis" class="form-label fw-medium">Jenis Lowongan:</label>
        <input type="text" class="form-control border-2 border-dark-subtle bg-body-tertiary"
               name="jenis_lowongan" required id="jenis" aria-describedby="jenishelp">
      </div>
      <div class="mb-3">
        <label for="tanggal_tutup" class="form-label fw-medium">Tanggal Lowongan Ditutup:</label>
        <input type="date" class="form-control border-2 border-dark-subtle bg-body-tertiary" 
               name="tanggal_tutup" id="tanggal_tutup" required>
      </div>
      <div class="mb-3">
        <label for="deskripsi" class="form-label fw-medium">Deskripsi:</label>
        <textarea class="form-control border-2 border-dark-subtle bg-body-tertiary" 
                  name="deskripsi" id="deskripsi" rows="4" required></textarea>
      </div>
      <div class="mb-3">
        <label for="limit_pelamar" class="form-label fw-medium">Limit Pelamar:</label>
        <input type="number" class="form-control border-2 border-dark-subtle bg-body-tertiary"
               name="limit_pelamar" id="limit_pelamar" required min="1">
      </div>
      <div class="mb-3">
        <label for="harga_jasa" class="form-label fw-medium">Harga Jasa (Rp):</label>
        <input type="number" class="form-control border-2 border-dark-subtle bg-body-tertiary"
               name="harga_jasa" id="harga_jasa" required min="0" step="0.01">
      </div>
      <button type="submit" class="btn btn-success mb-3 w-100">Kirim</button>
    </form>
  </div>
</section>

<!-- CONTENT 2 -->
<div class="container py-5">
    <h2 class="text-center mb-4">Dashboard Lowongan</h2>
    
    <!-- Tampilkan informasi statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>Total Lowongan</h5>
                    <h2><?php echo $total_lowongan; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5>Aktif</h5>
                    <h2><?php echo $status_counts['aktif']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body text-center">
                    <h5>Ditutup</h5>
                    <h2><?php echo $status_counts['tutup']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body text-center">
                    <h5>Selesai</h5>
                    <h2><?php echo $status_counts['selesai']; ?></h2>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter status -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="btn-group" role="group">
                <a href="?status=all" class="btn btn-outline-primary <?php echo $status_filter == 'all' ? 'active' : ''; ?>">Semua</a>
                <a href="?status=aktif" class="btn btn-outline-primary <?php echo $status_filter == 'aktif' ? 'active' : ''; ?>">Aktif</a>
                <a href="?status=tutup" class="btn btn-outline-primary <?php echo $status_filter == 'tutup' ? 'active' : ''; ?>">Ditutup</a>
                <a href="?status=selesai" class="btn btn-outline-primary <?php echo $status_filter == 'selesai' ? 'active' : ''; ?>">Selesai</a>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <a href="#form-lowongan" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Lowongan Baru</a>
        </div>
    </div>
    
    <!-- Tampilkan notifikasi jika ada -->
    <?php if(isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    <!-- Tampilkan lowongan dalam bentuk tabel untuk informasi lebih lengkap -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nama Lowongan</th>
                    <th>Jenis</th>
                    <th>Tanggal Posting</th>
                    <th>Tenggat</th>
                    <th>Status</th>
                    <th>Pelamar</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nama_lowongan']); ?></td>
                            <td><?php echo htmlspecialchars($row['jenis_lowongan']); ?></td>
                            <td><?php echo formatTanggal($row['tanggal_unggah']); ?></td>
                            <td>
                                <?php echo formatTanggal($row['tanggal_tutup']); ?>
                                <span class="badge bg-info"><?php echo hitungSisaHari($row['tanggal_tutup']); ?></span>
                            </td>
                            <td>
                                <?php 
                                    $badge_class = '';
                                    switch($row['status_lowongan']) {
                                        case 'aktif':
                                            $badge_class = 'bg-success';
                                            break;
                                        case 'tutup':
                                            $badge_class = 'bg-warning text-dark';
                                            break;
                                        case 'selesai':
                                            $badge_class = 'bg-secondary';
                                            break;
                                    }
                                ?>
                                <span class="badge <?php echo $badge_class; ?>"><?php echo ucfirst($row['status_lowongan']); ?></span>
                            </td>
                            <td>
                                <?php echo $row['jumlah_pelamar']; ?> / 
                                <?php echo $row['limit_pelamar'] > 0 ? $row['limit_pelamar'] : '∞'; ?>
                            </td>
                            <td><?php echo formatRupiah($row['harga_jasa']); ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="riwayat_unggah.php?id_lowongan=<?php echo $row['id_lowongan']; ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-users"></i> Pelamar
                                    </a>
                                    <a href="edit_lowongan.php?id_lowongan=<?php echo $row['id_lowongan']; ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($row['status_lowongan'] == 'aktif'): ?>
                                        <a href="change_status.php?id_lowongan=<?php echo $row['id_lowongan']; ?>&action=tutup" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Yakin ingin menutup lowongan ini?')">
                                            <i class="fas fa-times-circle"></i>
                                        </a>
                                    <?php elseif ($row['status_lowongan'] == 'tutup'): ?>
                                        <a href="change_status.php?id_lowongan=<?php echo $row['id_lowongan']; ?>&action=aktif" 
                                           class="btn btn-sm btn-success" 
                                           onclick="return confirm('Yakin ingin mengaktifkan kembali lowongan ini?')">
                                            <i class="fas fa-check-circle"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Belum ada lowongan yang dibuat</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Tampilan alternatif dalam bentuk card untuk tampilan mobile -->
    <div class="d-md-none">
        <?php 
        // Reset result set untuk digunakan lagi
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo htmlspecialchars($row['nama_lowongan']); ?></h5>
                        <span class="badge <?php echo $badge_class; ?>"><?php echo ucfirst($row['status_lowongan']); ?></span>
                    </div>
                    <div class="card-body">
                        <p><strong>Jenis:</strong> <?php echo htmlspecialchars($row['jenis_lowongan']); ?></p>
                        <p><strong>Tanggal Posting:</strong> <?php echo formatTanggal($row['tanggal_unggah']); ?></p>
                        <p><strong>Tenggat:</strong> <?php echo formatTanggal($row['tanggal_tutup']); ?> 
                            <span class="badge bg-info"><?php echo hitungSisaHari($row['tanggal_tutup']); ?></span>
                        </p>
                        <p><strong>Pelamar:</strong> <?php echo $row['jumlah_pelamar']; ?> / 
                            <?php echo $row['limit_pelamar'] > 0 ? $row['limit_pelamar'] : '∞'; ?>
                        </p>
                        <p><strong>Harga:</strong> <?php echo formatRupiah($row['harga_jasa']); ?></p>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100" role="group">
                            <a href="manage_applicants.php?id_lowongan=<?php echo $row['id_lowongan']; ?>" class="btn btn-primary">
                                <i class="fas fa-users"></i> Pelamar
                            </a>
                            <a href="edit_lowongan.php?id_lowongan=<?php echo $row['id_lowongan']; ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <?php if ($row['status_lowongan'] == 'aktif'): ?>
                                <a href="change_status.php?id_lowongan=<?php echo $row['id_lowongan']; ?>&action=tutup" 
                                   class="btn btn-danger" 
                                   onclick="return confirm('Yakin ingin menutup lowongan ini?')">
                                    <i class="fas fa-times-circle"></i> Tutup
                                </a>
                            <?php elseif ($row['status_lowongan'] == 'tutup'): ?>
                                <a href="change_status.php?id_lowongan=<?php echo $row['id_lowongan']; ?>&action=aktif" 
                                   class="btn btn-success" 
                                   onclick="return confirm('Yakin ingin mengaktifkan kembali lowongan ini?')">
                                    <i class="fas fa-check-circle"></i> Aktifkan
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info text-center">
                Belum ada lowongan yang dibuat. 
                <a href="add_lowongan.php" class="alert-link">Buat lowongan baru sekarang!</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal konfirmasi untuk hapus/tutup lowongan (opsional) -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="confirmationModalBody">
                Apakah Anda yakin ingin melakukan tindakan ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="confirmAction" class="btn btn-primary">Ya, Lanjutkan</a>
            </div>
        </div>
    </div>
</div>

<script>
// Script untuk modal konfirmasi (jika menggunakan)
function showConfirmation(message, actionUrl) {
    document.getElementById('confirmationModalBody').textContent = message;
    document.getElementById('confirmAction').setAttribute('href', actionUrl);
    
    var modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    modal.show();
}
</script>


<!-- FOOTER -->
<footer class="bg-dark text-white">
  <div class="container text-center">
    <p class="mb-0">&copy; 2025 TaskTroop. All rights reserved.</p>
    <div class="mt-2">
      <a href="#" class="text-white me-3">Privacy Policy</a>
      <a href="#" class="text-white">Terms of Service</a>
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>