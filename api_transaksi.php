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

$data = [];

$query = mysqli_query(
    $conn,
    "SELECT
        t.id_transaksi,
        p.nama_pelanggan,
        ps.tipe_ps,
        ps.harga_per_jam,
        t.durasi_main,
        t.total_bayar,
        t.tanggal_sewa
     FROM transaksi t
     JOIN pelanggan p
        ON t.id_pelanggan = p.id_pelanggan
     JOIN playstation ps
        ON t.id_ps = ps.id_ps
     ORDER BY t.id_transaksi DESC"
);

while($row = mysqli_fetch_assoc($query)){
    $data[] = $row;
}

echo json_encode($data);
?>