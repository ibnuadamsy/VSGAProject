<?php
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';
$id = $_GET["id"]; // tangkap id dari index

if (hapus ($id) > 0) { // mengirim id ke function hapus, kalo hapusnya berhasil akan ada baris yg terpengaruhi, kalo hapus bernilai 1 tandanya ada baris yg hilang 
    echo "
        <script>
            alert('data berhasil dihapus!');
            document.location.href = 'index.php';
        </script>      
        ";
}else {
    echo "
            <script>
                alert('data gagal dihapus!');
                document.location.href = 'index.php';
            </script>      
            ";
}
?>