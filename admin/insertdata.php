<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "db_motor";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Proses form jika ada data yang dikirimkan
if(isset($_POST["submit"])) {
    // Memastikan semua field diisi
    if(!empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['description']) && !empty($_POST['unit']) && !empty($_FILES["image"]["name"])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $unit = $_POST['unit'];

        // Unggah gambar
        $target_dir = "../uploads";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image = $target_file;

        // Cetak path gambar
        echo "Path Gambar: " . $image . "<br>";
        // Insert data ke database
        $sql = "INSERT INTO tbl_motomart (id, name, price, description, unit, image)
        VALUES ('$id', '$name', '$price', '$description', '$unit', '$image')";

        if ($conn->query($sql) === TRUE) {
            echo "Data inserted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Harap lengkapi semua field.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Insert Data Motor</title>
<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sigmar+One&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sigmar+One&display=swap" rel="stylesheet">
<link rel="stylesheet" href="insert.css">
<script>
    // Validasi form sebelum submit
    function validateForm() {
        var id = document.getElementById('id').value;
        var name = document.getElementById('name').value;
        var price = document.getElementById('price').value;
        var description = document.getElementById('description').value;
        var unit = document.getElementById('unit').value;
        var image = document.getElementById('image').value;

        if (id == '' || name == '' || price == '' || description == '' || unit == '' || image == '') {
            alert('Harap lengkapi semua field.');
            return false;
        }
    }
</script>
</head>
<body>

<div class="container">
    <h2 class="h2">Insert Data Motor</h2>

    <form action="insertdata.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label class="label" for="id">ID:</label>
        <input type="text" id="id" name="id">

        <label class="label" for="image">Image:</label>
        <input type="file" id="image" name="image">

        <label class="label" for="name">Name:</label>
        <input type="text" id="name" name="name">

        <label class="label" for="price">Price:</label>
        <input type="text" id="price" name="price">

        <label class="label" for="description">Description:</label>
        <textarea id="description" name="description"></textarea>

        <label class="label" for="unit">Unit:</label>
        <input type="text" id="unit" name="unit">

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
