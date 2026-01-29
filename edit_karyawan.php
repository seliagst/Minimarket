<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM karyawan WHERE id = '$id'");
$karyawan = mysqli_fetch_assoc($result);

if (!$karyawan) {
    header("Location: list_karyawan.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_karyawan = mysqli_real_escape_string($conn, $_POST['nama_karyawan']);
    $nomor_telepon = mysqli_real_escape_string($conn, $_POST['nomor_telepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'] ? mysqli_real_escape_string($conn, $_POST['password']) : $karyawan['password']; 
    $role = $_POST['role'];

    $query = "UPDATE karyawan SET 
              nama_karyawan = '$nama_karyawan', 
              nomor_telepon = '$nomor_telepon', 
              alamat = '$alamat', 
              username = '$username', 
              password = '$password', 
              role = '$role' 
              WHERE id = '$id'";
    
    if(mysqli_query($conn, $query)) {
        header("Location: list_karyawan.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Karyawan - Sell Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3BB77E;
            --dark-green: #29A56C;
            --soft-green: #DEF9EC;
            --heading: #253D4E;
            --text: #7E7E7E;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            margin: 0;
            height: 100vh;
            background-color: #ffffff;
            overflow: hidden;
        }

        .main-wrapper {
            height: 100vh;
            display: flex;
            flex-direction: row; 
        }

        .form-section {
            flex: 1.5; 
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            overflow-y: auto;
            padding: 40px;
        }

        .form-card {
            width: 100%;
            max-width: 550px;
        }

        .side-info {
            flex: 1; 
            background: linear-gradient(135deg, var(--soft-green) 0%, #ffffff 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            position: relative;
            border-left: 1px solid #f1f1f1;
        }

        .side-info::after {
            content: "";
            position: absolute;
            width: 250px;
            height: 250px;
            background: var(--primary);
            filter: blur(120px);
            opacity: 0.1;
            top: 20%;
            right: 10%;
        }

        .login-image {
            width: 100%;
            max-width: 280px;
            margin-bottom: 25px;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.05));
            z-index: 1;
        }

        .form-label {
            font-weight: 700;
            color: var(--heading);
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            padding: 14px;
            border-radius: 12px;
            border: 2px solid #f1f1f1;
            background-color: #f8f9fa;
            font-weight: 500;
            font-family: 'Quicksand', sans-serif;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 4px rgba(59, 183, 126, 0.15);
            border-color: var(--primary);
            background-color: #fff;
            outline: none;
        }

        .btn-update {
            background: linear-gradient(to right, var(--primary), var(--dark-green));
            color: white;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 10px 20px rgba(59, 183, 126, 0.2);
            transition: 0.3s;
            cursor: pointer;
        }

        .btn-update:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(59, 183, 126, 0.3);
        }

        .back-link {
            text-decoration: none;
            color: var(--text);
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
            margin-top: 25px;
        }

        .back-link:hover { color: var(--primary); }

        @media (max-width: 991px) {
            .side-info { display: none; }
            .form-section { flex: 1; padding: 20px; }
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    
    <div class="form-section">
        <div class="form-card">
            <h2 class="fw-bold mb-1" style="color: var(--heading); padding-top: 70px;">Edit Karyawan</h2>
            <p class="text-muted mb-4">Perbarui informasi data staf Anda.</p>

            <form method="POST">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_karyawan" class="form-control" value="<?= htmlspecialchars($karyawan['nama_karyawan']); ?>" required>
                    </div>

                    <div class="col-md-7 mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" class="form-control" value="<?= htmlspecialchars($karyawan['nomor_telepon']); ?>">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Posisi / Role</label>
                        <select name="role" class="form-select" required>
                            <option value="karyawan" <?= $karyawan['role'] == 'karyawan' ? 'selected' : ''; ?>>Karyawan</option>
                            <option value="admin" <?= $karyawan['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="2" required><?= htmlspecialchars($karyawan['alamat']); ?></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($karyawan['username']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                    </div>
                </div>
                
                <button type="submit" class="btn-update">Perbarui Data</button>
            </form>

            <div class="text-center">
                <a href="list_karyawan.php" class="back-link">&larr; Batal dan Kembali</a>
            </div>
        </div>
    </div>

    <div class="side-info text-center">
        <img src="asset/gambar-1.png" alt="Edit Data" class="login-image mx-auto">
        <h3 class="fw-bold" style="color: var(--heading);">Sell Mart</h3>
        <p class="text-secondary px-4">Pastikan data karyawan selalu akurat untuk kelancaran operasional toko.</p>
    </div>

</div>

</body>
</html>