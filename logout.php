<?php
// Pastikan session sudah dimulai sebelum mencoba mengakses atau menghancurkannya
session_start();

// 1. Hapus semua variabel session
$_SESSION = array();

// 2. Hancurkan session
// Jika menggunakan cookie session, hapus juga cookienya.
// Catatan: Ini akan menghancurkan cookie session, dan bukan data sesi.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan data sesi di server
session_destroy();

// 3. Alihkan pengguna kembali ke halaman login
// Ganti 'login.php' dengan path halaman login Anda yang sebenarnya.
header("Location: login.php");
exit;
?>