<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buat Akun</title>
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
      padding: 0;
    }

    .register-container {
      width: 100%;
      max-width: 450px;
      height: 100vh;
      position: relative;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      background: #ffffff;
    }

    .header-image {
      width: 100%;
      height: 35%;
      min-height: 180px;
      position: relative;
      overflow: hidden;
    }

    .circle-bg {
      width: 100%;
      height: 100%;
      background-color: #000;
      border-radius: 0 0 50% 50%;
      overflow: hidden;
      position: relative;
    }

    .plant-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.8;
    }

    .header-text {
      position: absolute;
      top: 30%;
      left: 10%;
      color: #fff;
      font-size: 2.2em;
      font-weight: bold;
      line-height: 1.2;
      z-index: 10;
    }

    .form-section {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
      position: relative;
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

    textarea.input-field {
      height: 80px;
      padding-top: 15px;
      resize: none;
    }

    .input-field:focus {
      border-color: #000;
      box-shadow: 0 0 0 2px rgba(0,0,0,0.1);
    }

    .input-field::placeholder {
      color: #aaa;
    }

    .checkbox-field {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
    }

    .checkbox-field input {
      margin-right: 10px;
      width: 18px;
      height: 18px;
    }

    .register-button {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .btn-daftar {
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

    .login-link {
      position: absolute;
      bottom: 40px;
      right: 20px;
      background-color: #000;
      color: #fff;
      padding: 8px 16px;
      border-radius: 20px;
      text-decoration: none;
      font-weight: bold;
      z-index: 100;
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

    .login-text {
      margin-top: 10px;
      margin-bottom: 20px;
      text-align: center;
    }

    .login-text a {
      color: #000;
      text-decoration: none;
      font-weight: bold;
    }

    .file-input-container {
      position: relative;
      margin-bottom: 15px;
    }

    .file-input-label {
      display: block;
      width: 100%;
      height: 55px;
      border: 1px solid #ddd;
      border-radius: 12px;
      padding: 0 15px;
      font-size: 16px;
      display: flex;
      align-items: center;
      cursor: pointer;
      color: #aaa;
    }

    .file-input {
      position: absolute;
      top: 0;
      left: 0;
      opacity: 0;
      width: 100%;
      height: 100%;
      cursor: pointer;
    }

    /* Responsive styles */
    @media screen and (min-width: 768px) {
      body {
        background-color: #f5f5f5;
        padding: 20px;
      }

      .register-container {
        height: auto;
        min-height: 700px;
        max-height: 90vh;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      }

      .header-image {
        height: 180px;
      }

      .form-section {
        padding: 20px 30px;
      }

      .input-field {
        height: 60px;
        font-size: 17px;
      }

      .btn-daftar {
        font-size: 24px;
      }

      .btn-circle {
        width: 48px;
        height: 48px;
      }
    }

    @media screen and (min-width: 1024px) {
      .register-container {
        max-width: 500px;
      }
    }

    @media screen and (max-height: 800px) and (min-width: 768px) {
      .register-container {
        max-height: 95vh;
      }
      
      .header-image {
        height: 140px;
        min-height: 140px;
      }

      .input-field {
        height: 50px;
        margin-bottom: 12px;
      }
      
      textarea.input-field {
        height: 70px;
      }
    }
  </style>
</head>
<body>
  <div class="register-container">
    <div class="header-image">
      <div class="circle-bg">
        <img src="https://images.unsplash.com/photo-1535930749574-1399327ce78f" alt="Plant Background" class="plant-bg" id="plantBg">
        <div class="header-text">Buat<br>Akun</div>
      </div>
    </div>

    <div class="form-section">
      <form method="post" action="submit_register.php" enctype="multipart/form-data" id="registerForm">
        <input type="text" class="input-field" id="username" name="username" placeholder="Username" required minlength="4">
        
        <input type="email" class="input-field" id="email" name="email" placeholder="Email" required>
        
        <input type="password" class="input-field" id="password" name="password" placeholder="Password" required minlength="6">
        
        <input type="text" class="input-field" id="full_name" name="full_name" placeholder="Nama Lengkap" required>
        
        <input type="tel" class="input-field" id="phone_number" name="phone_number" placeholder="Nomor Telepon" required pattern="[0-9+]{10,15}">
        
        <div class="file-input-container">
          <label class="file-input-label" id="file-label">Foto Profil</label>
          <input type="file" class="file-input" id="profile_picture" name="profile_picture" accept="image/jpeg,image/png,image/gif">
        </div>
        
        <textarea class="input-field" id="bio" name="bio" placeholder="Bio" rows="3"></textarea>
        
        <div class="checkbox-field">
          <input type="checkbox" id="is_seller" name="is_seller" value="1">
          <label for="is_seller">Daftar sebagai Pelamar</label>
        </div>
        
        <div class="register-button">
          <button type="submit" class="btn-daftar">Daftar</button>
          <div class="btn-circle">
            <svg viewBox="0 0 24 24">
              <path d="M8.59,16.59L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.59Z" />
            </svg>
          </div>
        </div>
        
        <div class="login-text">
          <a href="login.php">Sudah Punya Akun?</a>
        </div>
      </form>
    </div>

    <a href="login.php" class="login-link">Masuk</a>
    <div class="bottom-circle"></div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Adjust container height based on viewport
      function adjustHeight() {
        const container = document.querySelector('.register-container');
        const viewportHeight = window.innerHeight;
        
        // Set minimum height for mobile
        if (window.innerWidth < 768) {
          container.style.height = viewportHeight + 'px';
        } else {
          container.style.height = 'auto';
          container.style.minHeight = '700px';
          container.style.maxHeight = '90vh';
        }
      }
      
      // Run on page load and window resize
      adjustHeight();
      window.addEventListener('resize', adjustHeight);
      
      // Check if plant image loads, if not use a default color
      const plantImg = document.getElementById('plantBg');
      
      plantImg.onerror = function() {
        const circleBg = document.querySelector('.circle-bg');
        circleBg.style.background = 'linear-gradient(to bottom right, #1e3c35, #2d5f4c)';
        this.style.display = 'none';
      };
      
      // Update file input label when file is selected
      const fileInput = document.getElementById('profile_picture');
      const fileLabel = document.getElementById('file-label');
      
      fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
          const fileName = this.files[0].name;
          fileLabel.textContent = fileName.length > 25 ? fileName.substring(0, 22) + '...' : fileName;
          fileLabel.style.color = '#000';
        } else {
          fileLabel.textContent = 'Foto Profil';
          fileLabel.style.color = '#aaa';
        }
      });
      
      // Form validation and submission handling
      const registerForm = document.getElementById('registerForm');
      
      registerForm.addEventListener('submit', function(e) {
        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const fullName = document.getElementById('full_name').value;
        const phoneNumber = document.getElementById('phone_number').value;
        
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
        
        if (!validateEmail(email)) {
          e.preventDefault();
          alert('Format email tidak valid.');
          return;
        }
        
        if (fullName.trim() === '') {
          e.preventDefault();
          alert('Nama lengkap harus diisi.');
          return;
        }
        
        if (!validatePhone(phoneNumber)) {
          e.preventDefault();
          alert('Format nomor telepon tidak valid.');
          return;
        }
        
        // Form is valid, will submit normally
      });
      
      // Email validation function
      function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
      }
      
      // Phone validation function
      function validatePhone(phone) {
        const re = /^[0-9+]{10,15}$/;
        return re.test(phone);
      }
      
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