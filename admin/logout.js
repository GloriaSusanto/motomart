// Fungsi untuk logout
document.getElementById("logoutBtn").addEventListener("click", function() {
    // Mengarahkan pengguna kembali ke halaman index.php di dalam folder Final
    window.location.href = "../login/index.php";
});

// Fungsi untuk menuju halaman insertdata.php
document.getElementById("insertDataBtn").addEventListener("click", function() {
    // Mengarahkan pengguna ke halaman insertdata.php
    window.location.href = "insertdata.php";
});