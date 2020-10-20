<?php
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query){
    global $conn; //global conn supaya mengacu pada $conn yg atas
    $result = mysqli_query($conn, $query);
    $rows = []; // rows adalah array atau wadah kosong
    while ($row = mysqli_fetch_assoc($result)){ // row objek yg di looping
        $rows[] = $row; // ambil objek di simpen disebelahnya 
    }
    return $rows;
}


function tambah($data){
    global $conn; //global conn supaya mengacu pada $conn yg atas
     $nama = htmlspecialchars($data["nama"]); //htmlspecialchars menghindari inputan dengan elemen atau html
     $nim  = htmlspecialchars($data["nim"]);
     $jurusan = htmlspecialchars($data["jurusan"]);
     $email = htmlspecialchars($data["email"]) ;

     // upload gambar
     $gambar = upload();
     if(!$gambar) {
         return false;
     }

    // query insert data
    $query = "INSERT INTO mahasiswa
                values
                ('', '$nama', '$nim', '$jurusan', '$email', 
                '$gambar')"; 
    mysqli_query($conn, $query);

    return  mysqli_affected_rows($conn);

}

function upload(){
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang di upload
    if( $error === 4 ) {
        echo "<script>
                alert('pilih gambar terlebih dahulu!');
             </script>";
        return false;     
    }

    // cek apakah yang di upload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if ( !in_array($ekstensiGambar, $ekstensiGambarValid )){
        echo "<script>
                alert('yang di upload bukan gambar');
             </script>";
        return false;
    }

   
    
    // cek jika ukurannya terlalu besar 
    if( $ukuranFile > 1000000) {
        echo "<script>
                alert('ukuran gambar terlalu besar');
             </script>";
        return false;  
    }
    //generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;
   
     // lolos pengecekan, gambar siap di upload
     move_uploaded_file($tmpName, 'img/'.$namaFileBaru);
     return $namaFileBaru;

     
}


function hapus($id) { // id dikirim dari halaman hapus
    global $conn; //global conn supaya mengacu pada $conn yg atas
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($conn);
}


function ubah($data) {
    global $conn; //global conn supaya mengacu pada $conn yg atas

     $id = $data["id"];
     $nama = htmlspecialchars($data["nama"]);
     $nim  = htmlspecialchars($data["nim"]);
     $jurusan = htmlspecialchars($data["jurusan"]);
     $email = htmlspecialchars($data["email"]) ;
     $gambarLama = htmlspecialchars($data["gambarLama"]);
     
     // cek apakah user pilih gambar baru atau tidak
     if ($_FILES['gambar']['error'] === 4 ){
         $gambar = $gambarLama; 
     }else {
         $gambar = upload();
     }

    // query insert data
    $query = "UPDATE mahasiswa SET
                nama = '$nama',
                nim = '$nim',
                jurusan = '$jurusan',
                email = '$email',
                gambar = '$gambar'
              WHERE id = $id
                "; 
    mysqli_query($conn, $query);

    return  mysqli_affected_rows($conn);
} 

function cari($keyword) { //LIKE digunakan untuk pencarian yg flexibel, misal cari nama lengkap, cukup nama depannya saja
    $query = "SELECT * FROM mahasiswa
                WHERE
                nama LIKE '%$keyword%' OR
                nim LIKE '%$keyword%' OR
                email Like '%$keyword%' OR
                jurusan LIKE '%$keyword%'
            ";
    return query($query);
}

function registrasi($data) {
    global $conn; //global conn supaya mengacu pada $conn yg atas

    $username = strtolower(stripslashes($data["username"])); //strtolower = wajib huruf kecil, stripslashes = mencegah penulisan karakter tertentu, contoh backslash 
    $password = mysqli_real_escape_string($conn, $data["password"]); // mysqli_real_escape_string = memungkinkan user memasuakn pasword dengan tanda kutip
    $password2 = mysqli_real_escape_string($conn, $data["password2"]); // password 2 untuk konfirmasi password

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE
        username = '$username'");
    if(mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('username sudah terdaftar!');
             </script>";
        return false;
    }

    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
                alert('konfirmasi password tidak sesuai');
             </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT); //password_hash = untuk mengenskripsi pasword, password_default algoritma default yg dipilih oleh php

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')"); // '',=id

    return mysqli_affected_rows($conn);

}

?>