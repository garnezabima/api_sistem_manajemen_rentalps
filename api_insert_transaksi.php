<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
include "koneksi.php";

$id_pelanggan = $_POST['id_pelanggan'] ?? '';
$id_ps = $_POST['id_ps'] ?? '';
$durasi_main = $_POST['durasi_main'] ?? '';
$tanggal_sewa = $_POST['tanggal_sewa'] ?? '';

if(
    $id_pelanggan == '' ||
    $id_ps == '' ||
    $durasi_main == '' ||
    $tanggal_sewa == ''
){
    echo json_encode([
        "status" => false,
        "message" => "Semua field wajib diisi"
    ]);
    exit;
}

$getPS = mysqli_query(
    $conn,
    "SELECT harga_per_jam
     FROM playstation
     WHERE id_ps='$id_ps'"
);

$dataPS = mysqli_fetch_assoc($getPS);

$harga_per_jam = $dataPS['harga_per_jam'];

$total_bayar = $harga_per_jam * $durasi_main;

$query = "INSERT INTO transaksi
(
    id_pelanggan,
    id_ps,
    durasi_main,
    total_bayar,
    tanggal_sewa
)
VALUES(?,?,?,?,?)";

$stmt = mysqli_prepare($conn,$query);

mysqli_stmt_bind_param(
    $stmt,
    "iiiis",
    $id_pelanggan,
    $id_ps,
    $durasi_main,
    $total_bayar,
    $tanggal_sewa
);

if(mysqli_stmt_execute($stmt)){

    mysqli_query(
        $conn,
        "UPDATE playstation
         SET status='Dipakai'
         WHERE id_ps='$id_ps'"
    );

    echo json_encode([
        "status" => true,
        "message" => "Transaksi berhasil ditambahkan"
    ]);

}else{

    echo json_encode([
        "status" => false,
        "message" => "Transaksi gagal ditambahkan"
    ]);

}
?>