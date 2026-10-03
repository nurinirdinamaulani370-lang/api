<?php

include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    $query = "INSERT INTO users
              (name, username, email, address)
              VALUES
              ('$name', '$username', '$email', '$address')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: index.html");
        exit;
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }
}
?>