<?php 
//echo "hello world";
include("conn.php");
mysql_connect($hostname_conn, $username_conn, $password_conn) or die ("Tidak bisa terkoneksi ke Database server");
mysql_select_db($database_conn) or die ("Database tidak ditemukan");
?>

<html>
	<head>
	</head>
	<body>
		<form method="post" action="cetak3.php">
			Pilih No. Invoice :
			<select name="no_invoice">
				<option value="0">No. Invoice</option>
				<?php
				$msql = "select * from tb_invoice";
				$mquery = mysql_query($msql);
				while($row = mysql_fetch_array($mquery)) {
					?>
				<option value="<?php echo $row["id"]?>"><?php echo $row["no_invoice"]?></option>
					<?php
				}
				?>
			</select>
			<input type="submit" name="msubmit" value="Submit">&nbsp;<input type="button" name="mback" value="Back" onclick="window.location.href='.'">
		</form>
	</body>
</html>
