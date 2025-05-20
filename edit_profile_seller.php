<?php
include('connection_db.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil data user
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $bio = $_POST['bio'];

    // File upload optional
    $profile_picture = $user['profile_picture'];
    if (!empty($_FILES['profile_picture']['name'])) {
        $profile_picture = $_FILES['profile_picture']['name'];
        $target_path = 'uploads/' . $profile_picture; // Simpan di folder uploads
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_path);
    }

    $update_sql = "UPDATE users SET full_name=?, email=?, phone_number=?, bio=?, profile_picture=?, updated_at=NOW() WHERE username=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssss", $full_name, $email, $phone_number, $bio, $profile_picture, $_SESSION['username']);

    if ($update_stmt->execute()) {
        header("Location: profil_seller.php");
        exit;
    } else {
        echo "Gagal memperbarui profil: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profil</title>
    <script>
    // Tambahkan CSS dengan JavaScript
    document.addEventListener("DOMContentLoaded", function() {
        const style = document.createElement('style');
        style.textContent = `
            body {
                font-family: Arial, sans-serif;
                background-color: #f8f9fa;
                padding: 30px;
            }

            h2 {
                color: #333;
                text-align: center;
            }

            form {
                max-width: 500px;
                margin: 0 auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .form-group {
                margin-bottom: 15px;
            }

            label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
            }

            input[type="text"],
            input[type="email"],
            textarea,
            input[type="file"] {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            button {
                background-color: #28a745;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                width: 100%;
            }

            button:hover {
                background-color: #218838;
            }
        `;
        document.head.appendChild(style);
    });
    </script>
</head>
<body>
    <h2>Edit Profil Seller</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Lengkap:</label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>">
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
        </div>

        <div class="form-group">
            <label>No. Telepon:</label>
            <input type="text" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>">
        </div>

        <div class="form-group">
            <label>Bio:</label>
            <textarea name="bio"><?php echo htmlspecialchars($user['bio']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Foto Profil (opsional):</label>
            <input type="file" name="profile_picture">
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
