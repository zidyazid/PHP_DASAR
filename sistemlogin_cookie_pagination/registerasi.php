<?php

require 'function.php';

if (isset($_POST["register"])) {
    # code...
    if (pendaftaran($_POST) > 0) {
        # code...
        echo "
            
            <script>
                alert('registerasi berhasil')
            </script>
            
            ";
    } else {
        # code...
        mysqli_error($koneksi);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>halaman registrasi</title>
    <style>
    label {
        display: block;
    }

    button {
        margin-top: 10px;
    }
    </style>
</head>

<body>
    <h1>Halaman Registrasi</h1>

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
                <label for="password2">Konfirmasi Password</label>
                <input type="password" name="password2" id="password2">
            </li>
            <li>
                <button type="submit" name="register">Submit</button>
            </li>
        </ul>
    </form>
</body>

</html>