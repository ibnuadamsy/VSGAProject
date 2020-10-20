<?php
session_start(); // wajib dijalankan pada saat menggunakan session
require 'functions.php';


//cek cookie
if(isset($_COOKIE['id']) && isset($_COOKIE['key'])){
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    //cek cookie dan username
    if( $key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}



if(isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}


if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn,"SELECT * FROM user WHERE username
        ='$username'"); // koneksi $conn wajib pangggil require function.php

    // cek username
    if(mysqli_num_rows($result) === 1){ // mysqli_num_rows = untuk menghitung ada berapa baris yang dikembalikan dari fungsi select di atas, kalo ketemu nilai 1, no = 0
        
        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) { // password_verify = kebalikan dari password_hash = cek string sama atau tidak dengan hashnya
            // set session
            $_SESSION["login"] = true;

            // cek remember me
            if(isset($_POST['remember'])){
                //buat cookie

                setcookie('id', $row['id'], time()+60);
                setcookie('key', hash('sha256', $row['username']), time()+60);
            }

            header("Location: index.php");
            exit;
        }

    }
    
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <title>Login Admin</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>
<body>
    <h2>Login Admin</h2><br>

    <?php if(isset($error)) : ?>
        <p style="color: red; font-style:italic">username/password salah!</p>
    <?php endif; ?>
    <div class="col-md-2">
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" >
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
                <br/>
                <div class="form-group">
                    <div class="form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input" id="dropdownCheck2">
                    <label class="form-check-label" for="remember">
                    Remember me
                    </label>
                </div>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>