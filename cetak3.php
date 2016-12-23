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

$msql = "select * from view1 where id = '".$_POST["no_invoice"]."'"; //echo $msql;
$mquery = mysql_query($msql);
$row = mysql_fetch_array($mquery);
$html = '';
$html .= '<table border="0" width="300">';
$html .= '<tr><td>'.$row["nama"].'</td></tr>';
$html .= '<tr><td>'.$row["alamat"].'</td></tr>';
$html .= '<tr><td>'.$row["kota"].' - '.$row["kodepos"].'</td></tr>';
$html .= '<tr><td>&nbsp;</td></tr>';
$html .= '<tr><td>'.$row["no_npwp"].'</td></tr>';
$html .= '<tr><td>&nbsp;</td></tr>';
$html .= '<tr><td><h2><b>INVOICE</b></h2></td></tr>';
$html .= '</table>';
$html .= '<table border="0">';
$html .= '<tr><td width="155">No.</td><td width="485">: '.$row["no_invoice"].'</td></tr>';
$tgl_invoice = strtotime($row["tgl_invoice"]);
$html .= '<tr><td>Tgl.</td><td>: '.date("d", $tgl_invoice).' '.$anamabln_[date("m", $tgl_invoice)].' '.date("Y", $tgl_invoice).'</td></tr>';
$html .= '<tr><td colspan="2">&nbsp;</td></tr>';
//$html .= '&nbsp;'.'<br>';
//$html .= '<table border="0">';
$html .= '<tr><td width="155">No. Order</td><td width="485">: '.$row["no_order"].'</td></tr>';
$html .= '<tr><td>No. Referensi</td><td>: '.$row["no_referensi"].'</td></tr>';
$html .= '<tr><td>Kegiatan</td><td>: '.$row["kegiatan"].'</td></tr>';
$tgl_pelaksanaan = strtotime($row["tgl_invoice"]);
$html .= '<tr><td>Tgl. Pelaksanaan</td><td>: '.date("d", $tgl_pelaksanaan).' '.$anamabln_[date("m", $tgl_pelaksanaan)].' '.date("Y", $tgl_pelaksanaan).'</td></tr>';
$html .= '<tr><td>No. Sertifikat/Laporan</td><td>: '.$row["no_sertfikat"].'</td></tr>';
$html .= '<tr><td colspan="2">&nbsp;</td></tr>';
$html .= '<tr><td>Fee</td><td>:&nbsp;</td></tr>';
$html .= '</table>';

$html .= '<table border="0">';

$total = $row["total"];
$ppn = $row["ppn"];
$total_ppn = $row["total_ppn"];
$keterangan = $row["keterangan"];
$terbilang = $row["terbilang"];

$mquery = mysql_query($msql);
while($row = mysql_fetch_array($mquery)) {
	$html .= '
	<tr>
		<td width="535">
			<table border="0">
				<tr>
					<td width="200">'.$row["nama1"].'</td>
					<td width="105" align="right">'.number_format($row["harga"]).'</td>
					<td width="40" align="center">x</td>
					<td width="40" align="right">'.$row["qty"].'</td>
					<td width="75"> '.$row["satuan"].' </td>
					<td width="75"> '.$row["keterangan1"].' </td>
				</tr>
			</table>
		</td>
		<td align="right" width="105">'.number_format($row["jumlah"]).'</td>
	</tr>
	';
	/*$html .= '
	<tr>
		<td align="right">'.number_format($row["harga"]).'</td>
		<td align="center" width="25">x</td>
		<td align="right" width="30">'.$row["qty"].'</td>
		<td>'.$row["unit"].'</td>
		<td>'.$row["keterangan1"].'</td>
		<td>  =  </td>
		<td align="right">'.number_format($row["jumlah"]).'</td>
	</tr>';*/
}
$html .= '</table>';
$html .= '<table border="0">';
$html .= '
	<tr>
		<td width="155">&nbsp;</td>
		<td width="485">
			<table border="0">
				<tr>
					<td colspan="6"></td>
					<td><hr></td>
				</tr>
			</table>
		</td>
	</tr>
	';
/*$html .= '
	<tr>
		<td>&nbsp;</td>
		<td>
			<table border="0">
				<tr>
					<td colspan="5"></td>
					<td><hr></td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	';*/
$html .= '<tr><td colspan="2">&nbsp;</td></tr>';
$html .= '
	<tr>
		<td width="155">&nbsp;</td>
		<td width="485">
			<table border="0">
				<tr>
					<td colspan="3"></td>
					<td colspan="2">Total</td>
					<td align="center">&nbsp;</td>
					<td align="right">'.number_format($total).'</td>
				</tr>
			</table>
		</td>
	</tr>
	';
$html .= '<tr><td colspan="2">&nbsp;</td></tr>';
$html .= '
	<tr>
		<td>&nbsp;</td>
		<td>
			<table border="0">
				<tr>
					<td colspan="3"></td>
					<td>PPN</td>
					<td align="right">'.$ppn.($ppn != 0 ? " %" : "").'</td>
					<td align="center">&nbsp;</td>
					<td align="right">'.($ppn != 0 ? number_format($total * $ppn/100) : "").'</td>
				</tr>
			</table>
		</td>
	</tr>
	';
$html .= '
	<tr>
		<td>&nbsp;</td>
		<td>
			<table border="0">
				<tr>
					<td colspan="6"></td>
					<td><hr></td>
				</tr>
			</table>
		</td>
	</tr>
	';
$html .= '
	<tr>
		<td>&nbsp;</td>
		<td>
			<table border="0">
				<tr>
					<td colspan="3"></td>
					<td colspan="2">Grand Total</td>
					<td align="center">&nbsp;</td>
					<td align="right">'.number_format($total_ppn).'</td>
				</tr>
			</table>
		</td>
	</tr>
	';
$html .= '<tr><td colspan="2">&nbsp;</td></tr>';
$html .= '<tr><td>Keterangan</td><td>: '.$keterangan.'</td></tr>';
$html .= '<tr><td colspan="2">&nbsp;</td></tr>';
$html .= '<tr><td>Terbilang</td><td>: '.$terbilang.'</td></tr>';
$html .= '</table>';

//echo $html;
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Invoice.pdf', 'I');
?>