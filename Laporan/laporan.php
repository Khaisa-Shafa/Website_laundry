<?php
include("../Config/db.php");
session_start();

// Fetch distinct months and years available in the database
$availableMonths = [];
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT DISTINCT MONTH(tanggal) AS month, YEAR(tanggal) AS year
            FROM pesanan 
            WHERE username = ? 
            ORDER BY year DESC, month DESC"; // Order by year and month

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $monthYear = date("F Y", mktime(0, 0, 0, $row['month'], 1, $row['year']));
            $availableMonths[] = $monthYear;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement" . $conn->error;
    }
}
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
  <!-- Your navigation bar -->
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
 

  <!-- Your table and other HTML content -->
  <section id="laporan" class="laporan">
    <div class="judul">
       <!-- Form for selecting month and year -->
  <form method="GET" action="">
    <label for="month">Select Month:</label>
    <select name="month" id="month">
      <?php
      foreach ($availableMonths as $month) {
        echo "<option value='" . date("m Y", strtotime($month)) . "'>" . $month . "</option>";
      }
      ?>
    </select>
    <button type="submit3" name="submit" class="btn btn-warning">Submit</button>
  </form>
      <h1>Laporan Pendapatan</h1>
      <table id="tabel2" style="width: 80vw;">
        <tr>
            <th>No. </th>
            <th>No. Struk</th>
            <th>Tanggal</th>
            <th>Nama Pelanggan</th>
            <th>Layanan</th>
            <th>Harga</th>
            <th>Kuantitas</th>
            <th>Diskon</th>
            <th>Total</th>
        </tr>

        <?php  
          if (isset($_SESSION['username']) && isset($_GET['submit']) && isset($_GET['month'])) 
          {
            $username = $_SESSION['username'];
            $selected_month_year = $_GET['month']; // Format: "MM YYYY"
            $selected_date = date_create_from_format("m Y", $selected_month_year);

            if ($selected_date !== false) {
                $selected_month = date_format($selected_date, "m");
                $selected_year = date_format($selected_date, "Y");
  
                $sql = "SELECT * FROM pesanan WHERE username = ? AND YEAR(tanggal) = ? AND MONTH(tanggal) = ?";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("sii", $username, $selected_year, $selected_month);
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
                          <td>" . $row["harga"] . "</td>
                          <td>" . $row["kuantitas"] . "</td>
                          <td>" . $row["diskon"] . "</td>
                          <td>" . $row["total"] . "</td>";
                        echo "</tr>";
                    }
                }  else {
                echo "<tr><td colspan='9'>0 results</td></tr>";
              }
            } else {
                {echo "Error preparing statement" . $conn->error; }
                echo "</table>";}}
            else {echo "Invalid month format!";}}
            ?>
      </table>
      <!-- Export button -->
     <!-- Export button -->
<a href="../export.php?month=<?php echo isset($_GET['month']) ? $_GET['month'] : ''; ?>" class="btn btn-outline-primary" type="submit2">Export To PDF</a>

     <?php 
      if (isset($_POST['export'])){
        header("location:export.php");
      }
     ?>
    </div>
  </section>

  <!-- Your scripts and closing tags -->
  <script src="https://unpkg.com/feather-icons"></script>
  <script>
    feather.replace();
  </script>
  <script src="script.js"></script>
</body>
</html>
