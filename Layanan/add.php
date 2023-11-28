<?php 
include("../Config/db.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['namalayanan'], $_POST['harga'])) {
    // $kode_layanan = $_POST['id'] ?? ''; // If you have an 'id' field in your form
    $namalayanan = $_POST['namalayanan'] ?? '';
    $harga = $_POST['harga'] ?? '';

     // Check if 'username' exists in the session
     if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        
        // Now you can use $username in your SQL query
        $insert_query = "INSERT INTO layanan (namalayanan, harga, username) VALUES ('$namalayanan', '$harga', '$username')";
        
        if ($conn->query($insert_query) === TRUE) {
            echo "Layanan berhasil ditambahkan!";
            header("Location: layanan.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: Session username not found.";
    }
}
?>