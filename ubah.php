<?php
require 'functions.php';

// ambil data di URL
$id = $_GET["id"];

// query data mahasiswa berdasarkan id
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0]; //panggil query langsung dari index ke 0 atau elemen pertama 


// cek apakah tmbol submit ditekan atau belum
if (isset($_POST["submit"]) ) {

    // cek apakah data berhasil diubah atau tidak
    if (ubah($_POST) > 0 ) {
        echo "
            <script>
                alert('data berhasil diubah!');
                document.location.href = 'index.php';
            </script>      
            ";
    } else {
        echo "
            <script>
                alert('data gagal diubah!');
                document.location.href = 'index.php';
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
    <title>Ubah Data Mahasiswa</title>
</head>
<body>

<div class="container">
    <h1>Ubah Data Mahasiswa</h1>
    <br/>
        <div class="col-md-8">
            <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $mhs["id"]; ?>">
            <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"]; ?>">  
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required
                    value="<?= $mhs["nama"]; ?>">
                </div>
                <div class="form-group">
                <label for="nim">NIM</label>
                    <input type="text" name="nim" id="nim" class="form-control" required
                    value="<?= $mhs["nim"]; ?>">
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <select class="form-control" name="jurusan" id="jurusan" required
                    value="<?= $mhs["jurusan"]; ?>">
                    <option>Teknik Informatika</option>
                    <option>Teknik Sipil</option>
                    <option>Teknik Industri</option>
                    <option>Teknik Kimia</option>
                    <option>Teknik Mesin</option>
                    <option>D3OAB</option>
                    </select>
                <div class="form-group">
                    <label for="email">email</label>
                    <input type="text" name="email" id="email" class="form-control" required
                    value="<?= $mhs["email"]; ?>">
                </div>
                <div class="form-group">
                    <label for="gambar">Foto Sebelumnya</label>
                    <img src="img/<?= $mhs['gambar']; ?>" width="40">
                    <input type="file" name="gambar" id="gambar" class="form-control-file">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
</div>
</body>
</html>