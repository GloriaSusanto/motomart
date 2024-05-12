<?php
// Koneksi ke database
$koneksi = new mysqli('localhost', 'phpmyadmin', 'glo07Joy15_31', 'db_motor');

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Set header untuk menunjukkan bahwa respons adalah JSON
header('Content-Type: application/json');

// Buat query SQL untuk mendapatkan data pembelian
$sql = "SELECT * FROM pembelian";
$result = $koneksi->query($sql);

// Inisialisasi array untuk menyimpan data barang
$data_pembelian = array();

// Periksa apakah terdapat data dalam hasil query
if ($result->num_rows > 0) {
    // Loop melalui setiap baris hasil query dan tambahkan ke array data_barang
    while ($row = $result->fetch_assoc()) {
        $data_pembelian[] = $row;
    }
}

// Tampilkan data barang dalam format JSON
echo json_encode($data_pembelian);

// Tutup koneksi ke database
$koneksi->close();
?>