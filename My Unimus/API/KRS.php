<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require_once '../config/database.php';

$nim = isset($_GET['nim']) ? $_GET['nim'] : '';

$stmt = $mysqli->prepare("SELECT k.kode_matkul, m.nama_matkul, k.status
                          FROM krs k
                          JOIN matkul m ON k.kode_matkul = m.kode_matkul
                          WHERE k.nim = ?");
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();

$krs = [];
while($row = $result->fetch_assoc()){
    $krs[] = $row;
}

echo empty($krs) ? json_encode(["message" => "KRS tidak ditemukan"]) : json_encode($krs);

$stmt->close();
$mysqli->close();
?>
