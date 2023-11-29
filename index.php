<?php
include("Config/db.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: Akun/masuk.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaPelanggan = $_POST['nama_pelanggan'];
    $tanggal = $_POST['tanggal'];
    $namaLayanan = $_POST['namalayanan'];
    $kuantitas = $_POST['kuantitas'];
    $diskon = $_POST['diskon'];
    $pembayaran = $_POST['pembayaran'];
    $username = $_SESSION['username'];

    $fetchPriceQuery = "SELECT harga FROM layanan WHERE namalayanan = ?";
    $stmtPrice = $conn->prepare($fetchPriceQuery);
    $stmtPrice->bind_param("s", $namaLayanan);
    $stmtPrice->execute();
    $result = $stmtPrice->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $harga = $row['harga'];

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
        echo "Service not found";
    }
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
        <a class="navbar-brand" href="index.php">LAUNDRY</a>
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
                        //OPERASI TAMBAH HANYA DI HARI TERSEBUT
                        ?>
                        <h2>RP XX.XXX</h2> 
                    </div>

                    <div class="box2">
                        <h2>Total pelanggan hari ini</h2>
                        <?php
                        //OPERASI TAMBAH HANYA DI HARI TERSEBUT
                        ?>
                        <h2>XX</h2>
                    </div>
                </div>
                <a href="Laporan/laporan.php"> <div class="for">
                <div class="box3">
                <img src="Styling/file-lines-regular.svg" alt="laporan">
                    <h2>Laporan</h2>
                </div>
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
        <!-- Your form for ordering services -->
        <form action="Laporan/laporan.php" method="POST">
            <label for="nama_pelanggan" class="form-label">Nama Pelanggan :</label>
            <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="inputan_box" required><br><br>

            <label for="tanggal" class="form-label">Tanggal :</label>
            <input type="text" id="tanggal" name="tanggal" class="inputan_box" required><br><br>

            <label for="diskon" class="form-label">Diskon :</label>
            <input type="number" id="diskon" name="diskon" class="inputan_box" required><br><br>

            <label for="pembayaran" class="form-label">Pembayaran :</label>
            <input type="text" id="pembayaran" name="pembayaran" class="inputan_box" required><br><br>

            <button type="submit1" name="submit" class="btn btn-primary">Submit</button>
    </div>      
        </form>


<table id="tabel1">
<?php
    echo "<tr>
            <th>No.</th>
            <th>Layanan</th>
            <th>Harga</th>
            <th>Action</th>
        </tr>";

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
                    echo "<td><form method='post' action=''>";
                    echo "<input type='hidden' name='kode_layanan' value='" . $i . "'>"; 

                    echo "<button class='tambah' onclick='updateQuantity(\"" . $row["namalayanan"] . "\", 1)'>+</button>";
                    echo "<button class='kurang' onclick='updateQuantity(\"" . $row["namalayanan"] . "\", -1)'>-</button>";
                    echo "</form></td></tr>";
                }
            } else {
                echo "<tr><td colspan='4'>0 results</td></tr>";
            }
            $stmt->close();
        } else {
            echo "Error preparing statement" . $conn->error;
        }
    }
?>
</table>

</section>

<!-- ... (your JavaScript and other scripts) -->
<script src="https://unpkg.com/feather-icons"></script>
    <script>
      feather.replace();
      // JavaScript section or your external script file

// Initialize an object to store the quantities for each service
let serviceQuantities = {};

function updateQuantity(serviceName, increment) {
    // Check if the service name exists in the object, if not, initialize it with a quantity of 0
    if (!(serviceName in serviceQuantities)) {
        serviceQuantities[serviceName] = 0;
    }

    // Update the quantity based on the increment
    serviceQuantities[serviceName] += increment;

    // Ensure the quantity doesn't go below 0
    if (serviceQuantities[serviceName] < 0) {
        serviceQuantities[serviceName] = 0;
    }

    // Update the displayed quantity (you might have a place to display this on your page)
    console.log(`Service: ${serviceName}, Quantity: ${serviceQuantities[serviceName]}`);
}

    </script>
    <script src="Script/script.js"></script>
</body>
</html> 