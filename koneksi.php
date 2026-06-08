<?php

$host = "sql107.infinityfree.com";
$user = "if0_42094056";
$password = "utpIpJucXQFb";
$database = "if0_42094056_rental_ps";

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");

?>