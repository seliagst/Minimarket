<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'karyawan' && $_SESSION['role'] !== 'admin')) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';

$query_jenis = mysqli_query($conn, "SELECT COUNT(*) as total FROM barang");
$data_jenis = mysqli_fetch_assoc($query_jenis);
$total_jenis = $data_jenis['total'];

$query_tipis = mysqli_query($conn, "SELECT COUNT(*) as total FROM barang WHERE jumlah < 5");
$data_tipis = mysqli_fetch_assoc($query_tipis);
$stok_tipis = $data_tipis['total'];

$stok_prioritas = mysqli_query($conn, "SELECT * FROM barang ORDER BY jumlah ASC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan - Sell Mart</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary: #3BB77E;
            --warning: #FDC040;
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
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background-color: #fff;
            height: 100vh;
            position: fixed;
            padding: 25px 20px;
            border-right: 1px solid #ececec;
            display: flex;
            flex-direction: column; 
            z-index: 100;
        }

        .sidebar-brand {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 35px;
            padding: 0 10px;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--text);
            text-decoration: none;
            font-weight: 600;
            border-radius: 12px;
            margin-bottom: 8px;
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
            color: var(--danger) !important;
            font-weight: 700;
            margin-top: auto; 
            border-top: 1px solid #f1f1f1;
            padding-top: 20px;
            border-radius: 0;
        }

        .content { 
            margin-left: 280px; 
            padding: 40px; 
            width: 100%; 
        }

        .welcome-box {
            background: linear-gradient(135deg, var(--primary), #29A56C);
            border-radius: 20px; 
            padding: 35px; 
            color: white; 
            margin-bottom: 35px;
            box-shadow: 0 10px 20px rgba(59, 183, 126, 0.2);
        }

        .info-card {
            background: white; 
            border-radius: 20px; 
            padding: 25px;
            border: none; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            transition: 0.3s;
        }

        .info-card:hover { transform: translateY(-5px); }

        .badge-warning { 
            background: #FFF3EB; 
            color: #FD8D27; 
            padding: 6px 12px; 
            border-radius: 8px; 
            font-size: 12px; 
            font-weight: 700;
        }

        .table-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-shop"></i> Sell Mart
            <small style="font-size: 11px; display:block; color: #7e7e7e; font-weight: 500;">Staff Mode</small>
        </div>
        
        <ul class="nav-menu">
            <li>
                <a href="dashboard_karyawan.php" class="nav-link active">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="karyawan_list.php" class="nav-link">
                    <i class="bi bi-box-seam"></i> Cek Stok Barang
                </a>
            </li>
        </ul>

        <a href="index.php" class="nav-link logout-link">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
    </nav>

    <main class="content">
        <div class="welcome-box shadow">
            <h2 class="fw-bold">Halo, <?= htmlspecialchars($_SESSION['nama'] ?? 'Karyawan'); ?>! 👋</h2>
            <p class="mb-0 opacity-75">Semangat bekerja hari ini. Pastikan laporan stok barang tetap akurat dan up-to-date.</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="info-card d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fw-bold small uppercase">Total Produk Aktif</p>
                        <h3 class="fw-bold mb-0 text-dark"><?= $total_jenis; ?> <span class="fs-6 text-muted fw-normal">Item</span></h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background: #DEF9EC; color: var(--primary);">
                        <i class="bi bi-box-seam fs-3"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-card d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fw-bold small uppercase">Perlu Re-stock</p>
                        <h3 class="fw-bold mb-0 text-dark"><?= $stok_tipis; ?> <span class="fs-6 text-muted fw-normal">Produk</span></h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background: #FFF1F1; color: var(--danger);">
                        <i class="bi bi-exclamation-octagon fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-container shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0" style="color: var(--heading);">Prioritas Stok Rendah</h5>
                <span class="badge bg-light text-dark border fw-bold">Update Terkini</span>
            </div>
            
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <th class="py-3">Nama Produk</th>
                            <th class="py-3">Sisa Stok</th>
                            <th class="py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($stok_prioritas)) : ?>
                        <tr>
                            <td class="fw-bold text-dark py-3"><?= htmlspecialchars($row['nama_barang']); ?></td>
                            <td><span class="fw-bold"><?= $row['jumlah']; ?></span> Unit</td>
                            <td class="text-center">
                                <?php if($row['jumlah'] < 5): ?>
                                    <span class="badge-warning">Stok Kritis</span>
                                <?php else: ?>
                                    <span class="badge bg-light text-success border border-success-subtle px-3 py-2 rounded-3 small fw-bold">Aman</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <a href="karyawan_list.php" class="btn btn-outline-success w-100 mt-3 fw-bold py-3" style="border-radius: 12px;">
                <i class="bi bi-card-list me-2"></i> Kelola Seluruh Stok
            </a>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>