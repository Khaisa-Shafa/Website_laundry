<!-- PR -->
<?php
include("../Config/db.php");
session_start();

// Function to handle service deletion
if (isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];

    $delete_query = "DELETE FROM layanan WHERE id = ?";
    
    if ($stmt = $conn->prepare($delete_query)) {
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Layanan berhasil dihapus!";
                header("Location: layanan.php");
            exit();
            } else {
                echo "No rows were affected. Maybe the ID doesn't exist.";
            }
        } else {
            echo "Error: " . $conn->error;
        }
        
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>