<?php
include('connection_db.php');

// Mendapatkan ID lowongan dari URL
$id_lowongan = $_GET['id_lowongan']; // Pastikan ID lowongan ada di URL

// Query untuk mendapatkan detail lowongan berdasarkan ID
$sql = "SELECT * FROM lowongan WHERE id_lowongan = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_lowongan);
$stmt->execute();
$result = $stmt->get_result();

// Mengecek apakah data ditemukan
if ($result->num_rows > 0) {
    $lowongan = $result->fetch_assoc();
} else {
    echo "Lowongan tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lowongan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      background-color: white;
    }

    .nav-logo img {
      width: 80px;
      height: 80px;
      margin-right: 10px;
    }

    .nav-links {
      display: flex;
      gap: 2rem;
    }

    .nav-links a {
      text-decoration: none;
      color: #333;
      font-size: 0.9rem;
    }

    .nav-buttons {
      display: flex;
      gap: 1rem;
    }

    .profil, .keluar {
      padding: 0.5rem 1rem;
      border: 1px solid #20b2aa;
      border-radius: 4px;
      background: transparent;
      color: #20b2aa;
      cursor: pointer;
    }
    .profil {
      border: none;
      color: #333;
    }
    </style>
</head>
<body>

<!-- NAVBAR AREA -->
<nav class="navbar">
    <div class="nav-logo">
        <img src="asset/img/logo1.png" alt="Logo">
    </div>
    <div class="nav-links">
        <a href="index_seller.php">Beranda</a>
        <a href="about2.php">Tentang Kami</a>
        <a href="contact.php">Kontak Kami</a>
    </div>
    <div class="nav-buttons">
        <a href="profil_seller.php" class="profil">Profil</a>
        <a href="logout.php" class="keluar">Keluar</a>
    </div>
</nav>

<!-- DETAIL LOWONGAN -->
<section class="container py-5">
    <h2 class="text-center fw-semibold text-primary"><?php echo htmlspecialchars($lowongan['nama_lowongan']); ?></h2>
    <div class="row mt-4">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <?php echo htmlspecialchars($lowongan['jenis_lowongan']); ?> - 
                        <strong>Rp <?php echo number_format($lowongan['harga_jasa'], 0, ',', '.'); ?> / Jam</strong>
                    </h5>

                    <p><strong>Deskripsi:</strong> <?php echo nl2br(htmlspecialchars($lowongan['deskripsi'])); ?></p>
                    <p><strong>Limit Pelamar:</strong> <?php echo $lowongan['limit_pelamar']; ?></p>
                    <p><strong>Tanggal Ditutup:</strong> <?php echo date('F j, Y', strtotime($lowongan['tanggal_tutup'])); ?></p>
                    <p><strong>Jumlah Pelamar:</strong> <?php echo $lowongan['jumlah_pelamar']; ?></p>

                    <p><strong>Status:</strong> 
                        <?php 
                            $status = strtolower($lowongan['status_lowongan']);
                            if ($status === 'aktif') {
                                echo '<span class="badge bg-success">Aktif</span>';
                            } elseif ($status === 'tutup') {
                                echo '<span class="badge bg-warning text-dark">Ditutup</span>';
                            } elseif ($status === 'selesai') {
                                echo '<span class="badge bg-secondary">Selesai</span>';
                            } else {
                                echo ucfirst($status);
                            }
                        ?>
                    </p>

                    <p><strong>Diupload pada:</strong> 
                        <?php 
                            echo ($lowongan['updated_at'] && $lowongan['updated_at'] !== '0000-00-00 00:00:00') 
                                ? date('F j, Y', strtotime($lowongan['updated_at'])) 
                                : '-';
                        ?>
                    </p>

                    <!-- TOMBOL LAMAR (HANYA KALAU STATUS = AKTIF) -->
                    <?php if ($status === 'aktif'): ?>
                        <form action="apply_job.php" method="POST">
                            <input type="hidden" name="id_lowongan" value="<?php echo $lowongan['id_lowongan']; ?>">
                            <button type="submit" class="btn btn-primary">Lamar Pekerjaan</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning mt-3">
                            Lowongan ini sudah <strong><?php echo ucfirst($status); ?></strong>. Anda tidak dapat melamar.
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-dark text-white mt-5">
    <div class="container text-center py-3">
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
