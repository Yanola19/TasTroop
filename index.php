<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kerja Lepas</title>
  <style>
    /* --- Style digabung dari ketiga bagian --- */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #f8f9fa;
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

    .login {
      padding: 0.5rem 1rem;
      border: none;
      background: transparent;
      color: #333;
      cursor: pointer;
    }

    .register {
      padding: 0.5rem 1rem;
      border: 1px solid #20b2aa;
      border-radius: 4px;
      background: transparent;
      color: #20b2aa;
      cursor: pointer;
    }

    /* Hero */
    .hero {
      display: flex;
      justify-content: space-between;
      padding: 2rem 4rem;
      position: relative;
      overflow: hidden;
    }

    .hero-content {
      width: 50%;
      padding-top: 5rem;
    }

    .hero-title {
      font-size: 4rem;
      font-weight: bold;
      line-height: 1.1;
      margin-bottom: 2rem;
    }

    .hero-image {
      width: 40%;
      position: relative;
    }

    .hero-image img {
      width: 100%;
      max-width: 350px;
      height: auto;
      border-radius: 50% 50% 0 0;
      background-color: rgba(32, 178, 171, 0.2);
    }

    .shapes { position: absolute; width: 100%; height: 100%; z-index: -1; }
    .shape { position: absolute; border-radius: 50%; }
    .yellow { background-color: #ffd966; width: 60px; height: 60px; top: 10%; right: 10%; }
    .green { background-color: #77dd77; width: 40px; height: 40px; bottom: 20%; left: 10%; }
    .blue { background-color: #aed9e0; width: 30px; height: 30px; bottom: 40%; right: 30%; }
    .pink { background-color: #ffc0cb; width: 50px; height: 50px; bottom: 20%; right: 10%; }

    .swirl {
      position: absolute;
      top: 30%;
      left: 50%;
      width: 100px;
      height: 100px;
      border: 3px solid #20b2aa;
      border-radius: 50%;
      border-left-color: transparent;
      transform: rotate(-45deg);
    }

    /* Partners */
    .partners {
      display: flex;
      justify-content: space-around;
      align-items: center;
      padding: 1rem 2rem;
      background-color: #f8f9fa;
      border-top: 1px solid #eee;
    }
    .partner { opacity: 0.7; font-weight: bold; color: #555; }

    /* Services */
    .services { padding: 4rem 2rem; text-align: center; }
    .services-title { font-size: 2rem; margin-bottom: 1rem; }
    .services-title span { color: #20b2aa; }
    .services-desc { font-size: 0.9rem; color: #666; max-width: 700px; margin: 0 auto; }

    .services-container { max-width: 1000px; width: 100%; margin: 0 auto; padding: 40px 0; }
    .services-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 30px;
      margin-bottom: 40px;
    }

    .service-card {
      height: 280px;
      border-radius: 30px;
      overflow: hidden;
      position: relative;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .service-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }
    .service-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(0.7);
    }
    .service-content {
      position: absolute;
      bottom: 30px;
      left: 30px;
      color: white;
      z-index: 2;
    }
    .service-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 10px;
      color: #2ce0d0;
      text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }
    .stars {
      color: #ffd700;
      font-size: 18px;
      letter-spacing: 5px;
    }
    .border-path { position: absolute; width: 100%; height: 100%; top: 0; left: 0; pointer-events: none; z-index: -1; }
    .border-path svg { width: 100%; height: 100%; stroke: #2ce0d0; stroke-width: 1px; fill: none; opacity: 0.3; }

    .view-all-btn,
    .features-btn {
      display: block;
      width: 180px;
      padding: 12px 0;
      background-color: transparent;
      color: #20b2aa;
      text-align: center;
      text-decoration: none;
      border: 1px solid #20b2aa;
      border-radius: 5px;
      font-size: 16px;
      margin: 0 auto;
      transition: all 0.3s ease;
      cursor: pointer;
    }
    .view-all-btn:hover,
    .features-btn:hover {
      background-color: #20b2aa;
      color: white;
    }

    .features {
      padding: 4rem 2rem;
      text-align: center;
      background-color: #f8f9fa;
    }
    .features-header h2 { font-size: 2.5rem; margin-bottom: 0.5rem; }
    .features-header h2 span { color: #20b2aa; font-weight: bold; }
    .features-desc {
      font-size: 0.9rem;
      color: #666;
      max-width: 700px;
      margin: 0 auto 3rem auto;
      line-height: 1.6;
    }
    .features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
      max-width: 1200px;
      margin: 0 auto 3rem auto;
    }
    .feature-card {
      background-color: white;
      border-radius: 10px;
      padding: 2rem 1.5rem;
      text-align: center;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    .feature-title { color: #20b2aa; font-size: 1.3rem; margin-bottom: 1rem; font-weight: 600; }
    .feature-desc { color: #666; font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem; }
    .feature-link {
      color: #20b2aa;
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
      display: inline-block;
      position: relative;
    }
    .feature-link:after {
      content: '';
      position: absolute;
      width: 100%;
      height: 2px;
      bottom: -4px;
      left: 0;
      background-color: #20b2aa;
      transform: scaleX(0);
      transform-origin: bottom right;
      transition: transform 0.3s ease;
    }
    .feature-link:hover:after {
      transform: scaleX(1);
      transform-origin: bottom left;
    }
    .features-btn {
      display: block;
      width: 180px;
      padding: 12px 0;
      background-color: transparent;
      color: #20b2aa;
      text-align: center;
      text-decoration: none;
      border: 1px solid #20b2aa;
      border-radius: 5px;
      font-size: 16px;
      margin: 0 auto;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .features-btn:hover {
      background-color: #20b2aa;
      color: white;
    }

    @media (max-width: 768px) {
      .hero {
        flex-direction: column;
        padding: 2rem;
      }

      .hero-content, .hero-image {
        width: 100%;
        text-align: center;
      }

      .hero-title {
        font-size: 3rem;
      }

      .nav-links {
        display: none;
      }

      .services-grid {
        grid-template-columns: 1fr;
      }

      .service-card {
        height: 220px;
      }

      .service-title {
        font-size: 20px;
      }

      .features-grid {
        grid-template-columns: 1fr;
      }
    }
    .testimonial-wrapper {
    padding: 4rem 2rem;
    background-color: #ffffff;
    max-width: 1200px;
    margin: 0 auto;
    }

    .testimonial-wrapper .header {
    text-align: center;
    margin-bottom: 30px;
    padding: 20px;
    }

    .testimonial-wrapper .header h2 {
    font-size: 40px;
    font-weight: 300;
    margin-bottom: 20px;
    }

    .testimonial-wrapper .header h2 span {
    color: #26a69a;
    font-weight: 400;
    }

    .testimonial-wrapper .header p {
    font-size: 16px;
    color: #333;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
    }

    .testimonial-container {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 30px;
    margin-bottom: 50px;
    }

    .profile-image {
    flex: 1;
    max-width: 300px;
    border-radius: 50%;
    overflow: hidden;
    }

    .profile-image img {
    width: 100%;
    height: auto;
    }

    .testimonial-content {
    flex: 2;
    background-color: #f9f9f9;
    padding: 40px;
    border-radius: 8px;
    }

    .testimonial-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
    }

    .testimonial-text {
    font-size: 16px;
    line-height: 1.6;
    color: #444;
    margin-bottom: 20px;
    }

    .rating {
    display: flex;
    margin-bottom: 10px;
    }

    .star {
    color: #ffc107;
    font-size: 20px;
    margin-right: 4px;
    }

    .client-info {
    margin-top: 10px;
    }

    .client-name {
    font-weight: 600;
    font-size: 18px;
    color: #333;
    }

    .client-position {
    font-size: 14px;
    color: #666;
    }

    .controls {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    }

    .control-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #fff;
    border: 1px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    }

    .control-btn:hover {
    background-color: #f0f0f0;
    }

    @media (max-width: 768px) {
    .testimonial-container {
        flex-direction: column;
    }

    .profile-image {
        margin-bottom: 20px;
    }

    .testimonial-wrapper .header h2 {
        font-size: 32px;
    }
    }
    
    .faq-wrapper {
    background-color: #ffffff;
    padding: 4rem 2rem;
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
    }

    .faq-wrapper .header {
    text-align: center;
    margin-bottom: 40px;
    padding-top: 40px;
    }

    .faq-wrapper .header h2 {
    font-size: 42px;
    font-weight: 500;
    color: #26a69a;
    position: relative;
    display: inline-block;
    }

    .faq-wrapper .header h2::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 100%;
    height: 1px;
    background-color: #eee;
    }

    .faq-container {
    max-width: 800px;
    margin: 0 auto;
    }

    .faq-item {
    background-color: #fff;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
    }

    .faq-question {
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    transition: background-color 0.3s ease;
    }

    .faq-question:hover {
    background-color: #f9f9f9;
    }

    .faq-question h3 {
    font-size: 18px;
    font-weight: 500;
    color: #333;
    flex-grow: 1;
    }

    .faq-toggle {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #26a69a;
    font-weight: bold;
    font-size: 24px;
    margin-right: 10px;
    }

    .faq-toggle.minus {
    color: #26a69a;
    }

    .faq-answer {
    padding: 0 20px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease, padding 0.3s ease;
    }

    .faq-answer.active {
    padding: 0 20px 20px;
    max-height: 300px;
    }

    .faq-answer p {
    color: #555;
    line-height: 1.6;
    font-size: 16px;
    }

    @media (max-width: 768px) {
    .faq-wrapper .header h2 {
        font-size: 32px;
    }
    .faq-question h3 {
        font-size: 16px;
    }
    }
    .footer-section {
    background-color: #222;
    color: #fff;
    padding: 60px 20px;
    position: relative;
    overflow: hidden;
    }
    .footer-bg-shape {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 0;
    }
    .footer-bg-shape::before,
    .footer-bg-shape::after {
    content: '';
    position: absolute;
    background-color: rgba(50, 50, 50, 0.5);
    transform: rotate(45deg);
    }
    .footer-bg-shape::before {
    width: 120%;
    height: 300px;
    top: -150px;
    left: -10%;
    }
    .footer-bg-shape::after {
    width: 120%;
    height: 300px;
    bottom: -150px;
    left: -10%;
    }
    .footer-content {
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
    }
    .footer-headline {
    text-align: center;
    margin-bottom: 60px;
    }
    .footer-headline h2 {
    font-size: 36px;
    font-weight: 600;
    line-height: 1.3;
    max-width: 700px;
    margin: 0 auto;
    padding: 0 20px;
    }
    .demo-btn {
    display: block;
    width: 180px;
    padding: 12px 20px;
    background-color: transparent;
    color: #fff;
    border: 1px solid #fff;
    text-align: center;
    margin: 30px auto 60px;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
    }
    .demo-btn:hover {
    background-color: rgba(255, 255, 255, 0.1);
    }
    .footer-columns {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 0 20px;
    }
    .footer-column {
    flex: 1;
    min-width: 200px;
    margin-bottom: 30px;
    padding: 0 15px;
    }
    .footer-column h3 {
    font-size: 20px;
    margin-bottom: 20px;
    font-weight: 600;
    }
    .footer-column p,
    .footer-column a {
    color: #aaa;
    margin-bottom: 10px;
    line-height: 1.6;
    display: block;
    text-decoration: none;
    font-size: 14px;
    }
    .footer-column a:hover {
    color: #fff;
    }
    .contact-info {
    margin-bottom: 10px;
    }
    .footer-bottom {
    text-align: center;
    padding-top: 40px;
    font-size: 12px;
    color: #888;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    margin-top: 20px;
    }
    @media (max-width: 768px) {
    .footer-columns {
        flex-direction: column;
    }
    .footer-column {
        width: 100%;
        margin-bottom: 30px;
    }
    .footer-headline h2 {
        font-size: 28px;
    }
    }
  </style>
</head>
<body>
  <div class="shapes">
    <div class="shape yellow"></div>
    <div class="shape green"></div>
    <div class="shape blue"></div>
    <div class="shape pink"></div>
  </div>

  <!-- NAVBAR AREA -->
  <nav class="navbar">
    <div class="nav-logo">
      <img src="asset/img/logo1.png" alt="Logo">
    </div>

    <div class="nav-links">
      <a href="home.php">Beranda</a>
      <a href="about.php">Tentang Kami</a>
      <a href="#">Kategori Proyek</a>
      <a href="#">Kontak Kami</a>
    </div>

    <div class="nav-buttons">
      <a href="login.php" class="login">Masuk</a>
      <a href="register.php" class="register">Daftar</a>
    </div>
  </nav>

  <!-- CONTENT AREA -->

  <div class="hero">
    <div class="hero-content">
      <h1 class="hero-title">Kerja<br>Lepas</h1>
      <div class="swirl"></div>
    </div>

    <div class="hero-image">
      <img src="asset/img/smilling.png" alt="Orang Tersenyum">
    </div>
  </div>

  <div class="partners">
    <div class="partner">Planday</div>
    <div class="partner">umbraco</div>
    <div class="partner">Pearlfisher</div>
    <div class="partner">Brightpearl</div>
    <div class="partner">Planday</div>
  </div>

  <div class="services">
    <h2 class="services-title">Layanan <span>Terbaik</span></h2>
    <p class="services-desc">
      Surat pekerjaan menjadi ide perencanaan aktif memungkinkan untuk kedekatan hubungan masuk akal mudah beragai kerjaan dengan tidak sebagai.
    </p>
  </div>

  <div class="services-container">
    <div class="services-grid">
      <div class="service-card">
        <img src="/api/placeholder/400/320" alt="Web Development">
        <div class="service-content">
          <h3 class="service-title">Web Development</h3>
          <div class="stars">★★★★★</div>
        </div>
      </div>

      <div class="service-card">
        <img src="/api/placeholder/400/320" alt="Web Design">
        <div class="service-content">
          <h3 class="service-title">Web Design</h3>
          <div class="stars">★★★★★</div>
        </div>
      </div>

      <div class="service-card">
        <img src="/api/placeholder/400/320" alt="Database Management">
        <div class="service-content">
          <h3 class="service-title">Database Management</h3>
          <div class="stars">★★★★★</div>
        </div>
      </div>

      <div class="service-card">
        <img src="/api/placeholder/400/320" alt="SEO">
        <div class="service-content">
          <h3 class="service-title">SEO</h3>
          <div class="stars">★★★★★</div>
        </div>
      </div>
    </div>

    <button class="view-all-btn">Jelajahi Semua</button>

    <div class="border-path">
      <svg viewBox="0 0 1000 800">
        <path d="M200,0 C100,0 0,100 0,200 V600 C0,700 100,800 200,800 H800 C900,800 1000,700 1000,600 V200 C1000,100 900,0 800,0 H200 Z"></path>
      </svg>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      console.log('Dashboard Kerja Lepas siap digunakan!');

      const serviceCards = document.querySelectorAll('.service-card');
      serviceCards.forEach((card, index) => {
        setTimeout(() => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(50px)';
          setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          }, 100);
        }, index * 200);
      });

      serviceCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
          const title = this.querySelector('.service-title');
          title.style.transform = 'scale(1.1)';
          title.style.transition = 'transform 0.3s ease';
        });

        card.addEventListener('mouseleave', function () {
          const title = this.querySelector('.service-title');
          title.style.transform = 'scale(1)';
        });
      });

      const viewAllBtn = document.querySelector('.view-all-btn');
      viewAllBtn.addEventListener('click', function () {
        alert('Menampilkan semua layanan...');
      });
    });
    </script>
    
    <div class="shapes">
    <div class="shape yellow"></div>
    <div class="shape green"></div>
    <div class="shape blue"></div>
    <div class="shape pink"></div>
  </div>
</script>

  <!-- Fitur Kami Section -->
  <section class="features">
    <div class="features-header">
      <h2>Fitur <span>Kami</span></h2>
      <p class="features-desc">
        Surat pada menjadi alat cenderung aktif memungkinkan untuk 
        kedekatan hubungan masuk akal mudah beragai kejutan disaring tidak sebagai.
      </p>
    </div>

    <div class="features-grid">
      <div class="feature-card">
        <h3 class="feature-title">Beban Kerja</h3>
        <p class="feature-desc">
          Beban kerja pembuatan website freelance meliputi perencanaan fitur utama sesuai permintaan pengguna, pengembangan frontend dan backend, pembuatan database, pengujian sistem, deployment ke server, serta monitoring dan pemeliharaan website.
        </p>
        <a href="#" class="feature-link">Pelajari Lebih Lanjut</a>
      </div>

      <div class="feature-card">
        <h3 class="feature-title">Pelacakan Waktu</h3>
        <p class="feature-desc">
          Beban kerja pembuatan website freelance meliputi perencanaan fitur utama sesuai permintaan pengguna, pengembangan frontend dan backend, pembuatan database, pengujian sistem, deployment ke server, serta monitoring dan pemeliharaan website.
        </p>
        <a href="#" class="feature-link">Pelajari Lebih Lanjut</a>
      </div>

      <div class="feature-card">
        <h3 class="feature-title">Kolaborasi</h3>
        <p class="feature-desc">
          Beban kerja pembuatan website freelance meliputi perencanaan fitur utama sesuai permintaan pengguna, pengembangan frontend dan backend, pembuatan database, pengujian sistem, deployment ke server, serta monitoring dan pemeliharaan website.
        </p>
        <a href="#" class="feature-link">Pelajari Lebih Lanjut</a>
      </div>
    </div>

    <button class="features-btn">Jelajahi Semua</button>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      console.log('Dashboard Kerja Lepas siap digunakan!');

      // Animasi untuk service cards
      const serviceCards = document.querySelectorAll('.service-card');
      serviceCards.forEach((card, index) => {
        setTimeout(() => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(50px)';
          setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          }, 100);
        }, index * 200);
      });

      serviceCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
          const title = this.querySelector('.service-title');
          title.style.transform = 'scale(1.1)';
          title.style.transition = 'transform 0.3s ease';
        });

        card.addEventListener('mouseleave', function () {
          const title = this.querySelector('.service-title');
          title.style.transform = 'scale(1)';
        });
      });

      // Animasi untuk feature cards
      const featureCards = document.querySelectorAll('.feature-card');
      featureCards.forEach((card, index) => {
        setTimeout(() => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(30px)';
          setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          }, 100);
        }, index * 200);
      });

      // Button event handlers
      const viewAllBtn = document.querySelector('.view-all-btn');
      viewAllBtn.addEventListener('click', function () {
        alert('Menampilkan semua layanan...');
      });

      const featuresBtn = document.querySelector('.features-btn');
      featuresBtn.addEventListener('click', function () {
        alert('Menampilkan semua fitur...');
      });

      // Link effects
      const featureLinks = document.querySelectorAll('.feature-link');
      featureLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
          this.style.color = '#1a9d98';
        });
        
        link.addEventListener('mouseleave', function() {
          this.style.color = '#20b2aa';
        });
      });
    });
  </script>

  <!-- Testimonial Section -->
    <section class="testimonial-wrapper">
    <div class="header">
        <h2>Apa Yang <span>Klien</span> Katakan?</h2>
        <p>Surat pada menjadi dia cenderung aktif memungkinkan untuk. Kedekatan hubungan masuk akal mudah bergaul kejutan disaring tidak sebagai.</p>
    </div>

    <div class="testimonial-container">
        <div class="profile-image">
        <img src="asset/img/robert.png" alt="Professional person with glasses">
        </div>

        <div class="testimonial-content">
        <h3 class="testimonial-title">Pengembang Terbaik</h3>
        <p class="testimonial-text">Website freelance ini memudahkan saya menemukan freelancer berkualitas, dengan fitur pelacakan waktu,komunikasi langsung, dan pembayaran yang aman. Proyek jadi lebih efisien dan transparan.</p>

        <div class="rating">
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
        </div>

        <div class="client-info">
            <div class="client-name">Robert Johnson</div>
            <div class="client-position">Director of EdgeWorks</div>
        </div>
        </div>
    </div>

    <div class="controls">
        <button class="control-btn" id="prev">&#8249;</button>
        <button class="control-btn" id="next">&#8250;</button>
    </div>
    </section>

    <script>
    const testimonials = [
        {
        title: "Pengembang Terbaik",
        text: "Website freelance ini memudahkan saya menemukan freelancer berkualitas, dengan fitur pelacakan waktu,komunikasi langsung, dan pembayaran yang aman. Proyek jadi lebih efisien dan transparan.",
        rating: 5,
        name: "Robert Johnson",
        position: "Director of EdgeWorks"
        },
        {
        title: "Sangat Profesional",
        text: "Layanan yang ditawarkan sungguh luar biasa. Pengerjaan cepat dengan hasil yang memuaskan. Saya sudah merekomendasikan kepada rekan bisnis lainnya.",
        rating: 5,
        name: "Amanda Williams",
        position: "CEO of TechStart"
        },
        {
        title: "Partner Bisnis yang Handal",
        text: "Kerjasama dengan tim ini memberikan solusi yang tepat untuk kebutuhan website perusahaan kami. Komunikasi lancar dan selalu responsif.",
        rating: 5,
        name: "Michael Chen",
        position: "Marketing Manager at GrowthCorp"
        }
    ];

    let currentIndex = 0;

    function showTestimonial(index) {
        const testimonial = testimonials[index];
        document.querySelector('.testimonial-title').textContent = testimonial.title;
        document.querySelector('.testimonial-text').textContent = testimonial.text;
        document.querySelector('.rating').innerHTML = '★'.repeat(testimonial.rating).split('').map(s => `<span class="star">${s}</span>`).join('');
        document.querySelector('.client-name').textContent = testimonial.name;
        document.querySelector('.client-position').textContent = testimonial.position;
    }

    document.getElementById('next').addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % testimonials.length;
        showTestimonial(currentIndex);
    });

    document.getElementById('prev').addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
        showTestimonial(currentIndex);
    });

    setInterval(() => {
        currentIndex = (currentIndex + 1) % testimonials.length;
        showTestimonial(currentIndex);
    }, 8000);
    </script>

    <!-- FAQ Section -->
    <section class="faq-wrapper">
    <div class="header">
        <h2>Pertanyaan Umum</h2>
    </div>
    <div class="faq-container">
        <div class="faq-item">
        <div class="faq-question active">
            <div class="faq-toggle minus">−</div>
            <h3>Apa itu platform kerja lepas ini?</h3>
        </div>
        <div class="faq-answer active">
            <p>Platform kerja lepas kami adalah tempat di mana klien dapat mencari tenaga kerja lepas (freelancer) untuk menyelesaikan berbagai proyek seperti desain, pemrograman, penulisan, penerjemahan, dan lainnya.</p>
        </div>
        </div>
        <div class="faq-item">
        <div class="faq-question">
            <div class="faq-toggle">+</div>
            <h3>Apakah saya bisa bekerja untuk lebih dari satu proyek sekaligus?</h3>
        </div>
        <div class="faq-answer">
            <p>Ya, sebagai freelancer Anda dapat mengambil beberapa proyek sekaligus selama Anda yakin dapat menyelesaikannya dengan baik dan tepat waktu. Manajemen waktu yang baik sangat penting untuk menangani beberapa proyek secara bersamaan.</p>
        </div>
        </div>
        <div class="faq-item">
        <div class="faq-question">
            <div class="faq-toggle">+</div>
            <h3>Bagaimana cara menentukan harga jasa saya?</h3>
        </div>
        <div class="faq-answer">
            <p>Untuk menentukan harga jasa, Anda dapat mempertimbangkan faktor-faktor seperti tingkat keahlian, kompleksitas proyek, waktu yang dibutuhkan, dan harga pasar untuk layanan serupa. Kami juga menyediakan panduan harga untuk membantu Anda menentukan tarif yang kompetitif.</p>
        </div>
        </div>
        <div class="faq-item">
        <div class="faq-question">
            <div class="faq-toggle">+</div>
            <h3>Apakah ada sistem penilaian atau rating?</h3>
        </div>
        <div class="faq-answer">
            <p>Ya, platform kami memiliki sistem rating dan ulasan di mana klien dapat memberikan penilaian dan testimoni setelah proyek selesai. Rating ini akan membantu meningkatkan kredibilitas dan peluang Anda mendapatkan proyek di masa depan.</p>
        </div>
        </div>
    </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(question => {
        question.addEventListener('click', () => {
            const isActive = question.classList.contains('active');
            const toggle = question.querySelector('.faq-toggle');
            const answer = question.nextElementSibling;
            if (isActive) {
            question.classList.remove('active');
            toggle.textContent = '+';
            toggle.classList.remove('minus');
            answer.classList.remove('active');
            } else {
            question.classList.add('active');
            toggle.textContent = '−';
            toggle.classList.add('minus');
            answer.classList.add('active');
            }
        });
        });
    });
    </script>

    <!-- Footer Section -->
    <section class="footer-section">
    <div class="footer-bg-shape"></div>
    <div class="footer-content">
        <div class="footer-headline">
        <h2>Orang-orang yang siap mengambil kursus ini!</h2>
        <a href="#" class="demo-btn">Jadwal demo</a>
        </div>
        <div class="footer-columns">
        <div class="footer-column">
            <h3>Bayar saya</h3>
            <div class="contact-info">
            <p>Jl. Idr. Utara, Kayunan Kielen,</p>
            <p>Gondangmanis, Kec. Bae,</p>
            <p>Kabupaten Kudus, Jawa Tengah 59327</p>
            </div>
        </div>
        <div class="footer-column">
            <h3>Situs</h3>
            <a href="#">Berlatihan</a>
            <a href="#">Media Sosial</a>
            <a href="#">Penghitung</a>
            <a href="#">Kontak</a>
        </div>
        <div class="footer-column">
            <h3>Perusahaan</h3>
            <a href="#">Syarat dan ketentuan</a>
            <a href="#">Kebijakan dan privasi</a>
            <a href="#">Kontak</a>
        </div>
        <div class="footer-column">
            <h3>Hubungi kami</h3>
            <div class="contact-info">
            <p>Jl. Idr. Utara, Kayunan Kielen,</p>
            <p>Gondangmanis, Kec. Bae,</p>
            <p>Kabupaten Kudus, Jawa Tengah 59327</p>
            <p>08123232321</p>
            <p>info@paymu.net</p>
            </div>
        </div>
        </div>
        <div class="footer-bottom">
        <p>© 2025 Kelompok TaskTroop (PSI C)</p>
        <p>202251231_Maira Rully Berliana</p>
        <p>202251230_Viche Dewayanti</p>
        <p>202251153_Intan Nabila Hilma</p>
        </div>
    </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const demoBtn = document.querySelector('.demo-btn');
        if (demoBtn) {
        demoBtn.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s ease';
            this.style.transform = 'translateY(-3px)';
            this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.2)';
        });
        demoBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
        }
        const footerLinks = document.querySelectorAll('.footer-column a');
        footerLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.2s ease';
            this.style.paddingLeft = '5px';
        });
        link.addEventListener('mouseleave', function() {
            this.style.paddingLeft = '0';
        });
        });
    });
    </script>
</body>
</html>
