<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kasir_dwi";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk menghitung jumlah total produk
$sql_produk = "SELECT COUNT(*) AS total_produk FROM produk";
$result_produk = $conn->query($sql_produk);

$total_produk = 0;
if ($result_produk->num_rows > 0) {
    $row_produk = $result_produk->fetch_assoc();
    $total_produk = $row_produk["total_produk"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../asset/favicon-16x16.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="row">
        <?php include 'sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Selamat Datang DI Dashboard Kasir JKT48 Admin </h1>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card text-bg-primary mb-3">
                        <div class="card-header">Total Produk</div>
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Produk: <?php echo $total_produk; ?></h5>
                            <p class="card-text">Semua produk yang tersedia di toko.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-bg-success mb-3">
                        <div class="card-header">Total Transaksi</div>
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Transaksi: </h5>
                            <p class="card-text">Total transaksi yang terjadi hari ini.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-bg-warning mb-3">
                        <div class="card-header">Pendapatan Hari Ini</div>
                        <div class="card-body">
                            <h5 class="card-title">Total Pendapatan: </h5>
                            <p class="card-text">Pendapatan dari transaksi hari ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

