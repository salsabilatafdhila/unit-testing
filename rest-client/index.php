<?php
//load config.php
include("config/config.php");
 
//untuk api_key newsapi.org
$api_key="50114b823f9a418a90fdede328db35ae";
 
//url api untuk ambil berita headline di Indonesia
$url="https://newsapi.org/v2/top-headlines?country=us&apiKey=".$api_key;

//menyimpan hasil dalam variabel
$data=http_request_get($url);
 
//konversi data json ke array
$hasil=json_decode($data,true);
 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rest Client dengan cURL</title>
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Tambahan CSS untuk ubah warna dan font -->
    <style>
      body {
        background-color: #121212; /* latar belakang gelap */
        color: #f5f5f5; /* teks terang */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }

      .navbar {
        background-color: #1e1e1e !important; /* navbar gelap */
      }

      .navbar-brand {
        color: #ffcc00 !important; /* nama web warna kuning terang */
        font-weight: 700;
        font-size: 1.4rem;
      }

      .nav-link {
        color: #f0f0f0 !important;
      }

      .nav-link:hover {
        color: #ffcc00 !important;
      }

      .card {
        background-color: #1c1c1c;
        border: 1px solid #333;
      }

      .card-text {
        color: #ddd;
      }

      /* Tombol khusus berita */
      .btn-news {
        background-color: #ffcc00; /* kuning keemasan */
        color: #000;
        font-weight: 600;
        border: none;
      }

      .btn-news:hover {
        background-color: #e6b800;
        color: #000;
      }
    </style>
</head>
<body>
 
<!-- navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-info">
  <a class="navbar-brand ms-4" href="#">RestClient</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">News</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
    </ul>
  </div>
</nav>
<!-- navbar -->
<div class="container" style="margin-top: 75px;">
    <div class="row">
 
<!-- looping hasil data di array article -->
<?php foreach ($hasil['articles'] as $row) { ?>
 
        <div class="col-md" style="margin-top: 10px; margin-bottom: 10px;">
            <div class="card" style="width: 18rem;">
              <img src="<?php echo $row['urlToImage']; ?>" class="card-img-top" height="180px">
              <div class="card-body">
                <p class="card-text"><i>Oleh <?php echo $row['author']; ?></i> ~ <?php echo $row['title']; ?></p>
                <p class="text-right">
                <a href="<?php echo $row['url']; ?>" 
                  target="_blank" 
                  rel="noopener noreferrer" 
                  class="btn btn-news btn-sm">
                  Selengkapnya
                </a>
              </p>
              </div>
            </div>
        </div>
 
<?php } ?>
 
    </div>
</div>
 
<!-- JS Bootstrap -->
<script src="js/jquery-3.4.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>