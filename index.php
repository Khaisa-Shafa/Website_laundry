<!-- TODO LIST
. membuat tombol2 berfungsi
. bisa menginputkan pesanan-->

<?php
include("Config/db.php");
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: Akun/masuk.php"); // Redirect to login page
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $namaPelanggan = $_POST['nama_pelanggan'];
  $tanggal = $_POST['tanggal'];
  $nomorTelpon = $_POST['nomor_telpon'];
  $berat = $_POST['berat'];
  $pembayaran = $_POST['pembayaran'];

  // SQL query to insert data into the table
  $sql = "INSERT INTO your_table_name (nama_pelanggan, tanggal, nomor_telpon, berat, pembayaran)
          VALUES ('$namaPelanggan', '$tanggal', '$nomorTelpon', '$berat', '$pembayaran')";

  if ($conn->query($sql) === TRUE) {
      echo "Pesanan telah terekam";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
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
    <link rel="stylesheet" href="Styling/style.css" />
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
                <a href="#data"><button type="button" class="btn">Tambahkan +</button></a>
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
                <a href="#laporan"> <div class="for">
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

    <!-- data start -->
    <section id="data" class="data">
      <div class="inputan">
        <h1>Data Pelanggan</h1>
        <div class="mb-4">
          <!-- make this function to input to database -->
          <form action="submit_data.php" method="POST">
          <label for="namapelanggan" class="form-label">Nama Pelanggan:</label>
          <input type="text" id="namapelanggan" name="nama_pelanggan" required><br><br>
          </div>
      <div class="mb-4">
          <label for="tanggal" class="form-label">Tanggal:</label>
          <input type="text" id="tanggal" name="tanggal" required><br><br>
          </div>
      <div class="mb-4">
          <label for="notelpon" class="form-label">Nomor Telpon:</label>
          <input type="text" id="notelpon" name="notelpon" required><br><br>
          </div>
      <div class="mb-4">
          <label for="pembayaran" class="form-label">Pembayaran:</label>
          <input type="text" id="notelpon" name="notelpon" required><br><br>
      </div>
      <div class="mb-4">
          <label for="diskon" class="form-label">Diskon:</label>
          <input type="number" id="diskon" name="diskon" required><br><br>
      </div>
          <input type="submit" value="Submit">
        </form>


      <div class="tabel1" style="width: 50vw; height: 70vh;">
        <?php
        // Display the table with data
        echo "<table><tr><th>No.</th><th>Layanan</th><th>Harga</th><th>Action</th></tr>";

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
                echo "<input class='tambah' type='submit' name='edit' value='+'>";
                echo "<input class='kurang' type='submit' name='edit' value='-'>";
                echo "</form></td>";
                echo "</tr>";
            }
            echo "<tr><td colspan='4'>". $i. "results</td></tr>";
        } else {
            echo "<tr><td colspan='4'>0 results</td></tr>";
        }
        $stmt ->close();
    }
    else {echo "Error preparing statement" . $conn->error; }
        echo "</table>";}
        ?>
      </div>
     
    
    </section>

    <script src="https://unpkg.com/feather-icons"></script>
    <script>
      feather.replace();
    </script>
    <script src="Script/script.js"></script>
  </body>
</html>
