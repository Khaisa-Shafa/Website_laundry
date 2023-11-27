<?php
include("../Config/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $kode_layanan = '';
    $edited_namalayanan = $_POST['edited_namalayanan' . $kode_layanan];
    $edited_harga = $_POST['edited_harga' . $kode_layanan];

    $update_query = "UPDATE layanan SET namalayanan = '$edited_namalayanan', harga = '$edited_harga' WHERE id=$kode_layanan";

    $check_query = "SELECT * FROM layanan WHERE namalayanan = '$edited_namalayanan'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo "Error: Nama layanan sudah digunakan, silahkan ganti ke nama lain";
    } else {
        if ($conn->query($update_query) === TRUE) {
            echo "Layanan berhasil diubah!";
            // Redirect or perform any other action after successful update
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

?>