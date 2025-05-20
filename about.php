<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang TaskTroop - Platform Penghubung Pencari dan Penyedia Jasa</title>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #f39c12;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #2ecc71;
            --font-main: 'Poppins', sans-serif;
            --font-secondary: 'Roboto', sans-serif;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--font-main);
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
        }
        
        .logo span {
            color: var(--accent-color);
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 30px;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        nav ul li a:hover {
            color: var(--accent-color);
        }
        
        .active {
            border-bottom: 2px solid var(--accent-color);
        }
        
        .hero {
            padding: 100px 0;
            background: linear-gradient(rgba(44, 62, 80, 0.8), rgba(44, 62, 80, 0.8)), url('/api/placeholder/1200/500') center/cover no-repeat;
            color: white;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 20px;
            max-width: 800px;
            margin: 0 auto 30px;
        }
        
        .section {
            padding: 80px 0;
        }
        
        .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 2rem;
        background-color: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        position: sticky;
        top: 0;
        z-index: 1000;
        }

        .nav-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        font-size: 20px;
        color: #2c3e50;
        }

        .nav-logo img {
        width: 80px;
        height: 80px;
        }

        .nav-links {
        display: flex;
        gap: 2rem;
        }

        .nav-links a {
        text-decoration: none;
        color: #2c3e50;
        font-size: 1rem;
        transition: color 0.3s ease;
        }

        .nav-links a:hover,
        .nav-links a.active {
        color: #f39c12;
        font-weight: bold;
        }

        .nav-buttons {
        display: flex;
        gap: 1rem;
        }

        .login, .register {
        padding: 0.5rem 1rem;
        border: 1px solid #3498db;
        border-radius: 5px;
        background: transparent;
        color: #3498db;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        }

        .login:hover, .register:hover {
        background-color: #3498db;
        color: white;
        }
        
        .about-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .about-text {
            flex: 1;
            min-width: 300px;
            padding-right: 40px;
        }
        
        .about-image {
            flex: 1;
            min-width: 300px;
        }
        
        .about-image img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .features {
            background-color: var(--light-color);
        }
        
        .features-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .feature-card {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            flex: 0 0 calc(33.33% - 20px);
            min-width: 300px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .feature-card i {
            font-size: 50px;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        
        .feature-card h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: var(--secondary-color);
        }
        
        .how-it-works {
            background-color: white;
        }
        
        .steps {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            counter-reset: step-counter;
        }
        
        .step {
            flex: 0 0 calc(25% - 30px);
            min-width: 250px;
            text-align: center;
            padding: 20px;
            position: relative;
            margin-bottom: 30px;
        }
        
        .step::before {
            counter-increment: step-counter;
            content: counter(step-counter);
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 60px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            z-index: 1;
        }
        
        .step:not(:last-child)::after {
            content: "";
            position: absolute;
            top: -10px;
            right: -15%;
            width: 30%;
            height: 2px;
            background-color: var(--primary-color);
        }
        
        .step h3 {
            margin: 30px 0 15px;
            color: var(--secondary-color);
        }
        
        .testimonials {
            background-color: var(--light-color);
        }
        
        .testimonial-slider {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }
        
        .testimonial {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin: 20px;
            text-align: center;
        }
        
        .testimonial img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            border: 3px solid var(--primary-color);
        }
        
        .testimonial p {
            font-style: italic;
            margin-bottom: 20px;
        }
        
        .testimonial .name {
            font-weight: bold;
            color: var(--secondary-color);
        }
        
        .testimonial .role {
            color: #777;
            font-size: 14px;
        }
        
        .cta {
            background-color: var(--secondary-color);
            color: white;
            text-align: center;
        }
        
        .cta h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        
        .cta p {
            font-size: 18px;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--accent-color);
            color: white;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            background-color: #e67e22;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
        }
        
        .btn-secondary {
            background-color: transparent;
            border: 2px solid white;
        }
        
        .btn-secondary:hover {
            background-color: white;
            color: var(--secondary-color);
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="navbar">
            <div class="container-fluid nav-logo">
                <img src="asset/img/logo1.png" alt="Logo">
            </div>
        <div class="nav-links">
            <a href="home_page.php">Beranda</a>
            <a href="about.php" class="active">Tentang Kami</a>
            <a href="services.php">Kategori Proyek</a>
            <a href="contact.php">Kontak Kami</a>
        </div>
        <div class="nav-buttons">
            <a href="login.php" class="login">Masuk</a>
            <a href="register.php" class="register">Daftar</a>
        </div>
    </header>


    <section class="hero">
        <div class="container">
            <h1>Tentang TaskTroop</h1>
            <p>Platform penghubung terpercaya antara pencari dan penyedia jasa profesional</p>
        </div>
    </section>

    <section class="section">
        <div class="container about-content">
            <div class="about-text">
                <h2>Siapa Kami?</h2>
                <p>TaskTroop adalah platform inovatif yang menghubungkan para pencari jasa dengan penyedia jasa profesional. Didirikan dengan visi untuk menciptakan ekosistem di mana keahlian dan kebutuhan dapat bertemu dengan mudah dan efisien.</p>
                <p>Kami percaya bahwa setiap orang memiliki keahlian yang dapat membantu orang lain, dan setiap proyek membutuhkan profesional yang tepat untuk mewujudkannya. TaskTroop hadir untuk menjembatani keduanya.</p>
                <p>Dengan antarmuka yang intuitif dan sistem yang dirancang untuk memaksimalkan kecocokan antara pencari dan penyedia jasa, TaskTroop bertekad untuk menjadi solusi terdepan dalam pasar layanan freelance di Indonesia.</p>
            </div>
            <div class="about-image">
                <img src="/api/placeholder/600/400" alt="Tim TaskTroop">
            </div>
        </div>
    </section>

    <section class="section how-it-works">
        <div class="container">
            <div class="section-header">
                <h2>Bagaimana TaskTroop Bekerja?</h2>
                <p>Proses sederhana untuk mendapatkan dan menyediakan jasa melalui platform kami</p>
            </div> <br><br><br><br>
            <div class="steps">
                <div class="step">
                    <h3>Daftar</h3>
                    <p>Buat akun sebagai pencari atau penyedia jasa dengan mudah dan cepat.</p>
                </div>
                <div class="step">
                    <h3>Posting Lowongan</h3>
                    <p>Pencari jasa memposting lowongan dengan detail kebutuhan jasa yang diinginkan.</p>
                </div>
                <div class="step">
                    <h3>Terima Lamaran</h3>
                    <p>Penyedia jasa mengajukan lamaran untuk lowongan yang sesuai dengan keahlian mereka.</p>
                </div>
                <div class="step">
                    <h3>Pilih & Negosiasi</h3>
                    <p>Pencari jasa memilih dan bernegosiasi dengan penyedia jasa yang cocok.</p>
                </div>
                <div class="step">
                    <h3>Kerjasama Dimulai</h3>
                    <p>Setelah kesepakatan tercapai, kerjasama dimulai dengan jaminan TaskTroop.</p>
                </div>
                <div class="step">
                    <h3>Selesaikan Proyek</h3>
                    <p>Penyedia jasa menyelesaikan proyek sesuai dengan kesepakatan.</p>
                </div>
                <div class="step">
                    <h3>Verifikasi & Pembayaran</h3>
                    <p>Pencari jasa memverifikasi hasil kerja dan pembayaran diproses.</p>
                </div>
                <div class="step">
                    <h3>Beri Rating & Ulasan</h3>
                    <p>Kedua belah pihak dapat memberikan rating dan ulasan untuk meningkatkan reputasi.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section cta">
        <div class="container">
            <h2>Bergabunglah dengan TaskTroop Sekarang</h2>
            <p>Temukan penyedia jasa profesional atau tawarkan keahlian Anda kepada mereka yang membutuhkan. Bersama-sama, kita wujudkan ekosistem jasa yang efisien dan menguntungkan bagi semua pihak.</p>
            <div>
                <a href="register.php" class="btn">Daftar Sekarang</a>
                <a href="contact.php" class="btn btn-secondary">Hubungi Kami</a>
            </div>
        </div>
    </section>

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

    <script>
        // Animasi smooth scroll untuk link di navbar
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Animasi untuk tampilan testimonial slider
        const testimonials = document.querySelectorAll('.testimonial');
        let currentTestimonial = 0;
        
        function showTestimonial(index) {
            testimonials.forEach(testimonial => {
                testimonial.classList.remove('active');
            });
            
            testimonials[index].classList.add('active');
        }
        
        function nextTestimonial() {
            currentTestimonial = (currentTestimonial + 1) % testimonials.length;
            showTestimonial(currentTestimonial);
        }
        
        // Auto rotate testimonials setiap 5 detik
        setInterval(nextTestimonial, 5000);
        
        // Animasi untuk scroll
        window.addEventListener('scroll', function() {
            let scrollPosition = window.scrollY;
            
            // Membuat efek parallax pada background hero section
            document.querySelector('.hero').style.backgroundPositionY = scrollPosition * 0.5 + 'px';
            
            // Animasi untuk menampilkan elemen saat di-scroll
            document.querySelectorAll('.feature-card, .step, .testimonial').forEach(item => {
                let itemPosition = item.getBoundingClientRect().top;
                
                if (itemPosition < window.innerHeight - 100) {
                    item.classList.add('show');
                }
            });
        });
        
        // Tambahkan class CSS untuk animasi
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.feature-card, .step, .testimonial').forEach(item => {
                item.classList.add('fade-in');
            });
        });
    </script>
</body>
</html>