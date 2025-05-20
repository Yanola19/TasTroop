<?php
// Mulai sesi di awal file sebelum kirim output apapun
session_start();
include 'connection_db.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Anda harus login terlebih dahulu.";
    header("Location: login.php");
    exit();
}

// Periksa apakah parameter id_lowongan ada
if (!isset($_GET['id_lowongan'])) {
    $_SESSION['error_message'] = "ID lowongan tidak ditemukan.";
    header("Location: index_poster.php");
    exit();
}

$id_lowongan = $_GET['id_lowongan'];

// Verifikasi bahwa lowongan ini milik user yang sedang login
$sql_check = "SELECT * FROM lowongan WHERE id_lowongan = ? AND user_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $id_lowongan, $_SESSION['user_id']);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows == 0) {
    $_SESSION['error_message'] = "Anda tidak memiliki akses untuk mengedit lowongan ini.";
    header("Location: index_poster.php");
    exit();
}

// Ambil data lowongan yang akan diedit
$lowongan = $result_check->fetch_assoc();

// Proses form ketika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi input
    $nama_lowongan = trim($_POST['nama_lowongan']);
    $jenis_lowongan = trim($_POST['jenis_lowongan']);
    $tanggal_tutup = $_POST['tanggal_tutup'];
    $deskripsi = trim($_POST['deskripsi']);
    $limit_pelamar = (int)$_POST['limit_pelamar'];
    $harga_jasa = (float)$_POST['harga_jasa'];
    $status_lowongan = $_POST['status_lowongan'];
    
    // Validasi data
    $errors = [];
    
    if (empty($nama_lowongan)) {
        $errors[] = "Nama lowongan harus diisi.";
    }
    
    if (empty($jenis_lowongan)) {
        $errors[] = "Jenis lowongan harus diisi.";
    }
    
    if (empty($tanggal_tutup)) {
        $errors[] = "Tanggal tutup harus diisi.";
    } else {
        $date_now = new DateTime();
        $date_tutup = new DateTime($tanggal_tutup);
        
        if ($date_tutup < $date_now && $status_lowongan == 'aktif') {
            $errors[] = "Tanggal tutup tidak boleh kurang dari tanggal hari ini untuk lowongan aktif.";
        }
    }
    
    if (empty($deskripsi)) {
        $errors[] = "Deskripsi harus diisi.";
    }
    
    if ($limit_pelamar < 1) {
        $errors[] = "Limit pelamar minimal 1.";
    }
    
    if ($harga_jasa < 0) {
        $errors[] = "Harga jasa tidak boleh negatif.";
    }
    
    // Jika tidak ada error, update data lowongan
    if (empty($errors)) {
        $sql_update = "UPDATE lowongan SET 
                        nama_lowongan = ?, 
                        jenis_lowongan = ?, 
                        tanggal_tutup = ?, 
                        deskripsi = ?, 
                        limit_pelamar = ?, 
                        harga_jasa = ?,
                        status_lowongan = ?
                    WHERE id_lowongan = ? AND user_id = ?";
                    
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param(
            "ssssiisii", 
            $nama_lowongan, 
            $jenis_lowongan, 
            $tanggal_tutup, 
            $deskripsi, 
            $limit_pelamar, 
            $harga_jasa,
            $status_lowongan,
            $id_lowongan, 
            $_SESSION['user_id']
        );
        
        if ($stmt_update->execute()) {
            $_SESSION['success_message'] = "Lowongan berhasil diperbarui.";
            header("Location: index_poster.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Gagal memperbarui lowongan: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lowongan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        body {
            background-color: #FFFFFF;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .content {
            flex: 1;
        }
        
        .form-container {
            max-width: 800px;
            margin: 0 auto;
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
    </style>
</head>
<body>

<!-- NAVBAR AREA -->
  <nav class="navbar">
    <div class="nav-logo">
      <img src="asset/img/logo1.png" alt="Logo">
    </div>

    <div class="nav-links">
      <a href="index_poster.php">Beranda</a>
      <a href="about3.php">Tentang Kami</a>
      <a href="contact.php">Kontak Kami</a>
    </div>

    <div class="nav-buttons">
      <a href="profil_poster.php" class="profil">Profil</a>
      <a href="logout.php" class="keluar">Keluar</a>
    </div>
  </nav>

<!-- CONTENT AREA -->
<div class="content container py-5">
    <div class="form-container">
        <h2 class="text-center mb-4">Edit Lowongan</h2>
        
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
        
        <div class="card shadow">
            <div class="card-body">
                <form action="edit_lowongan.php?id_lowongan=<?php echo $id_lowongan; ?>" method="POST">
                    <div class="mb-3">
                        <label for="nama_lowongan" class="form-label fw-bold">Nama Lowongan:</label>
                        <input type="text" class="form-control border-2 border-dark-subtle bg-body-tertiary"
                               name="nama_lowongan" id="nama_lowongan" required
                               value="<?php echo htmlspecialchars($lowongan['nama_lowongan']); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="jenis_lowongan" class="form-label fw-bold">Jenis Lowongan:</label>
                        <input type="text" class="form-control border-2 border-dark-subtle bg-body-tertiary"
                               name="jenis_lowongan" id="jenis_lowongan" required
                               value="<?php echo htmlspecialchars($lowongan['jenis_lowongan']); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggal_tutup" class="form-label fw-bold">Tanggal Tutup:</label>
                        <input type="date" class="form-control border-2 border-dark-subtle bg-body-tertiary"
                               name="tanggal_tutup" id="tanggal_tutup" required
                               value="<?php echo $lowongan['tanggal_tutup']; ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi:</label>
                        <textarea class="form-control border-2 border-dark-subtle bg-body-tertiary" 
                                  name="deskripsi" id="deskripsi" rows="5" required><?php echo htmlspecialchars($lowongan['deskripsi']); ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="limit_pelamar" class="form-label fw-bold">Limit Pelamar:</label>
                            <input type="number" class="form-control border-2 border-dark-subtle bg-body-tertiary"
                                   name="limit_pelamar" id="limit_pelamar" required min="1"
                                   value="<?php echo $lowongan['limit_pelamar']; ?>">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="harga_jasa" class="form-label fw-bold">Harga Jasa (Rp):</label>
                            <input type="number" class="form-control border-2 border-dark-subtle bg-body-tertiary"
                                   name="harga_jasa" id="harga_jasa" required min="0" step="0.01"
                                   value="<?php echo $lowongan['harga_jasa']; ?>">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="status_lowongan" class="form-label fw-bold">Status Lowongan:</label>
                        <select class="form-select border-2 border-dark-subtle bg-body-tertiary" 
                                name="status_lowongan" id="status_lowongan" required>
                            <option value="aktif" <?php echo ($lowongan['status_lowongan'] == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                            <option value="tutup" <?php echo ($lowongan['status_lowongan'] == 'tutup') ? 'selected' : ''; ?>>Tutup</option>
                            <option value="selesai" <?php echo ($lowongan['status_lowongan'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="index_poster.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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

</body>
</html>