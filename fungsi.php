<?php
// fungsi.php
// Koneksi database untuk project ini

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Session handling (dipakai untuk autentikasi)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

function isLoggedIn(): bool {
    return isset($_SESSION['user']) && !empty($_SESSION['user']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
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

function register($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password1 = mysqli_real_escape_string($conn, $data["password1"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username sudah terdaftar!');
              </script>";
        return 0;
    }


    // cek konfirmasi password
    if($password1 != $password2) {
        echo "<script>
                alert('Password tidak sesuai!');
                window.location.href = 'register.php';
              </script>";
        return false;
    }

    // enkripsi password
    $passwordHash = password_hash($password1, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user (username, password) VALUES ('$username', '$passwordHash')");

    return mysqli_affected_rows($conn);
}