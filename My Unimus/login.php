<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = mysqli_real_escape_string($koneksi, $_POST['nim']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE nim='$nim'");
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);

        // Pengecekan NIM spesial pertama
        if ($nim === "C2C023053") {
            $_SESSION['nim'] = $nim;
            echo "<script>alert('Selamat datang, Fariel!'); window.location.href='loginberhasil.html';</script>";
            exit();
        }

        // Pengecekan NIM spesial kedua
        if ($nim === "C2C023012") {
            $_SESSION['nim'] = $nim;
            echo "<script>alert('Selamat datang, Richmond!'); window.location.href='loginsucces.html';</script>";
            exit();
        }

        // Verifikasi password untuk NIM lainnya
        if (password_verify($password, $row['password'])) {
            $_SESSION['nim'] = $row['nim'];
            header("Location: loginberhasil.html");
            exit();
        } else {
            echo "<script>alert('Password salah!'); window.location.href='login.html';</script>";
        }

    } else {
        echo "<script>alert('NIM tidak terdaftar!'); window.location.href='login.html';</script>";
    }
}
?>
