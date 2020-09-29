<?php
session_start();

if (!isset($_SESSION["Login"])) {
    # code...
    header("Location:login.php");
    exit;
}
require 'function.php';

$id = $_GET["id"];

if (hapus($id) > 0) {
    # code...
    echo "
    <script>
        alert('data berhasil dihapus!!');
        document.location.href = 'index.php'
    </script>
";
} else {
    echo "
    <script>
        alert('data gagal dihapus!!');
        document.location.href = 'index.php'
    </script>
";
}