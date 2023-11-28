<?php 
require_once("tcpdf/tcpdf.php");

include("Config/db.php");
session_start();


$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Laundry');
$pdf->setTitle('Laporan Pendapatan');
$pdf->setSubject('Laporan Pendapatan');
$pdf->setKeywords('Laporan Pendapatan');

$pdf->setFont('times', '', 11, '', true);

$pdf->AddPage();

if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];

  $result = [
    ['idpesanan' => '', 'tanggal' => '', 'namapelanggan' => '', 'namalayanan' => '', 'kuantitas' => '', 'total' => ''],
    
];

  $content = '<table border="1">
                  <tr>
                      <th>No. Struk</th>
                      <th>Tanggal</th>
                      <th>Nama Pelanggan</th>
                      <th>Nama Layanan</th>
                      <th>Kuantitas</th>
                      <th>Total</th>
                  </tr>';

  foreach ($result as $row) {
      $content .= '<tr>
                      <td>' . $row['idpesanan'] . '</td>
                      <td>' . $row['tanggal'] . '</td>
                      <td>' . $row['namapelanggan'] . '</td>
                      <td>' . $row['namalayanan'] . '</td>
                      <td>' . $row['kuantitas'] . '</td>
                      <td>' . $row['total'] . '</td>
                  </tr>';
  }

  $content .= '</table>';

  $pdf->writeHTML($content, true, false, true, false, '');

  $pdf->Output('laporan pendapatan.pdf', 'I');
}

?>