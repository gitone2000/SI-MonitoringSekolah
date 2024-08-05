<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Beranda</title>
    <!-- Memuat Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Menambahkan CSS khusus untuk latar belakang gambar -->
    <title>Footer dengan Logo Besar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Footer dengan Sudut Bundar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        @import 'animate.css';
        body {
            background-image: url('/vendor/laravel-admin/AdminLTE/dist/img/2020-11-06.jpg');
            background-size: cover;
            background-position: center;
            /* background-repeat: no-repeat; */
            background-attachment: fixed;
            color: rgb(255, 255, 255); /* Warna teks yang kontras dengan gambar latar belakang */
        }
        .overlay {
            position: absolute;
            /* top: 0;
            left: 0; */
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Ubah nilai alpha untuk mengatur kegelapan lapisan */
        }
        .card{
            color: black;
        }
        .transparent-background {
            background-color: rgba(255, 255, 255, 0.637); /* Adjust the last value (alpha) for opacity */
        }
        footer {
            position: fixed;
            bottom: 0;
            right: 0;
            width: 15%;
            z-index: 1;
            padding: 10px;
            border-radius: 15px 0 0 0;
        }
        .footer-icons a {
            font-size: 20px; /* Ukuran ikon */
            color: white;
        }

    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary animate__animated animate__fadeIn py-2">
  <div class="container">
    <a class="navbar-brand" href="#"><b>APLIKASI MONITORING</b></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://smknbandar.sch.id/" target="_blank">Tentang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Konten Utama -->
<div class="overlay">

<div class="container mt-4">
  <div class="row">

    <div class="col-1 mx-3 mb-3 animate__animated animate__fadeInLeft">
        <img src="/vendor/laravel-admin/AdminLTE/dist/img/Logo-SMKNBANDAR.png" alt="Logo" style="max-width: 100px; height: auto;">
      </div>

    <div class="col-lg-7 mb-4 animate__animated animate__backInUp">
      <h2><b>Aplikasi Monitoring KBM</b></h2>
      <h2><b>SMK Negeri Bandar</b></h2>
      <p>Harmonis Efektif dan Efisien Bangga Amanah Tangguh</p>
      <a class="btn btn-success" href="/admin">Mulai Sekarang</a>
    </div>

    <div class="col-lg-3 mt-2 animate__animated animate__backInUp">
      <div class="card transparent-background">
        <div class="card-body">
          <h5 class="card-title">Tentang Kami</h5>
          <p class="card-text">SMK Negeri Bandar Pacitan adalah Sekolah Menengah Kejuruan Negeri yang terdapat di Kabupaten Pacitan, beralamat di Jl. Raya Bandar-Pacitan RT 2 RW 4 Kab. Pacitan.</p>
          <a href="https://id.wikipedia.org/wiki/SMK_Negeri_1_Bandar_Pacitan" class="btn btn-success" target="_blank">Selengkapnya</a>
        </div>
      </div>
    </div>

    </div>
  </div>
</div>

<!-- Memuat Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<footer class="bg-primary text-white text-center py-2">
    <div class="container">
      <div class="row">
        <div class="col footer-icons">
          <!-- Logo Instagram -->
          <a href="https://www.instagram.com/smknbandarpacitan/" target="_blank" class="text-white me-4">
            <i class="fab fa-instagram"></i>
          </a>
          <!-- Logo Facebook -->
          <a href="https://www.facebook.com/profile.php?id=100013477784795" target="_blank" class="text-white me-4">
            <i class="fab fa-facebook"></i>
          </a>
          <!-- Logo WhatsApp -->
          <a href="https://wa.me/" target="_blank" class="text-white">
            <i class="fab fa-whatsapp"></i>
          </a>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>
