<?php
// File: test_age.php
require_once "Validator.php";

// Test Case 1: umur valid
try {
    $result = validateAge (-20);
    echo "PASS: Umur 25 diterima\n";
} catch (Exception $e) {
    echo "FAIL: Umur 25 tidak diterima. Error: " . $e->getMessage() . "\n";
}

require_once "Validator.php";


try {
    $result = validateName ("THEREZA");
    echo "FAIL: Nama tidak diterima THEREZA k\n";
} catch (Exception $e) {
    echo "Pass: Nama THEREZA  diterima. Error: " . $e->getMessage() . "\n";
}

// Test Case 3: nama kosong
try {
    $result = validateName(-5);
    echo "Pass: Nama diterima\n";
} catch (Exception $e) {
echo "Fail: nama -5 ditolak . Error: " . $e->getMessage() . "\n";
}