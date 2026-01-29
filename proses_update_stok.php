<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $jumlah_baru = mysqli_real_escape_string($conn, $_POST['jumlah_baru']);

    $query = "UPDATE barang SET jumlah = '$jumlah_baru' WHERE id = '$id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: karyawan_list.php?status=success");
    } else {
        header("Location: karyawan_list.php?status=error");
    }
}
?>