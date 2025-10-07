<?php
// File: Validator.php

function validateAge($age) {
    if (!is_numeric($age)) {
        throw new InvalidArgumentException("Umur harus berupa angka");
    }
    if ($age < 0) {
        throw new InvalidArgumentException("Umur tidak boleh negatif");
    }
    return true;
} // ← Tambahkan ini

function validateName($name) {
    if (!is_string($name)) {
        throw new InvalidArgumentException("Nama tidak boleh angka");
    }
    if (!empty($name)) {
        throw new InvalidArgumentException("nama tidak boleh kosong");
    }
    return true;
}