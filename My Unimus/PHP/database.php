<?php
$host = "localhost";
$user = "root";
$password = ""; // default XAMPP
$dbname = "unimus_db";

$mysqli = new mysqli($host, $user, $password, $dbname);

if ($mysqli->connect_error) {
    die(json_encode(["error" => "Koneksi database gagal: " . $mysqli->connect_error]));
}
?>
