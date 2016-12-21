<?php
//============================================================+
// File name   : example_002.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 002 for TCPDF class
//               Removing Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Removing Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Armanda');
$pdf->SetTitle('Invoice');
$pdf->SetSubject('Invoice');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
//$pdf->SetFont('times', 'BI', 20);

// add a page
$pdf->AddPage();

//echo "no_invoice " . $_POST["no_invoice"];

if (!$_POST["msubmit"]) {
	header("location: .");
}

if ($_POST["no_invoice"] == "0") {
	header("location: .");
}

include("conn.php");

mysql_connect($hostname_conn, $username_conn, $password_conn) or die ("Tidak bisa terkoneksi ke Database server");
mysql_select_db($database_conn) or die ("Database tidak ditemukan");

$msql = "select * from view1 where id = '".$_POST["no_invoice"]."'"; //echo $msql;
$mquery = mysql_query($msql);
$row = mysql_fetch_array($mquery);
$html = '';
$html .= $row["nama"].'<br>';
$html .= $row["alamat"].'<br>';
$html .= $row["kota"].' - '.$row["kodepos"].'<br>';
$html .= '&nbsp;'.'<br>';
$html .= $row["no_npwp"].'<br>';
$html .= '&nbsp;'.'<br>';
$html .= '&nbsp;'.'<br>';
$html .= '<b>INVOICE</b><br>';
$html .= 'No. '.$row["no_invoice"].'<br>';
$html .= 'Tgl. '.$row["tgl_invoice"].'<br>';
$html .= '&nbsp;'.'<br>';
$html .= 'No. Order '.$row["no_order"].'<br>';
$html .= 'No. Referensi '.$row["no_referensi"].'<br>';
$html .= 'Kegiatan '.$row["kegiatan"].'<br>';
$html .= 'Tgl. Pelaksanaan '.$row["tgl_pelaksanaan"].'<br>';
$html .= 'No. Sertifikat/Laporan '.$row["no_sertfikat"].'<br>';
$html .= '&nbsp;'.'<br>';
$html .= 'Fee :<br>';

$total = $row["total"];
$ppn = $row["ppn"];
$total_ppn = $row["total_ppn"];
$keterangan = $row["keterangan"];
$terbilang = $row["terbilang"];

$mquery = mysql_query($msql);
while($row = mysql_fetch_array($mquery)) {
	$html .= $row["harga"].'  x  '.$row["qty"].'  '.$row["unit"].'  '.$row["keterangan1"].'  =  '.$row["jumlah"].'<br>';
}

$html .= 'Total '.$total.'<br>';
$html .= 'PPN '.$ppn.'<br>';
$html .= 'Total setelah PPN '.$total_ppn.'<br>';
$html .= 'Keterangan '.$keterangan.'<br>';
$html .= 'Terbilang '.$terbilang.'<br>';

//echo $html;
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('example_006.pdf', 'I');
?>