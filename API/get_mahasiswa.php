<?php
ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Ganti dengan IP komputer kamu (bukan localhost)
$server_ip = "192.168.100.107";

// Koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "unimus_db");
if (!$koneksi) {
    echo json_encode(["status" => "error", "message" => "Koneksi database gagal"]);
    exit();
}

mysqli_set_charset($koneksi, "utf8");

// Ambil parameter nim
$nim = isset($_GET['nim']) ? mysqli_real_escape_string($koneksi, $_GET['nim']) : '';

if (!empty($nim)) {
    $query = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nim='$nim'");
    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        echo json_encode([
            "status" => "success",
            "data" => [
                "nim" => $data['nim'],
                "nama" => $data['nama'],
                "fakultas" => $data['fakultas'],
                "prodi" => $data['prodi'],
                "ip" => $data['ip'],
                "ipk" => $data['ipk'],
                "sks" => $data['sks']
            ]
        ]);
    } else {
        echo json_encode(["status" => "not_found", "message" => "Mahasiswa tidak ditemukan"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Parameter NIM tidak diberikan"]);
}

mysqli_close($koneksi);
?>
