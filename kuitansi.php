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
		<form method="post" action="kuitansi2.php">
			Pilih No. Kuitansi :
			<select name="no_kuitansi">
				<option value="0">No. Kuitansi</option>
				<?php
				$msql = "select * from tb_kuitansi";
				$mquery = mysql_query($msql);
				while($row = mysql_fetch_array($mquery)) {
					?>
				<option value="<?php echo $row["kuitansi_id"]?>"><?php echo $row["no_kuitansi"]?></option>
					<?php
				}
				?>
			</select>
			<input type="submit" name="msubmit" value="Submit">&nbsp;<input type="button" name="mback" value="Back" onclick="window.location.href='.'">
		</form>
	</body>
</html>


