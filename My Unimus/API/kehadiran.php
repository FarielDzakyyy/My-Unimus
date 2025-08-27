<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require_once '../config/database.php';

$nim = isset($_GET['nim']) ? $_GET['nim'] : '';

$stmt = $mysqli->prepare("SELECT k.kode_matkul, m.nama_matkul, k.tanggal, k.status
                          FROM kehadiran k
                          JOIN matkul m ON k.kode_matkul = m.kode_matkul
                          WHERE k.nim = ?");
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();

$kehadiran = [];
while($row = $result->fetch_assoc()){
    $kehadiran[] = $row;
}

echo empty($kehadiran) ? json_encode(["message" => "Data kehadiran tidak ditemukan"]) : json_encode($kehadiran);

$stmt->close();
$mysqli->close();
?>
