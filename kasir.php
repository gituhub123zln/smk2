<?php
// Challenge 4: halaman produk berisi detail produk, kasir bisa menambah dan mengurangi stok


session_start(); // Memulai sesi agar data stok tetap tersimpan selama sesi berlangsung.


// ========================== LOGOUT ADMIN ==========================
// Jika tombol logout ditekan, maka sesi akan dihancurkan dan admin diarahkan ke halaman login.
if (isset($_POST['logout'])) {
    session_destroy(); // Menghapus semua data sesi yang tersimpan.
    header("Location: login.php"); // Redirect ke halaman login setelah logout.
    exit(); // Menghentikan eksekusi kode lebih lanjut setelah redirect.
}


// ========================== DATA PRODUK ==========================
$dataproduk = array(
    array("PAKAN IKAN OTOMATIS", "beri makan ikan tanpa repot dengan pakan ikan otomatis produk dari jurusan RPL", 100000, "pakanikan.jpg", 10),
    array("WEBSITE COMPANY PROFILE", "Zaman now masih belum punya website percayakan pembuatan website pada kula koding smkn 2 banjarmasin", 45000, "webcomp.jpg", 15),
    array("KURSI JATI", "kursi estetik dengan bahan jati dibuat oleh jurusan Teknik Furniture", 50000, "kursijati.jpg", 8),
    array("SABUN LAUNDRY", "mewangikan pakaian mengunakan bahan yang aman untuk pakaian produksi dari jurusan Kimia Industri", 55000, "sabunlaundry.jpg", 20),
);


// ========================== INISIALISASI STOK DI SESSION ==========================
// Jika session 'stok' belum ada (misalnya saat pertama kali membuka halaman), 
// maka stok akan diambil dari array produk dan disimpan dalam session agar dapat dikelola.
if (!isset($_SESSION['stok'])) {
    // Mengecek apakah session 'stok' belum ada (belum diinisialisasi).

    foreach ($dataproduk as $key => $produk) {
        // Melakukan perulangan pada array $dataproduk.
        // $key adalah indeks (0, 1, 2, ...) dari setiap produk dalam array.
        // $produk adalah array yang berisi informasi dari satu produk.

        $_SESSION['stok'][$key] = $produk[4];
        // Menyimpan stok awal produk ke dalam session berdasarkan indeks produk.
        // $produk[4] adalah nilai stok yang sudah ditentukan dalam array $dataproduk.
    }
}



// ========================== PROSES PERUBAHAN STOK (TAMBAH / KURANGI) ==========================
// Program akan menangani perubahan stok produk berdasarkan aksi yang dipilih oleh admin.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi'])) {
    // Mengecek apakah request yang dikirim adalah metode POST dan apakah variabel 'aksi' ada dalam data POST.
    // Ini memastikan bahwa kode hanya berjalan ketika ada form yang dikirimkan dengan metode POST.

    $id = $_POST['id']; // Mengambil ID produk yang dikirimkan dari form, yang mewakili indeks produk dalam array.

    if ($_POST['aksi'] === 'tambah') {
        // Jika aksi yang dikirimkan adalah "tambah", maka stok produk dengan ID terkait akan bertambah 1.
        $_SESSION['stok'][$id] += 1;
    } elseif ($_POST['aksi'] === 'kurang' && $_SESSION['stok'][$id] > 0) {
        // Jika aksi adalah "kurang" dan stok masih lebih dari 0, maka stok produk akan dikurangi 1.
        // Kondisi $_SESSION['stok'][$id] > 0 memastikan bahwa stok tidak bisa menjadi negatif.
        $_SESSION['stok'][$id] -= 1;
    }

    // Setelah stok diperbarui, lakukan redirect ke halaman kasir.php agar perubahan stok langsung terlihat.
    header("Location: kasir.php");

    exit(); // Menghentikan eksekusi script setelah melakukan redirect untuk mencegah output lain ditampilkan.
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manajemen Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-4">
        <!-- Header halaman admin -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-center">Manajemen Detail Produk</h2>

            <!-- Tombol Logout -->
            <form method="POST">
                <button type="submit" name="logout" class="btn btn-danger">Logout</button>
            </form>
        </div>

        <!-- Tabel daftar produk -->
        <table class="table table-bordered text-center bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Deskripsi</th>
                    <th>Harga (Rp)</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Looping untuk menampilkan semua produk yang ada di array -->
                <?php foreach ($dataproduk as $key => $produk) : ?>
                    <tr>
                        <!-- Menampilkan gambar produk -->
                        <td><img src="img/<?= $produk[3]; ?>" alt="<?= $produk[0]; ?>" width="100"></td>

                        <!-- Menampilkan nama produk -->
                        <td><?= $produk[0]; ?></td>

                        <!-- Menampilkan deskripsi produk -->
                        <td><?= $produk[1]; ?></td>

                        <!-- Menampilkan harga produk dalam format rupiah -->
                        <td><?= number_format($produk[2], 0, ',', '.'); ?></td>

                        <!-- Menampilkan stok produk saat ini -->
                        <td><?= $_SESSION['stok'][$key]; ?></td>

                        <!-- Tombol untuk menambah atau mengurangi stok -->
                        <td>
                            <!-- Form untuk menambah stok -->
                            <form method="POST" style="display:inline;">
                                <!-- hidden : digunakan untuk mengirimkan data ke server tanpa menampilkannya kepada pengguna. -->
                                <!--  Mengirimkan ID produk yang dipilih agar server tahu produk mana yang sedang diubah stoknya. -->
                                <input type="hidden" name="id" value="<?= $key; ?>"> <!-- ID produk -->
                                <input type="hidden" name="aksi" value="tambah"> <!-- Aksi tambah -->
                                <button type="submit" class="btn btn-success btn-sm">Tambah Stok</button>
                            </form>

                            <!-- Form untuk mengurangi stok -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $key; ?>"> <!-- ID produk -->
                                <input type="hidden" name="aksi" value="kurang"> <!-- Aksi kurang -->
                                <button type="submit" class="btn btn-danger btn-sm">Kurangi Stok</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?> <!-- Akhir looping produk -->
            </tbody>
        </table>
    </div>

    <!-- Bootstrap script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>