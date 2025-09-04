<?php
session_start();
require 'koneksi.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = mysqli_real_escape_string($koneksi, $_POST['nim'] ?? '');
    $password = $_POST['password'] ?? '';

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE nim='$nim'");
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);

        // NIM spesial pertama
        if ($nim === "C2C023053") {
            $_SESSION['nim'] = $nim;
            echo json_encode([
                "status" => "success",
                "message" => "Selamat datang, Fariel!",
                "redirect" => "loginberhasil.html"
            ]);
            exit;
        }

        // NIM spesial kedua
        if ($nim === "C2C023012") {
            $_SESSION['nim'] = $nim;
            echo json_encode([
                "status" => "success",
                "message" => "Selamat datang, Richmond!",
                "redirect" => "loginsucces.html"
            ]);
            exit;
        }

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            $_SESSION['nim'] = $row['nim'];
            echo json_encode([
                "status" => "success",
                "message" => "Login berhasil",
                "redirect" => "loginberhasil.html"
            ]);
            exit;
        } else {
            echo json_encode(["status" => "error", "message" => "Password salah!"]);
            exit;
        }

    } else {
        echo json_encode(["status" => "error", "message" => "NIM tidak terdaftar!"]);
        exit;
    }
}
?>
