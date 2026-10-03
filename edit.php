<?php

include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    $query = "UPDATE users SET
              name='$name',
              username='$username',
              email='$email',
              address='$address'
              WHERE id='$id'";

    if (mysqli_query($koneksi, $query)) {
        header("Location: index.html");
        exit;
    } else {
        echo "Gagal mengedit data: " . mysqli_error($koneksi);
    }
}
?>