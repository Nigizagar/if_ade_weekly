<?php

require "fungsi.php";

// Ambil data mahasiswa dari database
$result = mysqli_query($conn, "SELECT id, nama, nim, jurusan, email, no_hp, foto FROM mahasiswa");
if (!$result) {
    $result = false;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa Informatika 2026</title>
    <link rel="stylesheet" href="aset/css/style.css">
</head>
<body>
    <h1>Informatika 2026</h1>
    <table border="1" cellspacing="0" cellpadding="10px">
        <tr>
            <td><a href="profile.php">Profile</a></td>
            <td><a href="index.php">Home</a></td>
            <td><a href="contact.php">Contact</a></td>
            <td><a href="contact.php">Data Mahasiswa</a></td>
        </tr>
    </table>

    <h2>Data Mahasiswa Informatika 2026</h2>
    <a href="tambahdata.php">
        <button>Tambah Data Mahasiswa</button>
    </a>

    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Jurusan</th>
            <th>Email</th>
            <th>No. Hp</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>

        <?php if ($result && mysqli_num_rows($result) > 0) : ?>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td align="center"><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['nama'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['nim'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['jurusan'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['email'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($row['no_hp'] ?? ''); ?></td>
                    <td>
                        <?php
                        $foto = $row['foto'] ?? '';
                        if (!empty($foto)) {
                            echo '<img src="aset/Image/' . htmlspecialchars($foto) . '" alt="Foto Mahasiswa" width="100px">';
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                    <td>
                        <a href="ubahdata.php?id=<?php echo (int)($row['id'] ?? 0); ?>">Edit</a> |
                        <a href="hapusdata.php?id=<?php echo (int)($row['id'] ?? 0); ?>" onclick="return confirm('Apakah yakin mau menghapus data ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else : ?>
            <tr>
                <td colspan="8" align="center">Belum ada data</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>

