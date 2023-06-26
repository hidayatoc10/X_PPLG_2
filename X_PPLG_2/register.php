<?php

$conn = mysqli_connect("Localhost", "root", "", "data_pegawai");

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registrasi</title>
    <link rel="icon" href="dist/img/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body class="hold-transition login-page">
    <style>
    a{
        text-decoration: none;
    }
</style>
    <div class="login-box">

        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <div class="login-logo">
                        <font color="blue">
                            <b>- Forum Registrasi -</b>
                        </font>
                </div>
                <center>
                    <img src="dist/img/logo.png" width=180px />
                    <br>
                    <br>
                </center>
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="name" placeholder="Full Name" autofocus required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="bi bi-person-square"></i>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username" autofocus
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="bi bi-lock-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="kpassword" placeholder="Verification Password"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="bi bi-check2"></i>
                            </div>
                        </div>
                    </div>
                    <select class="form-select" aria-label="Default select example" name="level" required>
                        <option selected>Level</option>
                        <option value="1">Administrator</option>
                        <option value="2">Sekretaris</option>
                    </select><p>
                    <center>Already Member<a href="login.php"> Sign In</a>
                        <p>
                    </center>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" name="submit"
                                title="Masuk Sistem">
                                <b>Sign Up</b>
                            </button>
                        </div>
                </form>

            </div>
        </div>
    </div>
    <script src="plugins/alert.js"></script>

</body>

</html>

<?php

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

if (isset($_POST["submit"])) {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = md5($_POST["password"]);
    $kpassword = md5($_POST["kpassword"]);
    $level = $_POST["level"];
    $m = query("SELECT * FROM tb_pengguna WHERE username = '$username'");


    if (strlen($password) < 8) {
        echo "<script>
        Swal.fire({title: 'Password Terlalu pendek',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {if (result.value)
            {window.location = 'register.php';}
        })</script>";
        return false;
    }

    if ($m) {
        echo "<script>
        Swal.fire({title: 'Opss Username atau Email Sudah Terdaftar',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {if (result.value)
            {window.location = 'register.php';}
        })</script>";
        return false;
    }

    if ($password !== $kpassword) {
        echo "<script>
			Swal.fire({title: 'Password Tidak Sesuai',text: '',icon: 'error',confirmButtonText: 'OK'
			}).then((result) => {if (result.value)
				{window.location = 'register.php';}
			})</script>";
        return false;
    }



    $query = "INSERT INTO tb_pengguna
            VALUES
          ('', '$name','$username','$password','$level')
        ";
    $masuk = mysqli_query($conn, $query);

    if ($masuk) {
        echo "<script>
			Swal.fire({title: 'Register Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
			}).then((result) => {if (result.value)
				{window.location = 'login.php';}
			})</script>";
        return false;
    }
}
?>
