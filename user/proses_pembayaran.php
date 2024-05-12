<?php
session_start();

// Koneksi ke database
$servername = "localhost";
$username = "phpmyadmin";
$password = "glo07Joy15_31";
$dbname = "db_motor";
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data pembayaran dari formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $nomor_pembayaran = $_POST['nomor_pembayaran'];

    // Update status pembayaran menjadi "sudah dibayar"
    $id_pembelian = $_SESSION['id_pembelian']; // ID pembelian dari sesi
    // Update status pembelian menjadi "sudah dibayar"
    $id_pembelian = $_SESSION['id_pembelian']; // ID pembelian dari sesi
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $nomor_pembayaran = $_POST['nomor_pembayaran'];
    $sql = "UPDATE pembelian SET status='sudah dibayar', metode_pembayaran='$metode_pembayaran', nomor_pembayaran='$nomor_pembayaran' WHERE id_pembelian=$id_pembelian";
    
    if ($conn->query($sql) === TRUE) {
        // Menampilkan notifikasi pop-up
        echo '<script>alert("Pembayaran berhasil. Status pembelian telah diperbarui.");</script>';
        // Mengarahkan kembali ke halaman utama dan merefresh halaman
        echo '<script>window.location.href = "beli.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Permintaan tidak valid.";
}

// Tutup koneksi database
$conn->close();
?>
