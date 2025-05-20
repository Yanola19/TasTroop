<?php
session_start();
include('connection_db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data pengguna
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    header("Location: logout.php");
    exit();
}

// Proses form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $bio = $_POST['bio'] ?? '';
    $profile_picture = $user['profile_picture'];

    // Upload foto jika ada
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir);
        $filename = time() . '_' . basename($_FILES["profile_picture"]["name"]);
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = $target_file;
        }
    }

    // Update database tanpa alamat
    $sql_update = "UPDATE users SET full_name = ?, email = ?, phone_number = ?, bio = ?, profile_picture = ? WHERE user_id = ?";
    $stmt_update = $conn->prepare($sql_update);

    if ($stmt_update) {
        $stmt_update->bind_param("sssssi", $full_name, $email, $phone_number, $bio, $profile_picture, $user_id);
        $stmt_update->execute();
        $stmt_update->close();
        header("Location: profil_poster.php");
        exit();
    } else {
        die("Gagal menyiapkan statement: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Profil Pencari Jasa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container py-5">
    <div class="col-md-8 offset-md-2">
      <div class="card">
        <div class="card-header bg-warning text-white">
          <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edit Profil Pencari Jasa</h4>
        </div>
        <div class="card-body">
          <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="full_name" class="form-label">Nama Lengkap</label>
              <input type="text" name="full_name" id="full_name" class="form-control" required value="<?= htmlspecialchars($user['full_name']) ?>">
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control" required value="<?= htmlspecialchars($user['email']) ?>">
            </div>

            <div class="mb-3">
              <label for="phone_number" class="form-label">Nomor Telepon</label>
              <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?= htmlspecialchars($user['phone_number']) ?>">
            </div>

            <div class="mb-3">
              <label for="bio" class="form-label">Deskripsi / Bio</label>
              <textarea name="bio" id="bio" rows="4" class="form-control"><?= htmlspecialchars($user['bio']) ?></textarea>
            </div>

            <div class="mb-3">
              <label for="profile_picture" class="form-label">Foto Profil</label><br>
              <img src="<?= htmlspecialchars($user['profile_picture'] ?: 'assets/img/default-avatar.png') ?>" 
                   alt="Foto Sekarang" style="width:100px; height:100px; object-fit:cover;" class="rounded-circle mb-2">
              <input type="file" name="profile_picture" id="profile_picture" class="form-control">
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-success">Simpan</button>
              <a href="profil_poster.php" class="btn btn-secondary">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
