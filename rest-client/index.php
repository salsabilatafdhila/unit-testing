<?php
// load config.php
include("config/config.php");

// API Key dari newsapi.org
$api_key = "50114b823f9a418a90fdede328db35ae";

// Inisialisasi variabel untuk menampung hasil dan pesan error
$hasil = ['articles' => []];
$error_message = "";

// Logika pencarian
if (isset($_GET['q'])) {
    $keyword = trim($_GET['q']);

    if ($keyword === "") {
        // Jika pencarian kosong
        $error_message = "Masukkan kata kunci!";
    } else {
        // Jika ada kata kunci, ambil berita sesuai keyword
        $keyword = urlencode($keyword);
        $url = "https://newsapi.org/v2/everything?q={$keyword}&apiKey={$api_key}";
        $data = http_request_get($url);
        $hasil = json_decode($data, true);
    }
} else {
    // Tampilan awal: menampilkan headline default
    $url = "https://newsapi.org/v2/top-headlines?country=us&apiKey={$api_key}";
    $data = http_request_get($url);
    $hasil = json_decode($data, true);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rest Client dengan cURL</title>

    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Tambahan CSS: tema gelap dan font -->
    <style>
        body {
            background-color: #121212;
            color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: #1e1e1e !important;
        }

        .navbar-brand {
            color: #ffcc00 !important;
            font-weight: 700;
            font-size: 1.4rem;
            margin-left: 20px;
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
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.03);
        }

        .card-text {
            color: #ddd;
        }

        .btn-news {
            background-color: #ffcc00;
            color: #000;
            font-weight: 600;
            border: none;
        }

        .btn-news:hover {
            background-color: #e6b800;
            color: #000;
        }

        .error-message {
            color: #ff5555;
            margin-top: 10px;
            font-weight: 500;
        }

        h3.section-title {
            margin-top: 30px;
            color: #ffcc00;
            font-weight: 600;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="#">RestClient</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="#">News</a></li>
      <li class="nav-item"><a class="nav-link" href="#">About</a></li>
    </ul>
  </div>
</nav>

<!-- Form Pencarian -->
<div class="container" style="margin-top: 90px;">
  <form method="GET" action="">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Cari berita..."
             value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
      <div class="input-group-append">
        <button class="btn btn-news" type="submit">Cari</button>
      </div>
    </div>
  </form>

  <!-- Pesan Error -->
  <?php if ($error_message !== ""): ?>
      <div class="error-message"><?php echo $error_message; ?></div>
  <?php else: ?>
      <?php if (isset($_GET['q']) && !empty($_GET['q'])): ?>
          <h3 class="section-title">Hasil pencarian untuk: <span style="color:#f5f5f5;"><?php echo htmlspecialchars($_GET['q']); ?></span></h3>
      <?php else: ?>
          <h3 class="section-title">Berita Terbaru Hari Ini</h3>
      <?php endif; ?>
  <?php endif; ?>
</div>

<!-- Daftar Berita -->
<div class="container" style="margin-top: 20px;">
  <div class="row">
    <?php
    // tampilkan berita hanya jika tidak ada error
    if ($error_message === "" && !empty($hasil['articles'])) {
        foreach ($hasil['articles'] as $row) {
            if (!empty($row['urlToImage'])) {
                ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="<?php echo $row['urlToImage']; ?>" class="card-img-top" height="180px">
                        <div class="card-body">
                            <p class="card-text">
                                <strong><?php echo htmlspecialchars($row['title']); ?></strong><br>
                                <i>Oleh: <?php echo htmlspecialchars($row['author'] ?? 'Tidak diketahui'); ?></i>
                            </p>
                            <a href="<?php echo $row['url']; ?>"
                               target="_blank" rel="noopener noreferrer"
                               class="btn btn-news btn-sm">
                               Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    } elseif ($error_message === "" && isset($_GET['q'])) {
        // Jika pencarian tidak menghasilkan berita
        echo "<p class='mt-3'>Tidak ada berita ditemukan untuk kata kunci tersebut.</p>";
    }
    ?>
  </div>
</div>

<!-- JS Bootstrap -->
<script src="js/jquery-3.4.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
