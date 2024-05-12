<?php
// Inisialisasi variabel
$email = $password = $role = ""; // Tentukan nilai awal untuk variabel

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari formulir
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"]; // Ambil peran yang dipilih

    // Buat koneksi ke database
    $servername = "localhost";
    $username = "phpmyadmin";
    $db_password = "glo07Joy15_31"; // Ubah nama variabel dari $password menjadi $db_password
    $dbname = "db_motor";
    $conn = new mysqli($servername, $username, $db_password, $dbname); // Gunakan $db_password untuk koneksi database

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mencari pengguna berdasarkan email
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND role = '$role'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Pengguna ditemukan, arahkan ke halaman dashboard admin atau halaman pembelian user
        $row = $result->fetch_assoc();
        $user_id = $row['id']; // Ambil user_id dari kolom 'id'
        if ($role == 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../user/beli.php");
        }
        exit();
    } else {
        // Pengguna tidak ditemukan atau kombinasi email/kata sandi tidak sesuai
        $error_message = "Email, kata sandi, atau peran tidak valid.";
    }

    // Tutup koneksi ke database
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login MotoMart</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Masukkan CSS Anda di sini -->
    <link href="login.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sigmar+One&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sigmar+One&display=swap" rel="stylesheet">
</head>
<body class="background">
    <div class="container">
        <p class="login">Login</p>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label class="sub-header" for="role">Pilih Peran</label>
            <select id="role" name="role" required>
                <option class="sub-header" value="admin">Admin</option>
                <option class="sub-header" value="user">User</option>
            </select>
            
            <label class="sub-header" for="email">Alamat Surel</label>
            <input type="email" id="email" name="email" placeholder="Alamat Surel" required>

            <label class="sub-header" for="password">Kata Sandi</label>
            <input type="password" id="password" name="password" placeholder="********" required>

            <?php if(isset($error_message)) { ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php } ?>

            <button class="submit-button" type="submit">Masuk</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
