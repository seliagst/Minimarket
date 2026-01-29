<?php
session_start();
// Pastikan hanya Admin yang bisa masuk
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';

// --- AMBIL DATA REAL DARI DATABASE ---

// 1. Total Jenis Produk
$query_jenis = mysqli_query($conn, "SELECT COUNT(*) as total FROM barang");
$data_jenis = mysqli_fetch_assoc($query_jenis);
$total_jenis = $data_jenis['total'];

// 2. Total Unit Stok (Jumlah dari semua kolom jumlah)
$query_stok = mysqli_query($conn, "SELECT SUM(jumlah) as total_unit FROM barang");
$data_stok = mysqli_fetch_assoc($query_stok);
$total_unit = $data_stok['total_unit'] ?? 0;

// 3. Produk Stok Tipis (Stok di bawah 5)
$query_tipis = mysqli_query($conn, "SELECT COUNT(*) as total FROM barang WHERE jumlah < 5");
$data_tipis = mysqli_fetch_assoc($query_tipis);
$stok_tipis = $data_tipis['total'];

// 4. Ambil 5 Produk Terbaru untuk Tabel
$barang_terbaru = mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sell Mart</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #3BB77E;
            --secondary: #FDC040;
            --heading: #253D4E;
            --text: #7E7E7E;
            --bg-body: #F4F6FA;
            --danger: #FD6E6E;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: var(--bg-body);
            margin: 0;
            display: flex;
        }

        /* --- Sidebar --- */
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
            display: flex; align-items: center; gap: 10px;
        }

        .nav-menu { list-style: none; padding: 0; flex-grow: 1; }

        .nav-link {
            display: flex; align-items: center; padding: 12px 15px;
            color: var(--text); text-decoration: none; font-weight: 600;
            border-radius: 10px; margin-bottom: 5px; transition: 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #DEF9EC; color: var(--primary);
        }

        .nav-link i { margin-right: 12px; font-size: 1.2rem; }
        .logout-link { color: var(--danger); font-weight: 700; }

        /* --- Content --- */
        .content { margin-left: 280px; padding: 40px; width: 100%; }

        .header-top {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 40px;
        }

        .stat-card {
            background: white; border-radius: 20px; padding: 25px;
            border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            display: flex; align-items: center; gap: 20px; transition: 0.3s;
        }

        .icon-box {
            width: 60px; height: 60px; border-radius: 15px;
            display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
        }

        .bg-1 { background: #DEF9EC; color: #3BB77E; } /* Hijau */
        .bg-2 { background: #E7E9FF; color: #5B6CFF; } /* Biru */
        .bg-3 { background: #FFF1F1; color: #FD6E6E; } /* Merah */

        .table-container {
            background: white; border-radius: 20px; padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02); margin-top: 30px;
        }

        .badge-stock {
            padding: 5px 12px; border-radius: 50px; font-weight: 700; font-size: 0.75rem;
        }
        .stock-ok { background: #DEF9EC; color: #3BB77E; }
        .stock-low { background: #FFF1F1; color: #FD6E6E; }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="sidebar-brand"><i class="bi bi-shop"></i> Sell Mart</div>
        <ul class="nav-menu">
            <li><a href="dashboard.php" class="nav-link active"><i class="bi bi-grid"></i> Dashboard</a></li>
            <li><a href="list_barang.php" class="nav-link"><i class="bi bi-box-seam"></i> Produk</a></li>
            <li><a href="list_karyawan.php" class="nav-link"><i class="bi bi-people"></i> Karyawan</a></li>
        </ul>
        <a href="index.php" class="nav-link logout-link"><i class="bi bi-box-arrow-right"></i> Keluar</a>
    </nav>

    <main class="content">
        <header class="header-top">
            <div>
                <h2 class="fw-bold mb-0">Overview Inventaris</h2>
                <p class="text-muted">Pantau ketersediaan stok barang Anda hari ini.</p>
            </div>
            <div class="d-flex align-items-center gap-3 bg-white px-4 py-2 rounded-pill shadow-sm">
                <i class="bi bi-calendar3 text-primary"></i>
                <span class="fw-bold small"><?= date('d M Y'); ?></span>
            </div>
        </header>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box bg-1"><i class="bi bi-box"></i></div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold">Jenis Produk</p>
                        <h3 class="fw-bold mb-0"><?= $total_jenis; ?> <small style="font-size: 1rem;">Item</small></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box bg-2"><i class="bi bi-stack"></i></div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold">Total Unit Stok</p>
                        <h3 class="fw-bold mb-0"><?= number_format($total_unit, 0, ',', '.'); ?> <small style="font-size: 1rem;">Unit</small></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box bg-3"><i class="bi bi-exclamation-triangle"></i></div>
                    <div>
                        <p class="text-muted mb-0 small fw-bold">Perlu Re-stock</p>
                        <h3 class="fw-bold mb-0"><?= $stok_tipis; ?> <small style="font-size: 1rem;">Produk</small></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Produk yang Baru Ditambahkan</h4>
                <a href="list_barang.php" class="btn btn-sm btn-outline-success fw-bold px-3">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($barang_terbaru)) : ?>
                        <tr>
                            <td>
                                <?php if(!empty($row['gambar'])): ?>
                                    <img src="asset/<?= $row['gambar']; ?>" width="45" height="45" class="rounded-3 object-fit-cover">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/45" class="rounded-3">
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold"><?= $row['nama_barang']; ?></td>
                            <td><?= $row['jumlah']; ?> Unit</td>
                            <td>
                                <?php if($row['jumlah'] < 5): ?>
                                    <span class="badge-stock stock-low">Stok Rendah</span>
                                <?php else: ?>
                                    <span class="badge-stock stock-ok">Aman</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="detail_barang.php?id=<?= $row['id']; ?>" class="btn btn-light btn-sm rounded-circle">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>