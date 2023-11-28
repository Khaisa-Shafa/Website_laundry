<?php
include("../Config/db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    // Assuming 'id' is sent from the form
    $kode_layanan = $_POST['id'];
    $edited_namalayanan = $_POST['edited_namalayanan_' . $kode_layanan] ?? '';
    $edited_harga = $_POST['edited_harga_' . $kode_layanan] ?? '';

    // Use prepared statements to prevent SQL injection
    $update_query = "UPDATE layanan SET namalayanan = ?, harga = ? WHERE id = ?";
    
    // Prepare and bind
    if ($stmt = $conn->prepare($update_query)) {
        $stmt->bind_param("ssi", $edited_namalayanan, $edited_harga, $kode_layanan);

        // Execute the update query
        if ($stmt->execute()) {
            // Check if any rows were affected by the update
            if ($stmt->affected_rows > 0) {
                echo "Layanan berhasil diubah!";
                header("Location: layanan.php");
            exit();
            } else {
                echo "No rows were affected. Maybe the ID doesn't exist or the data is unchanged.";
            }
        } else {
            echo "Error: " . $conn->error;
        }
        
        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>