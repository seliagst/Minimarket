<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengamankan input
    $nama_karyawan = mysqli_real_escape_string($conn, $_POST['nama_karyawan']);
    $nomor_telepon = mysqli_real_escape_string($conn, $_POST['nomor_telepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = $_POST['role'];

    $query = "INSERT INTO karyawan (nama_karyawan, nomor_telepon, alamat, username, password, role) 
              VALUES ('$nama_karyawan', '$nomor_telepon', '$alamat', '$username', '$password', '$role')";
    
    if(mysqli_query($conn, $query)) {
        // Setelah daftar, arahkan ke login agar mereka bisa mencoba akun barunya
        header("Location: loginkaryawan.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Karyawan - Sell Mart</title>
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
            /* Form di Kiri, Info di Kanan */
            flex-direction: row; 
        }

        /* Sisi Kiri: AREA FORM (LEBIH LEBAR) */
        .form-section {
            flex: 1.5; /* Proporsi 60% */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            overflow-y: auto;
            padding: 40px;
        }

        .form-card {
            width: 100%;
            max-width: 550px; /* Diperlebar agar inputan lega */
        }

        /* Sisi Kanan: AREA INFO (LEBIH RAMPING) */
        .side-info {
            flex: 1; /* Proporsi 40% */
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
            height: auto;
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

        .btn-submit {
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

        .btn-submit:hover {
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

        /* Responsif HP */
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
            <h1 class="fw-bold mb-1" style="color: var(--heading); padding-top: 70px;">Daftar Akun</h1>
            <p class="text-muted mb-4">Lengkapi data untuk membuat akun baru.</p>

            <form method="POST">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_karyawan" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="col-md-7 mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" class="form-control" placeholder="08xxxx" required>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Posisi / Role</label>
                        <select name="role" class="form-select" required>
                            <option value="karyawan">Karyawan</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Buat username" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Buat password" required>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit">Simpan & Daftar</button>
            </form>

            <div class="text-center">
                <a href="loginkaryawan.php" class="back-link">&larr; Sudah punya akun? Login di sini</a>
            </div>
        </div>
    </div>

    <div class="side-info text-center">
        <img src="asset/gambar-1.png" alt="Registration" class="login-image mx-auto">
        <h3 class="fw-bold" style="color: var(--heading);">Sell Mart</h3>
        <p class="text-secondary">Ayo mulai kelola operasional toko dengan lebih cerdas dan teratur.</p>
    </div>

</div>

</body>
</html>