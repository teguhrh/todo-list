<?php
session_start();
require_once "koneksi.php";

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

$result = $conn->query("SELECT id, judul, selesai, dibuat_pada FROM tugas ORDER BY selesai ASC, dibuat_pada DESC");
$tugas = $result->fetch_all(MYSQLI_ASSOC);

$total = count($tugas);
$selesai = count(array_filter($tugas, fn($item) => (int)$item["selesai"] === 1));
$aktif = $total - $selesai;

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container">
        <header class="page-header">
            <div class="logo">✓</div>
            <div>
                <h1>To-Do List</h1>
                <p>Catat tugasmu dan selesaikan satu per satu.</p>
            </div>
        </header>

        <?php if (isset($_SESSION["pesan"])): ?>
            <div class="notice"><?= e($_SESSION["pesan"]) ?></div>
            <?php unset($_SESSION["pesan"]); ?>
        <?php endif; ?>

        <section class="summary" aria-label="Ringkasan tugas">
            <div class="summary-card">
                <span class="summary-number"><?= $total ?></span>
                <span class="summary-label">Total tugas</span>
            </div>
            <div class="summary-card">
                <span class="summary-number"><?= $aktif ?></span>
                <span class="summary-label">Belum selesai</span>
            </div>
            <div class="summary-card">
                <span class="summary-number"><?= $selesai ?></span>
                <span class="summary-label">Selesai</span>
            </div>
        </section>

        <section class="panel">
            <h2>Tambah Tugas</h2>
            <form action="tambah.php" method="POST" class="add-form">
                <input type="hidden" name="csrf_token" value="<?= e($_SESSION["csrf_token"]) ?>">
                <label class="sr-only" for="judul">Nama tugas</label>
                <input id="judul" type="text" name="judul" maxlength="255"
                       placeholder="Contoh: Mengerjakan tugas kuliah..." required>
                <button type="submit" class="btn btn-primary">+ Tambah</button>
            </form>
        </section>

        <section class="panel">
            <div class="list-heading">
                <h2>Daftar Tugas</h2>
                <span class="count"><?= $total ?> tugas</span>
            </div>

            <?php if ($total === 0): ?>
                <div class="empty-state">
                    <div class="empty-icon">☷</div>
                    <h3>Belum ada tugas</h3>
                    <p>Tambahkan tugas pertamamu melalui kolom di atas.</p>
                </div>
            <?php else: ?>
                <ul class="task-list">
                    <?php foreach ($tugas as $item): ?>
                        <li class="task-item <?= (int)$item["selesai"] === 1 ? "is-done" : "" ?>">
                            <form action="selesai.php" method="POST" class="complete-form">
                                <input type="hidden" name="csrf_token" value="<?= e($_SESSION["csrf_token"]) ?>">
                                <input type="hidden" name="id" value="<?= (int)$item["id"] ?>">
                                <button type="submit" class="check-button"
                                        aria-label="<?= (int)$item["selesai"] === 1 ? "Tandai belum selesai" : "Tandai selesai" ?>">
                                    <?= (int)$item["selesai"] === 1 ? "✓" : "" ?>
                                </button>
                            </form>

                            <div class="task-content">
                                <span class="task-title"><?= e($item["judul"]) ?></span>
                                <span class="task-status">
                                    <?= (int)$item["selesai"] === 1 ? "Selesai" : "Belum selesai" ?>
                                </span>
                            </div>

                            <form action="hapus.php" method="POST" class="delete-form"
                                  onsubmit="return confirm('Yakin ingin menghapus tugas ini?');">
                                <input type="hidden" name="csrf_token" value="<?= e($_SESSION["csrf_token"]) ?>">
                                <input type="hidden" name="id" value="<?= (int)$item["id"] ?>">
                                <button type="submit" class="btn-delete" aria-label="Hapus tugas" title="Hapus tugas">Hapus</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <footer>To-Do List sederhana · PHP &amp; MySQL</footer>
    </main>
</body>
</html>
