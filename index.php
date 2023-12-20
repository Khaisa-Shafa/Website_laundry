<?php
include("Config/db.php");
session_start();
$totalResult = null;

if (!isset($_SESSION['username'])) {
    header("Location: Akun/masuk.php");
    exit();
}

// Modify the PHP code to retrieve quantities from the serviceQuantities object
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nama_pelanggan'], $_POST['tanggal'], $_POST['diskon'], $_POST['pembayaran'], $_POST['namalayanan'], $_POST['kuantitas'])) {
    $namaPelanggan = $_POST['nama_pelanggan'];
    $tanggal = $_POST['tanggal'];
    $diskon = $_POST['diskon'];
    $pembayaran = $_POST['pembayaran'];
    $username = $_SESSION['username'];

    $serviceNames = $_POST['namalayanan'];
    $quantities = $_POST['kuantitas'];

    // Loop through the service names array
    for ($i = 0; $i < count($serviceNames); $i++) {
        $serviceName = $serviceNames[$i];
        $quantity = $quantities[$i];

        // Use the service name to fetch the service's price from the database
        $fetchPriceQuery = "SELECT * FROM layanan WHERE namalayanan = ?";
        $stmtPrice = $conn->prepare($fetchPriceQuery);
        $stmtPrice->bind_param("s", $serviceName);
        $stmtPrice->execute();
        $result = $stmtPrice->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $harga = $row['harga'];

            // Calculate the total price for this specific service
            $total = ($harga * $quantity) - $diskon;
            $stmtInsert->bind_param("sssiidiis", $tanggal, $namaPelanggan, $serviceName, $harga, $quantity, $diskon, $total, $pembayaran, $username);

            // Insert the details (including quantity) into the database
            $insertQuery = "INSERT INTO pesanan (tanggal, namapelanggan, namalayanan, harga, kuantitas, diskon, total, pembayaran, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($insertQuery);

            if ($stmtInsert->execute()) {
                
            } else {
                echo "Error inserting data: " . $stmtInsert->error;
            }
        } else {
            echo "Service not found for: " . $namalayanan;
        }
    }
    $totalSumQuery = "SELECT SUM(total) AS totalSum FROM pesanan WHERE DATE(tanggal) = CURDATE() AND username = ?";
            $stmtTotal = $conn->prepare($totalSumQuery);
            $stmtTotal->bind_param("s", $username);
            $stmtTotal->execute();
        $totalResult = $stmtTotal->get_result();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laundry</title>
    <link rel="stylesheet" href="style.css" />
    <style><?php include 'style.css'; ?></style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rokkitt:ital,wght@0,100;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   
</head>
<body>
<!-- navbar start -->
<nav class="position-fixed z-1 start-0 end-0 navbar navbar-expand-lg ">
    <div class="container">
        <a class="navbar-brand" href="index.php">LAUNDRYKUY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                
                <li class="nav-item">
                <a href="index.php#data"><button type="button" class="btn">Tambahkan +</button></a>
                </li>
                <li class="nav-item">
                <a class="admin" aria-current="page" href="Layanan/layanan.php"><img src="Styling/user-regular.svg" alt="user"></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- navbar end -->

<!-- home start -->
    <section id="home" class="home">
        <div class="all">
            <div class="hero">
                <h1>Dashboard</h1> 
                <div class="box">
                    <div class="box1">
                    <h2>Transaksi hari ini</h2>
                    <?php
                        $totalSumQuery = "SELECT SUM(total) AS totalSum FROM pesanan WHERE DATE(tanggal) = CURDATE() AND username = ?";
                        $stmtTotal = $conn->prepare($totalSumQuery);
                        $stmtTotal->bind_param("s", $username);
                        $stmtTotal->execute();
                        $totalResult = $stmtTotal->get_result();
                        
                        if ($totalResult && $totalResult->num_rows > 0) {
                            $totalRow = $totalResult->fetch_assoc();
                            $totalSum = $totalRow['totalSum'];
                            
                            echo "Rp " . number_format($totalSum, 0);
                        } else {
                            echo "Rp 0,000";
                        }
                    ?>
                    </div>

                    <div class="box2">
                        <h2>Total pelanggan hari ini</h2>
                        <?php
                            $totalSumQuery = "SELECT count(idpesanan) AS totalSum FROM pesanan WHERE DATE(tanggal) = CURDATE() AND username = ?";
                            $stmtTotal = $conn->prepare($totalSumQuery);
                            $stmtTotal->bind_param("s", $username);
                            $stmtTotal->execute();
                            $totalResult = $stmtTotal->get_result();
                            
                            if ($totalResult && $totalResult->num_rows > 0) {
                                $totalRow = $totalResult->fetch_assoc();
                                $totalSum = $totalRow['totalSum'];
                                
                                echo number_format($totalSum, 0) . " orang";
                            } else {
                                echo "0 orang";
                            }
                        ?>
                    </div>
                </div>
                <a href="Laporan/laporan.php">
                    <div class="for">
                    <img src="Styling/file-lines-regular.svg" alt="laporan">
                    <h2>Laporan</h2>
                </a>
            </div>
        </div>
        <div class="hero2">
            <img src="Styling/LAUNDRY.png" alt="">
        </div>
    </section>
<!-- home end -->
<!-- ... (your navbar and other HTML content) -->

<section id="data" class="data">
    <div class="inputan">
        <h1>Data Pelanggan</h1>
        <form action="" method="POST">
        <!-- Your form for ordering services -->
            <label for="nama_pelanggan" class="form-label">Nama Pelanggan :</label>
            <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="inputan_box" required><br><br>

            <label for="tanggal" class="form-label">Tanggal :</label>
            <input type="date" id="tanggal" name="tanggal" class="inputan_box" required><br><br>

            <label for="diskon" class="form-label">Diskon :</label>
            <input type="number" id="diskon" name="diskon" class="inputan_box" required><br><br>

            <label for="pembayaran" class="form-label">Pembayaran :</label>
            <input type="text" id="pembayaran" name="pembayaran" class="inputan_box" required><br><br>
            

            <label for="namalayanan" class="form-label">Nama Layanan :</label>
            <select id="namalayanan" name="namalayanan[]" class="inputan_box" required>
                <?php
                $username = $_SESSION['username'];
                $sql = "SELECT namalayanan FROM layanan WHERE username = ?";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("s", $username);
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $serviceName = $row["namalayanan"];
                                echo "<option value='$serviceName'>$serviceName</option>";
                            }
                        } else {
                            echo "<option value='' disabled>No services available</option>";
                        }
                    } else {
                        echo "Error executing statement: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "Error in preparing statement: " . $conn->error;
                }
                ?>
</select>

            
            <label for="kuantitas" class="form-label">Kuantitas :</label>
            <input type="number" id="kuantitas" name="kuantitas[]" class="inputan_box" required><br><br>

            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
    </div>

</section>

<!-- ... (your JavaScript and other scripts) -->
<script src="https://unpkg.com/feather-icons"></script>
    </body>
</html> 