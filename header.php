<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TaskTroop - Kerja Lepas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="/index.php">
      <img src="/assets/img/logo2.png" alt="TaskTroop" height="50">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="/frontend/home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/frontend/about.php">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Jelajah</a></li>
        <li class="nav-item"><a class="nav-link disabled" aria-disabled="true">Hubungi</a></li>
      </ul>
    </div>
    <form class="d-flex me-3" role="search">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Profil</a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="/frontend/profile.php">Lihat Profil</a></li>
          <li><a class="dropdown-item" href="/backend/logout.php">Keluar</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>