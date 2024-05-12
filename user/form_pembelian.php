<?php
session_start();

// Inisialisasi session jika belum ada
if (!isset($_SESSION['pembelian'])) {
    $_SESSION['pembelian'] = [];
}

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

// Tangkap data dari tabel tbl_motomart jika ID motor diberikan
$id_motor = isset($_GET['id']) ? $_GET['id'] : '';

// Ambil data motor dari tabel tbl_motomart berdasarkan ID
$sql_motor = "SELECT * FROM tbl_motomart WHERE id = '$id_motor'";
$result_motor = $conn->query($sql_motor);

// Inisialisasi variabel untuk data motor
$id_motor = '';
$nama_motor = '';
$harga = '';
$deskripsi = '';

// Jika data motor ditemukan, isi variabel dengan nilai-nilai dari tabel
if ($result_motor->num_rows > 0) {
    $row = $result_motor->fetch_assoc();
    $id_motor = $row['id'];
    $nama_motor = $row['name'];
    $harga = $row['price'];
    $deskripsi = $row['description'];
}

// Tangkap data dari form jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['description']) && isset($_POST['nama_pembeli']) && isset($_POST['jumlah'])) {
        // Simpan data pembelian dalam sesi
        $_SESSION['pembelian'] = [
            'id' => $_POST['id'],
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'description' => $_POST['description'],
            'nama_pembeli' => $_POST['nama_pembeli'],
            'deskripsi_pembeli' => $_POST['deskripsi_pembeli'],
            'jumlah' => $_POST['jumlah']
        ];

        // Redirect ke halaman pembayaran
        header("Location: checkout.php");
        exit();
    } else {
        // Jika ada data yang kurang, tampilkan pesan kesalahan
        echo "Data pembelian tidak lengkap.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembelian</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sigmar+One&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sigmar+One&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="form.css" rel="stylesheet">
</head>
<body>
    <h2>Form Pembelian</h2>
    <div class="container">
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $id_motor; ?>"> <!-- Ganti dengan id motor yang sesuai -->
        <input type="text" name="name" placeholder="Nama Motor" value="<?php echo $nama_motor; ?>" required><br>
        <input type="number" name="price" placeholder="Harga" value="<?php echo $harga; ?>" required><br>
        <textarea name="description" placeholder="Deskripsi" required><?php echo $deskripsi; ?></textarea><br>
        <input type="text" name="nama_pembeli" placeholder="Nama Pembeli" required><br>
        <input type="text" name="deskripsi_pembeli" placeholder="Deskripsi Pembeli" required><br>
        <input type="number" name="jumlah" placeholder="Jumlah" value="<?php echo $harga; ?>" required><br>
        <button type="submit">Submit</button>
    </form>
    </div>
     <!-- Bootstrap JS -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
