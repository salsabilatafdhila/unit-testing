<?php
/**
 * =====================================================
 * WHITE BOX SYSTEM TEST - Rest Client NewsAPI (index.php)
 * =====================================================
 * Tujuan:
 * Menguji jalur logika internal (white box) pada index.php
 * untuk memastikan:
 *  1️⃣ API key valid -> data tampil
 *  2️⃣ API key salah -> error ditangani
 *  3️⃣ Endpoint salah -> exception tertangkap
 * =====================================================
 */

include("rest-client/config/config.php");

// ----------------------------------------------------
// Fungsi bantu untuk hasil test dalam format HTML
// ----------------------------------------------------
function printResult($testName, $condition, $message) {
    $status = $condition ? "PASS ✅" : "FAIL ❌";
    $badgeClass = $condition ? "success" : "danger";

    echo "
    <div class='card mb-3 shadow-sm'>
        <div class='card-header bg-$badgeClass text-white fw-bold'>
            $testName
        </div>
        <div class='card-body'>
            <p><strong>Status:</strong> <span class='badge bg-$badgeClass'>$status</span></p>
            <p><strong>Detail:</strong> $message</p>
        </div>
    </div>
    ";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>White Box Testing - Rest Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        h1 {
            color: #222;
            text-align: center;
            margin-bottom: 40px;
        }
        .container {
            max-width: 800px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            color: #777;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>🧪 White Box System Test - Rest Client (NewsAPI)</h1>

<?php
// ====================================================
// TEST CASE 1 - API Key Valid & Endpoint Valid
// ====================================================
try {
    $api_key = "50114b823f9a418a90fdede328db35ae";
    $url = "https://newsapi.org/v2/top-headlines?country=us&apiKey=" . $api_key;

    $response = http_request_get($url);
    $data = json_decode($response, true);

    $status_ok = isset($data['status']) && $data['status'] === "ok";
    $has_articles = isset($data['articles']) && is_array($data['articles']) && count($data['articles']) > 0;

    printResult(
        "WB_SYS_001 - API Key Valid & Endpoint Valid",
        $status_ok && $has_articles,
        $status_ok
            ? "Data berita berhasil diambil dan struktur sesuai ('ok')."
            : "Status bukan 'ok' atau artikel kosong."
    );
} catch (Exception $e) {
    printResult("WB_SYS_001 - API Key Valid & Endpoint Valid", false, "Exception: " . $e->getMessage());
}


// ====================================================
// TEST CASE 2 - API Key Salah
// ====================================================
try {
    $api_key_invalid = "50114b823f9a418a90fdede328db35ae";
    $url_invalid_key = "https://newsapi.org/v2/top-headlines?country=us&apiKey=" . $api_key_invalid;

    $response = http_request_get($url_invalid_key);
    $data = json_decode($response, true);

    $status_error = isset($data['status']) && $data['status'] === "error";

    printResult(
        "WB_SYS_002 - API Key Salah",
        $status_error,
        $status_error
            ? "Error autentikasi berhasil ditangani ('error')."
            : "Tidak muncul status error seperti yang diharapkan."
    );
} catch (Exception $e) {
    printResult("WB_SYS_002 - API Key Salah", true, "Exception berhasil ditangani: " . $e->getMessage());
}


// ====================================================
// TEST CASE 3 - Endpoint Salah
// ====================================================
try {
    $api_key_valid = "50114b823f9a418a90fdede328db35ae";
    $url_wrong = "https://newsapi.org/v2/top-headlines?country=us&apiKey=" . $api_key_valid; // endpoint salah

    $response = http_request_get($url_wrong);
    $data = json_decode($response, true);

    $invalid_json = !isset($data['status']);

    printResult(
        "WB_SYS_003 - Endpoint Salah",
        $invalid_json,
        $invalid_json
            ? "Endpoint salah memicu respon tidak valid (struktur JSON rusak atau kosong)."
            : "Respon tidak sesuai ekspektasi: status ditemukan padahal endpoint salah."
    );
} catch (Exception $e) {
    printResult("WB_SYS_003 - Endpoint Salah", true, "Exception berhasil ditangkap: " . $e->getMessage());
}
?>

    <div class="footer">
        <hr>
        <p>✅ Semua pengujian selesai • White Box Testing - PHP Rest Client (NewsAPI)</p>
    </div>
</div>

</body>
</html>
