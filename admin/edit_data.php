<?php
// Koneksi ke database
$servername = "localhost";
$username = "phpmyadmin";
$password = "glo07Joy15_31";
$dbname = "db_motor";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Periksa apakah ada parameter ID yang dikirimkan melalui URL
if(isset($_GET['id'])) {
    $editId = $_GET['id'];
    
    // Query untuk mengambil data yang akan diedit berdasarkan ID
    $sql_edit_data = "SELECT * FROM tbl_motomart WHERE id = '$editId'";
    $result_edit_data = $conn->query($sql_edit_data);

    if ($result_edit_data->num_rows > 0) {
        // Ambil data dari hasil query
        $edit_row = $result_edit_data->fetch_assoc();
        $edit_id = $edit_row['id'];
        $edit_name = $edit_row['name'];
        $edit_price = $edit_row['price'];
        $edit_description = $edit_row['description'];
        $edit_unit = $edit_row['unit'];
        $edit_image = $edit_row['image'];
    } else {
        // Jika data tidak ditemukan, tampilkan pesan error
        echo "Data not found.";
        exit();
    }
} else {
    // Jika tidak ada parameter ID, tampilkan pesan error
    echo "ID parameter is missing.";
    exit();
}

// Proses form jika ada data yang dikirimkan
if(isset($_POST["submit"])) {
    // Memastikan semua field diisi
    if(!empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['description']) && !empty($_POST['unit']) && !empty($_FILES["image"]["name"])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $unit = $_POST['unit'];

        // Unggah gambar
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image = $target_file;

        // Lakukan proses edit data
        $sql_edit = "UPDATE tbl_motomart SET name = '$name', price = '$price', description = '$description', unit = '$unit', image = '$image' WHERE id = '$editId'";
        
        if ($conn->query($sql_edit) === TRUE) {
            echo "Data updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Harap lengkapi semua field.";
    }
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Data Motor</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sigmar+One&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sigmar+One&display=swap" rel="stylesheet">

<link rel="stylesheet" href="insert.css">
</head>
<body>

<div class="container">
    <h2 class="h2">Edit Data Motor</h2>

    <form action="edit_data.php?id=<?php echo $edit_id; ?>" method="post" enctype="multipart/form-data">
        <label class="label" for="image">Image:</label>
        <input type="file" id="image" name="image">
        <img src="<?php echo $edit_image; ?>" height="100">

       <br> <label class="label"  for="name">Name:</label></br>
        <input type="text" id="name" name="name" value="<?php echo $edit_name; ?>">

        <label class="label"  for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo $edit_price; ?>">

        <label class="label"  for="description">Description:</label>
        <textarea id="description" name="description"><?php echo $edit_description; ?></textarea>

        <label class="label" for="unit">Unit:</label>
        <input type="text" id="unit" name="unit" value="<?php echo $edit_unit; ?>">

        <input type="submit" name="submit" value="Submit">
    </form>
    <button class="back-btn" onclick="window.location.href='dashboard.php'">Back</button>
</div>

 <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
