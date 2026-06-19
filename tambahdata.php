<?php

    require "fungsi.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nama = $_POST["nama"];
        $nim = $_POST["nim"]; // pastikan isi nim berupa angka/string sesuai tipe kolom di DB
        $nim = trim($nim);
        $jurusan = $_POST["jurusan"];
        $email = $_POST["email"];
        $no_hp = $_POST["no_hp"];
        $foto = '';

        // upload file foto
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['foto']['tmp_name'];
            $namaFile = $_FILES['foto']['name'];
            $namaFile = preg_replace('/[^A-Za-z0-9._-]/', '_', $namaFile);

            // ganti nama menjadi unik (uniqid)
            $ext = pathinfo($namaFile, PATHINFO_EXTENSION);
            $ext = preg_replace('/[^A-Za-z0-9]/', '', $ext);
            $namaFile = uniqid('foto_', true) . ($ext ? '.' . $ext : '');

            $targetDir = __DIR__ . '/aset/Image/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $targetPath = $targetDir . $namaFile;
            if (move_uploaded_file($tmpName, $targetPath)) {
                $foto = $namaFile;
            }
        }

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
                <td>
                    <input type="file" id="foto" name="foto" accept="image/*">
                    <small>Nama file otomatis</small>
                </td>
            </tr>

        </table>
        <br>
        <button type="submit">Tambahkan Data</button>
        <br>
        </table>
</form>
</body>
</html>
