<?php
include 'koneksi.php';

// Periksa apakah ID ada di parameter GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Siapkan query DELETE
    $query = "DELETE FROM karyawan WHERE id = $id";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, arahkan kembali ke list karyawan
        header("Location: list_karyawan.php");
        exit; // Hentikan eksekusi skrip setelah redirect
    } else {
        // Jika gagal, tampilkan pesan kesalahan
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak ditemukan.";
}

// Tutup koneksi
mysqli_close($conn);
?>
