<?php
session_start();
include 'connection_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user_id = $result->fetch_assoc();

        // VERIFIKASI DENGAN password_verify
        if (password_verify($password, $user_id['password_hash'])) {
            // Login berhasil
            $_SESSION['user_id'] = $user_id['user_id'];
            $_SESSION['username'] = $user_id['username'];

            if ($user_id['is_seller'] == 1) {
                $_SESSION['is_seller'] = true;
                header("Location: index_seller.php");
            } else {
                $_SESSION['is_seller'] = false;
                header("Location: index_poster.php");
            }
        } else {
            $error_message = "Password salah.";
        }
    } else {
        $error_message = "Username tidak ditemukan.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Arial', sans-serif;
    }
    
    body {
      min-height: 100vh;
      background-color: #ffffff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    
    .login-container {
      width: 100%;
      max-width: 450px;
      height: 100vh;
      min-height: 600px;
      padding: 20px;
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }
    
    .logo-container {
      position: relative;
      width: 100%;
      height: 180px;
      margin-bottom: 20px;
    }
    
    .logo-circle {
      position: absolute;
      top: 0;
      left: 0;
      width: 100px;
      height: 100px;
      background-color: #000;
      border-radius: 50%;
      clip-path: polygon(0 0, 50% 0, 50% 100%, 0 100%);
    }
    
    .plant-image {
      position: absolute;
      top: 0;
      left: 50px;
      width: 150px;
      height: 150px;
      background-color: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }
    
    .plant-image img {
      height: 120px;
      object-fit: contain;
    }
    
    h1 {
      font-size: 28px;
      font-weight: bold;
      margin: 15px 0;
    }
    
    .input-field {
      width: 100%;
      height: 55px;
      border: 1px solid #ddd;
      border-radius: 12px;
      margin-bottom: 15px;
      padding: 0 15px;
      font-size: 16px;
      outline: none;
      transition: border-color 0.3s;
    }
    
    .input-field:focus {
      border-color: #000;
    }
    
    .input-field::placeholder {
      color: #aaa;
    }
    
    .login-button {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 10px;
    }
    
    .btn-masuk {
      background: none;
      border: none;
      font-size: 22px;
      font-weight: bold;
      cursor: pointer;
      padding: 0;
    }
    
    .btn-circle {
      width: 40px;
      height: 40px;
      background-color: #000;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    .btn-circle svg {
      width: 20px;
      height: 20px;
      fill: #fff;
    }
    
    .register-link {
      position: absolute;
      bottom: 40px;
      right: 20px;
      background-color: #000;
      color: #fff;
      padding: 8px 16px;
      border-radius: 20px;
      text-decoration: none;
      font-weight: bold;
    }
    
    .bottom-circle {
      position: absolute;
      bottom: 0;
      right: 0;
      width: 100px;
      height: 100px;
      background-color: #000;
      border-radius: 50% 0 0 0;
    }
    
    .error-message {
      color: #ff3333;
      margin-bottom: 15px;
      font-size: 14px;
    }
    
    /* Tambahan style untuk "Belum Punya Akun?" */
    .no-account {
      text-align: center;
      margin-top: 20px;
      font-size: 15px;
    }
    
    .no-account a {
      color: #000;
      font-weight: bold;
      text-decoration: none;
    }
    
    .no-account a:hover {
      text-decoration: underline;
    }
    
    /* Responsive styles */
    @media screen and (min-width: 768px) {
      body {
        background-color: #f5f5f5;
        padding: 20px;
      }
      
      .login-container {
        height: auto;
        min-height: 600px;
        max-height: 90vh;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        margin: 20px auto;
        overflow: hidden;
      }
      
      .logo-container {
        margin-top: 20px;
      }
      
      .plant-image {
        width: 180px;
        height: 180px;
      }
      
      .plant-image img {
        height: 140px;
      }
      
      h1 {
        font-size: 32px;
      }
      
      .input-field {
        height: 60px;
        font-size: 18px;
      }
      
      .btn-masuk {
        font-size: 24px;
      }
      
      .btn-circle {
        width: 48px;
        height: 48px;
      }
      
      .no-account {
        font-size: 16px;
      }
    }
    
    @media screen and (min-width: 1024px) {
      .login-container {
        max-width: 500px;
      }
    }
    
    @media screen and (max-height: 700px) {
      .logo-container {
        height: 150px;
      }
      
      .plant-image {
        width: 130px;
        height: 130px;
      }
      
      .plant-image img {
        height: 100px;
      }
      
      .input-field {
        height: 50px;
        margin-bottom: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="logo-container">
      <div class="logo-circle"></div>
      <div class="plant-image">
        <img src="plant.png" alt="Plant" id="plantImage">
      </div>
    </div>
    
    <h1>Masuk</h1>
    
    <?php if(isset($error_message)): ?>
      <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    
    <form method="post" action="login.php" id="loginForm">
      <input type="text" class="input-field" id="username" name="username" placeholder="Username " required>
      <input type="password" class="input-field" id="password" name="password" placeholder="Password" required>
      
      <div class="login-button">
        <button type="submit" class="btn-masuk">Masuk</button>
        <div class="btn-circle">
          <svg viewBox="0 0 24 24">
            <path d="M8.59,16.59L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.59Z" />
          </svg>
        </div>
      </div>
    </form>
    
    <!-- Tambahan "Belum Punya Akun?" -->
    <div class="no-account">
      Belum Punya Akun? <a href="register.php">Klik Disini</a>
    </div>
    
    <a href="register.php" class="register-link">Daftar</a>
    <div class="bottom-circle"></div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Adjust container height based on viewport
      function adjustHeight() {
        const container = document.querySelector('.login-container');
        const viewportHeight = window.innerHeight;
        
        // Set minimum height for mobile
        if (window.innerWidth < 768) {
          container.style.height = viewportHeight + 'px';
        } else {
          container.style.height = 'auto';
          container.style.minHeight = '600px';
          container.style.maxHeight = '90vh';
        }
      }
      
      // Run on page load and window resize
      adjustHeight();
      window.addEventListener('resize', adjustHeight);
      
      // Check if plant image loads, if not use a default placeholder
      const plantImg = document.getElementById('plantImage');
      
      plantImg.onerror = function() {
        // Create SVG plant-like image as fallback
        const svg = `
          <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <path d="M50,90 C50,90 80,60 80,40 C80,20 65,20 50,40 C35,20 20,20 20,40 C20,60 50,90 50,90 Z" fill="none" stroke="#4CAF50" stroke-width="2"/>
            <path d="M50,90 L50,40" stroke="#4CAF50" stroke-width="2"/>
            <path d="M50,60 C50,60 60,50 70,55" stroke="#4CAF50" stroke-width="2"/>
            <path d="M50,70 C50,70 40,65 30,70" stroke="#4CAF50" stroke-width="2"/>
            <path d="M50,50 C50,50 60,40 65,45" stroke="#4CAF50" stroke-width="2"/>
          </svg>
        `;
        
        const container = plantImg.parentElement;
        container.innerHTML = svg;
      };
      
      // Form validation and submission handling
      const loginForm = document.getElementById('loginForm');
      
      loginForm.addEventListener('submit', function(e) {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        
        if (username.length < 4) {
          e.preventDefault();
          alert('Username harus minimal 4 karakter.');
          return;
        }
        
        if (password.length < 6) {
          e.preventDefault();
          alert('Password harus minimal 6 karakter.');
          return;
        }
        
        // Form is valid, will submit normally
      });
      
      // Add focus effects for input fields
      const inputs = document.querySelectorAll('.input-field');
      
      inputs.forEach(input => {
        input.addEventListener('focus', function() {
          this.style.borderColor = '#000';
          this.style.boxShadow = '0 0 0 2px rgba(0,0,0,0.1)';
        });
        
        input.addEventListener('blur', function() {
          this.style.borderColor = '#ddd';
          this.style.boxShadow = 'none';
        });
      });
    });
  </script>
</body>
</html>