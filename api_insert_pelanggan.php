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

$nama_pelanggan = $_POST['nama_pelanggan'] ?? '';
$no_hp = $_POST['no_hp'] ?? '';

if($nama_pelanggan == '' || $no_hp == ''){
    echo json_encode([
        "status"=>false,
        "message"=>"Semua field wajib diisi"
    ]);
    exit;
}

$query = "INSERT INTO pelanggan(nama_pelanggan,no_hp)
          VALUES(?,?)";

$stmt = mysqli_prepare($conn,$query);

mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $nama_pelanggan,
    $no_hp
);

if(mysqli_stmt_execute($stmt)){
    echo json_encode([
        "status"=>true,
        "message"=>"Data pelanggan berhasil ditambahkan"
    ]);
}else{
    echo json_encode([
        "status"=>false,
        "message"=>"Data pelanggan gagal ditambahkan"
    ]);
}
?>