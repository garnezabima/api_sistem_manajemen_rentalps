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

if($id_ps == ''){
    echo json_encode([
        "status"=>false,
        "message"=>"ID PlayStation wajib diisi"
    ]);
    exit;
}

$query = "DELETE FROM playstation
          WHERE id_ps=?";

$stmt = mysqli_prepare($conn,$query);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id_ps
);

if(mysqli_stmt_execute($stmt)){
    echo json_encode([
        "status"=>true,
        "message"=>"Data PlayStation berhasil dihapus"
    ]);
}else{
    echo json_encode([
        "status"=>false,
        "message"=>"Data PlayStation gagal dihapus"
    ]);
}
?>