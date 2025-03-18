<?php
session_start();

// Daftar produk dalam bentuk array dengan nama, deskripsi, harga, dan gambar
$dataproduk = array(
    array("PAKAN IKAN OTOMATIS", "beri makan ikan tanpa repot dengan pakan ikan otomatis produk dari jurusan RPL", 100000, "pakanikan.jpg"),
    array("WEBSITE COMPANY PROFILE", "Zaman now masih belum punya website percayakan pembuatan website pada kula koding smkn 2 banjarmasin", 45000, "webcomp.jpg"),
    array("KURSI JATI", "kursi estetik dengan bahan jati dibuat oleh jurusan Teknik Furniture", 50000, "kursijati.jpg"),
    array("SABUN LAUNDRY", "mewangikan pakaian mengunakan bahan yang aman untuk pakaian produksi dari jurusan Kimia Industri", 55000, "sabunlaundry.jpg"),
);

// Menginisialisasi stok jika belum ada di session
if (!isset($_SESSION['stok'])) {
    $_SESSION['stok'] = array_fill(0, count($dataproduk), 10); // Misalnya stok awal 10 untuk tiap produk
}

// Mengambil parameter ID produk dari URL dan memastikan itu adalah angka
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
// Memeriksa apakah ID yang diberikan sesuai dengan indeks dalam array
// Jika valid, produk dipilih dari array berdasarkan ID.
// Jika ID tidak valid, produk pertama dipilih secara default.
if ($id >= 0 && $id < count($dataproduk)) {
    $paket = $dataproduk[$id];
} else {
    $paket = $dataproduk[0]; // Default ke produk pertama jika ID tidak valid
}

// Inisialisasi variabel transaksi
$no_transaksi = "";
$nama_cus = "";
$tanggal = "";
$jumlah_produk = 1;
$total_harga = 0;
$pembayaran = 0;
$kembalian = 0;
$pesan = "";

// Mengecek apakah ada data yang dikirim dari form menggunakan metode POST.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //mengambil data dari form
    $harga = isset($_POST['harga']) ? (int)$_POST['harga'] : 0; //Mengambil harga dari formulir. Jika tidak diisi, maka nilainya 0.
    $no_transaksi = $_POST['no_transaksi'];
    $nama_cus = $_POST['nama'];
    $tanggal = $_POST['tanggal'];
    $jumlah_produk = isset($_POST['jumlah_produk']) ? (int)$_POST['jumlah_produk'] : 1; //Mengambil jumlah produk yang dibeli. Jika tidak diisi, defaultnya 1.
    $total_harga = $harga * $jumlah_produk; // Menghitung total harga berdasarkan harga satuan × jumlah produk.
    $pembayaran = isset($_POST['pembayaran']) ? (int)$_POST['pembayaran'] : 0;

    // CHALLANGE 1. pada total pembayaran, jika total pembayaran kurang maka tampilkan "pembayaran kurang" 
    // Mengecek apakah tombol "Hitung Kembalian" ditekan
    if (isset($_POST['hitung_kembalian'])) {
        // Mengecek apakah jumlah pembayaran kurang dari total harga
        if ($pembayaran < $total_harga) {
            // Jika pembayaran kurang, maka muncul pesan "Pembayaran kurang"
            $pesan = "Pembayaran kurang";
        } else {
            // Jika pembayaran cukup atau lebih, hitung kembalian
            $kembalian = $pembayaran - $total_harga;
        }
    }


    // Mengurangi stok jika transaksi disimpan
    if (isset($_POST['simpan'])) {
        if (isset($_SESSION['stok'][$id]) && $_SESSION['stok'][$id] >= $jumlah_produk) {
            $_SESSION['stok'][$id] -= $jumlah_produk;
            echo "<script>
                    alert('Transaksi berhasil disimpan! Stok tersisa: " . $_SESSION['stok'][$id] . "');
                    window.location.href = 'beranda.php';
                  </script>";
        } else {
            $pesan = "Stok tidak mencukupi!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Transaksi Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar" style="background-color: #1e3c72;">
        <div class="container-fluid">
            <div class="d-flex">
                <a class="nav-link text-light mx-2 fs-6 py-1 px-2" href="beranda.php">Home</a>
                <a class="nav-link text-light mx-2 fs-6 py-1 px-2" href="transaksi.php">Transaksi</a>
            </div>
            <a class="nav-link text-light mx-2 fs-6 py-1 px-2" href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center fw-bold">Transaksi</h2>
                        <form method="POST">
                            <!-- Input Nomor Transaksi -->
                            <div class="mb-3">
                                <label class="form-label">No. Transaksi</label>
                                <input type="number" class="form-control" name="no_transaksi" value="<?= $no_transaksi; ?>" required>
                            </div>
                            <!-- Input Tanggal Transaksi -->
                            <div class="mb-3">
                                <label class="form-label">Tanggal Transaksi</label>
                                <input type="date" class="form-control" name="tanggal" value="<?= $tanggal; ?>" required>
                            </div>
                            <!-- Input Nama Customer -->
                            <div class="mb-3">
                                <label class="form-label">Nama Customer</label>
                                <input type="text" class="form-control" name="nama" value="<?= $nama_cus; ?>" required>
                            </div>
                            <!-- Menampilkan Nama Produk yang Dipilih -->
                            <div class="mb-3">
                                <label class="form-label">Pilih Produk</label>
                                <input type="text" class="form-control" name="paket" value="<?= $dataproduk[$id][0]; ?>" readonly>
                            </div>
                            <!-- Menampilkan Harga Produk -->
                            <div class="mb-3">
                                <label class="form-label">Harga Produk</label>
                                <input type="number" class="form-control" name="harga" value="<?= $dataproduk[$id][2]; ?>" readonly>
                            </div>
                            <!-- Input Jumlah Produk -->
                            <div class="mb-3">
                                <label class="form-label">Jumlah Produk</label>
                                <input type="number" class="form-control" name="jumlah_produk" value="<?= $jumlah_produk; ?>" min="1" required>
                            </div>
                            <!-- Tombol Hitung Total Harga -->
                            <button type="submit" class="btn btn-dark mb-3" name="hitung">Hitung Total Harga</button>
                            <!-- Menampilkan Total Harga -->
                            <div class="mb-3">
                                <label class="form-label">Total Harga</label>
                                <input type="number" class="form-control" name="total_harga" value="<?= $total_harga; ?>" readonly>
                            </div>
                            <!-- Input Pembayaran -->
                            <div class="mb-3">
                                <label class="form-label">Pembayaran</label>
                                <input type="number" class="form-control" name="pembayaran" value="<?= $pembayaran; ?>">
                            </div>
                            <!-- Tombol Hitung Kembalian -->
                            <button type="submit" class="btn btn-dark" name="hitung_kembalian">Hitung Kembalian</button>
                            <!-- Menampilkan Kembalian -->
                            <div class="mb-3">
                                <label class="form-label">Kembalian</label>
                                <input type="number" class="form-control" name="kembalian" value="<?= $kembalian; ?>" readonly>
                            </div>

                            <!-- pesan -->
                            <!-- Komentar HTML untuk memberi tahu bahwa ini bagian pesan -->
                            <?php if ($pesan): ?> <!-- Mengecek apakah variabel $pesan memiliki nilai (tidak kosong atau bukan false) -->
                                <div class="alert alert-danger"> <?= $pesan; ?> </div>
                                <!-- // Jika $pesan memiliki nilai, maka akan ditampilkan dalam elemen div dengan class "alert alert-danger"
                                // "alert alert-danger" adalah kelas Bootstrap yang membuat tampilan pesan berwarna merah, biasanya digunakan untuk peringatan atau error. -->
                            <?php endif; ?>

                            <!-- Tombol Simpan Transaksi -->
                            <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<!-- challange
 1. pada total pembayaran, jika total pembayaran kurang maka tampilkan "pembayaran kurang"  /SELESAI
 2. harga nya di rapikan agar simetris semuanya /SELESAI
 3. buat 2 user login pembeli dan kasir(admin), di halaman kasir(buat halaman baru) berisi halaman produk 
 4. halaman produk berisi detail produk, kasir bisa menambah dan mengurangi stok
 5. jika stok habis maka tampilkan stok tidak tersedia, jika stok kurang dari 3 maka tampilkan "stok menipis"
-->