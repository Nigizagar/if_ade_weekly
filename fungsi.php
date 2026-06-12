<?php
// fungsi.php
// Koneksi database untuk project ini

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'adeweeklyb'; // <-- sesuaikan bila nama database kamu berbeda

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}
$conn->set_charset('utf8mb4');

// Catatan: di project ini, tambahdata.php memproses INSERT langsung,
// fungsi berikut disediakan untuk pemakaian alternatif.
function tambahData($data) {
    global $conn;

    $nama = htmlspecialchars($data['nama']) ?? '';
    $nim = trim(htmlspecialchars($data['nim']) ?? '');
    $jurusan = htmlspecialchars($data['jurusan']) ?? '';
    $email = htmlspecialchars($data['email']) ?? '';
    $no_hp = htmlspecialchars($data['no_hp']) ?? '';
    $foto = htmlspecialchars($data['foto']) ?? '';

    $query = "INSERT INTO mahasiswa (nama, nim, jurusan, email, no_hp, foto) VALUES 
    ('$nama', '$nim', '$jurusan', '$email', '$no_hp', '$foto')";

    return mysqli_query($conn, $query);
}

function hapusData($id) {
    global $conn;

    $id = (int)$id; // pastikan id adalah integer
    if ($id > 0) {
        $query = "DELETE FROM mahasiswa WHERE id = $id";
        return mysqli_query($conn, $query);
    }
    return false;
}

