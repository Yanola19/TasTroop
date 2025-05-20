<?php
include('connection_db.php');
session_start();

if (!isset($_POST['id_lowongan']) || !is_numeric($_POST['id_lowongan'])) {
    die("ID lowongan tidak tersedia.");
}

$id_lowongan = intval($_POST['id_lowongan']); 

$sql = "SELECT * FROM lowongan WHERE id_lowongan = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_lowongan);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Lowongan tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar untuk Kerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Daftar untuk Lowongan: <?= htmlspecialchars($row['nama_lowongan']) ?></h1>
        <form action="submit_apply.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_lowongan" value="<?= $id_lowongan ?>">
            <div class="form-group mb-3">
                <label for="deskripsi_diri">Deskripsi Diri</label>
                <textarea class="form-control" name="deskripsi_diri" id="deskripsi_diri" rows="4" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="penawaran_harga">Penawaran Harga (dalam angka)</label>
                <input type="number" class="form-control" name="penawaran_harga" id="penawaran_harga" required>
            </div>
            <div class="form-group mb-3">
                <label for="portofolio">Portofolio (File)</label>
                <input type="file" class="form-control" name="portofolio" id="portofolio" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit Lamaran</button>
        </form>
    </div>
</body>
</html>
