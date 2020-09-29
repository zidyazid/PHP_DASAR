<?php

/** 
 *koneksi ke database 
 *untuk melakukan koneksi php menyediakan 3 driver yang dapat digunakan
 * yaitu (mysql_conect, mysqli_connect, PDO)
 * 1. mysql_connect merupakan driver pertama yang dikembangkan
 * php untuk melakukan koneksi ke database namun driver ini sudah tidak lagi digunakan
 * karena banyaknya kekurangan
 * 2. mysqli_connect, i pada kata mysqli merupakan improve yang merujuk kepada
 * pengembangan dari mysql_connect yang sebelumnya versi ini sudah lebih baik dan banyak di gunakan sampai saat ini
 * 3. PDO merupakan driver yang dapat digunakan untuk koneksi kedatabase, yang menjadi keunggulannya ialah
 * saat kita melakukan perubahan database sebagai contoh dari database mysqli ke postgre sql kita tidak perlu melakukan banyak perubahan pada codingan
 * kesimpulan utk saat ini yang dapat digunakan adalah mysqli dan pdo
 * */
$koneksi = mysqli_connect("localhost", "root", "", "gudang");



/**
 * variable terbagi menjadi 3 pengkategorian
 * 1. variable lokal 
 * yaitu seperti variable $koneksi diatas yang diletakkan atau didefinisikan 
 * diluar function
 * 2. merupakan variable global dapat dilihat didalam 
 * function terdapat global $koneksi itu berarti menjadikan setiap $koneksi yang
 * berada diluar function sebagai variable global agar dapat diakses oleh semua function
 */
function query($query)
{
    global $koneksi;
    // mysqli_query merupakan function milik php untuk menjalankan query
    // dia menyimpan 2 parameter yaitu koneksi dan query yang akan digunakan
    $result = mysqli_query($koneksi, $query);

    $rows = [];
    // untuk mengcek apakah ada kolom yang mengalami perubahan
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// CRUD


// 1. create
function tambah($data)
{
    // memanggil variable konesi yang ada diluar function
    global $koneksi;
    // menyimpan setiap nilai dari inputan kedalam variable
    // $data, merupakan pengganti dari$_post karena function tambah telah memiliki parameter $_post pada halaman tambah data
    $merek = htmlspecialchars($data["merek"]);
    $tipe = htmlspecialchars($data["tipe"]);
    $stok = htmlspecialchars($data["stok"]);
    $harga = htmlspecialchars($data["harga"]);
    $gambar = upload();

    if (!$gambar) {
        # code...
        return false;
    }


    // membuat query create yaitu insert nilai diurutkan sesuai pada field yang ada didatabase
    $query = "INSERT INTO gudang VALUES 
            ('', '$merek', '$tipe', '$stok', '$gambar', '$harga')";

    // menjalan kan query dengan memanggil query yang telah disimpan
    // didalam $query dengan menggunakan mysqli_query
    mysqli_query($koneksi, $query);
    // cek apakah table mengalami perubahan
    return mysqli_affected_rows($koneksi);
}

function upload()
{
    // mengambil nama dari yng diinputkan
    $namaFiles = $_FILES["gambar"]["name"];
    // mengambil ukuran dari yng diinputkan
    $ukuranFiles = $_FILES["gambar"]["size"];
    // mengambil kesalahan dari yng diinputkan
    $error = $_FILES["gambar"]["error"];
    // mengambil direktori dari yng diinputkan
    $tmpFiles = $_FILES["gambar"]["tmp_name"];

    // cek apakah ada file yang ingin di upload
    if ($error === 4) {
        # code...
        echo "<script>
                alert('pilih file terlebih dahulu')
              </script>";
        return false;
    }
    // cek apakah yang diupload adalah gambar

    $ekstensiyangdiizinkan = ['jpg', 'jpeg', 'png'];
    $eckstensiGambar = explode('.', $namaFiles);
    $ekstensi = strtolower(end($eckstensiGambar));

    if (!in_array($ekstensi, $ekstensiyangdiizinkan)) {
        # code...
        echo "<script>
                alert('file yang dipilih bukan gambar')
              </script>";
        return false;
    }
    // cek jiika ukuran gambar terlalu besar
    if ($ukuranFiles > 4000000) {
        # code...
        echo "<script>
        alert('ukuran gambar terlalu besar')
      </script>";
        return false;
    }
    // sebelum di upload muncul kendala seandainya data yang diupload sama maka perlu
    // dihandle dengan merubah nama file secara random

    $namaFilesBaru = uniqid();
    $namaFilesBaru .= '.';
    $namaFilesBaru .= $ekstensi;

    // var_dump($namaFilesBaru);
    // die;

    // jika lolos disetiap validasi maka upload gambar
    // nama file akan dikirim ke database sedangkan file yang dipilih akan dikirim ke direktori
    move_uploaded_file($tmpFiles, 'img/' . $namaFilesBaru);
    return $namaFilesBaru;
}


function ubah($data)
{
    // memanggil variable $koneksi yang ada diluar function
    global $koneksi;
    // menyimpan setiap nilai dari inputan kedalam variable
    // $data, merupakan pengganti dari $_post karena function tambah telah memiliki parameter $_post pada halaman tambah data
    $id = $data["id"];
    $merek = htmlspecialchars($data["merek"]);
    $tipe = htmlspecialchars($data["tipe"]);
    $stok = htmlspecialchars($data["stok"]);
    $harga = htmlspecialchars($data["harga"]);
    $gambarLama = htmlspecialchars($data["gambarlama"]);

    if ($_FILES['gambar']['error'] === 4) {
        # code...
        $gambar = $gambarLama;
    } else {
        # code...
        $gambar = upload();
    }


    $query = "UPDATE gudang SET
             merk_mobil = '$merek',
             tipe_mobil = '$tipe',
             stok_mobil = '$stok',
             gambar = '$gambar',
             harga = '$harga' 
             WHERE id = $id  
   ";

    // menjalan kan query dengan memanggil query yang telah disimpan
    // didalam $query dengan menggunakan mysqli_query
    mysqli_query($koneksi, $query);
    // membuat query create yaitu insert nilai diurutkan sesuai pada field yang ada didatabase
    return mysqli_affected_rows($koneksi);
}

function hapus($id)
{
    // memanggil variable $koneksi yang ada diluar function
    global $koneksi;

    mysqli_query($koneksi, "DELETE FROM gudang WHERE id = $id");

    return mysqli_affected_rows($koneksi);
}

// function search data

function cari($keyword)
{
    // mencari data berdasarkan kriteria tertentu
    $query = "SELECT * FROM gudang
              WHERE merk_mobil 
              LIKE '%$keyword%' OR
              tipe_mobil LIKE '%$keyword%' OR
              stok_mobil LIKE '%$keyword%'";

    // memanggil function query
    return query($query);
}

function pendaftaran($data)
{
    global $koneksi;
    // htmlspecialchars merupakan pengaman untuk melindungi web dari xss

    $username = htmlspecialchars(strtolower(stripslashes($data["username"])));
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);
    // melakukan pengcekan apakah username telah digunakan
    $result = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        # code...
        echo "
            <script>
                alert('username telah digunakan')
            </script>
        ";
        // diberikan return false agar penyimpanannya gagal
        return false;
    }
    // melakukan seleksi apakah password sesuai
    if ($password !== $password2) {
        # code...
        // echo mysqli_error($koneksi);
        echo "
            <script>
                alert('konfirmasi password salah')
            </script>
        ";
        return false;
    }

    // lakukan encrypt password menggunakan fungsi password_hash bawaan php
    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($koneksi, "INSERT INTO user VALUES 
                            ('', '$username', '$password')");

    return mysqli_affected_rows($koneksi);
    // meanmbahkan user baru ke database
}