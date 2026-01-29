<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'karyawan' && $_SESSION['role'] !== 'admin')) {
    header("Location: login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Stok - Sell Mart</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary: #3BB77E;
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
        }

        /* --- Main Content --- */
        .content { 
            margin-left: 280px; 
            padding: 40px; 
            width: 100%; 
        }

        .product-card {
            background: white;
            border-radius: 20px;
            border: none;
            overflow: hidden;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .img-container {
            height: 160px;
            background-color: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        .img-container img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }

        .product-info { padding: 20px; }

        .product-name {
            font-size: 1rem;
            font-weight: 700;
            color: var(--heading);
            margin-bottom: 5px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .stock-label {
            font-size: 0.85rem;
            color: #7E7E7E;
            margin-bottom: 15px;
        }

        .input-stok {
            border-radius: 10px;
            border: 2px solid #f1f1f1;
            font-weight: 700;
            text-align: center;
        }

        .btn-update {
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 8px 15px;
            transition: 0.3s;
        }

        .btn-update:hover { background-color: #29A56C; }

        .header-title {
            margin-bottom: 30px;
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
                <a href="dashboard_karyawan.php" class="nav-link">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="karyawan_list.php" class="nav-link active">
                    <i class="bi bi-box-seam"></i> Cek Stok Barang
                </a>
            </li>
        </ul>

        <a href="index.php" class="nav-link logout-link">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
    </nav>

    <main class="content">
        <div class="header-title">
            <h2 class="fw-bold">Manajemen Stok Barang</h2>
            <p class="text-muted">Perbarui jumlah stok fisik yang tersedia di gudang.</p>
        </div>

        <div class="row g-4">
            <?php while($row = mysqli_fetch_assoc($result)) : ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card">
                    <div class="img-container">
                        <?php if(!empty($row['gambar'])): ?>
                            <img src="asset/<?= $row['gambar']; ?>" alt="produk">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/150?text=No+Image" alt="produk">
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <div class="product-name" title="<?= $row['nama_barang']; ?>"><?= $row['nama_barang']; ?></div>
                        <div class="stock-label">Stok: <strong><?= $row['jumlah']; ?> Unit</strong></div>
                        
                        <form action="proses_update_stok.php" method="POST">
                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                            <div class="d-flex gap-2">
                                <input type="number" name="jumlah_baru" class="form-control input-stok" value="<?= $row['jumlah']; ?>" min="0">
                                <button type="submit" class="btn-update">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </main>

    <?php if (isset($_GET['status'])): ?>
    <script>
        const status = "<?= $_GET['status'] ?>";
        if (status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Stok barang telah diperbarui.',
                confirmButtonColor: '#3BB77E'
            });
        } else if (status === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat update data.',
                confirmButtonColor: '#FD6E6E'
            });
        }
    </script>
    <?php endif; ?>

</body>
</html>