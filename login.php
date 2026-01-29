<?php
session_start();
include 'koneksi.php';

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Cari user tanpa filter role dulu untuk cek siapa dia sebenarnya
    $query = "SELECT * FROM karyawan WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // CEK ROLE: Jika dia Karyawan tapi maksa login di halaman Admin
        if ($user['role'] !== 'admin') {
            header("Location: loginkaryawan.php");
            exit();
        }

        // Jika dia benar Admin, baru buat session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; 
        
        header("Location: dashboard.php");
        exit(); 
    } else {
        $error_message = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Sell Mart</title>
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

        /* Sisi Kiri */
        .side-info {
            flex: 1;
            background: linear-gradient(135deg, var(--soft-green) 0%, #ffffff 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px;
            position: relative;
        }

        .side-info::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: var(--primary);
            filter: blur(150px);
            opacity: 0.1;
            top: -50px;
            left: -50px;
        }

        .login-image {
            width: 100%;
            max-width: 250px;
            height: auto;
            margin-bottom: 20px;
            display: block;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.05));
        }

        .side-info h2 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--heading);
            line-height: 1.1;
        }

        .side-info h2 span {
            color: var(--primary);
        }

        /* Sisi Kanan */
        .login-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 40px;
        }

        .form-label {
            font-weight: 700;
            color: var(--heading);
            font-size: 0.9rem;
        }

        .form-control {
            padding: 15px;
            border-radius: 12px;
            border: 2px solid #f1f1f1;
            background-color: #f8f9fa;
            font-weight: 500;
            font-family: 'Quicksand', sans-serif;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(59, 183, 126, 0.15);
            border-color: var(--primary);
            background-color: #fff;
            outline: none;
        }

        .btn-login {
            background: linear-gradient(to right, var(--primary), var(--dark-green));
            color: white;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 10px 20px rgba(59, 183, 126, 0.3);
            transition: 0.3s;
            cursor: pointer;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(59, 183, 126, 0.4);
        }

        .back-home {
            text-decoration: none;
            color: var(--text);
            font-weight: 600;
            font-size: 0.9rem;
            margin-top: 30px;
            display: inline-block;
        }

        .back-home:hover { color: var(--primary); }

        @media (max-width: 991px) {
            .side-info { display: none; }
            .login-section { background: var(--soft-green); }
            .login-card { 
                background: white; 
                border-radius: 30px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            }
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    
    <div class="side-info">
        <img src="asset/gambar-1.png" alt="Sell Mart Illustration" class="login-image">
        <h2>Selamat Datang di <br><span>Sell Mart</span></h2>
        <p class="mt-3 fs-5">Sistem manajemen minimarket modern untuk efisiensi bisnis Anda.</p>
    </div>

    <div class="login-section">
        <div class="login-card">
            <h3 class="fw-bold mb-1" style="color: var(--heading);">Masuk Akun Admin</h3>
            <p class="text-muted mb-4">Masukkan Username dan Password!</p>

            <?php if ($error_message != ""): ?>
                <div class='alert alert-danger py-2 small text-center' style="border-radius: 10px; border: none;">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control"  required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn-login">Login Sekarang</button>
            </form>

            <div class="text-center">
                <a href="index.php" class="back-home">&larr; Kembali ke Beranda</a>
            </div>
        </div>
    </div>

</div>

</body>
</html>