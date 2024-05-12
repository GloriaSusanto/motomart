<?php
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

// Query untuk mengambil data pembelian
$sql = "SELECT * FROM pembelian";
$result = $conn->query($sql);

// Pencarian tabel pembelian
$sql_pembelian = "SELECT * FROM pembelian";
if(isset($_GET['search'])) {
    $search = $_GET['search'];
    if(!empty($search)) {
        // Jika ada kata kunci pencarian, ambil data sesuai dengan kata kunci
        $sql_pembelian = "SELECT * FROM pembelian WHERE 
                          nama_motor LIKE '%$search%' OR 
                          deskripsi LIKE '%$search%' OR 
                          id_pembelian = '$search' OR 
                          nama_pembeli LIKE '%$search%' OR 
                          status LIKE '%$search%' OR 
                          metode_pembayaran LIKE '%$search%' OR 
                          nomor_pembayaran LIKE '%$search%'";
        // Jalankan query pencarian
        $result_pembelian = $conn->query($sql_pembelian);
        // Tampilkan pesan pop-up notifikasi
        echo "<script>alert('Search completed.');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Pembelian</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sigmar+One&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sigmar+One&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="pembelian.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5"> 
        <!-- Tabel data pembelian -->
        <h1 class="h1">List Pembelian</h1>
        <button class="back-btn" onclick="window.location.href='dashboard.php'">Back</button>

        <div class="container mt-5"> 
        <!-- Form pencarian -->
        <form action="" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search data..." name="search">
                <div class="input-group-append">
                    <button class="btn1 btn-outline-secondary" type="submit">Search</button>
                </div>
                <!-- Tombol Kembali -->
                <div class="input-group-append">
                    <a href="javascript:history.go(-1)" class="btn1 btn-outline-secondary">Back</a>
                </div>
            </div>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="th">ID Pembelian</th>
                    <th class="th">ID Motor</th>
                    <th class="th">Nama Motor</th>
                    <th class="th">Harga</th>
                    <th class="th">Deskripsi</th>
                    <th class="th">Jumlah</th>
                    <th class="th">Nama Pembeli</th>
                    <th class="th">Deskripsi Pembeli</th>
                    <th class="th">Tanggal</th>
                    <th class="th">Status</th>
                    <th class="th">Metode Pembayaran</th>
                    <th class="th">Nomor Pembayaran</th>
                    <!-- Tambahkan kolom lain sesuai kebutuhan -->
                </tr>
            </thead>
            <tbody>
            <?php
            // Menggunakan result_pembelian jika query pencarian dilakukan
            $result_display = isset($result_pembelian) ? $result_pembelian : $result;
    
            if ($result_display->num_rows > 0) {
                 while ($row = $result_display->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id_pembelian"] . "</td>";
                    echo "<td>" . $row["id_motor"] . "</td>";
                    echo "<td>" . $row["nama_motor"] . "</td>";
                    echo "<td>" . $row["harga"] . "</td>";
                    echo "<td>" . $row["deskripsi"] . "</td>";
                    echo "<td>" . $row["jumlah"] . "</td>";
                    echo "<td>" . $row["nama_pembeli"] . "</td>";
                    echo "<td>" . $row["deskripsi_pembeli"] . "</td>";
                    echo "<td>" . $row["tanggal_pembelian"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td>" . $row["metode_pembayaran"] . "</td>";
                    echo "<td>" . $row["nomor_pembayaran"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='12'>No results found.</td></tr>";
            }
    ?>
</tbody>

        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>
