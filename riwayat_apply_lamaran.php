<?php include('connection_db.php'); 
session_start(); 

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT dl.*, l.nama_lowongan, l.jenis_lowongan, l.deskripsi, l.harga_jasa, l.tanggal_tutup
        FROM daftar_lowongan dl
        JOIN lowongan l ON dl.id_lowongan = l.id_lowongan
        WHERE dl.user_id = ?
        ORDER BY dl.created_at DESC";

try {
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
} catch (Exception $e) {
    $error_message = $e->getMessage();
} finally {
    if (!empty($stmt) && get_class($stmt) === 'mysqli_stmt') {
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerja Lepas - Riwayat Lamaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1e56a0;
            --secondary-color: #7FB3D5;
            --accent-color: #4DA6FF;
            --light-bg: #f8fbfd;
            --border-radius: 12px;
            --box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: #333;
            padding-bottom: 50px;
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
        
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 25px;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 15px 20px;
            border-bottom: none;
        }
        
        .card-body {
            padding: 25px;
        }
        
        .card-title {
            font-weight: 600;
            color: #222;
            margin-bottom: 12px;
        }
        
        .card-subtitle {
            font-size: 0.9rem;
            margin-bottom: 15px;
            color: #666;
        }
        
        .badge {
            padding: 6px 12px;
            font-weight: 500;
            margin-right: 8px;
            font-size: 0.8rem;
        }
        
        .badge-primary {
            background-color: var(--primary-color);
        }
        
        .price-tag {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.1rem;
        }
        
        .portofolio-link {
            display: inline-flex;
            align-items: center;
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .portofolio-link:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }
        
        .portofolio-link i {
            margin-right: 8px;
        }
        
        .submission-date {
            color: #888;
            font-size: 0.85rem;
            margin-top: 15px;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }
        
        .empty-state i {
            font-size: 3.5rem;
            color: #ccc;
            margin-bottom: 20px;
        }
        
        .empty-state-text {
            font-weight: 500;
            color: #777;
            max-width: 400px;
            margin: 0 auto 20px;
        }
        
        .loading-spinner {
            text-align: center;
            padding: 40px;
        }
        
        /* Responsiveness */
        @media (max-width: 768px) {
            .page-header {
                padding: 25px 0 15px;
                margin-bottom: 25px;
            }
            
            .card-body {
                padding: 20px 15px;
            }
        }
        
        /* Profile badge */
        .profile-badge {
            background-color: var(--accent-color);
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        /* Hero section */
        .hero-section {
            background-color: var(--primary-color);
            padding: 60px 0;
            margin-bottom: 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background-image: url('asset/images/pattern.svg');
            background-size: cover;
            opacity: 0.1;
            z-index: 1;
        }
        
        .hero-title {
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 15px;
        }
        
        .hero-text {
            font-size: 1.1rem;
            max-width: 600px;
            margin-bottom: 25px;
            opacity: 0.9;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 15px;
        }
        
        .status-pending {
            background-color: #FFF3CD;
            color: #856404;
        }
        
        .status-accepted {
            background-color: #D4EDDA;
            color: #155724;
        }
        
        .status-rejected {
            background-color: #F8D7DA;
            color: #721C24;
        }
        
        /* Progress Timeline */
        .timeline {
            margin-top: 30px;
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            height: 100%;
            width: 2px;
            background-color: #e9ecef;
            left: 0;
            top: 0;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 25px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: var(--accent-color);
            left: -37px;
            top: 0;
        }
        
        .timeline-date {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 5px;
        }
        
        .timeline-event {
            font-weight: 500;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        /* Card status indicator */
        .card-status-indicator {
            position: absolute;
            top: 0;
            right: 0;
            width: 15px;
            height: 100%;
        }
        
        .status-indicator-pending {
            background-color: #FFC107;
        }
        
        .status-indicator-accepted {
            background-color: #28A745;
        }
        
        .status-indicator-rejected {
            background-color: #DC3545;
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

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 hero-content">
                    <h1 class="hero-title">Kerja Lepas</h1>
                    <p class="hero-text">Kelola dan pantau semua lamaran yang telah kamu ajukan. Lihat status dan temukan peluang karier freelance terbaikmu.</p>
                </div>
                <div class="col-md-6 text-center d-none d-md-block">
                    <img src="asset/img/logo1.png" alt="Illustration" class="img-fluid" style="max-height: 250px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h2 class="section-title">Riwayat Lamaran Kamu</h2>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger fade-in">Error: <?= htmlspecialchars($error_message) ?></div>
        <?php else: ?>
            <div class="row fade-in" id="lamaran-container">
                <!-- Loading spinner will be replaced by content -->
                <div class="loading-spinner" id="loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat lamaran...</p>
                </div>
                
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-lg-6 lamaran-item" style="display: none;">
                            <div class="card position-relative">
                                <!-- Status indicator based on status (you'll need to add a status field to your database) -->
                                <?php
                                // This is just a placeholder. Replace with actual status logic from your database
                                $status = isset($row['status']) ? $row['status'] : 'pending';
                                $statusClass = 'status-indicator-pending';
                                $statusBadgeClass = 'status-pending';
                                $statusText = 'Menunggu';
                                
                                if ($status === 'accepted') {
                                    $statusClass = 'status-indicator-accepted';
                                    $statusBadgeClass = 'status-accepted';
                                    $statusText = 'Diterima';
                                } elseif ($status === 'rejected') {
                                    $statusClass = 'status-indicator-rejected';
                                    $statusBadgeClass = 'status-rejected';
                                    $statusText = 'Ditolak';
                                }
                                ?>
                                <div class="card-status-indicator <?= $statusClass ?>"></div>
                                
                                <div class="card-body">
                                    <span class="status-badge <?= $statusBadgeClass ?>"><?= $statusText ?></span>
                                    <h5 class="card-title"><?= htmlspecialchars($row['nama_lowongan']) ?></h5>
                                    <h6 class="card-subtitle text-muted">
                                        <i class="fa-solid fa-tag me-1"></i> <?= htmlspecialchars($row['jenis_lowongan']) ?>
                                    </h6>
                                    
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Harga Pekerjaan:</strong></p>
                                            <p class="price-tag">Rp <?= number_format($row['harga_jasa'], 0, ',', '.') ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Penawaran Kamu:</strong></p>
                                            <p class="price-tag">Rp <?= number_format($row['penawaran_harga'], 0, ',', '.') ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <p class="mb-1"><strong>Deskripsi Pekerjaan:</strong></p>
                                        <p class="text-muted"><?= nl2br(htmlspecialchars(substr($row['deskripsi'], 0, 150) . (strlen($row['deskripsi']) > 150 ? '...' : ''))) ?></p>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <p class="mb-1"><strong>Deskripsi Diri:</strong></p>
                                        <p class="text-muted"><?= nl2br(htmlspecialchars(substr($row['deskripsi_diri'], 0, 150) . (strlen($row['deskripsi_diri']) > 150 ? '...' : ''))) ?></p>
                                    </div>
                                    
                                    <?php
                                    $portofolio_path = 'asset/portofolio/' . $row['portofolio'];
                                    if (!empty($row['portofolio']) && file_exists($portofolio_path)):
                                    ?>
                                        <div class="mt-3">
                                            <a href="<?= $portofolio_path ?>" class="portofolio-link" target="_blank">
                                                <i class="fa-solid fa-file-lines"></i> Lihat Portofolio
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="submission-date">
                                        <i class="fa-regular fa-clock me-1"></i> Dilamar pada <?= date('d/m/Y H:i', strtotime($row['created_at'])) ?>
                                    </div>
                                    
                                    <button class="btn btn-outline-primary mt-3 view-details-btn" data-id="<?= $row['id'] ?>">
                                        <i class="fa-solid fa-eye me-1"></i> Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-state" style="display: none;" id="empty-state">
                        <i class="fa-solid fa-file-circle-xmark"></i>
                        <h4>Belum Ada Lamaran</h4>
                        <p class="empty-state-text">Kamu belum mengajukan lamaran pada lowongan apapun.</p>
                        <a href="lowongan.php" class="btn btn-primary">
                            <i class="fa-solid fa-briefcase me-1"></i> Cari Lowongan
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="text-center mt-4">
            <a href="index_seller.php" class="btn btn-outline-primary">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simulate loading
            setTimeout(function() {
                document.getElementById('loading-spinner').style.display = 'none';
                
                const lamaranItems = document.querySelectorAll('.lamaran-item');
                if (lamaranItems.length > 0) {
                    lamaranItems.forEach(function(item, index) {
                        setTimeout(function() {
                            item.style.display = 'block';
                            item.classList.add('fade-in');
                        }, index * 100);
                    });
                } else {
                    document.getElementById('empty-state').style.display = 'block';
                    document.getElementById('empty-state').classList.add('fade-in');
                }
            }, 800);
            
            // View details button functionality
            const viewDetailsBtns = document.querySelectorAll('.view-details-btn');
            viewDetailsBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const applicationId = this.getAttribute('data-id');
                    showApplicationDetails(applicationId);
                });
            });
            
            // This is a mock function - in a real app, you would fetch the data from server
            function showApplicationDetails(id) {
                // Simulating API call to get details
                const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
                
                // Set modal content (this would come from API in a real app)
                // For now we'll just use placeholder data
                document.getElementById('submission-date').textContent = getCurrentDateString(-7);
                document.getElementById('review-date').textContent = getCurrentDateString(-3);
                document.getElementById('decision-date').textContent = getCurrentDateString(-1);
                
                // Show modal
                detailModal.show();
                
                // In a real app, you'd do something like this:
                /*
                fetch('get_application_details.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        // Update modal content with the fetched data
                        document.getElementById('detail-content').innerHTML = 
                            `<h4>${data.job_title}</h4>
                             <p>${data.description}</p>`;
                        // Show modal
                        detailModal.show();
                    })
                    .catch(error => {
                        console.error('Error fetching application details:', error);
                    });
                */
            }
            
            // Helper to get date string for X days ago
            function getCurrentDateString(dayOffset = 0) {
                const date = new Date();
                date.setDate(date.getDate() + dayOffset);
                return date.toLocaleDateString('id-ID');
            }
        });
    </script>
</body>
</html>