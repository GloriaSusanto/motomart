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

// Menampilkan detail pembelian dalam tabel
if (isset($_SESSION['pembelian'])) {
    $id_motor = $_SESSION['pembelian']['id'];
    $nama_motor = $_SESSION['pembelian']['name'];
    $harga = $_SESSION['pembelian']['price'];
    $deskripsi = $_SESSION['pembelian']['description'];
    $nama_pembeli = $_SESSION['pembelian']['nama_pembeli'];
    $deskripsi_pembeli = $_SESSION['pembelian']['deskripsi_pembeli'];
    $jumlah = $_SESSION['pembelian']['jumlah'];

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Pembelian Berhasil</title>
        <!-- Bootstrap CSS -->
        <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
        <!-- Custom CSS -->
        <style>
            /* Tambahkan gaya kustom Anda di sini */
            body {
                padding: 20px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Pembelian Berhasil</h1>
            <div class='table-responsive'>
                <table class='table table-bordered'>
                    <thead class='thead-light'>
                        <tr>
                            <th>ID Motor</th>
                            <th>Nama Motor</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th>Nama Pembeli</th>
                            <th>Deskripsi Pembeli</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>$id_motor</td>
                            <td>$nama_motor</td>
                            <td>$harga</td>
                            <td>$deskripsi</td>
                            <td>$nama_pembeli</td>
                            <td>$deskripsi_pembeli</td>
                            <td>$jumlah</td>
                        </tr>
                    </tbody>
                </table>
            </div>";

            // Simpan detail pembelian ke dalam tabel "pembelian"
            $status = "belum dibayar";
            $sql = "INSERT INTO pembelian (id_motor, nama_motor, harga, deskripsi, nama_pembeli, deskripsi_pembeli, jumlah, status) VALUES ('$id_motor', '$nama_motor', '$harga', '$deskripsi', '$nama_pembeli', '$deskripsi_pembeli', '$jumlah', '$status')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['id_pembelian'] = $conn->insert_id;
                echo "<br>";
                echo "<div class='alert alert-success'>Pembelian berhasil disimpan. Silakan <a href='pembayaran.html'>melakukan pembayaran</a>.</div>";
            } else {
                echo "<p class='alert alert-danger'>Error saat menyimpan pembelian: " . $conn->error . "</p>";
            }            

            // Hapus data pembelian dari sesi setelah disimpan ke database
            unset($_SESSION['pembelian']);

            echo "</div>
            <!-- Bootstrap JS (Optional) -->
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js'></script>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js'></script>
            <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
        </body>
        </html>";
} else {
    echo "<div class='container'>";
    echo "<p class='alert alert-warning'>Data pembelian tidak ditemukan.</p>";
    echo "</div>";
}

// Tutup koneksi database
$conn->close();
?>
