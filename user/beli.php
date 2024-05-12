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
    <link href="../admin/dashboard.css" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1 class="my-4">WELCOME TO MotoMart</h1>
            <nav>
                <ul class="nav">
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
        <table class="table table-striped-columns">
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
                        <form action='form_pembelian.php' method='GET'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='hidden' name='name' value='" . $row['name'] . "'>
                        <input type='hidden' name='price' value='" . $row['price'] . "'>
                        <input type='hidden' name='description' value='" . $row['description'] . "'>
                        <input type='submit' class='btn btn-success btn-sm' name='buy' value='Beli'>
                        </form>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No results found.</td></tr>";
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
