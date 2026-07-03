<?php
require 'fungsi.php';

if (isLoggedIn()) {
    header('Location: mahasiswa.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = strtolower(trim($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        $usernameEscaped = mysqli_real_escape_string($conn, $username);
        $result = mysqli_query($conn, "SELECT username, password FROM user WHERE username = '$usernameEscaped' LIMIT 1");

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $storedHash = $row['password'] ?? '';

            if (password_verify($password, $storedHash)) {
                $_SESSION['user'] = $row['username'];
                header('Location: mahasiswa.php');
                exit;
            }
        }

        $error = 'Login gagal. Username atau password salah.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Informatika 2026</title>
    <link rel="stylesheet" href="aset/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        <table class="nav-table">
            <tr>
                <td><a href="index.php">Home</a></td>
                <td><a href="register.php">Register</a></td>
                <td><a href="logout.php">Logout</a></td>
            </tr>
        </table>

        <hr>

        <?php if ($error !== ''): ?>
            <p style="color:red; font-weight:bold;"> <?php echo htmlspecialchars($error); ?> </p>
        <?php endif; ?>

        <form id="loginForm" action="login.php" method="post" autocomplete="off">
            <table cellpadding="5">
                <tr>
                    <td><label for="username">Username</label></td>
                    <td>:</td>
                    <td><input type="text" id="username" name="username" required placeholder="Masukkan username"></td>
                </tr>
                <tr>
                    <td><label for="password">Password</label></td>
                    <td>:</td>
                    <td>
                        <input type="password" id="password" name="password" required placeholder="Masukkan password">
                        <div style="margin-top:6px; display:flex; gap:10px; align-items:center;">
                            <input type="checkbox" id="showPassword">
                            <label for="showPassword" style="margin:0; cursor:pointer;">Tampilkan password</label>
                        </div>
                    </td>
                </tr>
            </table>

            <br>
            <button type="submit" id="loginBtn">Login</button>

            <p id="loadingText" style="display:none; margin-top:8px; color:#2c3e50; font-weight:bold;">
                Memeriksa kredensial...
            </p>
        </form>

        <p style="margin-top:20px; color:#555;">
            Tips: gunakan username & password yang sudah terdaftar di halaman <b>Register</b>.
        </p>
    </div>

    <script>
        (function () {
            const showPassword = document.getElementById('showPassword');
            const passwordInput = document.getElementById('password');
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const loadingText = document.getElementById('loadingText');

            if (showPassword && passwordInput) {
                showPassword.addEventListener('change', function () {
                    passwordInput.type = this.checked ? 'text' : 'password';
                });
            }

            if (loginForm && loginBtn && loadingText) {
                loginForm.addEventListener('submit', function () {
                    loginBtn.disabled = true;
                    loginBtn.textContent = 'Loading...';
                    loadingText.style.display = 'block';
                });
            }
        })();
    </script>
</body>
</html>


