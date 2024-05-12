<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "db_motor";
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fungsi untuk menghapus data
function deleteData($conn, $id) {
    $sql = "DELETE FROM tbl_motomart WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        return "Data berhasil dihapus";
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Tangani permintaan untuk menghapus data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $deleteId = $_POST["id"];
    $deleteResult = deleteData($conn, $deleteId);
    // Menampilkan pesan pop-up notifikasi
    echo "<script>alert('$deleteResult'); window.location.href = 'dashboard.php';</script>";
}


// Tangani permintaan untuk mengedit data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
    // Anda bisa langsung mengarahkan ke halaman edit_data.php dengan membawa id data yang akan diubah
    $editId = $_POST["id"];
    header("Location: edit_data.php?id=$editId");
    exit();
}

// Pencarian tbl_motomart
$sql_tbl_motomart = "SELECT * FROM tbl_motomart";
if(isset($_GET['search'])) {
    $search = $_GET['search'];
    if(!empty($search)) {
        // Jika ada kata kunci pencarian, ambil data sesuai dengan kata kunci
        $sql_tbl_motomart = "SELECT * FROM tbl_motomart WHERE name LIKE '%$search%' OR description LIKE '%$search%' OR id = '$search'";
        // Jalankan query pencarian
        $result_tbl_motomart = $conn->query($sql_tbl_motomart);
        // Tampilkan pesan pop-up notifikasi
        echo "<script>alert('Search completed.');</script>";
    }
}


$result_tbl_motomart = $conn->query($sql_tbl_motomart);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Motor</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sigmar+One&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sigmar+One&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dashboard.css" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1 class="my-4">WELCOME TO MotoMart</h1>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link" href="pembelian.php">List Pembelian</a></li>
                    <li class="nav-item"><a class="nav-link" href="insertdata.php" id="insertDataBtn">New Data</a></li>
                    <li class="nav-item"><a class="nav-link" href="../login/index.php"><button class="btn" id="logoutBtn">Logout</button></a></li> <!-- Tombol Logout -->
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mt-5"> 
        <!-- Form pencarian -->
        <form action="" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search data..." name="search">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
                <!-- Tombol Kembali -->
                <div class="input-group-append">
                    <a href="javascript:history.go(-1)" class="btn btn-outline-secondary">Back</a>
                </div>
            </div>
        </form>

        <!-- Tabel data motor -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="table-light" colspan="8">Data Motor</th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Actions</th>
                </tr>   
            </thead>
        
            <tbody>
                <?php
                // Menampilkan hasil pencarian dalam format tabel HTML
                if ($result_tbl_motomart->num_rows > 0) {
                    while ($row = $result_tbl_motomart->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td><img src='" . $row["image"] . "' alt=''' height='100'></td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td>" . $row["unit"] . "</td>"; 
                        echo "<td>  
                                <form action='' method='POST' style='display: inline;'>
                                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                                    <input type='submit' class='btn-edit btn-info btn-sm' name='edit' value='Edit'>
                                </form>
                                <form action='' method='POST' style='display: inline;'>
                                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                                    <input type='submit' class='btn-delete btn-danger btn-sm' name='delete' value='Delete' onclick='return confirm(\"Are you sure?\");'>
                                </form>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No results found.</td></tr>";
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
