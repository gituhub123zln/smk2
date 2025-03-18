<?php
/* 
    Challenge 3: Buat 2 user login, pembeli dan kasir (admin) 
    -> Sudah diterapkan dengan array $users yang berisi dua jenis pengguna: pembeli dan kasir.
    -> Role 'pembeli' diarahkan ke 'beranda.php'.
    -> Role 'kasir' diarahkan ke 'kasir.php'.
*/

// Deklarasi username dan password untuk dua jenis pengguna
// $users adalah array asosiatif multidimensi yang menyimpan username dan password untuk dua jenis pengguna: pembeli dan kasir.
$users = [
    "pembeli" => ["username" => "userlsp", "password" => "smk"],
    "kasir"   => ["username" => "kasir", "password" => "kasir123"]
];

// Cek apakah tombol login ditekan
if (isset($_POST['login'])) {


    // Mengambil input username, password, dan role yang dimasukkan pengguna.
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Role yang dipilih

    // Periksa apakah username dan password sesuai dengan role yang dipilih
    if (isset($users[$role]) && $username === $users[$role]["username"] && $password === $users[$role]["password"]) {
        // Jika login berhasil, arahkan ke halaman sesuai role
        if ($role === "pembeli") {
            echo "<meta http-equiv='refresh' content='1;url=beranda.php'>"; // Pembeli masuk ke halaman beranda
        } elseif ($role === "kasir") {
            echo "<meta http-equiv='refresh' content='1;url=kasir.php'>"; // Kasir masuk ke halaman kasir
        }
    } else {
        // Jika login gagal akan muncul alert
        echo "<script>alert('Username atau password salah!')</script>";
        echo "<meta http-equiv='refresh' content='1;url=login.php'>";
    }
}
