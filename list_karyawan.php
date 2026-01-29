<?php
session_start();
include 'koneksi.php';

// Proteksi: Hanya Admin yang bisa mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Logika Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM karyawan WHERE id='$id'");
    header("Location: list_karyawan.php");
}

// Ambil semua data karyawan
$query = mysqli_query($conn, "SELECT * FROM karyawan ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Karyawan - Sell Mart Admin</title>
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
        }

        /* Re-use Sidebar Style from Dashboard */
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
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 30px;
            padding: 10px 15px;
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

        /* Main Content */
        .content {
            margin-left: 280px;
            padding: 40px;
            width: 100%;
        }

        .card-table {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: none;
        }

        .table thead th {
            background-color: #f8f9fa;
            color: var(--heading);
            font-weight: 700;
            border: none;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            color: var(--text);
            font-weight: 500;
        }

        .badge-role {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: capitalize;
        }

        .role-admin { background: #E7E9FF; color: #5B6CFF; }
        .role-karyawan { background: #DEF9EC; color: #3BB77E; }

        .btn-action {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: 0.3s;
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
                <a href="list_barang.php" class="nav-link">
                    <i class="bi bi-box-seam"></i> Produk
                </a>
            </li>
            <li class="nav-item">
                <a href="list_karyawan.php" class="nav-link active">
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
                <h2 class="fw-bold text-dark mb-1">Manajemen Karyawan</h2>
                <p class="text-muted">Kelola akses dan data seluruh staf Sell Mart.</p>
            </div>
            <a href="tambah_karyawan.php" class="btn btn-success fw-bold px-4 py-2" style="border-radius: 12px;">
                <i class="bi bi-plus-lg me-2"></i> Tambah Karyawan
            </a>
        </div>

        <div class="card-table">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>No. Telepon</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark"><?php echo $row['nama_karyawan']; ?></div>
                                <small class="text-muted"><?php echo $row['alamat']; ?></small>
                            </td>
                            <td>@<?php echo $row['username']; ?></td>
                            <td><?php echo $row['nomor_telepon']; ?></td>
                            <td>
                                <span class="badge-role <?php echo ($row['role'] == 'admin') ? 'role-admin' : 'role-karyawan'; ?>">
                                    <?php echo $row['role']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="edit_karyawan.php?id=<?php echo $row['id']; ?>" class="btn-action btn-outline-primary me-1" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="list_karyawan.php?hapus=<?php echo $row['id']; ?>" 
                                   class="btn-action btn-outline-danger" 
                                   onclick="return confirm('Yakin ingin menghapus karyawan ini?')" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>