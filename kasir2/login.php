<?php
    @ob_start();
    session_start();
    if(isset($_POST['proses'])){
        require 'config.php';
            
        $user = strip_tags($_POST['user']);
        $pass = strip_tags($_POST['pass']);

        $sql = mysqli_query($conn,"SELECT * FROM login WHERE user='$user' and pass='$pass'");
        $data = mysqli_fetch_assoc($sql);
        $cek = mysqli_num_rows($sql);
        // $_SESSION['status'] = 'login';
        if($cek > 0){
            $_SESSION['user'] = $user;
            if($data['role'] === 'admin'){
                echo "<script>alert('Selamat datang admin');window.location='index.php';</script>";
            }else{
                echo '<script>alert("Login Sukses");window.location="laporan.php";</script>';
            }
        }else{
            echo '<script>alert("Maaf! data yang anda masukan salah.");history.go(-1);</script>';
        }
    }
    if(isset($_SESSION['user'])){
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="pavicon.ico">
    <link rel="icon" href="icon.ico" type="image/ico">
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="background-color:#87CEFA">

<div class="container">
<br><br><br><br><br><br>

<div class="row justify-content-center">

    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body">
                <h1 class="h4 text-center mb-4"><b>Login </b></h1>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <img src="assets/img/login.png" alt="assets/img/login.png" style="width: 200px; height: auto;">
                </div>
                <form method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" name="user" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-user" name="pass" placeholder="Password">
                    </div>
                    <button class="btn btn-info form-control-user btn-block" name="proses"  type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>

</div>


</div> <!-- end container fluid -->

    <script src="assets/js/jquery.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script>
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 1000);
</script>
</body>
</html>