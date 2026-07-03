# TODO - Tambah Login & Session

- [x] Edit `fungsi.php`: tambah `session_start`, helper `isLoggedIn()` dan `requireLogin()`
- [x] Buat `login.php`: form login + validasi ke tabel `user`, set `$_SESSION`
- [x] Buat `logout.php`: destroy session + redirect
- [x] Proteksi halaman: `profile.php`, `mahasiswa.php`, `tambahdata.php`, `ubahdata.php`, `hapusdata.php` dengan `requireLogin()`
- [ ] (Opsional) Update navigasi/tombol menu untuk menampilkan Logout saat sudah login
- [ ] Uji alur: register -> login -> akses halaman CRUD -> logout -> redirect

# TODO - Interaktif Login
- [x] Update `login.php` jadi lebih interaktif (UI, validasi, show/hide password, status login)


