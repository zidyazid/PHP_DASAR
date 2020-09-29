<?php
session_start();

if (!isset($_SESSION["Login"])) {
    # code...
    header("Location:login.php");
    exit;
}
// koneksi ke database
// memanggil file function.php yang didalamnya sudah ada koneksi ke database 
require 'function.php';
// cek apakah button submit telah ditekan
if (isset($_POST["submit"])) {

    // var_dump($_POST);
    // var_dump($_FILES);
    /**
     * $_FILES akan memunculkan sebuah asosiatif array diamana array tersebut merupakan array 2 dimensi 
     * */
    // die;
    # code...
    // panggil function tambah
    // lalu lakukan pengecekan apakah ada row yang mengalami perubahab
    // apabila ada jalankan kondisi pertama apabila tidak
    // jalankan else
    if (tambah($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil ditambahkan!!');
                document.location.href = 'index.php'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal ditambahkan!!');
                document.location.href = 'index.php'
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
    <title>Tambah Data Isi Gudang</title>
</head>

<body>
    <h1>Tambah data isi gudang</h1>

    <!-- ectype berfungsi untuk mengelolan file -->
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="merek">Merk Mobil :</label>
                <input type="text" name="merek" id="merek">
            </li>
            <li>
                <label for="tipe">Type Mobil :</label>
                <input type="text" name="tipe" id="tipe">
            </li>
            <li>
                <label for="stok">Stok Mobil :</label>
                <input type="number" name="stok" id="stok">
            </li>
            <li>
                <label for="gambar">Gambar :</label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <label for="harga">Harga Mobil :</label>
                <input type="text" name="harga" id="harga">
            </li>
            <li>
                <button type="submit" name="submit">Submit</button>
            </li>
        </ul>
    </form>

</body>

</html>