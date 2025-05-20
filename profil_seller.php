<?php
include('connection_db.php');

// Pastikan session sudah dimulai
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil data profil seller berdasarkan ID
$sql = "SELECT * FROM users WHERE is_seller = 1 AND username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();

// Simpan hasil ke variabel
$result = $stmt->get_result();
$seller = $result->fetch_assoc();
$stmt->close();

// Jika seller tidak ditemukan
if (!$seller) {
    echo "Seller tidak ditemukan";
    exit;
}

// Ambil data portofolio seller
$sql_portfolio = "SELECT * FROM portofolio WHERE user_id = ?";
$stmt_portfolio = $conn->prepare($sql_portfolio);
$stmt_portfolio->bind_param("i", $seller['user_id']); // Menggunakan user_id dari data seller
$stmt_portfolio->execute();
$result_portfolio = $stmt_portfolio->get_result();
$portfolio = $result_portfolio->fetch_all(MYSQLI_ASSOC);
$stmt_portfolio->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Seller</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    .card {
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: 0.3s;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    .card:hover {
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
    .card-header {
      background-color: #6c757d;
      color: white;
      font-weight: bold;
      border-radius: 10px 10px 0 0 !important;
    }
    .btn-back {
      margin-top: 20px;
    }
    .portfolio-item {
      border-bottom: 1px solid #eee;
      padding: 10px 0;
      margin-bottom: 10px;
    }
    .portfolio-item:last-child {
      border-bottom: none;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <!-- Card Profil -->
        <div class="card">
          <div class="card-header bg-primary text-white">
            <h3 class="mb-0"><i class="fas fa-user-circle me-2"></i>Profil Seller</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <!-- Tampilkan profil seller -->
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>Informasi Pribadi</h5>
                  </div>
                  <div class="card-body">
                    <div class="d-flex flex-column">
                      <div class="mb-3 text-center">
                        <img src="<?php echo !empty($seller['profile_picture']) ? $seller['profile_picture'] : 'assets/img/default-avatar.png'; ?>" 
                             alt="Profile Picture" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                      </div>
                      <div class="mb-2">
                        <strong><i class="fas fa-user me-2"></i>Nama:</strong> 
                        <?php echo $seller['full_name']; ?>
                      </div>
                      <div class="mb-2">
                        <strong><i class="fas fa-user-tag me-2"></i>Role:</strong> 
                        <?php echo isset($seller['role']) ? ucfirst($seller['role']) : 'Seller'; ?>
                      </div>
                      <div class="mb-2">
                        <strong><i class="fas fa-envelope me-2"></i>Email:</strong> 
                        <?php echo $seller['email']; ?>
                      </div>
                      <?php if(isset($seller['phone_number']) && !empty($seller['phone_number'])): ?>
                      <div class="mb-2">
                        <strong><i class="fas fa-phone me-2"></i>Telepon:</strong> 
                        <?php echo $seller['phone_number']; ?>
                      </div>
                      <?php endif; ?>
                      <?php if(isset($seller['bio']) && !empty($seller['bio'])): ?>
                      <div class="mb-2">
                        <strong><i class="fas fa-info-circle me-2"></i>Bio:</strong> 
                        <p><?php echo $seller['bio']; ?></p>
                      </div>
                      <?php endif; ?>
                    </div>
                    <div class="text-center mt-3">
                      <a href="edit_profile_seller.php" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit Profil
                      </a>
                    </div>
                  </div>
                </div>
              </div>
        
        <!-- Tombol Kembali -->
        <div class="text-center btn-back">
          <a href="index_seller.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
          </a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>