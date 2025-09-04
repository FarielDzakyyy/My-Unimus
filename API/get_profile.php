<?php
error_reporting(0); // matikan warning/notices supaya JSON valid
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "unimus_db");
if (!$koneksi) {
    echo json_encode([
        "status" => "error",
        "message" => "Koneksi database gagal"
    ]);
    exit();
}

mysqli_set_charset($koneksi, "utf8");

// Ambil parameter nim dari URL
$nim = isset($_GET['nim']) ? mysqli_real_escape_string($koneksi, $_GET['nim']) : '';

if (!$nim) {
    echo json_encode([
        "status" => "error",
        "message" => "Parameter NIM tidak diberikan"
    ]);
    exit();
}

// Query ambil data mahasiswa dari tabel profile
$query = mysqli_query($koneksi, "SELECT * FROM profile WHERE nim='$nim'");

if ($query && mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);

    // URL foto
    $foto_url = !empty($data['foto']) 
        ? "http://192.168.100.107/uploads/" . $data['foto'] 
        : "http://192.168.100.107/fariel.jpg"; // default fallback

    echo json_encode([
        "status" => "success",
        "data" => [
            "nim" => $data['nim'],
            "nama" => $data['nama'],
            "email" => $data['email'],
            "phone" => $data['phone'],
            "dosen_wali" => $data['dosen_wali'],
            "foto" => $foto_url
        ]
    ]);
} else {
    echo json_encode([
        "status" => "not_found",
        "message" => "Profile dengan NIM $nim tidak ditemukan"
    ]);
}

mysqli_close($koneksi);
?>
