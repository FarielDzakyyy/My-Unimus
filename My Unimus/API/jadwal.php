<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require_once '../config/database.php';

$nim = isset($_GET['nim']) ? $_GET['nim'] : '';

$stmt = $mysqli->prepare("SELECT m.kode_matkul, m.nama_matkul, j.hari, j.jam, j.ruangan 
                          FROM jadwal j 
                          JOIN matkul m ON j.kode_matkul = m.kode_matkul 
                          WHERE j.nim = ?");
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();

$jadwal = [];
while($row = $result->fetch_assoc()){
    $jadwal[] = $row;
}

echo empty($jadwal) ? json_encode(["message" => "Jadwal tidak ditemukan"]) : json_encode($jadwal);

$stmt->close();
$mysqli->close();
?>
