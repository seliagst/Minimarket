<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM karyawan WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: list_karyawan.php");
        exit; 
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak ditemukan.";
}

mysqli_close($conn);
?>
