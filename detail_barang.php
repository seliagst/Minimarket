<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM barang WHERE id = '$id'");
$barang = mysqli_fetch_assoc($result);

if (!$barang) {
    header("Location: list_barang.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Sell Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #3BB77E;
            --heading: #253D4E;
            --text: #7E7E7E;
            --bg-body: #F4F6FA;
            --danger: #fd6e6e;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: var(--bg-body);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .detail-card {
            background: white;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
        }

        .image-section {
            flex: 1;
            min-width: 350px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            border-right: 1px solid #f1f1f1;
        }

        .product-img-large {
            max-width: 100%;
            max-height: 400px;
            object-fit: contain;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
        }

        .info-section {
            flex: 1.2;
            padding: 50px;
            min-width: 350px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .badge-id {
            background: var(--soft-green);
            color: var(--primary);
            font-weight: 700;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            display: inline-block;
            margin-bottom: 15px;
            background-color: #DEF9EC;
        }

        .product-name {
            color: var(--heading);
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .stock-label {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 30px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-custom {
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            border: none;
        }

        .btn-edit {
            background-color: var(--primary);
            color: white;
        }

        .btn-edit:hover {
            background-color: #29A56C;
            transform: translateY(-3px);
            color: white;
        }

        .btn-delete {
            background-color: #fff1f1;
            color: var(--danger);
        }

        .btn-delete:hover {
            background-color: var(--danger);
            color: white;
            transform: translateY(-3px);
        }

        .back-link {
            margin-top: 30px;
            color: var(--text);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .back-link:hover { color: var(--primary); }

        @media (max-width: 768px) {
            .image-section { border-right: none; border-bottom: 1px solid #f1f1f1; }
            .info-section { padding: 30px; }
        }
    </style>
</head>
<body>

<div class="detail-card">
    <div class="image-section">
        <?php if(!empty($barang['gambar']) && file_exists("asset/" . $barang['gambar'])): ?>
            <img src="asset/<?= $barang['gambar']; ?>" class="product-img-large" alt="Produk">
        <?php else: ?>
            <img src="https://via.placeholder.com/400?text=No+Image" class="product-img-large" alt="No Image">
        <?php endif; ?>
    </div>

    <div class="info-section">
        <span class="badge-id">ID Barang: #BRG-<?= $barang['id']; ?></span>
        <h1 class="product-name"><?= htmlspecialchars($barang['nama_barang']); ?></h1>
        <p class="stock-label">
            <i class="bi bi-box-seam me-2"></i>Persediaan: <?= $barang['jumlah']; ?> Unit
        </p>
        
        <p class="text-muted mb-4">
            Kelola data produk ini dengan teliti. Perubahan pada nama atau jumlah stok akan langsung memengaruhi laporan inventaris Sell Mart.
        </p>

        <div class="action-buttons">
            <a href="edit_barang.php?id=<?= $id; ?>" class="btn-custom btn-edit">
                <i class="bi bi-pencil-square"></i> Edit Produk
            </a>
            
            <form action="hapus_barang.php?id=<?= $id; ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini secara permanen?');">
                <button type="submit" class="btn-custom btn-delete">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
        </div>

        <a href="list_barang.php" class="back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke Katalog
        </a>
    </div>
</div>

</body>
</html>