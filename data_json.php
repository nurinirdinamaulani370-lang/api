<?php

header("Content-Type: application/json");

include "koneksi.php";

$method = $_SERVER["REQUEST_METHOD"];

// =========================
// GET -> ambil semua data
// =========================
if ($method === "GET") {

    $query = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id ASC");

    $data = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = [
            "id" => $row["id"],
            "name" => $row["name"],
            "username" => $row["username"],
            "email" => $row["email"],
            "address" => $row["address"]
        ];
    }

    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
}

// =========================
// POST -> tambah / edit / hapus
// =========================
if ($method === "POST") {

    $input = json_decode(file_get_contents("php://input"), true);

    $action = $input["action"] ?? "";

    if ($action === "add") {

        $name = mysqli_real_escape_string($koneksi, $input["name"]);
        $username = mysqli_real_escape_string($koneksi, $input["username"]);
        $email = mysqli_real_escape_string($koneksi, $input["email"]);
        $address = mysqli_real_escape_string($koneksi, $input["address"]);

        $query = "INSERT INTO users (name, username, email, address)
                  VALUES ('$name', '$username', '$email', '$address')";

        if (mysqli_query($koneksi, $query)) {
            echo json_encode(["success" => true, "message" => "Data berhasil ditambahkan"]);
        } else {
            echo json_encode(["success" => false, "message" => "Gagal menambahkan data: " . mysqli_error($koneksi)]);
        }

    } elseif ($action === "edit") {

        $id = intval($input["id"]);
        $name = mysqli_real_escape_string($koneksi, $input["name"]);
        $username = mysqli_real_escape_string($koneksi, $input["username"]);
        $email = mysqli_real_escape_string($koneksi, $input["email"]);
        $address = mysqli_real_escape_string($koneksi, $input["address"]);

        $query = "UPDATE users SET
                  name='$name', username='$username', email='$email', address='$address'
                  WHERE id=$id";

        if (mysqli_query($koneksi, $query)) {
            echo json_encode(["success" => true, "message" => "Data berhasil diperbarui"]);
        } else {
            echo json_encode(["success" => false, "message" => "Gagal mengedit data: " . mysqli_error($koneksi)]);
        }

    } elseif ($action === "delete") {

        $id = intval($input["id"]);

        $query = "DELETE FROM users WHERE id=$id";

        if (mysqli_query($koneksi, $query)) {
            echo json_encode(["success" => true, "message" => "Data berhasil dihapus"]);
        } else {
            echo json_encode(["success" => false, "message" => "Gagal menghapus data: " . mysqli_error($koneksi)]);
        }

    } else {
        echo json_encode(["success" => false, "message" => "Action tidak dikenali"]);
    }

    exit;
}