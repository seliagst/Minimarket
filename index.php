<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Mart - Portal Sistem</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #3BB77E;
            --secondary: #FDC040;
            --heading: #253D4E;
            --text: #7E7E7E;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #ffffff;
            margin: 0;
            overflow: hidden;
        }

        .hero {
            height: 100vh;
            background: url('asset/background.png') no-repeat center center/cover;
            display: flex;
            align-items: center;
        }

        h1 {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            color: var(--heading);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -1px;
        }

        .badge-custom {
            background-color: var(--secondary);
            color: var(--heading);
            font-weight: 700;
            padding: 8px 20px;
            border-radius: 50px;
            display: inline-block;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        .btn-sell {
            padding: 16px 40px;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-admin {
            background-color: var(--primary);
            color: white;
            border: none;
        }

        .btn-admin:hover {
            background-color: #29A56C;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(59, 183, 126, 0.3);
            color: white;
        }

        .btn-karyawan {
            background-color: var(--heading);
            color: white;
            border: none;
        }

        .btn-karyawan:hover {
            background-color: #1a2d3a;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(37, 61, 78, 0.2);
            color: white;
        }

        /* Tombol Daftar Baru */
        .btn-register {
            border: none;
            color: white;
            background-color: var(--secondary);
        }

        .btn-register:hover {
            background-color: var(--secondary);
            color: white;
            transform: translateY(-3px);
        }

        .floating-info {
            position: absolute;
            bottom: 50px;
            right: 8%;
            background: white;
            padding: 25px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border-bottom: 4px solid var(--primary);
        }
    </style>
</head>
<body>

    <main class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10">
                    <div class="badge-custom mb-4">Internal Management System</div>
                    
                    <h1 class="mb-3">
                        Kelola Operasional <br> 
                        <span style="color: var(--primary);">Sell Mart</span> Lebih Mudah.
                    </h1>
                    
                    <p class="lead mb-5 text-secondary pe-lg-5">
                        Selamat datang di portal manajemen pusat. Pantau stok barang dan data karyawan dalam satu dashboard terintegrasi.
                    </p>
                    
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="login.php" class="btn-sell btn-admin">
                            Login Admin
                        </a>
                        <a href="loginkaryawan.php" class="btn-sell btn-karyawan">
                            Login Karyawan
                        </a>
                        <a href="tambah_karyawan.php" class="btn-sell btn-register">
                            Daftar Akun
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="floating-info d-none d-lg-block text-center">
        <div class="h3 mb-0 fw-bold" style="color: var(--primary);">Sell Mart</div>
        <div class="small fw-600 text-muted">Fresh & Modern Grocery</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>