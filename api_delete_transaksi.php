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

$id_transaksi = $_POST['id_transaksi'] ?? '';

if($id_transaksi == ''){
    echo json_encode([
        "status" => false,
        "message" => "ID transaksi wajib diisi"
    ]);
    exit;
}

$query = "DELETE FROM transaksi
          WHERE id_transaksi=?";

$stmt = mysqli_prepare($conn,$query);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id_transaksi
);

if(mysqli_stmt_execute($stmt)){

    echo json_encode([
        "status" => true,
        "message" => "Transaksi berhasil dihapus"
    ]);

}else{

    echo json_encode([
        "status" => false,
        "message" => "Transaksi gagal dihapus"
    ]);

}
?>