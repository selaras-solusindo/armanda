<?php

//echo "no_invoice " . $_POST["no_invoice"];

if (!$_POST["msubmit"]) {
	header("location: .");
}

if ($_POST["no_invoice"] == "0") {
	header("location: .");
}

$hostname_conn = "localhost";
$database_conn = "db_armanda"; //$database_conn = "zecorind_mitra2";
$username_conn = "root"; //$username_conn = "zecorind_root";
$password_conn = "admin";

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

echo $html;
?>