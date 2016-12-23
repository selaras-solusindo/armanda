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
//$pdf->AddPage("L", "A5");
$pdf->AddPage();

//echo "no_invoice " . $_POST["no_invoice"];

if (!$_POST["msubmit"]) {
	header("location: .");
}

if ($_POST["no_kuitansi"] == "0") {
	header("location: .");
}

include("conn.php");

mysql_connect($hostname_conn, $username_conn, $password_conn) or die ("Tidak bisa terkoneksi ke Database server");
mysql_select_db($database_conn) or die ("Database tidak ditemukan");

// array nama bulan
$anamabln_ = array(
  1 => "Januari",
  "Februari",
  "Maret",
  "April",
  "Mei",
  "Juni",
  "Juli",
  "Agustus",
  "September",
  "Oktober",
  "November",
  "Desember"
  );

$msql = "select * from view2 where kuitansi_id = '".$_POST["no_kuitansi"]."'"; //echo $msql;
$mquery = mysql_query($msql);
$row = mysql_fetch_array($mquery);
$html = '';
$html .= '<table border="0">';
$html .= '<tr><td width="485">&nbsp;</td><td>Kuitansi No. '.$row["no_kuitansi"].'</td></tr>';
$html .= '</table>';
$html .= '<table border="0">';
$html .= '<tr><td width="155">Sudah terima dari</td><td width="485">: '.$row["nama"].'</td></tr>';
$html .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
$html .= '<tr><td width="155">Uang sejumlah</td><td>: '.$row["terbilang1"].' rupiah</td></tr>';
$html .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
$html .= '<tr><td width="155">Untuk Pembayaran</td><td>: '.$row["keterangan1"].'</td></tr>';
$html .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
$html .= '<tr><td width="155">&nbsp;</td><td>No. Invoice : '.$row["no_invoice"].'</td></tr>';
$html .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
$html .= '<tr><td width="155">&nbsp;</td><td>No. Sertifikat : '.$row["no_sertifikat"].'</td></tr>';
$html .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
$html .= '<tr><td width="155">&nbsp;</td><td>NO. ACC. CV. ARMADA NUSANTARA</td></tr>';
$html .= '<tr><td width="155">&nbsp;</td><td>512 - 015691 - 0  BANK BCA CABANG PRAPEN</td></tr>';
$html .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
$html .= '</table>';
$html .= '<table border="0">';
$tgl_invoice = strtotime($row["tgl_invoice"]);
$html .= '<tr><td width="435">&nbsp;</td><td>Surabaya, '.date("d", $tgl_invoice).' '.$anamabln_[date("m", $tgl_invoice)].' '.date("Y", $tgl_invoice).'</td></tr>';
$html .= '</table>';
$html .= '<table border="0">';
$html .= '<tr><td width="155" align="right">Rp.</td><td> '.number_format($row["total_ppn1"]).'</td></tr>';

//echo $html;
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Invoice.pdf', 'I');
?>