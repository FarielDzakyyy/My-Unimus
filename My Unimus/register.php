<?php
header('Content-Type: application/json'); // Pastikan JSON

require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data POST
    $full_name = mysqli_real_escape_string($koneksi, $_POST['fullName'] ?? '');
    $email = mysqli_real_escape_string($koneksi, $_POST['email'] ?? '');
    $nim = mysqli_real_escape_string($koneksi, $_POST['nim'] ?? '');
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

    // Validasi sederhana
    if (!$full_name || !$email || !$nim || !$password) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }

    // Cek apakah email atau NIM sudah terdaftar
    $check = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email' OR nim='$nim'");
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email atau NIM sudah terdaftar!']);
        exit;
    }

    // Insert data
    $query = "INSERT INTO users (full_name, email, nim, password) VALUES ('$full_name', '$email', '$nim', '$password')";
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Registrasi berhasil! Silakan login.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan data']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
