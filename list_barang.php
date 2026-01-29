<?php
session_start();
include 'koneksi.php';

// Ambil data barang
$result = mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - Sell Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #3BB77E;
            --heading: #253D4E;
            --text: #7E7E7E;
            --bg-body: #F4F6FA;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: var(--bg-body);
            display: flex;
            margin: 0;
        }

        /* Sidebar Tetap Sama */
        .sidebar {
            width: 280px;
            background-color: #fff;
            height: 100vh;
            position: fixed;
            padding: 20px;
            border-right: 1px solid #ececec;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 10px 15px;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            flex-grow: 1;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--text);
            text-decoration: none;
            font-weight: 600;
            border-radius: 10px;
            margin-bottom: 5px;
            transition: 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #DEF9EC;
            color: var(--primary);
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 1.2rem;
        }

        .logout-link {
            color: #FD6E6E;
            font-weight: 700;
        }

        .content {
            margin-left: 260px;
            padding: 40px;
            width: 100%;
        }

        /* --- Grid Card Style --- */
        .product-card {
            background: white;
            border-radius: 15px;
            border: 1px solid #ececec;
            transition: all 0.3s ease;
            height: 100%;
            overflow: hidden;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            border-color: var(--primary);
        }

        .product-img {
            width: 100%;
            height: 150px; /* Tinggi tetap */
            object-fit: contain; /* Gambar akan menyesuaikan tanpa terdistorsi */
            padding: 10px;
        }

        .img-wrapper {
            background-color: #f8f9fa;
            height: 180px; /* Samakan semua tinggi kotak gambar */
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .card-body {
            padding: 15px;
        }

        .category-text {
            font-size: 11px;
            color: #adadad;
            text-transform: uppercase;
            font-weight: 700;
        }

        .product-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--heading);
            margin: 5px 0;
            display: block;
            text-decoration: none;
        }

        .stock-info {
            font-size: 13px;
            color: var(--primary);
            font-weight: 600;
        }

        .btn-detail {
            width: 100%;
            background-color: var(--soft-green);
            color: var(--primary);
            border: none;
            border-radius: 8px;
            padding: 8px;
            font-weight: 700;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-detail:hover {
            background-color: var(--primary);
            color: white;
        }

        .badge-new {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--primary);
            color: white;
            font-size: 10px;
            padding: 4px 10px;
            border-radius: 20px;
            z-index: 2;
        }

        .btn-add-new {
            background-color: var(--primary);
            color: white;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 700;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-shop"></i> Sell Mart
        </div>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="list_barang.php" class="nav-link active">
                    <i class="bi bi-box-seam"></i> Produk
                </a>
            </li>
            <li class="nav-item">
                <a href="list_karyawan.php" class="nav-link">
                    <i class="bi bi-people"></i>Karyawan
                </a>
            </li>
        </ul>

        <a href="index.php" class="nav-link logout-link">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
    </nav>

    <main class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Katalog Produk</h2>
                <p class="text-muted small">Tampilan grid untuk manajemen stok yang lebih visual.</p>
            </div>
            <a href="tambah_barang.php" class="btn-add-new"><i class="bi bi-plus-lg"></i> Tambah Barang</a>
        </div>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="col">
                <div class="product-card">
                    <span class="badge-new">New</span>
                    <div class="img-wrapper">
                        <?php if(!empty($row['gambar'])): ?>
                            <img src="asset/<?= $row['gambar']; ?>" class="product-img" onerror="this.src='https://via.placeholder.com/150?text=Error+Loading'">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/150?text=No+Image" class="product-img">
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <span class="category-text">General</span>
                        <a href="detail_barang.php?id=<?= $row['id']; ?>" class="product-title">
                            <?= htmlspecialchars($row['nama_barang']); ?>
                        </a>
                        <div class="stock-info mb-2">
                            Stok: <?= $row['jumlah']; ?> Unit
                        </div>
                        <a href="detail_barang.php?id=<?= $row['id']; ?>" class="btn-detail text-center d-block">
                            <i class="bi bi-cart-plus me-1"></i> Detail
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>