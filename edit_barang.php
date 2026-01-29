<?php
session_start();
include 'koneksi.php';

// Ambil ID dari URL
$id = mysqli_real_escape_string($conn, $_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM barang WHERE id = $id");
$barang = mysqli_fetch_assoc($result);

if (!$barang) {
    header("Location: list_barang.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);
    
    // Cek apakah user mengupload gambar baru
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $nama_file = $_FILES['gambar']['name'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        $nama_gambar_baru = date('dmYHis') . '_' . str_replace(' ', '_', $nama_file);
        $path = "asset/" . $nama_gambar_baru;

        if (move_uploaded_file($tmp_name, $path)) {
            // Hapus gambar lama jika ada (opsional agar folder asset tidak penuh)
            if (!empty($barang['gambar']) && file_exists("asset/" . $barang['gambar'])) {
                unlink("asset/" . $barang['gambar']);
            }
            $query = "UPDATE barang SET nama_barang = '$nama_barang', jumlah = '$jumlah', gambar = '$nama_gambar_baru' WHERE id = $id";
        }
    } else {
        // Jika tidak ganti gambar, update nama & jumlah saja
        $query = "UPDATE barang SET nama_barang = '$nama_barang', jumlah = '$jumlah' WHERE id = $id";
    }

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
    <title>Edit Produk - Sell Mart</title>
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
        }

        /* Area Form (60%) */
        .form-section {
            flex: 1.5;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .form-card {
            width: 100%;
            max-width: 500px;
        }

        /* Area Preview (40%) */
        .preview-section {
            flex: 1;
            background: linear-gradient(135deg, var(--soft-green) 0%, #ffffff 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            border-left: 1px solid #f1f1f1;
            text-align: center;
        }

        .form-label {
            font-weight: 700;
            color: var(--heading);
            font-size: 0.9rem;
        }

        .form-control {
            padding: 12px;
            border-radius: 12px;
            border: 2px solid #f1f1f1;
            background-color: #f8f9fa;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(59, 183, 126, 0.15);
            border-color: var(--primary);
        }

        .btn-update {
            background: linear-gradient(to right, var(--primary), var(--dark-green));
            color: white;
            border: none;
            padding: 15px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-update:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(59, 183, 126, 0.2);
        }

        .current-img-preview {
            width: 200px;
            height: 200px;
            object-fit: contain;
            background: white;
            border-radius: 20px;
            padding: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        @media (max-width: 991px) {
            .preview-section { display: none; }
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <div class="form-section">
        <div class="form-card">
            <h2 class="fw-bold mb-1" style="color: var(--heading);">Perbarui Produk</h2>
            <p class="text-muted mb-4">Ubah informasi stok atau ganti foto produk Anda.</p>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($barang['nama_barang']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Stok</label>
                    <input type="number" name="jumlah" class="form-control" value="<?= htmlspecialchars($barang['jumlah']); ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Ganti Foto Produk (Opsional)</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                </div>
                
                <button type="submit" class="btn-update">Simpan Perubahan</button>
            </form>

            <div class="text-center mt-3">
                <a href="detail_barang.php?id=<?= $id; ?>" class="text-decoration-none text-muted small">&larr; Kembali ke Detail</a>
            </div>
        </div>
    </div>

    <div class="preview-section">
        <h5 class="fw-bold mb-4" style="color: var(--heading);">Gambar Saat Ini</h5>
        <?php if(!empty($barang['gambar']) && file_exists("asset/" . $barang['gambar'])): ?>
            <img src="asset/<?= $barang['gambar']; ?>" class="current-img-preview">
        <?php else: ?>
            <img src="https://via.placeholder.com/200?text=No+Image" class="current-img-preview">
        <?php endif; ?>
        <p class="text-secondary small px-5">Pastikan data yang Anda masukkan sudah benar sebelum menekan tombol update.</p>
    </div>
</div>

</body>
</html>