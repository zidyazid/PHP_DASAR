<?php
session_start();

if (!isset($_SESSION["Login"])) {
    # code...
    header("Location:login.php");
    exit;
}
// koneksi ke database
require 'function.php';
$id = $_GET["id"];

// var_dump($id); untuk mengecak apakah variable id menyimpan nilai

// query merupakan function yang telah kita buat didalam file function.php
$mobil = query("SELECT * FROM gudang WHERE id = $id")[0];

// untuk mengcek apakah button dengan name submit telah diklik
if (isset($_POST["submit"])) {
    # code...
    // panggil function ubah
    if (ubah($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil diubah!!');
                document.location.href = 'index.php'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal diubah!!');
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
    <title>Ubah Data Isi Gudang</title>
</head>

<body>
    <h1>Ubah data isi gudang</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <input type="text" hidden name="id" id="id" value="<?= $mobil["id"] ?>" readonly required>
            <input type="text" hidden name="gambarlama" id="gambarlama" value="<?= $mobil["gambar"] ?>" readonly
                required>
            <li>
                <label for="merek">Merk Mobil :</label>
                <input type="text" name="merek" id="merek" value="<?= $mobil["merk_mobil"] ?>" required>
            </li>
            <li>
                <label for="tipe">Type Mobil :</label>
                <input type="text" name="tipe" id="tipe" value="<?= $mobil["tipe_mobil"] ?>" required>
            </li>
            <li>
                <label for="stok">Stok Mobil :</label>
                <input type="number" name="stok" id="stok" value="<?= $mobil["stok_mobil"] ?>" required>
            </li>
            <li>
                <img src="img/<?= $mobil["gambar"]; ?>" width="50" alt="">
            </li>
            <li>
                <label for="gambar">Gambar :</label>
                <input type="file" name="gambar" id="gambar" required>
            </li>
            <li>
                <label for="harga">Harga Mobil :</label>
                <input type="text" name="harga" id="harga" value="<?= $mobil["harga"] ?>" required>
            </li>
            <li>
                <button type="submit" name="submit">save change</button>
            </li>
        </ul>
    </form>

</body>

</html>