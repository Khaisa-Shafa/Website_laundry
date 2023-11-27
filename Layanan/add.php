<?php 
include("../Config/db.php");
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add'])) {
    $kode_layanan="";
    $namalayanan = $_POST['namalayanan'];
    $harga = $_POST['harga'];

    // Check namalayanan
    $check_query = "SELECT * FROM layanan WHERE namalayanan = '$namalayanan'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo "Error: Nama layanan sudah digunakan, silahkan ganti ke nama lain";
    } else {
        $insert_query = "INSERT INTO layanan (namalayanan, harga) VALUES ('$namalayanan', '$harga')";
        if ($conn->query($insert_query) === TRUE) {
            echo "Layanan berhasil ditambahkan!";
            // Redirect or perform any other action after successful insertion
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>