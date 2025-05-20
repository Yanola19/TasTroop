<?php
include_once 'connection_db.php';

// Ambil data lowongan pekerjaan
$sql_lowongan = "SELECT * FROM lowongan LIMIT 10";
$result_lowongan = $conn->query($sql_lowongan);
$lowongan_list = ($result_lowongan && $result_lowongan->num_rows > 0)
    ? $result_lowongan->fetch_all(MYSQLI_ASSOC)
    : [];

// Ambil data daftar proyek / lamaran
$sql_daftar = "SELECT * FROM daftar_lowongan LIMIT 10";
$result_daftar = $conn->query($sql_daftar);
$daftar_proyek = ($result_daftar && $result_daftar->num_rows > 0)
    ? $result_daftar->fetch_all(MYSQLI_ASSOC)
    : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Utama</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
  /* Navbar */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      background-color: white;
    }

    .nav-logo {
      display: flex;
      align-items: center;
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

    .nav-links a.active {
      font-weight: bold;
    }

    .nav-buttons {
      display: flex;
      gap: 1rem;
    }

    .profil {
      padding: 0.5rem 1rem;
      border: none;
      background: transparent;
      color: #333;
      cursor: pointer;
    }

    .keluar {
      padding: 0.5rem 1rem;
      border: 1px solid #20b2aa;
      border-radius: 4px;
      background: transparent;
      color: #20b2aa;
      cursor: pointer;
    }

    /* Hero */
    .hero {
      display: flex;
      justify-content: space-between;
      padding: 2rem 4rem;
      position: relative;
      overflow: hidden;
    }

    .hero-content {
      width: 50%;
      padding-top: 5rem;
    }

    .hero-title {
      font-size: 4rem;
      font-weight: bold;
      line-height: 1.1;
      margin-bottom: 2rem;
    }

    .hero-image {
      width: 40%;
      position: relative;
    }

    .hero-image img {
      width: 100%;
      max-width: 350px;
      height: auto;
      border-radius: 50% 50% 0 0;
      background-color: rgba(32, 178, 171, 0.2);
    }

    .shapes { position: absolute; width: 100%; height: 100%; z-index: -1; }
    .shape { position: absolute; border-radius: 50%; }
    .yellow { background-color: #ffd966; width: 60px; height: 60px; top: 10%; right: 10%; }
    .green { background-color: #77dd77; width: 40px; height: 40px; bottom: 20%; left: 10%; }
    .blue { background-color: #aed9e0; width: 30px; height: 30px; bottom: 40%; right: 30%; }
    .pink { background-color: #ffc0cb; width: 50px; height: 50px; bottom: 20%; right: 10%; }

    .swirl {
      position: absolute;
      top: 30%;
      left: 50%;
      width: 100px;
      height: 100px;
      border: 3px solid #20b2aa;
      border-radius: 50%;
      border-left-color: transparent;
      transform: rotate(-45deg);
    }
    .card-text {
      max-height: 80px;
      overflow: hidden;
    }

</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <div class="nav-logo">
    <img src="asset/img/logo1.png" alt="Logo">
  </div>
  <div class="nav-links">
    <a href="index_seller.php" class="active">Beranda</a>
    <a href="about2.php">Tentang Kami</a>
    <a href="contact.php">Kontak Kami</a>
  </div>
  <div class="nav-buttons">
    <a href="profil_seller.php" class="profil">Profil</a>
    <a href="logout.php" class="keluar">Keluar</a>
  </div>
</nav>

<!-- HERO -->
<div class="hero">
  <div class="hero-content">
    <h1 class="hero-title">Kerja<br>Lepas</h1>
    <div class="swirl"></div>
  </div>
  <div class="hero-image">
    <img src="asset/img/smilling.png" alt="Orang Tersenyum">
  </div>
</div>

<!-- TOMBOL RIWAYAT -->
<div class="container mt-3">
  <div class="d-flex justify-content-end">
    <a href="riwayat_apply_lamaran.php" class="btn btn-outline-primary">
      <i class="fas fa-file-alt"></i> Riwayat Lamaran Saya
    </a>
  </div>
</div>

<!-- LOWONGAN PEKERJAAN -->
<section class="container my-4 p-3 bg-white shadow rounded">
  <h5 class="fw-semibold mb-3">Cari Lowongan yang Masih Terbuka</h5>

  <div class="mt-4">
    <h6 class="fw-semibold">Available Jobs</h6>
    <?php if (!empty($lowongan_list)): ?>
      <div class="row">
        <?php foreach ($lowongan_list as $lowongan): ?>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($lowongan['nama_lowongan']) ?></h5>
                <p class="card-text"><?= substr($lowongan['deskripsi'], 0, 100) . '...'; ?></p>
                <div class="project-details">
                  <p><strong>Penawaran Harga:</strong> <?= htmlspecialchars($lowongan['harga_jasa']) ?></p>
                  <p><strong>Started:</strong> <?= date('F j, Y', strtotime($lowongan['created_at'])) ?></p>
                  <p><strong>Harga:</strong> Rp<?= number_format($lowongan['harga_jasa'], 0, ',', '.') ?> / jam</p>
                </div>
                <a href="jobs_detail.php?id_lowongan=<?= $lowongan['id_lowongan'] ?>" class="btn btn-primary">Lihat Pekerjaan</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-center">Belum ada lowongan masuk baru.</p>
    <?php endif; ?>
  </div>
</section>

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

</body>
</html>
