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

if($id_pelanggan == ''){
    echo json_encode([
        "status"=>false,
        "message"=>"ID pelanggan wajib diisi"
    ]);
    exit;
}

$query = "DELETE FROM pelanggan
          WHERE id_pelanggan=?";

$stmt = mysqli_prepare($conn,$query);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id_pelanggan
);

if(mysqli_stmt_execute($stmt)){
    echo json_encode([
        "status"=>true,
        "message"=>"Data pelanggan berhasil dihapus"
    ]);
}else{
    echo json_encode([
        "status"=>false,
        "message"=>"Data pelanggan gagal dihapus"
    ]);
}
?>