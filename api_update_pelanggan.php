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
$nama_pelanggan = $_POST['nama_pelanggan'] ?? '';
$no_hp = $_POST['no_hp'] ?? '';

if($id_pelanggan == '' || $nama_pelanggan == '' || $no_hp == ''){
    echo json_encode([
        "status"=>false,
        "message"=>"Semua field wajib diisi"
    ]);
    exit;
}

$query = "UPDATE pelanggan
          SET nama_pelanggan=?,
              no_hp=?
          WHERE id_pelanggan=?";

$stmt = mysqli_prepare($conn,$query);

mysqli_stmt_bind_param(
    $stmt,
    "ssi",
    $nama_pelanggan,
    $no_hp,
    $id_pelanggan
);

if(mysqli_stmt_execute($stmt)){
    echo json_encode([
        "status"=>true,
        "message"=>"Data pelanggan berhasil diupdate"
    ]);
}else{
    echo json_encode([
        "status"=>false,
        "message"=>"Data pelanggan gagal diupdate"
    ]);
}
?>