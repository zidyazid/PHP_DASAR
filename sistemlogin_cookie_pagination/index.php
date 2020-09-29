<?php
session_start();

if (!isset($_SESSION["Login"])) {
    # code...
    header("Location:login.php");
    exit;
}
// memanggil file function.php dan menjalankan koneksi yang ada didalamnya
require 'function.php';

// membuat pagination dengan menentukan menentukan jumlah daata perhalaman jumlah data perhalaman
$jumlahdataPerhalaman = 2;
// $result = mysqli_query($koneksi, "SELECT * FROM gudang");
$jumlahdata = count(query("SELECT * FROM gudang"));
// ceil untuk membulatkan keatas
$jumlahHalaman = ceil($jumlahdata / $jumlahdataPerhalaman);


$halamanSaatini = (isset($_GET["hal"])) ? $_GET["hal"] : 1;
$awalData = ($jumlahdataPerhalaman * $halamanSaatini) - $jumlahdataPerhalaman;

// melakukan query untuk menampilkan data dari table yang ada didalam database
$gudang = query("SELECT * FROM gudang LIMIT $awalData, $jumlahdataPerhalaman");

if (isset($_POST["cari"])) {
    # code...
    $gudang = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
    .tambah {
        border-width: 1px;
        margin-bottom: 3px;
        margin-left: 5px;
        border-style: "groove";
    }

    .pagination {
        border-width: 1px;
        margin-left: 5px;
    }

    table {
        margin: 5px;
        margin-bottom: 3px;
    }
    </style>

</head>

<body>

    <h1>Data Gudang</h1>

    <a class="tambah" href="tambahdata.php">Tambah Data</a>

    <form action="" method="post">
        <input type="text" name="keyword" id="keyword" autofocus autocomplete placeholder="masukan keyword pencarian"
            style="margin:5px" size=40px>

        <button type="submit" name="cari">Submit</button>
    </form>

    <a href="?hal=<?= $halamanSaatini - 1; ?>" class="pagination">&lt;</a>
    <?php for ($i = 1; $i < $jumlahHalaman; $i++) : ?>
    <?php if ($i == $halamanSaatini) : ?>
    <a href="?hal=<?= $i; ?>" class="pagination" style="font-weight: bold; color:red;"><?= $i; ?></a>
    <?php else : ?>
    <a href="?hal=<?= $i; ?>" class="pagination"><?= $i; ?></a>
    <?php endif; ?>
    <?php endfor; ?>

    <?php if ($halamanSaatini < $jumlahHalaman) : ?>
    <a href="?hal=<?= $halamanSaatini + 1; ?>" class="pagination">&gt;;</a>
    <?php endif; ?>
    <table border="2">
        <tr>
            <th>No</th>
            <th>Merk Mobil</th>
            <th>Tipe Mobil</th>
            <th>Stok Mobil</th>
            <th>Gambar</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php $i = 1 ?>
        <!-- 
            data yang ada pada database itu lebih dari 1
            oleh karena itu pemanggilan datanya harus diletakkan didalam looping
            agar data tersebut ditampilkan sesuai dengan jumlah data yang ada
         -->

        <!-- perulangan -->
        <?php foreach ($gudang as $row) : ?>
        <tr>
            <td><?= $i; ?></td>
            <!-- pemanggilan data berdasarkan function row pada file function.php
                 pemanggilan seperti dibawah ini dilakukan untuk array assosiatif,
                 apabila data bersifat array numerik maka pemanggilanya menjadi sepert berikut : $row[index] contoh : $row[0]   
        -->
            <td><?= $row["merk_mobil"]; ?></td>
            <td><?= $row["tipe_mobil"]; ?></td>
            <td><?= $row["stok_mobil"]; ?></td>
            <td>
                <img src="img/<?= $row["gambar"]; ?>" width="50px" alt="">
            </td>
            <td><?= $row["harga"]; ?></td>
            <td>
                <a href="ubah.php?id=<?= $row["id"]; ?>">Edit</a>
                |<a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin?');">Delete</a>
            </td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
        <!-- mengakhiri perulangan -->
    </table>

    <br>

    <a href="logout.php" style="color: red;">logout</a>

</body>

</html>