<?php
if(isset($_GET["nim"]) && !empty(trim($_GET['nim']))){
	require_once 'config.php';

	$sql = "SELECT nama,nim,tugas,uts,uas,umur,alamat,jenis_kelamin,(tugas+uts+uas)/3 AS nilai_akhir from mahasiswa WHERE nim = ?";

	if($stmt = mysqli_prepare($link, $sql)){
		mysqli_stmt_bind_param($stmt, "i", $param_nim);

		$param_nim = trim($_GET["nim"]);

		if(mysqli_stmt_execute($stmt)){
			$result = mysqli_stmt_get_result($stmt);

			if(mysqli_num_rows($result) == 1){
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$nama = $row["nama"];
				$nim = $row["nim"];
				$tugas = $row["tugas"];
				$uts = $row["uts"];
				$uas = $row["uas"];
				$nilai_akhir = $row["nilai_akhir"];
				$umur = $row["umur"];
				$alamat = $row["alamat"];
				$jenis_kelamin = $row["jenis_kelamin"];
			} else{
				header("location: error.php");
				exit();
			}
		} else {
			echo "oops! something went wrong. please try again later.";
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($link);
} else{
	header("location: error.php");
	exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>VIEW RECORD</title>
	<link rel='stylesheet' href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
		<style type="text/css">
			.wrapper{
				width: 950px;
				margin: auto;
			}
		</style>
	</head>
	<body>
		<div class="wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="page-header">
							<h1 class="text-center"> Data Mahasiswa </h1>
						</div>
						<div class="form-group">
							<label>Nama</label>
							<p class="form-control"><?php echo $row["nama"]; ?></p>
						<div class="form-group">
							<label>NIM</label>
							<p class="form-control"><?php echo $row["nim"]; ?></p>
						<div class="form-group">
							<label>Tugas</label>
							<p class="form-control"><?php echo $row["tugas"]; ?></p>
						</div>
						<div class="form-group">
							<label>UTS</label>
							<p class="form-control"><?php echo $row["uts"]; ?></p>
						<div class="form-group">
							<label>UAS</label>
							<p class="form-control"><?php echo $row["uas"]; ?></p>
						</div>
						<div class="form-group">
							<label>Nilai Akhir</label>
							<p class="form-control"><?php echo $row["nilai_akhir"]; ?></p>
						</div>
						<div class="form-group">
							<label>Umur</label>
							<p class="form-control	"><?php echo $row["umur"]; ?></p>
						</div>
						<div class="form-group">
							<label>Alamat</label>
							<p class="form-control"><?php echo $row["alamat"]; ?></p>
						</div>
						<div class="form-group">
							<label>Jenis Kelamin</label>
							<p class="form-control"><?php echo $row["jenis_kelamin"]; ?></p>
						</div>
						<p><a href="index.php"class="btn btn-default">Back</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>