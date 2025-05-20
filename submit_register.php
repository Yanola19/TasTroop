<?php
session_start();
include 'connection_db.php'; // Sesuaikan dengan file koneksi kamu

// Ambil data dari form
$username      = $_POST['username'];
$email         = $_POST['email'];
$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
$full_name     = $_POST['full_name'];
$phone_number  = $_POST['phone_number'];
$bio           = $_POST['bio'];
$is_seller     = isset($_POST['is_seller']) ? 1 : 0;

// Upload foto profil jika ada
$profile_picture = null;

if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_tmp = $_FILES['profile_picture']['tmp_name'];
    $file_name = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
    $target_path = $upload_dir . $file_name;

    if (move_uploaded_file($file_tmp, $target_path)) {
        $profile_picture = $target_path;
    }
}

// Siapkan query insert
$stmt = $conn->prepare("INSERT INTO users 
    (username, email, password_hash, full_name, phone_number, profile_picture, bio, is_seller) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("sssssssi", $username, $email, $password_hash, $full_name, $phone_number, $profile_picture, $bio, $is_seller);

// Eksekusi dan login otomatis
if ($stmt->execute()) {
    $_SESSION['user_id'] = $stmt->insert_id;

    // Redirect langsung ke dashboard lowongan (index_poster.php)
    header("Location: index_poster.php");
    exit();
} else {
    $_SESSION['error_message'] = "Pendaftaran gagal: " . $stmt->error;
    header("Location: register.php");
    exit();
}
?>
