<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "todo_db";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $username, $password, $database);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    exit("Koneksi database gagal. Pastikan MySQL aktif dan database todo_db sudah dibuat.");
}
?>
