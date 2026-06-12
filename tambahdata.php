<?php

    require "fungsi.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nama = $_POST["nama"];
        $nim = $_POST["nim"]; // pastikan isi nim berupa angka/string sesuai tipe kolom di DB
        $nim = trim($nim);
        $jurusan = $_POST["jurusan"];
        $email = $_POST["email"];
        $no_hp = $_POST["no_hp"];
        // foto diketik sebagai nama file (contoh: Muhalim.jpeg)
        $foto = isset($_POST["foto"]) ? $_POST["foto"] : '';


        // simpan data ke tabel mahasiswa (langsung saja, tanpa prepared statement agar minim perubahan)
        $query = "INSERT INTO mahasiswa (nama, nim, jurusan, email, no_hp, foto) VALUES ('$nama', '$nim', '$jurusan', '$email', '$no_hp', '$foto')";
        mysqli_query($conn, $query);

        if (mysqli_affected_rows($conn) > 0) {
            // jika berhasil, redirect ke halaman data mahasiswa
            header("Location: mahasiswa.php");
            exit;
        } else {
            echo "Gagal menambahkan data mahasiswa.";
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Data Mahasiswa</title>
    <link rel="stylesheet" href="aset/css/style.css">
</head>
<body>
    <h2>Tambah Data Mahasiswa Informatika 2026</h2>
<form action="tambahdata.php" method="post" enctype="multipart/form-data">
        <table cellpadding="5">
            <tr>
                <td><label for="nama">Nama</label></td>
                <td>:</td>
                <td><input type="text" id="nama" name="nama"></td>
            </tr>
            <tr>
                <td><label for="nim">NIM</label></td>
                <td>:</td>
                <td><input type="text" id="nim" name="nim"></td>
            </tr>
            <tr>
                <td><label for="jurusan">Jurusan</label></td>
                <td>:</td>
                <td><input type="text" id="jurusan" name="jurusan"></td>
            </tr>
            <tr>
                <td><label for="email">Email</label></td>
                <td>:</td>
                <td><input type="email" id="email" name="email"></td>
            </tr>
            <tr>
                <td><label for="no_hp">No HP</label></td>
                <td>:</td>
                <td><input type="tel" id="no_hp" name="no_hp"></td>
            </tr>
            <tr>
                <td><label for="foto">Foto</label></td>
                <td>:</td>
                <td><input type="text" id="foto" name="foto" placeholder="contoh: Muhalim.jpeg"></td>
            </tr>

        </table>
        <br>
        <button type="submit">Tambahkan Data</button>
        <br>
        </table>
</form>
</body>
</html>
