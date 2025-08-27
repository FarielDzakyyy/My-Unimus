<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require_once '../config/database.php';

$nim = isset($_GET['nim']) ? $_GET['nim'] : '';

$stmt = $mysqli->prepare("SELECT n.kode_matkul, m.nama_matkul, n.nilai_angka, n.nilai_huruf
                          FROM nilai n
                          JOIN matkul m ON n.kode_matkul = m.kode_matkul
                          WHERE n.nim = ?");
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();

$nilai = [];
while($row = $result->fetch_assoc()){
    $nilai[] = $row;
}

echo empty($nilai) ? json_encode(["message" => "Nilai tidak ditemukan"]) : json_encode($nilai);

$stmt->close();
$mysqli->close();
?>
