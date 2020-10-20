<?php
session_start();

if(!isset($_SESSION["login"])) { // jika tidak ada session login
    header("Location: login.php"); // kembalikan ke halaman login
    exit;
}

require 'functions.php'; // menghubungkan halaman index ke halaman functions (logic) 
$mahasiswa = query("SELECT * FROM mahasiswa"); // apa yg ditampil dilayar karena query ini

// tombol cari diklik
if (isset($_POST["cari"])) { // jika tombol cari diklik
    $mahasiswa = cari($_POST["keyword"]); // cari mahasiswa berdasarkan keyword inputan
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
    <title>Halaman Admin</title>
</head>
<body>
    
<center><h1>Hallo Admin!</h1> 
<h2>Daftar Mahasiswa Fakultas Teknik - UMJ</h2>
</center> <br>

<a href="tambah.php" class="btn btn-primary">Tambah Data Mahasiswa</a>
<br><br>


<a href="logout.php" class="btn btn-danger float-right">Logout</a>
<form action="" method="POST">
    <input type="text" name="keyword" size="30" autofocus
    placeholder="cari nama anda disini..." autocomplete="off">
    <button type="submit" name="cari" class="btn btn-secondary btn-sm">Cari!</button>
</form>
<br>
<table class="table table-hover">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Aksi</th>
            <th scope="col">Gambar</th>
            <th scope="col">NIM</th>
            <th scope="col">Nama</th>
            <th scope="col">Jurusan</th>
            <th scope="col">Email</th>
        </tr>
    </thead>
    <?php $i=1; //mengurutkan id dengan membuat variabel i ?>
    <?php foreach ( $mahasiswa as $row) : //foreach untuk pengulangan pada array ?> 
    <tr>
        <td><?= $i; ?></td>
        <td>
            <a href="ubah.php?id=<?= $row["id"]; ?>" class="btn btn-outline-success btn-sm">Ubah</a>
            <a href="hapus.php?id=<?= $row["id"]; //akan menghapus mahasiswa dengan id tertentu ?>"class="btn btn-outline-danger btn-sm" 
            onclick="return confirm('Apakah yakin menghapus data ini? ');">Hapus</a> 
        </td>
        <td><img src="img/<?= $row["gambar"]; ?>" width="60"></td>
        <td><?= $row["nim"]; ?></td>
        <td><?= $row["nama"] ?></td>
        <td><?= $row["jurusan"] ?></td>
        <td><?= $row["email"] ?></td>
    </tr>
    <?php $i++; //variabel i nambah terus setiap pengulangannya?> 
    <?php endforeach; ?>

</table>
<br/>
<a href="downloadexcel.php" class="btn btn-success">Download Excel</a>
</body>
</html>