<?php 
require_once("tcpdf/tcpdf.php");
include("Config/db.php");
session_start();

if (isset($_SESSION['username']) && isset($_GET['month'])) {
  $username = $_SESSION['username'];
  $selected_month_year = $_GET['month']; // Format: "MM YYYY"
  $selected_date = date_create_from_format("m Y", $selected_month_year);

  if ($selected_date !== false) {
    $selected_month = date_format($selected_date, "m");
    $selected_year = date_format($selected_date, "Y");

    $sql = "SELECT idpesanan, tanggal, namapelanggan, namalayanan, harga, kuantitas, diskon, total 
            FROM pesanan 
            WHERE username = ? AND YEAR(tanggal) = ? AND MONTH(tanggal) = ?";
    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("sii", $username, $selected_year, $selected_month);
      $stmt->execute();
      $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

      // set document information
      $pdf->setCreator(PDF_CREATOR);
      $pdf->setAuthor('Laundry');
      $pdf->setTitle('Laporan Pendapatan');
      $pdf->setSubject('Laporan Pendapatan');
      $pdf->setKeywords('Laporan Pendapatan');

      $pdf->setFont('times', '', 11, '', true);

      $pdf->AddPage();

      // Generate PDF table content from fetched data
      $content = '<table border="1">
                    <tr>
                      <th>No. Struk</th>
                      <th>Tanggal</th>
                      <th>Nama Pelanggan</th>
                      <th>Layanan</th>
                      <th>Harga</th>
                      <th>Kuantitas</th>
                      <th>Diskon</th>
                      <th>Total</th>
                    </tr>';

      foreach ($result as $row) {
        $content .= '<tr>
                        <td>' . $row['idpesanan'] . '</td>
                        <td>' . $row['tanggal'] . '</td>
                        <td>' . $row['namapelanggan'] . '</td>
                        <td>' . $row['namalayanan'] . '</td>
                        <td>' . $row['harga'] . '</td>
                        <td>' . $row['kuantitas'] . '</td>
                        <td>' . $row['diskon'] . '</td>
                        <td>' . $row['total'] . '</td>
                    </tr>';
      }

      $content .= '</table>';

      $pdf->writeHTML($content, true, false, true, false, '');

      // Output the PDF file
      $filePath = 'laporan_pendapatan.pdf';
      $pdf->Output($filePath, 'I'); // Save the PDF file on the server

      // Check if the file is generated and initiate download
      if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
      }
    }
  }
}

// If PDF generation fails or conditions not met, redirect to a suitable location
header("Location: index.php");
exit;
?>
