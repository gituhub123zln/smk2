<?php
session_start(); // Memastikan session dimulai

$dataproduk = array(
    array("PAKAN IKAN OTOMATIS", "beri makan ikan tanpa repot dengan pakan ikan otomatis produk dari jurusan RPL", 100000, "pakanikan.jpg"),
    array("WEBSITE COMPANY PROFILE", "Zaman now masih belum punya website percayakan pembuatan website pada kula koding smkn 2 banjarmasin", 45000, "webcomp.jpg"),
    array("KURSI JATI", "kursi estetik dengan bahan jati dibuat oleh jurusan Teknik Furniture", 50000, "kursijati.jpg"),
    array("SABUN LAUNDRY", "mewangikan pakaian mengunakan bahan yang aman untuk pakaian produksi dari jurusan Kimia Industri", 55000, "sabunlaundry.jpg"),
);

// Inisialisasi stok jika belum ada di session
if (!isset($_SESSION['stok'])) {
    $_SESSION['stok'] = array(10, 15, 8, 20); // Default stok awal untuk setiap produk
}
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beranda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            font-size: 18px;
        }

        .card:hover {
            transform: translateY(-5px);
            transition: transform 0.2s ease-in-out;
        }

        .btn-dark {
            background-color: #1e3c72;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-dark:hover {
            background-color: #2a5298;
        }

        .banner {
            height: 500px;
            object-fit: cover;
        }

        /* Menjaga agar harga tetap berada di tengah secara vertikal dan memiliki tinggi minimal yang sama, sehingga semua harga sejajar. */
        .price-container {
            min-height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-desc {
            min-height: 60px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1e3c72;" py-3 shadow>
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="beranda.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="transaksi.php">Transaksi</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Banner -->
    <div class="container-fluid p-0">
        <img src="img/banner.png" class="img-fluid w-100 banner" alt="Banner">
    </div>

    <!-- Daftar Produk -->
    <div class="container my-5">
        <h2 class="fw-bold mb-4 text-start">Daftar Produk Technopark Gallery SMK 2 BANJARMASIN</h2>
        <div class="row">
            <!-- $dataproduk dipecah menjadi satu persatu, $index tempat utk menampung nomor array nya,
                 $data utk menampung data yang ada di array -->
            <?php foreach ($dataproduk as $index => $data) { ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow border-0 text-center d-flex flex-column">
                        <img src="img/<?= $data[3] ?>" class="card-img-top" alt="<?= $data[0] ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body flex-grow-1">
                            <h5 class="fw-bold"> <?= $data[0] ?> </h5>
                            <p class="text-muted small product-desc"> <?= $data[1] ?> </p>
                            <!-- CHALLANGE 2   harga nya di rapikan agar simetris semuanya  -->
                            <div class="price-container">
                                <!-- Harga Produk -->
                                <h6 class="fw-bold text-primary">Rp <?= number_format($data[2], 0, ',', '.') ?>,-</h6>
                            </div>

                            <!-- CHALLANGE 5 jika stok habis maka tampilkan stok tidak tersedia, jika stok kurang dari 3 maka tampilkan "stok menipis" -->
                            <p class="fw-bold text-danger">
                                <?php
                                // Mengecek apakah stok produk bernilai 0 (stok habis)
                                if ($_SESSION['stok'][$index] == 0) {
                                    echo "Stok Tidak Tersedia";  // Jika stok habis, tampilkan teks "Stok Tidak Tersedia"

                                    // Jika stok masih ada tetapi kurang dari 3 (stok kritis)
                                } elseif ($_SESSION['stok'][$index] < 3) {
                                    echo "Stok Menipis ({$_SESSION['stok'][$index]})";  // Tampilkan jumlah stok yang tersisa dalam kurung

                                    // Jika stok lebih dari atau sama dengan 3
                                } else {
                                    echo "Stok: {$_SESSION['stok'][$index]}";  // Tampilkan jumlah stok secara normal
                                }
                                ?>

                            </p>

                        </div>
                        <div class="card-footer bg-white border-0 text-center">
                            <!-- mengirimkan id sesuai index yang dipilih -->
                            <a href="transaksi.php?id=<?= $index ?>" class="btn btn-dark w-100">Pilih Produk</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>