<?php 
include("../Config/db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['namalayanan'], $_POST['harga'])) {
    $namalayanan = $_POST['namalayanan'] ?? '';
    $harga = $_POST['harga'] ?? '';

    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        
        $insert_query = "INSERT INTO layanan (namalayanan, harga, username) VALUES (?, ?, ?)";
        
        // Prepare and bind the statement
        if ($stmt = $conn->prepare($insert_query)) {
            $stmt->bind_param("sss", $namalayanan, $harga, $username);
            
            if ($stmt->execute()) {
                echo "Layanan berhasil ditambahkan!";
                // Redirect to layanan.php after successful insertion
                header("Location: layanan.php");
                exit(); // Ensure that no other output is sent
            } else {
                echo "Error: " . $conn->error;
            }
            
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Error: Session username not found.";
    }
}
?>
