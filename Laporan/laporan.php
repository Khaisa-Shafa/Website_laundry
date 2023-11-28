<?php 
include("../Config/db.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rokkitt:ital,wght@0,100;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
  <!-- navbar start -->
  <nav class="position-fixed z-1 start-0 end-0 navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="../index.php">LAUNDRY</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a href="../index.php#data" class="btn-link">
              <button type="button" class="btn">Tambahkan +</button>
          </a>  
          </li>
          <li class="nav-item">
            <a class="admin" aria-current="page" href="../Layanan/layanan.php"><img src="../Styling/user-regular.svg" alt="user"></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- navbar end -->

  <!-- laporan start -->
  <section id="laporan" class="laporan">
    <div class="judul">
      <h1>Laporan Pendapatan</h1>
        <table id="tabel2" style="width: 80vw; height: 70vh;">
        <tr>
            <th>No. </th>
            <th>No. Struk</th>
            <th>Tanggal</th>
            <th>Nama Pelanggan</th>
            <th>Layanan</th>
            <th>kuantitas</th>
            <th>Total</th>
          </tr>

        <?php  
          if (isset($_SESSION['username'])) 
          {
            $username = $_SESSION['username'];

            $sql = "SELECT * FROM pesanan WHERE username = ?";
            if ($stmt = $conn->prepare($sql)) 
            {
              $stmt->bind_param("s", $username);
              $stmt->execute();
              $result = $stmt->get_result();
                  if ($result->num_rows > 0) 
                  {
                    $i = 0;
                    while ($row = $result->fetch_assoc()) 
                    {
                      $i++;
                      echo 
                        "<tr>
                          <td>" . $i . "</td>
                          <td>" . $row["idpesanan"] . "</td>
                          <td>" . $row["tanggal"] . "</td>
                          <td>" . $row["namapelanggan"] . "</td>
                          <td>" . $row["namalayanan"] . "</td>
                          <td>" . $row["kuantitas"] . "</td>
                          <td>" . $row["total"] . "</td>";
                        echo "<td><form method='post' action=''>";
                        echo "<input type='hidden' name='kode_layanan' value='" . $i . "'>";
                        echo "</form></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>0 results</td></tr>";
                }
                $stmt ->close();
            }
            else {echo "Error preparing statement" . $conn->error; }
                echo "</table>";}
                ?>
        </table>
        <a href="../export.php" name="export" target="_blank" class="btn btn-outline-primary" type="submit1">Export To PDF</a>
     <?php 
      if (isset($_POST['export'])){
        
        header("location:export.php");
      }
     ?>
      </div>
  </section>
  <!-- laporan end -->

  <script src="https://unpkg.com/feather-icons"></script>
  <script>
    feather.replace();
  </script>
  <script src="script.js"></script>
</body>
</html>