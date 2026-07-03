<?php

require 'fungsi.php';
requireLogin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $query = "DELETE FROM mahasiswa WHERE id = $id";
    mysqli_query($conn, $query);
}

if(mysqli_affected_rows($conn) > 0) {
    // jika berhasil, redirect ke halaman data mahasiswa
    header('Location: mahasiswa.php');
    exit;
} else {
    echo "Gagal menghapus data mahasiswa.";
}

header('Location: mahasiswa.php');
exit;
?>
