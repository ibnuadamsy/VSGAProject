<?php
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';
// cek apakah tmbol submit ditekan atau belum
if (isset($_POST["submit"]) ) {


    // cek apakah data berhasil ditambahkan atau tidak
    if (tambah($_POST) > 0 ) {
        echo "
            <script>
                alert('data berhasil ditambahkan');
                document.location.href = 'index.php';
            </script>    
            ";
        echo "
            <script>
                alert('data gagal ditambahkan!');
                document.location.href = 'tambah.php';
            </script>
            ";
    }
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
    <title>Tambah Data Mahasiswa</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Tambah Data Mahasiswa</h1>
    <br/>
        <div class="col-md-8">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>
                <div class="form-group">
                <label for="nim">NIM</label>
                    <input type="text" name="nim" id="nim" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <select class="form-control" name="jurusan" id="jurusan" required>
                    <option>Teknik Informatika</option>
                    <option>Teknik Sipil</option>
                    <option>Teknik Industri</option>
                    <option>Teknik Kimia</option>
                    <option>Teknik Mesin</option>
                    <option>D3OAB</option>
                    </select>
                <div class="form-group">
                    <label for="email">email</label>
                    <input type="text" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="gambar">Upload Foto</label>
                    <input type="file" name="gambar" id="gambar" class="form-control-file">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
</div>
</body>
</html>