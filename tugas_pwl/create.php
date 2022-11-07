<?php
// Include config file
require_once "config.php";

//Tentukan variabel dan inisialisasi dengan nilai kosong
$nama = $nim = $tugas = $uts = $uas = $umur = $alamat = $jenis_kelamin = "";
$nama_err = $nim_err = $tugas_err = $uts_err = $uas_err = $umur_err = $alamat_err = $jenis_kelamin_err = "";

// Memproses data formulir saat formulir dikirimkan
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_nama = trim($_POST["nama"]);
    if(empty($input_nama)){
        $nama_err = "Please enter a name.";
    } elseif(!filter_var($input_nama, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-A\s]+/")))){
        $nama_err = "Please enter a valid name.";
    } else{
        $nama = $input_nama;
    }


    $input_nim = trim($_POST["nim"]);
    if(empty($input_nim)){
        $nim_err = "Please enter your nim.";
    } else{
        $nim = $input_nim;
    }

    // Validate salary
    $input_tugas = trim($_POST["tugas"]);
    if(empty($input_tugas)){
        $tugas_err = "Please enter nilai tugas.";
    } elseif(!ctype_digit($input_tugas)){
        $tugas_err = "Please enter a positive integer value.";
    } else{
        $tugas = $input_tugas;
    }

    $input_uts = trim($_POST["uts"]);
    if(empty($input_uts)){
        $uts_err = "Please enter nilai uts.";
    } elseif(!ctype_digit($input_tugas)){
        $uts_err = "Please enter a positive integer value.";
    } else{
        $uts = $input_uts;
    }

    $input_uas = trim($_POST["uas"]);
    if(empty($input_uas)){
        $uas_err = "Please enter nilai uas.";
    } elseif(!ctype_digit($input_tugas)){
        $uas_err = "Please enter a positive integer value.";
    } else{
        $uas = $input_uas;
    }

    $input_umur = trim($_POST["umur"]);
    if(empty($input_umur)){
        $umur_err = "Please enter your umur.";
    } elseif(!ctype_digit($input_tugas)){
        $umur_err = "Please enter a positive integer value.";
    } else{
        $umur = $input_umur;
    }

    $input_alamat = trim($_POST["alamat"]);
    if(empty($input_umur)){
        $alamat_err = "Please enter your Alamat.";
    } elseif(!ctype_digit($input_tugas)){
        $alamat_err = "Please enter a your Alamat.";
    } else{
        $alamat = $input_alamat;
    }

    $input_jenis_kelamin = trim($_POST["jenis_kelamin"]);
    if(empty($input_umur)){
        $jenis_kelamin_err = "Please enter your Jenis Kelamin.";
    } elseif(!ctype_digit($input_tugas)){
        $jenis_kelamin_err = "Please enter a your Jenis Kelamin.";
    } else{
        $jenis_kelamin = $input_jenis_kelamin;
    }

    // Check input errors before inserting in database
    if(empty($nama_err) && empty($nim_err) && empty($tugas_err) && empty($uts_err) && empty($uas_err) && empty($umur_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO mahasiswa (nama, nim, tugas, uts, uas, umur, alamat, jenis_kelamin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "siiiiiss", $param_nama, $param_nim, $param_tugas, $param_uts, $param_uas, $param_umur, $param_alamat, $param_jenis_kelamin);

            // Set paramaters
            $param_nama = $nama;
            $param_nim = $nim;
            $param_tugas = $tugas;
            $param_uts = $uts;
            $param_uas = $uas;
            $param_umur = $umur;
            $param_alamat = $alamat;
            $param_jenis_kelamin = $jenis_kelamin;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing pagr
                header("location: index.php");
                exit();
            } else{
                echo "Something went wring. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Tambah Data Mahasiswa</h2>
                    </div>
                    <p>Silahkan Lengkapi Data Diri Anda.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nama_err)) ? 'has-error' : ''; ?>">
                            <label>Nama</label>
                            <textarea name="nama" class="form-control"><?php echo $nama; ?></textarea>                            
                            <span class="help-block"><?php echo $nama_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($nim_err)) ? 'has-error' : ''; ?>">
                            <label>NIM</label>
                            <input type="text" name="nim" class="form-control" value="<?php echo $nim; ?>">                          
                            <span class="help-block"><?php echo $nim_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tugas_err)) ? 'has-error' : ''; ?>">
                            <label>Tugas</label>
                            <input type="text" name="tugas" class="form-control" value="<?php echo $tugas; ?>">
                            <span class="help-block"><?php echo $tugas_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($uts_err)) ? 'has-error' : ''; ?>">
                            <label>UTS</label>
                            <input type="text" name="uts" class="form-control" value="<?php echo $uts; ?>">
                            <span class="help-block"><?php echo $uts_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($uas_err)) ? 'has-error' : ''; ?>">
                            <label>UAS</label>
                            <input type="text" name="uas" class="form-control" value="<?php echo $uas; ?>">                         
                            <span class="help-block"><?php echo $uas_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($umur_err)) ? 'has-error' : ''; ?>">
                            <label>Umur</label>
                            <input type="text" name="umur" class="form-control" value="<?php echo $umur; ?>">                         
                            <span class="help-block"><?php echo $umur_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($alamat_err)) ? 'has-error' : ''; ?>">
                            <label>Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="<?php echo $alamat; ?>">                         
                            <span class="help-block"><?php echo $alamat_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($jenis_kelamin_err)) ? 'has-error' : ''; ?>">
                            <label>Jenis Kelamin</label>
                            <input type="text" name="jenis_kelamin" class="form-control" value="<?php echo $jenis_kelamin; ?>">                         
                            <span class="help-block"><?php echo $jenis_kelamin_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>