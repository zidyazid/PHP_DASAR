<?php
session_start();
require 'function.php';

// if (isset($_COOKIE["login"])) {
//     # code...
//     if ($_COOKIE["login"] == true) {
//         # code...
//         $_SESSION["Login"] = true;
//     }
// }

if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
    # code...
    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"];

    $result = mysqli_query($koneksi, "SELECT username FROM user WHERE id = '$id'");

    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username

    if ($key === hash('sha256', $row['username'])) {
        # code...
        $_SESSION["Login"] = true;
    }
}

if (isset($_SESSION["Login"])) {
    # code...
    header("Location:index.php");
    exit;
}

if (isset($_POST["login"])) {

    # code...
    $username = $_POST["username"];
    $password = $_POST["password"];

    // pertama cek apakah ada username didalam database yang sesuai dengan yang diinputkan
    $result = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        # code...
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            # code...
            /**
             * session akan menjadi media penyimpanan layaknya variable tetapi hanya berlaku sementara
             * dan akan berakhir disaat browser dihapus atau laptop dimatikan 
             */
            $_SESSION["Login"] = true;
            // cek apakah cookie digunakan
            /**
             * cookie memiliki fungsi yang sama dengan session
             * namun menggunakan cookie kita dapat mengatur berapa lama dia(cookie) berlaku, dan cookie
             * tidak akan hilang selama masih berlaku meski browser di close
             */
            if (isset($_POST["remember"])) {
                # code...
                setcookie('id', $row["id"], time() + 60);
                setcookie('key', hash('sha256', $row["username"], time() + 60));
            }
            header("Location:index.php");
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
    <title>Login</title>
</head>

<body>
    <h1>Halaman Login</h1>

    <?php if (isset($error)) : ?>
    <p style="color: red; font-style : bold">Maaf username atau password anda salah</p>
    <?php endif; ?>

    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </li>
            <li>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember Me</label>
            </li>
            <li>
                <button type="submit" name="login">Login</button>
            </li>
        </ul>
    </form>

</body>

</html>