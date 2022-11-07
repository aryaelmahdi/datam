<?php require "config.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <title>Data Mahasiswa</title>
    <style type="text/css">
        .wrapper{
            width: 950px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 10px;
        }
        .btn-success.focus {
        color: #fff;
        background-color: #449d44;
        border-color: #255625;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="text-center">Data Mahasiswa</h2>
                        <a href="create.php" class="text-center">Tambah Mahasiswa</a>
                    </div>
                    <form method="get">
                        <div class="input-group">
                            <div class="form-outline">
                                <input type="search" name="search" id="form1" placeholder="Cari Mahasiswa" class="form-control"/>
                            </div>
                            <br><br/>
                            <input type="submit" class="btn tn-success:hover pull-right" value="Search">
                            <br><br/>
                        </div>
                    </form>
                    <div class="wrapper">
                        <div class="row">
                        <table class='table table-striped'>
  <thead >
    <tr>
     <th>Nama</th>
     <th>NIM</th>
     <th>Nalai Akhir</th>
    </tr>
   </thead>
   <tbody>
                            <?php
                            $batas = 3;
                            $halaman = @$_GET['halaman'];
                            if(empty($halaman)){
                                $posisi = 0;
                                $halaman = 1;
                            }
                            else{
                                $posisi = ($halaman-1) * $batas;
                            }
                            if(isset($_GET['search'])){
                                $search = $_GET['search'];
                                $sql="SELECT nama,nim,tugas,uts,uas,umur,(tugas+uts+uas)/3 AS nilai_akhir from mahasiswa WHERE nama LIKE '%$search%' order by nim asc limit $posisi, $batas";
                            }else{
                                $sql="SELECT nama,nim,tugas,uts,uas,umur,(tugas+uts+uas)/3 AS nilai_akhir from mahasiswa order by nim asc limit $posisi,$batas";
                            }

                            $hasil=mysqli_query($link, $sql);
                            while ($data = mysqli_fetch_array($hasil)){
                                ?>
                             
 
  
  <tr>
   <td><?= $data['nama'] ?> </td>
   <td><?= $data['nim'] ?></td>
   <td><?= $data['nilai_akhir'] ?> </td>
  
   <td>
    <a href="read.php?nim=<?= $data['nim'] ?>" title='View Record' data-toggle='tooltip'>
    <span>View</span></a>

    <a href="update.php?nim=<?= $data['nim'] ?>"title='Update Record' data-toggle='tooltip'>
    <span>Edit</span></a>

    <a href="delete.php?nim=<?= $data['nim'] ?>"title='Delete Record' data-toggle='tooltip'>
    <span>Delete</span></a>
   </td>
   <?php }
   ?> 
  
  </tr>
  <?php
if(isset($_GET['search'])){
$search = $_GET['search'];
$query2 = "SELECT nama,nim,tugas,uts,uas,umur,(tugas+uts+uas)/3 AS nilai_akhir from mahasiswa WHERE nama LIKE '%$search%' order by nim asc";
}else{
$query2 = "SELECT nama,nim,tugas,uts,uas,umur,(tugas+uts+uas)/3 AS nilai_akhir from mahasiswa order by nim asc";
}
$result2 = mysqli_query($link, $query2);
$jmldata = mysqli_num_rows($result2);
$jmlhalaman = ceil($jmldata/$batas);
?>
</tbody>
</table>

</div>


                        <br>
                        <ul class="pagination">
                            <?php
                            for($i=1;$i<=$jmlhalaman;$i++){
                                if ($i !=$halaman){
                                    if(isset($_GET['search'])){
                                        $search = $_GET['search'];
                                        echo "<li class='page-item'><a class='page-link' href='index.php?halaman=$i&search=$search'>$i</a></li>";
                                    }else{
                                        echo "<li class='page-item'><a class='page-link' href='index.php?halaman=$i'>$i</a></li>";
                                    }

                                }else{
                                    echo "<li class='page-item active'><a class='page-link' href='#'>$i</a></li>";
                                }
                            }
                            ?>
                        </ul>
  
                </div>
            </div>
        </div>
    </div>
</body>
</html>                     