<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($koneksi, $_POST['fullName'] ?? '');
    $email = mysqli_real_escape_string($koneksi, $_POST['email'] ?? '');
    $nim = mysqli_real_escape_string($koneksi, $_POST['nim'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validasi input
    if (!$full_name || !$email || !$nim || !$password) {
        echo json_encode([
            "status" => "error",
            "message" => "Semua field wajib diisi!"
        ]);
        exit;
    }

    if (strlen($nim) < 8) {
        echo json_encode([
            "status" => "error",
            "message" => "NIM harus minimal 8 karakter."
        ]);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode([
            "status" => "error",
            "message" => "Password harus minimal 6 karakter."
        ]);
        exit;
    }

    // Cek apakah email atau NIM sudah ada
    $check = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email' OR nim='$nim'");
    if (mysqli_num_rows($check) > 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Email atau NIM sudah terdaftar!"
        ]);
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert ke database
    $query = "INSERT INTO users (full_name, email, nim, password) VALUES ('$full_name', '$email', '$nim', '$hashed_password')";
    if (mysqli_query($koneksi, $query)) {
        echo json_encode([
            "status" => "success",
            "message" => "Registrasi berhasil! Silakan login."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Terjadi kesalahan saat menyimpan data."
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method"
    ]);
}
