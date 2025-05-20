<?php
include('connection_db.php');
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Anda harus login terlebih dahulu.";
    header("Location: login.php");
    exit();
}

// Validasi method request harus POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error_message'] = "Metode request tidak valid.";
    header("Location: riwata_apply_lamaran.php");
    exit();
}

// Ambil ID lowongan dari POST (lebih aman daripada GET untuk form submission)
if (!isset($_POST['id_lowongan']) || !is_numeric($_POST['id_lowongan'])) {
    $_SESSION['error_message'] = "ID lowongan tidak valid.";
    header("Location: index_seller.php");
    exit();
}
$id_lowongan = (int)$_POST['id_lowongan'];


// Validasi ID lowongan harus numerik
if (!is_numeric($id_lowongan)) {
    $_SESSION['error_message'] = "ID lowongan tidak valid.";
    header("Location: index_seller.php");
    exit();
}

// Ambil data lowongan untuk memastikan ID valid dan lowongan masih aktif
$ql = "SELECT * FROM lowongan WHERE id_lowongan = ? AND status_lowongan = 'aktif'";
$stmt = $conn->prepare($ql);
$stmt->bind_param("i", $id_lowongan);
$stmt->execute();
$result = $stmt->get_result();

// Jika lowongan tidak ditemukan atau tidak aktif
if ($result->num_rows == 0) {
    $_SESSION['error_message'] = "Lowongan tidak ditemukan atau sudah tidak aktif.";
    header("Location: index_seller.php");
    exit();
}

$lowongan = $result->fetch_assoc();

// Periksa apakah sudah mencapai limit pelamar
if ($lowongan['jumlah_pelamar'] >= $lowongan['limit_pelamar'] && $lowongan['limit_pelamar'] > 0) {
    $_SESSION['error_message'] = "Maaf, lowongan ini sudah mencapai batas maksimal pelamar.";
    header("Location: index_seller.php");
    exit();
}

// Periksa apakah user sudah pernah melamar di lowongan ini
$check_sql = "SELECT * FROM daftar_lowongan WHERE id_lowongan = ? AND user_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $id_lowongan, $_SESSION['user_id']);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    $_SESSION['error_message'] = "Anda sudah pernah melamar untuk lowongan ini.";
    header("Location: lowongan_detail.php?id_lowongan=" . $id_lowongan);
    exit();
}

// Ambil ID pengguna dan data form lamaran
$user_id = $_SESSION['user_id'];
$deskripsi_diri = htmlspecialchars(trim($_POST['deskripsi_diri']));
$penawaran_harga = floatval($_POST['penawaran_harga']);

// Validasi input
if (empty($deskripsi_diri) || $penawaran_harga <= 0) {
    $_SESSION['error_message'] = "Semua field harus diisi dengan benar.";
    header("Location: apply_lowongan.php?id_lowongan=" . $id_lowongan);
    exit();
}

// Ambil data file portofolio dan pindahkan ke folder
$upload_success = false;
$portofolio = '';

if (isset($_FILES['portofolio']) && $_FILES['portofolio']['error'] == 0) {
    // Validasi file type
    $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    $file_type = $_FILES['portofolio']['type'];
    
    if (!in_array($file_type, $allowed_types)) {
        $_SESSION['error_message'] = "Format file tidak didukung. Gunakan PDF atau DOC/DOCX.";
        header("Location: apply_lowongan.php?id_lowongan=" . $id_lowongan);
        exit();
    }
    
    // Validasi ukuran file (max 5MB)
    if ($_FILES['portofolio']['size'] > 5000000) {
        $_SESSION['error_message'] = "Ukuran file terlalu besar (maksimal 5MB).";
        header("Location: apply_lowongan.php?id_lowongan=" . $id_lowongan);
        exit();
    }
    
    // Generate nama file unik untuk menghindari overwrite file yang sudah ada
    $file_extension = pathinfo($_FILES['portofolio']['name'], PATHINFO_EXTENSION);
    $portofolio = "portfolio_" . $user_id . "_" . time() . "." . $file_extension;
    
    $target_dir = "asset/portofolio/";
    
    // Pastikan direktori ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . $portofolio;
    
    // Pindahkan file
    if (move_uploaded_file($_FILES['portofolio']['tmp_name'], $target_file)) {
        $upload_success = true;
    } else {
        $_SESSION['error_message'] = "Gagal mengupload portofolio: " . error_get_last()['message'];
        header("Location: apply_lowongan.php?id_lowongan=" . $id_lowongan);
        exit();
    }
} else {
    $_SESSION['error_message'] = "File portofolio harus diunggah.";
    header("Location: apply_lowongan.php?id_lowongan=" . $id_lowongan);
    exit();
}

// Mulai transaksi
$conn->begin_transaction();

try {
    // Query untuk menyimpan lamaran ke tabel daftar_lowongan
    $created_at = date("Y-m-d H:i:s");
    $sql = "INSERT INTO daftar_lowongan (id_lowongan, user_id, portofolio, penawaran_harga, deskripsi_diri, created_at) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisdss", $id_lowongan, $user_id, $portofolio, $penawaran_harga, $deskripsi_diri, $created_at);
    $stmt->execute();
    
    // Update jumlah pelamar di tabel lowongan
    $update_sql = "UPDATE lowongan SET jumlah_pelamar = jumlah_pelamar + 1 WHERE id_lowongan = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $id_lowongan);
    $update_stmt->execute();
    
    // Commit transaksi jika semua berhasil
    $conn->commit();
    
    // Set pesan sukses dan redirect
    $_SESSION['success_message'] = "Lamaran berhasil dikirim! Tim kami akan meninjau lamaran Anda.";
    header("Location: riwayat_apply_lamaran.php");
    exit();
} catch (Exception $e) {
    // Rollback jika ada error
    $conn->rollback();
    
    // Hapus file jika sudah terupload tapi gagal menyimpan ke database
    if ($upload_success && file_exists($target_file)) {
        unlink($target_file);
    }
    
    $_SESSION['error_message'] = "Gagal mengirim lamaran: " . $e->getMessage();
    header("Location: apply_lowongan.php?id_lowongan=" . $id_lowongan);
    exit();
}
?>