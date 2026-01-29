<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);
    
    // Logika Upload Gambar
    $nama_gambar_db = "";
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $gambar = $_FILES['gambar']['name'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        
        // Buat nama unik agar file tidak tertimpa
        $nama_gambar_db = date('dmYHis') . '_' . str_replace(' ', '_', $gambar);
        $path = "asset/" . $nama_gambar_db;

        // Pindahkan file ke folder asset
        move_uploaded_file($tmp_name, $path);
    }

    $query = "INSERT INTO barang (nama_barang, jumlah, gambar) VALUES ('$nama_barang', '$jumlah', '$nama_gambar_db')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: list_barang.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Sell Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3BB77E;
            --soft-green: #DEF9EC;
            --heading: #253D4E;
        }
        body { font-family: 'Quicksand', sans-serif; background-color: #fff; margin: 0; overflow: hidden; }
        .main-wrapper { height: 100vh; display: flex; }
        .form-section { flex: 1.5; display: flex; justify-content: center; align-items: center; padding: 40px; }
        .side-info { flex: 1; background: linear-gradient(135deg, var(--soft-green) 0%, #ffffff 100%); display: flex; flex-direction: column; justify-content: center; padding: 60px; border-left: 1px solid #f1f1f1; }
        .form-card { width: 100%; max-width: 500px; }
        .form-control { padding: 12px; border-radius: 12px; border: 2px solid #f1f1f1; background-color: #f8f9fa; margin-bottom: 20px; }
        .btn-save { background: #3BB77E; color: white; border: none; padding: 15px; border-radius: 12px; font-weight: 700; width: 100%; transition: 0.3s; }
        .btn-save:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(59, 183, 126, 0.2); }
    </style>
</head>
<body>

<div class="main-wrapper">
    <div class="form-section">
        <div class="form-card">
            <h2 class="fw-bold mb-1">Tambah Produk</h2>
            <p class="text-muted mb-4">Input data barang dan unggah gambar ke folder asset.</p>

            <form method="POST" enctype="multipart/form-data">
                <label class="fw-bold mb-2">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" placeholder="Masukkan nama barang" required>

                <label class="fw-bold mb-2">Jumlah Stok</label>
                <input type="number" name="jumlah" class="form-control" placeholder="0" required>

                <label class="fw-bold mb-2">Unggah Foto Produk</label>
                <input type="file" name="gambar" class="form-control" accept="image/*">
                
                <button type="submit" class="btn-save">Simpan ke Katalog</button>
            </form>
            <a href="list_barang.php" class="d-block text-center mt-3 text-decoration-none text-muted small">&larr; Batal</a>
        </div>
    </div>
    <div class="side-info text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/869/869636.png" style="width: 200px; margin: 0 auto 30px; opacity: 0.8;" alt="Icon">
            <h3 class="fw-bold" style="color: var(--heading);">Kelola Inventaris</h3>
            <p class="text-secondary px-4">Pastikan stok barang selalu diperbarui agar pelanggan mendapatkan informasi yang akurat.</p>
        </div>
</div>

</body>
</html>