<?php

require 'fungsi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Jika form update dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    $nama = $_POST['nama'] ?? '';
    $nim = trim($_POST['nim'] ?? '');
    $jurusan = $_POST['jurusan'] ?? '';
    $email = $_POST['email'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $foto = $_POST['foto'] ?? '';

    // upload file foto (opsional)
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

    // update data
    if ($id > 0) {
        $nama = mysqli_real_escape_string($conn, $nama);
        $nim = mysqli_real_escape_string($conn, $nim);
        $jurusan = mysqli_real_escape_string($conn, $jurusan);
        $email = mysqli_real_escape_string($conn, $email);
        $no_hp = mysqli_real_escape_string($conn, $no_hp);
        $foto = mysqli_real_escape_string($conn, $foto);

        $query = "UPDATE mahasiswa SET
            nama = '$nama',
            nim = '$nim',
            jurusan = '$jurusan',
            email = '$email',
            no_hp = '$no_hp',
            foto = '$foto'
        WHERE id = $id";

        mysqli_query($conn, $query);

        header('Location: mahasiswa.php');
        exit;
    }
}

// Ambil data untuk ditampilkan di form
$data = null;
if ($id > 0) {
    $id = (int)$id;
    $result = mysqli_query($conn, "SELECT id, nama, nim, jurusan, email, no_hp, foto FROM mahasiswa WHERE id = $id");
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    }
}

if (!$data) {
    header('Location: mahasiswa.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Mahasiswa</title>
    <link rel="stylesheet" href="aset/css/style.css">
</head>
<body>
    <h2>Ubah Data Mahasiswa Informatika 2026</h2>

    <form action="ubahdata.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo (int)$data['id']; ?>">

        <table cellpadding="5">
            <tr>
                <td><label for="nama">Nama</label></td>
                <td>:</td>
                <td><input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama'] ?? ''); ?>"></td>
            </tr>
            <tr>
                <td><label for="nim">NIM</label></td>
                <td>:</td>
                <td><input type="text" id="nim" name="nim" value="<?php echo htmlspecialchars($data['nim'] ?? ''); ?>"></td>
            </tr>
            <tr>
                <td><label for="jurusan">Jurusan</label></td>
                <td>:</td>
                <td><input type="text" id="jurusan" name="jurusan" value="<?php echo htmlspecialchars($data['jurusan'] ?? ''); ?>"></td>
            </tr>
            <tr>
                <td><label for="email">Email</label></td>
                <td>:</td>
                <td><input type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>"></td>
            </tr>
            <tr>
                <td><label for="no_hp">No HP</label></td>
                <td>:</td>
                <td><input type="tel" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($data['no_hp'] ?? ''); ?>"></td>
            </tr>
            <tr>
                <td><label for="foto">Foto</label></td>
                <td>:</td>
                <td>
                    <?php if (!empty($data['foto'])): ?>
                        <div style="margin-bottom:6px;">
                            <img src="aset/Image/<?php echo htmlspecialchars($data['foto']); ?>" alt="Foto" width="100px">
                        </div>
                    <?php endif; ?>
                    <input type="file" id="foto" name="foto" accept="image/*">
                    <input type="hidden" name="foto" value="<?php echo htmlspecialchars($data['foto'] ?? ''); ?>">
                </td>
            </tr>
        </table>

        <br>
        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>

