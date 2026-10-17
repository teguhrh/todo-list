<?php
session_start();
require_once "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

if (!isset($_POST["csrf_token"]) || !hash_equals($_SESSION["csrf_token"] ?? "", $_POST["csrf_token"])) {
    $_SESSION["pesan"] = "Permintaan tidak valid. Silakan coba lagi.";
    header("Location: index.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    $_SESSION["pesan"] = "ID tugas tidak valid.";
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("UPDATE tugas SET selesai = IF(selesai = 1, 0, 1) WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$_SESSION["pesan"] = "Status tugas berhasil diperbarui.";
header("Location: index.php");
exit;
?>
