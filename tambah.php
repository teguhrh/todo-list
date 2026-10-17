<?php
session_start();
require_once "koneksi.php";

function kembali() {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    kembali();
}

if (!isset($_POST["csrf_token"]) || !hash_equals($_SESSION["csrf_token"] ?? "", $_POST["csrf_token"])) {
    $_SESSION["pesan"] = "Permintaan tidak valid. Silakan coba lagi.";
    kembali();
}

$judul = trim($_POST["judul"] ?? "");

if ($judul === "") {
    $_SESSION["pesan"] = "Nama tugas tidak boleh kosong.";
    kembali();
}

if (mb_strlen($judul) > 255) {
    $_SESSION["pesan"] = "Nama tugas maksimal 255 karakter.";
    kembali();
}

$stmt = $conn->prepare("INSERT INTO tugas (judul) VALUES (?)");
$stmt->bind_param("s", $judul);
$stmt->execute();

$_SESSION["pesan"] = "Tugas berhasil ditambahkan.";
kembali();
?>
