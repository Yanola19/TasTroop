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

// Cek apakah parameter ada
if (!isset($_GET['id_pelamar']) || !isset($_GET['action']) || !isset($_GET['id_lowongan'])) {
    $_SESSION['error_message'] = "Parameter tidak lengkap.";
    header("Location: index_poster.php");
    exit();
}

$id_pelamar = $_GET['id_pelamar'];
$action = $_GET['action'];
$id_lowongan = $_GET['id_lowongan'];

// Validasi tindakan
if ($action !== 'accept' && $action !== 'reject') {
    $_SESSION['error_message'] = "Tindakan tidak valid.";
    header("Location: view_applicants.php?id_lowongan=$id_lowongan");
    exit();
}

// Validasi kepemilikan lowongan
$sql_check = "SELECT * FROM lowongan 
              WHERE id_lowongan = ? AND user_id = ? AND status_lowongan = 'aktif'";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $id_lowongan, $_SESSION['user_id']);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows === 0) {
    $_SESSION['error_message'] = "Anda tidak memiliki akses atau lowongan sudah tidak aktif.";
    header("Location: index_poster.php");
    exit();
}

// Update status lamaran
$new_status = ($action === 'accept') ? 'diterima' : 'ditolak';

$sql_update = "UPDATE pelamar_apply 
               SET status_lamaran = ? 
               WHERE id_pelamar = ? AND id_lowongan = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("sii", $new_status, $id_pelamar, $id_lowongan);

// Jalankan query update
if ($stmt_update->execute()) {
    // Jika menolak, tidak perlu melakukan langkah tambahan
    if ($action === 'accept') {
        // Jika menerima, kirim notifikasi ke pelamar
        // Ambil user_id pelamar
        $sql_get_user = "SELECT user_id FROM pelamar_apply WHERE id_pelamar = ?";
        $stmt_get_user = $conn->prepare($sql_get_user);
        $stmt_get_user->bind_param("i", $id_pelamar);
        $stmt_get_user->execute();
        $result_get_user = $stmt_get_user->get_result();
        $user_data = $result_get_user->fetch_assoc();
        
        if ($user_data) {
            // Buat notifikasi untuk pelamar yang diterima
            $sql_notif = "INSERT INTO notifikasi (user_id, judul, pesan, tipe, is_read, related_id) 
                          VALUES (?, 'Lamaran Diterima', 'Selamat! Lamaran Anda untuk proyek telah diterima.', 
                                 'application_accepted', 0, ?)";
            $stmt_notif = $conn->prepare($sql_notif);
            $stmt_notif->bind_param("ii", $user_data['user_id'], $id_lowongan);
            $stmt_notif->execute();
        }
        
        // Update juga tabel lowongan jika pengguna memilih untuk otomatis menutup lowongan setelah menerima pelamar
        // (Opsional - Anda bisa menambahkan fitur ini jika diperlukan)
        // $sql_update_job = "UPDATE lowongan SET status_lowongan = 'tutup' WHERE id_lowongan = ?";
        // $stmt_update_job = $conn->prepare($sql_update_job);
        // $stmt_update_job->bind_param("i", $id_lowongan);
        // $stmt_update_job->execute();
    } else {
        // Jika menolak, kirim notifikasi ke pelamar
        $sql_get_user = "SELECT user_id FROM pelamar_apply WHERE id_pelamar = ?";
        $stmt_get_user = $conn->prepare($sql_get_user);
        $stmt_get_user->bind_param("i", $id_pelamar);
        $stmt_get_user->execute();
        $result_get_user = $stmt_get_user->get_result();
        $user_data = $result_get_user->fetch_assoc();
        
        if ($user_data) {
            $sql_notif = "INSERT INTO notifikasi (user_id, judul, pesan, tipe, is_read, related_id) 
                          VALUES (?, 'Lamaran Ditolak', 'Mohon maaf, lamaran Anda untuk proyek tidak dapat kami terima saat ini.', 
                                 'application_rejected', 0, ?)";
            $stmt_notif = $conn->prepare($sql_notif);
            $stmt_notif->bind_param("ii", $user_data['user_id'], $id_lowongan);
            $stmt_notif->execute();
        }
    }
    
    $_SESSION['success_message'] = ($action === 'accept') 
                                 ? "Berhasil menerima pelamar." 
                                 : "Berhasil menolak pelamar.";
} else {
    $_SESSION['error_message'] = "Gagal memperbarui status lamaran: " . $conn->error;
}

// Kembali ke halaman daftar pelamar
header("Location: view_applicants.php?id_lowongan=$id_lowongan");
exit();
?>