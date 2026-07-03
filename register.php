<?php
require 'fungsi.php';

if (isset($_POST['Register'])) {
    if (register($_POST) > 0) {
        echo "<script>
                alert('User baru berhasil ditambahkan!');
                window.location.href = 'index.php';
            </script>";
    } else {
        echo "<script>
                alert('User baru gagal dibuat!');
                window.location.href = 'index.php';
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Register User</h1>
    <hr>
    <form action="register.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password1" required><br><br>

        <label for="password2">Confirm Password:</label><br>
        <input type="password" name="password2" required><br><br>

        <input type="submit" name="Register">
    </form>
</body>
</html>

