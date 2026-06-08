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

$id_ps = $_POST['id_ps'] ?? '';
$tipe_ps = $_POST['tipe_ps'] ?? '';
$harga_per_jam = $_POST['harga_per_jam'] ?? '';
$status = $_POST['status'] ?? '';

if($id_ps == '' || $tipe_ps == '' || $harga_per_jam == '' || $status == ''){
    echo json_encode([
        "status"=>false,
        "message"=>"Semua field wajib diisi"
    ]);
    exit;
}

$query = "UPDATE playstation
          SET tipe_ps=?,
              harga_per_jam=?,
              status=?
          WHERE id_ps=?";

$stmt = mysqli_prepare($conn,$query);

mysqli_stmt_bind_param(
    $stmt,
    "sisi",
    $tipe_ps,
    $harga_per_jam,
    $status,
    $id_ps
);

if(mysqli_stmt_execute($stmt)){
    echo json_encode([
        "status"=>true,
        "message"=>"Data PlayStation berhasil diupdate"
    ]);
}else{
    echo json_encode([
        "status"=>false,
        "message"=>"Data PlayStation gagal diupdate"
    ]);
}
?>