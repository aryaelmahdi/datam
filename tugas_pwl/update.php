<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values

$nama = $nim = $tugas = $uts = $uas = $umur = $alamat = $jenis_kelamin = "";
$nama_err = $nim_err = $tugas_err = $uts_err = $uas_err = $umur_err = $alamat_err = $jenis_kelamin_err = "";

// Processing form data when form is submitted
if(isset($_POST["nim"]) && !empty($_POST["nim"])){
    // Get hidden input value
    $nim = $_POST["nim"];

    // Validate name
    $input_nama = trim($_POST["nama"]);
    if(empty($input_nama)){
        $nama_err = "Please enter a name.";
    } elseif(!filter_var($input_nama, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nama_err = "Please enter a valid name.";
    } else{
        $nama = $input_nama;
    }

    // Validate address
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
    } elseif(!ctype_digit($input_uts)){
        $uts_err = "Please enter a positive integer value.";
    } else{
        $uts = $input_uts;
    }

    $input_uas = trim($_POST["uas"]);
    if(empty($input_uas)){
        $tugas_err = "Please enter nilai uas.";
    } elseif(!ctype_digit($input_uas)){
        $uas_err = "Please enter a positive integer value.";
    } else{
        $uas = $input_uas;
    }

    $input_umur = trim($_POST["umur"]);
    if(empty($input_umur)){
        $umur_err = "Please enter nilai uas.";
    } elseif(!ctype_digit($input_umur)){
        $umur_err = "Please enter a positive integer value.";
    } else{
        $umur = $input_umur;
    }

    $input_alamat = trim($_POST["alamat"]);
    if(empty($input_alamat)){
        $alamat_err = "Please enter your alamat.";
    } elseif(!ctype_digit($input_alamat)){
        $alamat_err = "Please enter alamat.";
    } else{
        $alamat = $input_alamat;
    }

    $input_jenis_kelamin = trim($_POST["jenis_kelamin"]);
    if(empty($input_alamat)){
        $jenis_kelamin_err = "Please enter your jenis kelamin.";
    } elseif(!ctype_digit($input_jenis_kelamin)){
        $jenis_kelamin_err = "Please enter jenis kelamin.";
    } else{
        $jenis_kelamin = $input_jenis_kelamin;
    }

    // Check input errors before inserting in database
    if(empty($nama_err) && empty($nim_err) && empty($tugas_err) && empty($uts_err) && empty($uas_err) && empty($umur_err) && empty($alamat_err && empty($jenis_kelamin_err))){
        // Prepare an insert statement
        $sql = "UPDATE mahasiswa SET nama=?, tugas=?, uts=?, uas=?, umur=?, alamat=?, jenis_kelamin=? WHERE nim=?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "siiiissi", $param_nama, $param_tugas, $param_uts, $param_uas, $param_umur, $param_alamat, $param_jenis_kelamin, $param_nim);

            // Set paramaters
            $param_nama = $nama;
            $param_tugas = $tugas;
            $param_uts = $uts;
            $param_uas = $uas;
            $param_umur = $umur;
            $param_alamat = $alamat;
            $param_jenis_kelamin = $jenis_kelamin;
            $param_nim = $nim;
            

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing pagr
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["nim"]) && !empty(trim($_GET["nim"]))){
        // Get URL parameter
        $nim = trim($_GET["nim"]);

        // Prepare a select statement
        $sql = "SELECT * FROM mahasiswa WHERE nim = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parametes
            mysqli_stmt_bind_param($stmt, "i", $param_nim);

            // Set parameters
            $param_nim = $nim;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $nama = $row["nama"];
                    $nim = $row["nim"];
                    $tugas = $row["tugas"];
                    $uts = $row["uts"];
                    $uas = $row["uas"];
                    $umur = $row["umur"];
                    $alamat = $row["alamat"];
                    $jenis_kelamin = $row["jenis_kelamin"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
    } else{
        // URL doesn't contain id parameter. Redirect to erro page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Update Record</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<style type="text/css">
		.wrapper{
			width: 500px;
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
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                        <div class="form-group <?php echo (!empty($alamat_err)) ? 'has-error' : ''; ?>">
                            <label>Jenis Kelamin</label>
                            <input type="text" name="jenis_kelamin" class="form-control" value="<?php echo $jenis_kelamin; ?>">                         
                            <span class="help-block"><?php echo $jenis_kelamin_err;?></span>
                        </div>
                        <input type="hidden" name="nim" value="<?php echo $nim; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>