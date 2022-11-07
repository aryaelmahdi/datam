<?php
$db_host = 'localhost'; 
$db_user = 'root'; 
$db_pass = ''; 
$db_name = 'akademik'; 

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
	die ('Gagal terhubung MySQL: ' . mysqli_connect_error());	
}

$sql = 'SELECT nama,nim,tugas,uts,uas,tugas+uts+uas/3 AS nilai_akhir
FROM mahasiswa';
		
$query = mysqli_query($conn, $sql);

if (!$query) {
	die ('SQL Error: ' . mysqli_error($conn));
}

echo '<!DOCTYPE html>
<html lang="en">
<head>
 	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> DATA AKADEMIK MAHASISWA </title>
    	<style>
    		body {
    			font-family:verdana. tohama; 
    		}
    		table {
    			border-collapse: collapse;
    		}
    		th, td {
    			font-size: 13px;
    			border: 1px solid #116466;
    			padding: 3px 5px;
    			text-align: center;
    			color: #D1E8E2;
    			background:#D9B08C;
    		}
    		.subtotal td {
    			background: #D9B08C;
    		}
    		.right {
    			text-align: right:
    		}
    		.mid{
    			margin: auto;
    			width: 50%;
    			border: 3px solid black;
    			padding: 10px;
    		}
    	</style>
    	</head>
    	<body>
    		<table class= "mid">
    			<thead>
    				<tr>
    					<th>Nama</th>
    					<th>NIM</th>
    					<th>Tugas</th>
    					<th>UTS</th>
    					<th>UAS</th>
    					<th>Nilai Akhir</th>
    				</tr>
    			</thead>
    	</tbody>';

		
while ($row = mysqli_fetch_array($query))
{
	echo '<tr>
    	
			<td>'.$row['nama'].'</td>
			<td>'.$row['nim'].'</td>
			<td>'.$row['tugas'].'</td>
			<td>'.$row['uts'].'</td>
			<td>'.$row['uas'].'</td>
			<td class="right">'.number_format($row['nilai_akhir'], 0, ',', '.').'</td>
		</tr>';
}
echo '
	</tbody>
</table>
</body>
</html>';


mysqli_free_result($query);


mysqli_close($conn);