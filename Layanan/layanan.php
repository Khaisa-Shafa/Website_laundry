<!-- LIST TODO 
. fitur hapus belum ada
. tombol masi error (mungkin karna belum login, tablenya bingung username/laundry siapa)
. css belum siap pakai
. ngetes create, read, update, delete API -->


<?php
include("../Config/db.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Styling/layanan.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rokkitt:ital,wght@0,100;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <!-- navbar start -->
    <nav class="position-fixed z-1 start-0 end-0 navbar navbar-expand-lg ">
    <div class="container">
        <a class="navbar-brand" href="../index.php">LAUNDRY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="admin" aria-current="page" href="../Layanan/layanan.php"><img src="../Styling/user-regular.svg" alt="user"></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <!-- navbar end -->

    <!-- section layanan -->
    <div>
    <div class="tabel">
            <table id="tabel1" style="width: 50%;">
                <tr>
                    <th>No.</th>
                    <th>Layanan</th>
                    <th>Harga</th>
                    <th></th>
                </tr>

                <?php
                if (isset($_SESSION['username'])) {
                    $username = $_SESSION['username'];
                
                    $sql = "SELECT * FROM layanan WHERE username = ?";
                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        $i++;
                        echo "<tr><td>" . $i . "</td><td>" . $row["namalayanan"] . "</td><td>" . $row["harga"] . "</td>";
                        echo "<td>";
                        echo "<form method='post' action='edit.php'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                        echo "<input type='text' name='edited_namalayanan_" . $row['id'] . "' placeholder='Nama Layanan' required>";
                        echo "<input type='number' name='edited_harga_" . $row['id'] . "' placeholder='Harga' required>";
                        echo "<input type='submit' class='update' name='update' value='Update'>";
                        echo "</form>";
                        // Form for service deletion
                        
                        echo "<form method='post' action='delete.php'>";
                        echo "<input type='hidden' name='delete_id' value='" . $row['id'] . "'>";
                        echo "<input type='submit' class='delete' name='delete' value='Delete'>";
                        echo "</form>";
                    
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "<tr><td colspan='4'>" . $i . " results</td></tr>";
                } else {
                    echo "<tr><td colspan='4'>0 results</td></tr>";
                }
                $stmt->close();
            }else {
                echo "Error preparing statement" . $conn->error; 
            }}
                ?>

                <?php
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $harga = $row['harga'];
                
                    // Pastikan $harga memiliki nilai sebelum digunakan
                    if ($harga !== null) {
                        $total = ($harga * $kuantitas) - $diskon;
                
                        $insertQuery = "INSERT INTO pesanan (tanggal, namapelanggan, namalayanan, harga, kuantitas, diskon, total, pembayaran, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmtInsert = $conn->prepare($insertQuery);
                        $stmtInsert->bind_param("sssiidiis", $tanggal, $namaPelanggan, $namaLayanan, $harga, $kuantitas, $diskon, $total, $pembayaran, $username);
                        
                        if ($stmtInsert->execute()) {
                            echo "Data inserted successfully";
                        } else {
                            echo "Error inserting data: " . $stmtInsert->error;
                        }
                    } else {
                        echo "Harga tidak valid";
                    }
                } else {
                    echo "Service not found";
                }                
                ?>
                <tr>
                    <td colspan='4'>
                        <form method='post' action='add.php' class='addform'>
                            <input type="text" name="namalayanan" placeholder="Nama Layanan" required>
                            <input type="number" name="harga" placeholder="Harga" required>
                            <input type="submit" name="add" value="Tambah Layanan">
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
